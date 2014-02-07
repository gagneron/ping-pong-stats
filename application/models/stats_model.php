<?php

date_default_timezone_set('America/Los_Angeles');
		
	class Stats_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function user_list()
		{
			$query= "SELECT * FROM users ORDER BY first_name ASC";
			$data = $this->db->query($query);
			$data = $data->result_array();
			return $data;
		}

		function input_scores($data)
		{
			$winnerrating= "SELECT * FROM users WHERE first_name='{$data['team1']}'";
			$winnerrating= $this->db->query($winnerrating);
			$winnerrating= $winnerrating->result_array();

			$loserrating= "SELECT * FROM users WHERE first_name='{$data['team2']}'";
			$loserrating= $this->db->query($loserrating);
			$loserrating= $loserrating->result_array();

			$loserratings = $loserrating[0]['rating'];
			$winnerratings = $winnerrating[0]['rating'];
			$winnerscore = $data['score1'];
			$loserscore = $data['score2'];


			// Do a query to see how if players have played more than 3 games and is out of provisional ranking

			$gamescount1 = "SELECT COUNT(id) FROM scores WHERE (winner_name = '{$data['team1']}') or (loser_name = '{$data['team1']}')";

			$gamescount2 = "SELECT COUNT(id) FROM scores WHERE (winner_name = '{$data['team2']}') or (loser_name = '{$data['team2']}')";

			$gamescount1 = $this->db->query($gamescount1);
			$gamescount1 = $gamescount1->result_array();
			$gamescount2 = $this->db->query($gamescount2);
			$gamescount2 = $gamescount2->result_array();

			// var_dump($gamescount1[0]['COUNT(id)']);
			// var_dump($gamescount2[0]['COUNT(id)']);

			$gamescount1 = ($gamescount1[0]['COUNT(id)']);
			$gamescount2 = ($gamescount2[0]['COUNT(id)']);

			

			if($gamescount1 >=3 && $gamescount2 >=3)
			{
				$result = $this->trial2($winnerratings,$loserratings,$loserscore); //calls the normal rating function

				$ratingquery = "UPDATE users SET rating = CASE when first_name = '{$winnerrating[0]['first_name']}' then '{$result['newratingwinner']}' when first_name = '{$loserrating[0]['first_name']}' then '{$result['newratingloser']}' END WHERE first_name in ('{$winnerrating[0]['first_name']}', '{$loserrating[0]['first_name']}')";
				$this->db->query($ratingquery);
			}
			elseif($gamescount1 <3 && $gamescount2 >=3)
			{
				$result = $this->provisional_ranking($winnerscore,$loserscore,$loserratings);
				$ratingquery = "INSERT INTO provisional_ratings (first_name, provisional_rating, updated_at, created_at) VALUES('{$data['team1']}', '{$result['newratingwinner']}', NOW(), NOW())";
				$this->db->query($ratingquery);

				$gettemprating = "SELECT SUM(provisional_rating) FROM provisional_ratings where first_name ='{$data['team1']}'";
				$gettemprating = $this->db->query($gettemprating);
				$gettemprating = $gettemprating->result_array();
				$sumtemprating = ($gettemprating[0]['SUM(provisional_rating)']);
				$avetemprating = $sumtemprating/($gamescount1+1);
				// var_dump($avetemprating);
				$ratingquery2 = "UPDATE users SET rating = '{$avetemprating}' WHERE first_name = '{$data['team1']}'";
				$this->db->query($ratingquery2);
			}
			elseif($gamescount2 <3 && $gamescount1 >=3)
			{
				// echo "we're here";
				$result = $this->provisional_ranking($loserscore,$winnerscore,$winnerratings);
				$ratingquery = "INSERT INTO provisional_ratings (first_name, provisional_rating, updated_at, created_at) VALUES('{$data['team2']}', '{$result['newratingwinner']}', NOW(), NOW())";
				$this->db->query($ratingquery);

				$gettemprating = "SELECT SUM(provisional_rating) FROM provisional_ratings where first_name ='{$data['team2']}'";
				$gettemprating = $this->db->query($gettemprating);
				$gettemprating = $gettemprating->result_array();
				$sumtemprating = ($gettemprating[0]['SUM(provisional_rating)']);
				$avetemprating = $sumtemprating/($gamescount2+1);
				// var_dump($avetemprating);
				$ratingquery2 = "UPDATE users SET rating = '{$avetemprating}' WHERE first_name = '{$data['team2']}'";
				$this->db->query($ratingquery2);
			}

			
			else
			{
				$ratingquery = "SELECT * FROM provisional_ratings LIMIT 1";
			}


			// var_dump($loserrating);
			

			// var_dump($winnerrating);
			// var_dump($loserrating);
			// var_dump($winnerscore);
			// var_dump($loserscore);
			// $result = $this->trial2($winnerratings,$loserratings,$loserscore);
			// var_dump($result);
			
			// var_dump($ratingquery);

			
			$now = date('Y-m-d H:i:s');
			
			$score = "INSERT INTO scores (winner_name, loser_name, winner_score, loser_score, created_at, updated_at) VALUES('{$data['team1']}', '{$data['team2']}', '{$data['score1']}', '{$data['score2']}', '{$now}', '{$now}')";
				
			$this->db->query($score);	
		}





		function trial2($winner, $loser, $loserscore)//gets called by Input_scores
		{
			// echo " SCORE: 21 - ".$loserscore."<br>";
			$oppchange = 'nada1';
			$diffnoabs = ($loser-$winner);
			$diff = abs($loser-$winner); 
		 	$scale = floor(($diff/10)+1); //scale example: scale of 6 means higher rated player
			// needs to win 21 to (21-6) or 21-15 in order to gain full amount of rating points
			//10 rating points equals 1 scale
			$expectedscore = (21-($scale));
			$dreamoppchange = 'nada2';
			$wouldbeoppchange = 'nada3';
			// 	echo "21 - ".$expectedscore." is the expected score<br>";
			// echo  $winner."- winner original rating<br>";
			// echo $loser."-loser original rating<br>";

			if(!($diffnoabs<=10 and $diffnoabs>= -5)) //As long as the rating difference is large
			{
				if($winner<$loser) //if loser's rating was higher than the winner's rating
				{
					$change = (($diff/5));
					if($loserscore<20)
					{
						$scorerating = $change*.05*(19-$loserscore); //get extra points for points scored
					}
					elseif($loserscore==20) //if lower rated player barely wins (21-20) then he gets less points awarded
					{
						$dreamoppchange = (100/((($diff)*(.5*$diff))+(100/2)-12.5));
						$scorerating = -($change-$dreamoppchange)/$scale; 
						// $scorerating = $
					}
					
					
				}
				elseif($winner>$loser) 
				{
					$change = (100/((($diff)*(.5*$diff))+(100/2)-12.5));
					$wouldbeoppchange = (($diff/5));

					if($loserscore<=$expectedscore)
					{
						$scorerating = $change*0.05*($expectedscore-$loserscore);
					}
					elseif($loserscore>$expectedscore)
					{
						$scorerating = -(($wouldbeoppchange-$change)/$scale)*($loserscore-$expectedscore);
					}
				}
			}
			
			if($diffnoabs<=10 and $diffnoabs>= -5) //if players ratings are similar, simply get 2 points per win
				{
					$change =2;
					$scorerating = 0;
						if($loserscore<20)
						{
							$scorerating = $change*.05*(19-$loserscore); //points for score 	
						}
				}
			// $users = $this->session->all_userdata();
			// var_dump($users);
				$winner += $change+$scorerating+0.02; //.02 is added to purposely inflate the scores over time so that new players starting at rank 20 don't keep bringing the average down.
				$loser -= $change+$scorerating-0.02;
			// echo $wouldbeoppchange."- points loser would get if his rating was lower and he won</br>";
			// echo $dreamoppchange."- points loser would get if his rating was higher and he won</br>";
			// echo $oppchange." - oppchange if opponent won<br>";
			// echo $scorerating." - score rating<br>";
		
			// echo $change."- change without score<br>";
			// echo ($change+$scorerating)."- change with score factored in<br>";
			// echo  $winner."- winner new rating<br>";
			// echo $loser."- loser new rating<br>";
				$result['newratingwinner'] = $winner;
				$result['newratingloser'] = $loser;
				 return $result;
		}

		function provisional_ranking($onescore, $twoscore, $tworating)
		{
				if($onescore<$twoscore)
				{
					$onerating = (.2+(.035*$onescore))*$tworating;
				}
				else
				{
					$maxrating = (($tworating*.3)+80.5); //highest rating player can achieve if victory 21-0
					$onerating = $maxrating-3-(($maxrating-$tworating)/21)*$twoscore;
				}
				// echo "onescore: ".$onescore."<br>";
				// echo "twoscore: ".$twoscore."<br>";
				// echo "tworating: ".$tworating."<br>";
				// echo $onerating;
				$result['newratingwinner'] = $onerating;
				$result['newratingloser'] = $tworating;
				return $result;
		}

		function input_dubscores($data)
		{
			$team1= "SELECT id FROM users WHERE first_name='{$data['team1']}'";
			$team1= $this->db->query($team1);
			$team1= $team1->result();

			$team2= "SELECT id FROM users WHERE first_name='{$data['team2']}'";
			$team2= $this->db->query($team2);
			$team2=$team2->result();


			$team3= "SELECT id FROM users WHERE first_name='{$data['team3']}'";
			$team3= $this->db->query($team3);
			$team3= $team3->result();

			$team4= "SELECT id FROM users WHERE first_name='{$data['team4']}'";
			$team4= $this->db->query($team4);
			$team4=$team4->result();
			
			$score = "INSERT INTO dubs_scores (winner1, winner2, loser1, loser2, winner_score, loser_score, created_at, updated_at) VALUES('{$data['team1']}', '{$data['team2']}', '{$data['team3']}', '{$data['team4']}', '{$data['score1']}', '{$data['score2']}', NOW(), NOW())";
	
			$this->db->query($score);	
		}

		function get_stats()
		{
			$query= "SELECT * FROM scores ORDER BY created_at DESC";
			$data = $this->db->query($query);
			$data = $data->result_array();
			return $data;
		}

		function get_recent_stats()
		{
			$query = "SELECT * FROM scores ORDER BY created_at DESC LIMIT 1";
			$data = $this->db->query($query);
			return $data->result_array();
		}

			function get_dubs_stats()
		{
			$query= "SELECT * FROM dubs_scores ORDER BY created_at DESC";
			$data = $this->db->query($query);
			$data = $data->result_array();
			return $data;
		}

		function get_recent_dubs()
		{
			$query = "SELECT * FROM dubs_scores ORDER BY created_at DESC LIMIT 1";
			$data = $this->db->query($query);
			return $data->result_array();
		}

		function delete_score($data)	
		{
			$query = "SELECT * FROM scores WHERE id='{$data['hidden']}'";
			$query = $this->db->query($query);
			$query = $query->result_array();  //select this game

			$query[0]['former_id'] = $query[0]['id'];
			$query[0]['deleted_at'] = date('Y-m-d H:i:s');
			unset($query[0]['id']);

			$this->db->insert('trash_scores', $query[0]); //put this game in the trash table


			// $query2 = "SELECT  * FROM users WHERE first_name='{$query[0]['winner_name']}'";
			// $query2 = $this->db->query($query2);
			// $query2 = $query2->result_array();

			// $query2[0]['former_id'] = $query2[0]['id'];
			// $query2[0]['deleted_at'] = date('Y-m-d H:i:s');
			// unset($query2[0]['id']);
			
			// $this->db->insert('trash_users', $query2[0]);


			// $query3 = "SELECT  * FROM users WHERE first_name='{$query[0]['loser_name']}'";
			// $query3 = $this->db->query($query3);
			// $query3 = $query3->result_array();

			// $query3[0]['former_id'] = $query3[0]['id'];
			// $query3[0]['deleted_at'] = date('Y-m-d H:i:s');
			// unset($query3[0]['id']);
			
			// $this->db->insert('trash_users', $query3[0]);


			$query = "DELETE FROM scores WHERE id = '{$data['hidden']}'";
			//delete game from original table
			$this->db->query($query);
		}

		function delete_dubs_score($data)	
		{
			$query = "SELECT * FROM dubs_scores WHERE id='{$data['hidden']}'";
			$query = $this->db->query($query);
			$query = $query->result_array();  //select this game

			$query[0]['former_id'] = $query[0]['id'];
			$query[0]['deleted_at'] = date('Y-m-d H:i:s');
			unset($query[0]['id']);

			$this->db->insert('trash_dubs_scores', $query[0]); //put this game in the trash table

			$query = "DELETE FROM dubs_scores WHERE id = '{$data['hidden']}'"; //delete game from original table
			$this->db->query($query);
		}

		function input_player($data)
		{
			$query = "INSERT INTO users (first_name, last_name, created_at, updated_at, rating) VALUES('{$data['name']}', null, NOW(), NOW(),'{$data['rating']}' )";
			$this->db->query($query);
		}

		function delete_player($data)
		{
			$query = "SELECT * FROM users WHERE first_name='{$data['select']}'";
			$query = $this->db->query($query);
			$query = $query->result_array();

			$query[0]['former_id'] = $query[0]['id'];
			$query[0]['deleted_at'] = date('Y-m-d H:i:s');
			unset($query[0]['id']);
			
			$this->db->insert('trash_users', $query[0]);
			$query = "DELETE FROM users WHERE first_name = '{$data['select']}'";
			$this->db->query($query);
		}

		function get_match_ups($data)
		{
			$query = "SELECT * FROM scores WHERE (winner_name = '{$data['name']}' or loser_name = '{$data['name']}') AND (winner_name = '{$data['opponent']}' or loser_name = '{$data['opponent']}')";
			$query = $this->db->query($query);
			$query = $query->result_array();
			return $query;
		}

		function get_indiv_stats($data)
		{
			$query = "SELECT * FROM scores WHERE (winner_name = '{$data['name']}' or loser_name = '{$data['name']}') ";
			$query = $this->db->query($query);
			$query = $query->result_array();
			return $query;
		}

		function input_message($data)
		{
			$time = date('Y-m-d H:i:s');
		
			$query = array(
							'user_id' => $data['id'],
							'content' => $data['message'],
							'created_at' => $time,
							'updated_at' => $time,
							);

						$this->db->insert('messages', $query); 

						// Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')
			
			// $query = "INSERT INTO messages (user_id, content, created_at, updated_at) VALUES('{$data['id']}', '{$data['message']}', '{$time}', '{$time}')";
			// $query = $this->db->query($query);
		}

		function get_messages()
		{

			$query = "SELECT messages.id, messages.user_id, messages.content, messages.created_at, messages.updated_at, users.first_name FROM messages, users WHERE messages.user_id = users.id ORDER BY updated_at DESC";
			$query = $this->db->query($query);
			$query = $query->result_array();
			return $query;
		}

		function get_new_message()
		{
			$query = "SELECT messages.id, messages.user_id, messages.content, messages.created_at, messages.updated_at, users.first_name FROM messages, users WHERE messages.user_id = users.id ORDER BY updated_at DESC LIMIT 1";
			$query = $this->db->query($query);
			$query = $query->result_array();
			return $query;
		}

		
	}