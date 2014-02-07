<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Los_Angeles');

class Stats_controller extends CI_Controller
{

	public function index()
	{
		$this->load->model('Stats_model','',TRUE);

		$data['scores'] = $this->Stats_model->get_stats();
		$data['dubs_scores'] = $this->Stats_model->get_dubs_stats();

		$data['messages'] = $this->Stats_model->get_messages();

	
		$data['players'] = $this->stats_table($data);
		$data['dubsplayers'] = $this->dubs_stats_table($data);

		// if(isset($this->session->flashdata('errors')))
		// {
		// 	$data['errors'] = $this->session->flashdata('errors');
		// }
		
		$this->load->view('index', $data);
		
	}

	public function score_process()
	{	
		$this->load->model('Stats_model','',TRUE);

		$data['scores'] = $this->Stats_model->get_stats();
		$data['dubs_scores'] = $this->Stats_model->get_dubs_stats();

		$data['players'] = $this->stats_table($data); //needed for ajaxing new standings table upon score submit
		$data['dubsplayers'] = $this->dubs_stats_table($data);
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('team1', 'Winner', 'trim|required');
		$this->form_validation->set_rules('team2', 'Winner', 'trim|required');

		$this->form_validation->set_rules('score1', 'Score', 'trim|require|is_natural');
		$this->form_validation->set_rules('score2', 'Score', 'trim|required|is_natural');

		if(!$this->form_validation->run())
		{
			// $this->session->set_flashdata('errors') = validation_errors();
			// redirect(base_url('/stats_controller/index'));
			redirect(base_url(''));
			 // $data['errors'] = validation_errors();
			// $this->load->view('index', $data);
			// $this->index($data);
			// $this->load->view('index', $data);
		}

		else
		{
			$form_info = $this->input->post();
			$this->load->model('Stats_model', '', TRUE);

			if(count($form_info)<5) //if 4 input fields then a singles game was played
			{		
				$this->Stats_model->input_scores($form_info);
				$data['newscore'] = $this->Stats_model->get_recent_stats();
				$data['newscore'][0]['created_at'] = (date('M d, Y g:ia ', strtotime($data['newscore'][0]['created_at'])));
				$array['scores'] = $this->Stats_model->get_stats();
				$data['players'] = $this->stats_table($array); //to send standings through AJAX
			}
			else //doubles game was played
			{				
				$this->Stats_model->input_dubscores($form_info);
				$data['newscoredubs'] = $this->Stats_model->get_recent_dubs();
			}
			echo json_encode($data);
		}	 
	}

	public function stats_table($data)
	{	
		//fetch query of all user names here and loop through each name
		$this->load->model('Stats_model', '', TRUE);
		$users = $this->Stats_model->user_list();
		// var_dump($users);
		
		// $this->session->set_userdata($users);
		// $testing = $this->session->all_userdata();

		$h= 0;
		foreach($users as $user)
		{	
			$i=0;
			$j=0;
			$totalscore=0;
			$oppscore=0;
			foreach($data['scores'] as $array)
			{//everytime a player's name shows up under the 'winner' column, add $i++
				if(strtolower($array['winner_name']) == strtolower($user['first_name'])) 
				{	
					$i++;
					$totalscore+= $array['winner_score'];
					$oppscore+= $array['loser_score'];
				}
				//everytime a player's name shows up under the 'loser' column, add $j++
				if(strtolower($array['loser_name']) == strtolower($user['first_name']))
				{
					$j++;
					$totalscore+= $array['loser_score'];
					$oppscore+= $array['winner_score'];
				}	
			}
		
			//($i + $j) = total number of wins + losses = total number of games
			if(($i+$j)!=0) $users[$h]['avgscore'] = round($totalscore/($i+$j), 1);
			else{$users[$h]['avgscore'] = '0';} //if #of games played = 0, set average score to zero

			if(($i+$j)!=0) $users[$h]['oppavgscore'] = round($oppscore/($i+$j), 1);
			else{$users[$h]['oppavgscore'] = '0';} //if #of games played = 0, set average score to zero
			
			
			$users[$h]['wins'] = $i; 
			$users[$h]['losses'] = $j;
			if(($i+$j)!=0) $users[$h]['win_pct'] = number_format($i/($i+$j),3, '.', ',');
			else{$users[$h]['win_pct']= '0.000';}

			if(($users[$h]['wins']+$users[$h]['losses'])< 3)
			{
				$users[$h]['rating'] = 0;
			}
			
			$h++; //represents the index of $users aka the index of each player
		}

		 // var_dump($users);
			
		// Obtain a list of columns
		foreach ($users as $key => $row)
		{
			$rating[$key]  = $row['rating'];
		    $wins[$key] = $row['wins'];
		}
		// var_dump($rating);

		// Sort the users with rating descending, wins ascending
		// Add $users as the last parameter, to sort by the common key
		array_multisort($rating, SORT_DESC, $users);
		//var_dump($users);
		
		// var_dump($users);

		return $users;
	}


	public function dubs_stats_table($data)
	{	
		//fetch query of all user names here and loop through each name
		$this->load->model('Stats_model', '', TRUE);
		$users = $this->Stats_model->user_list();

		$h= 0;
		foreach($users as $user)
		{	
			$i=0;
			$j=0;
			$totalscore=0;
			$oppscore=0;
			foreach($data['dubs_scores'] as $array)
			{//everytime a player's name shows up under the 'winner' column, add $i++
				if((strtolower($array['winner1']) == strtolower($user['first_name'])) or (strtolower($array['winner2']) == strtolower($user['first_name']))) 
				{
					$totalscore+= $array['winner_score'];
					$oppscore+= $array['loser_score'];
					$i++;
				}
				if((strtolower($array['loser1']) == strtolower($user['first_name'])) or (strtolower($array['loser2']) == strtolower($user['first_name'])))
				{//everytime a player's name shows up under the 'loser' column, add $j++
				 	$j++;
				 	$totalscore+= $array['loser_score'];
					$oppscore+= $array['winner_score'];
				}		
			}
			//($i + $j) = total number of wins + losses = total number of games
			if(($i+$j)!=0) $users[$h]['avgscore'] = round($totalscore/($i+$j), 1);
			else{$users[$h]['avgscore'] = '0';}

			if(($i+$j)!=0) $users[$h]['oppavgscore'] = round($oppscore/($i+$j), 1);
			else{$users[$h]['oppavgscore'] = '0';}

			$users[$h]['wins'] = $i;
			$users[$h]['losses'] = $j;
			if(($i+$j)!=0) $users[$h]['win_pct'] = number_format($i/($i+$j),3, '.', ',');
			else{$users[$h]['win_pct']= '0.000';}
			
			$h++; //represents the index of $users aka the index of each player
		}
		return $users;
	}

	public function delete()
	{
		$data= $this->input->post();
		$this->load->model('Stats_model','', TRUE);
		$this->Stats_model->delete_score($data);
		// redirect(base_url(''));
	}

	public function delete_dubs()
	{
		$data= $this->input->post();
		$this->load->model('Stats_model','', TRUE);
		$this->Stats_model->delete_dubs_score($data);
		// redirect(base_url(''));
	}

	public function to_delete() //simply used to load view 'delete' when trying to delete player
	{
		$this->load->model('Stats_model', '', TRUE);
		$users['users'] = $this->Stats_model->user_list();
		$this->load->view('delete', $users);
	}

	public function delete_player()
	{
		$data= $this->input->post();
		$this->load->model('Stats_model', '', TRUE);
		$this->Stats_model->delete_player($data);
		redirect(base_url(''));
	}

	public function new_player()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean|prep_for_form');

		if(!$this->form_validation->run())
		{
			redirect(base_url(''));
		}
		else
		{
			$data= $this->input->post();
			$this->load->model('Stats_model','', TRUE);
			$this->Stats_model->input_player($data);
			redirect(base_url(''));
		}
		
	}

	// public function match_ups()
	// {
	// 	$this->load->model('Stats_model', '', TRUE);

	// 	$scores = $this->Stats_model->get_stats();
	// 	$users = $this->Stats_model->user_list();
	// 	$array = array();

	// 	foreach($users as $user)
	// 	{
	// 		// var_dump($user['first_name']);
	// 		foreach($scores as $score)
	// 		{
				
	// 				if(strtolower($score['winner_name']) == strtolower($user['first_name'])) 
	// 				{	
	// 					foreach($users as $opponent)
	// 					{
	// 						if(strtolower($score['loser_name']) == strtolower($opponent['first_name']))
	// 						{
	// 							$name = $opponent['first_name'];
	// 						$array[$name][] = "{$user['first_name']} beat {$score['loser_name']} 21 to {$score['loser_score']}";
	// 						}
							
	// 					}
						
						
	// 				}
	// 				//everytime a player's name shows up under the 'loser' column, add $j++
	// 				if(strtolower($score['loser_name']) == strtolower($user['first_name']))
	// 				{				
						
	// 				}		
				
	// 			// var_dump($score['winner_score']);
	// 		}
			
	// 	}
	// 	var_dump($array);
	// 	// var_dump($scores);
	// 	// var_dump($users);
	// }

	public function match_ups()
	{
		// var_dump($this->input->post());
		$names = $this->input->post();
		var_dump($names);
		$this->load->model('Stats_model', '', TRUE);
		$array = $this->Stats_model->get_match_ups($names);
		$i = 0;
		$j = 0;
		foreach($array as $one)
		{
			echo $one['winner_name']." beat ".$one['loser_name']." ".$one['winner_score']." to ".$one['loser_score']."<br>";
			if($one['winner_name'] == $names['name'])
			{
				$i++;
			}
			else
			{
				$j++;
			}
		}
		echo $i." - ".$j;
	}

	public function indiv_stats() //shows all opponent's stats
	{
		$name = $this->input->post();
		$this->load->model('Stats_model', '', TRUE);
		$matches = $this->Stats_model->get_indiv_stats($name);
		// $users = $this->session->all_userdata();
		// var_dump($users);
		$this->load->model('Stats_model', '', TRUE);
		$users = $this->Stats_model->user_list();
	
		
		$h = 0;
		foreach($users/*[0]*/ as $user)
		{	
			$i = 0;
			$j = 0;
			$ownscore=0;
			$oppscore=0;
			foreach($matches as $match)
			{

				if(strtolower($match['winner_name']) == strtolower($user['first_name'])) 
				{	
					$oppscore+= $match['winner_score'];
					$ownscore+= $match['loser_score'];
					$i++;
				}
				//everytime a player's name shows up under the 'loser' column, add $j++
				if(strtolower($match['loser_name']) == strtolower($user['first_name']))
				{
					$ownscore+= $match['winner_score'];
					$oppscore+= $match['loser_score'];
					$j++;
				}
			}
			
			if($user['first_name'] != $name['name'] && ($i+$j)!= 0)
			{

				$opponents[$h]['first_name'] = $user['first_name'];
				$opponents[$h]['wins'] = $j;
				$opponents[$h]['losses'] = $i;
				$opponents[$h]['win_pct'] = number_format($j/($i+$j),3, '.', ',');
				$opponents[$h]['ownscore'] = round($ownscore/($i+$j), 1);
				$opponents[$h]['oppscore'] = round($oppscore/($i+$j), 1);
				$opponents[$h]['name'] = $name;
				$opponents[$h]['rating'] = round($user['rating'],1);
				
			}
			$h++;
		}

		// var_dump($opponents);
		// die();
		echo json_encode($opponents);		
	}

	public function messages()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('message', 'message field', 'trim|required|xss_clean|prep_for_form');
		$this->load->model('Stats_model', '', TRUE);	

		if(!$this->form_validation->run())
		{
			redirect(base_url(''));
		}

		else
		{
			$form_info = $this->input->post();	
			$this->Stats_model->input_message($form_info);
			$data['newmessage'] = $this->Stats_model->get_new_message();
			echo json_encode($data);
		}
		// $data['messages'] = $this->Stats_model->get_messages();
		// redirect(base_url(''));
	}

	
}

