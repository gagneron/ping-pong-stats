<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset='utf-8'>
	<title>Dojo Ping Pong</title>
	

	

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- 	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> -->
	<script type="text/javascript" src='/assets/js/jquery.tablesorter.js'></script>
	<script type="text/javascript" src='/assets/js/bootstrap.js'></script>
	<link rel='stylesheet' href='/assets/css/bootstrap.css'></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" /> -->
  <!-- <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script> -->
	
  
	<style type="text/css">
		html,body{width:100%; height :100%;}
		.container{ padding:10px;}
		.main-page{margin-left:20px; }
		.bordered{border:1px solid lightgray;}
		.navbar{background-color:#273D7E; margin:0;}
		h2{color:white; padding-left:20px; margin-top:10px; margin-bottom:10px;}
		.btn-xs{float:right;}
		.winp-column{min-width: 55px;}
		.table-standings th, .table-standings td{vertical-align:center; min-width:55px; text-align:center;}
		.table-standings th:nth-child(1){min-width:70px;}
		.table-standings th:nth-child(n+5){max-width:75px; padding-left:0;}
		.table-standings th:nth-child(5){max-width:70px; padding-right:0;}
		.td{text-align:center; min-width:60px;}
		.add-player{padding:10px; display:block;}
		.block{display:block; width:100%;}
		.stiff{min-height:250px; float:left; display:inline;}
		span{font-weight:lighter;}
		.singles-scores,.dubs-scores{width:100%; display:block; /*height:800px; */}
		#new-player-submit{margin:5px 0px;}
		.tablea{display:inline; float:left; width:auto; margin:20px 15px;}
		.tables-div{overflow:auto; display:block;}
		.float-right{float:right; color:white;}
		.center{margin-left:320px;}
		.delete-form{height:35px;}
		.box{ overflow: auto;}
		.box2{overflow:auto; width:100%;}
		.stats{float:left; display:inline-block;margin-right:30px;}
		/*.float-lefty{float:left;}*/
		#small-div, #fake-table{width:0px; margin-left:0px; margin-right:0px;}
		.delete{display:none;}
		.stats-container{overflow:auto; width:100%; display:inline-block;}
		.clearplease{display:block; clear:both; height:30px;}
		.form-horizontal{display:inline;}
		#name{width:200px;}

		
		/*.form-group{display:block;}*/
		/*.table{width:auto;}*/
		/*.delete-form{border:1px solid black;min-height:5px; min-width:30px;}*/
	</style>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-45691909-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	<script type="text/javascript">
		$(document).ready(function(){




		// 	$(function() {
  // $(".research tr:not(.accordion)").hide();
  // $(".research tr:first-child").show();
  // $(".research tr.accordion").click(function(){
  // $(this).nextAll("tr").toggle();
  //   });
  // });

// $(function() {
//     var $research = $('.research');
//     $research.find("tr").not('.accordion').hide();
     
//      $research.find("tr"):eq(0).show();
     

//     $research.find(".accordion").click(function(){
//         $research.find('.accordion').not('.accordion').siblings().fadeOut(500);
//         $(this).siblings().not('.accordion').fadeToggle(500);
//     }).eq(0).trigger('click');
// });


			
			$('.delete').hide();


			// $('.hiderbox').click(function(){
			// 	$('.hider').show();
			// });


			$(document).on('submit', '#frm', function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						// console.log(data.newscore);
						// console.log(data.newscore[0]['winner_name']);
						// console.log(data.newscore[0]['winner_score']);
						$game= data.newscore[0];

						$html= "<table class='tablea table table-striped table-condensed' id='"+$game['id']+"'>\
						<thead>\
						   <tr class='delete-form'><td>"+$game['created_at']+"</td>\
						   <td class='td'><form class='delete' action='/stats_controller/delete' method='post'>\
											<input type='hidden' name='hidden' value='"+$game['id']+"'>\
											<button type='submit' class='btn btn-xs btn-danger'>delete</button>\
										</form></td></tr>\
						</thead>\
						<tbody>\
						<tr><th>"+$game['winner_name']+"</th><td>"+$game['winner_score']+"</td></tr><tr><td>"+$game['loser_name']+"</td><td>"+$game['loser_score']+"</td></tr>\
						</tbody>\
						</table>";

						$('#small-div').after($html);

					}, 'json');
				// $('.delete').hide(); //why is this not working
				return false;

			});




			$(document).on('submit', '#dubs-frm', function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						console.log(data.newscoredubs[0]);
						console.log(data.newscoredubs[0]['winner1']);
						console.log(data.newscoredubs[0]['loser_score']);
						$game= data.newscoredubs[0];

						$html='';
						$html= "<table class='tablea table table-striped table-condensed' id='"+$game['id']+"'>\
						<thead>\
						   <tr class='delete-form'><td>"+$game['created_at']+"</td>\
						   <td class='td'><form class='delete' action='/stats_controller/delete_dubs' method='post'>\
											<input type='hidden' name='hidden' value='"+$game['id']+"'>\
											<button type='submit' class='btn btn-xs btn-danger'>delete</button>\
										</form></td></tr>\
						</thead>\
						<tbody>\
						<tr><th>"+$game['winner1']+" & "+$game['winner2']+"</th><th>"+$game['winner_score']+"</th></tr><tr><td>"+$game['loser1']+" & "+$game['loser2']+"</td><td>"+$game['loser_score']+"</td></tr>\
						</tbody>\
						</table>";

						$('#fake-table').after($html);

					}, 'json');
				// $('.delete').hide(); //why 
				return false;
			});

			



			$(document).on('submit', '.delete', function(){
				$(this).closest('.tablea').hide();
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){


					}, 'json');
				return false;
			});

		

			$(document).on('click','li', function(){

				if(($(this).attr('value') === 'first-li'))
				{

					$('.first-li').addClass('active');
					$('.second-li').removeClass('active');
					// $('#top-li1').addClass('active');
					// $('#top-li2').removeClass('active');
					console.log('99');
				}
				else
				{
					

					$('.first-li').removeClass('active');
					$('.second-li').addClass('active');
					console.log('11');
				}
				console.log($(this).attr('value'));
				// console.log('hello');

			});


			  // $(function() {
			  //   $( "#accordion" ).accordion({
			  //     collapsible: true
			  //   });
			  // });
  
			





			$('.table-standings').tablesorter({
				 sortList: [[3,1],[1,1],[2,1]] 
			});

			$('.CityTable').tablesorter({
				 			});

$('.StateTable').tablesorter({
				 			});

			// $('.tablea').on('mouseenter', function(){
			// 	$(this).find('.delete').show();
			// });

			// $('.tablea').on('mouseleave', function(){
			// 	$(this).find('.delete').hide();
			// });

			$(document).on('mouseover', '.tablea', function(){
				$(this).find('.delete').show();
			});

			$(document).on('mouseout', '.tablea', function(){
				$(this).find('.delete').hide();
			});


			// $(document).on('click','.tablea', function(){

			// 	$(this).find('.delete').show();
			// });

			// $(document).on('click', '.tablea', function(){
			// 	// $('.delete').hide();
			// 	$(this).find('.delete').show();
			// });


			// $(document).on('mouseleave', '.tablea', function(){
			// 	$(this).find('.delete').fadeOut(100);
			// });

			
			// $('.tablea').mouseenter(function(){
			// 	$(this).find('.delete').show();
			// });

			// $('.tablea').mouseleave(function(){
			// 	$(this).find('.delete').hide();
			// });
// 	$('table.CityTable th') .click(
// 	function() {
// 		$(this) .parents('table.CityTable') .children('tbody') .toggle();
// 	}
// );

			$('form').submit(function() {
			    $('.score').removeAttr('disabled');
			});

			$('table.CityTable th') .click(
	function() {
		$(this) .parents('table.CityTable') .children('tbody') .toggle();
	}
);

// 			$('table.StateTable tr.statetablerow th') .click(
// 	function() {
// 		$(this) .parents('table.StateTable') .children('tbody') .toggle();
// 	}
// );


		});

	</script>
</head>
<body>
	<div class='container'>
		<nav class='navbar navbar-default' role='navigation'>
			<ul class='nav navbar-nav'>
				<li><h2>Dojo Ping Pong</h2></li>
				<li></li>
			</ul>
			<p class='float-right'></p>
		</nav>
		<div class='main-page'><!--used to give left margin without affecting navbar's margin -->





<ul class="nav nav-tabs" id="myTab">
  <li class="active first-li" value='first-li'><a href="#home" data-toggle="tab"><h3>Singles</h3></a></li>
  <li class='second-li' value='second-li'><a href="#profile" data-toggle="tab"><h3>Doubles</h3></a></li>
  <!-- <li><a href="#messages" data-toggle="tab">Messages</a></li>
  <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
</ul>

<!-- <table class="research">
                <tbody>
                    <tr class="accordion">
                        <td colspan="3">This is the header</td>
                    </tr>
                    <tr>
                        <td>Research</td>
                        <td>Description</td>
                        <td>Partner</td>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                    </tr>
                </tbody>
            </table>

            <table class="research">
                <tbody>
                    <tr class="accordion">
                        <td colspan="3">This is the header</td>
                    </tr>
                    <tr>
                        <td>Research</td>
                        <td>Description</td>
                        <td>Partner</td>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                    </tr>
                </tbody>
            </table>

            <table class="research">
                <tbody>
                    <tr class="accordion">
                        <td colspan="3">This is the header</td>
                    </tr>
                    <tr>
                        <td>Research</td>
                        <td>Description</td>
                        <td>Partner</td>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                    </tr>
                </tbody>
            </table>
 -->



<!-- <div class="tab-content">
  	<div class="tab-pane active" id="home">
  		<div class='stats' id='singles-table'>
			<table class=' research table table-striped table-condensed table-standings'>
				<thead>
					<tr class='dont-hide'>
						<th>Name</th>
						<th>Wins</th>
						<th>Losses</th>
						<th class='winp-column'>Win %</th>
						<th>Avg. Score</th>
						<th>Opp Avg. Score</th>
					</tr>
				</thead>
				<tbody>
					
				<?php  foreach($players as $player)
				{ ?>
				
					<tr class="accordion">
						
						<th><?= $player['first_name'] ?></th>
						<td><?= $player['wins'] ?></td>
						<td><?= $player['losses'] ?></td>
						<td><?= $player['win_pct'] ?></td>
						<td><?= $player['avgscore'] ?></td>
						<td><?= $player['oppavgscore'] ?></td>

						
					</tr>
					<tr><td>Opponents</td></tr> 
					<?php  foreach($players as $playa)
				{ ?>
				<table>
					<thead>
				<tbody>
				<tr>
					<td><?= $playa['first_name'] ?></td>
					<td><?= $playa['wins'] ?></td>
						<td><?= $playa['losses'] ?></td>
						<td><?= $playa['win_pct'] ?></td>
						<td><?= $playa['avgscore'] ?></td>
						<td><?= $playa['oppavgscore'] ?></td>
					</tr>
				</tbody>
				</thead>
				</table>
					
					<?php  } ?>
					
				<?php } ?> 
					</tbody>	
				
			</table>
		</div> -->

		<div class="tab-content">
  	<div class="tab-pane active" id="home">
  		<!-- <div class='stats' id='singles-table'>
			<table rules='all' class=' StateTable research table table-striped table-condensed table-standings'>
				<thead>
					<tr class='dont-hide statetablerow'>
						<th>Name</th>
						<th>Wins</th>
						<th>Losses</th>
						<th class='winp-column'>Win %</th>
						<th>Avg. Score</th>
						<th>Opp Avg. Score</th>
					</tr>
				</thead>
				<tbody>
					
				<?php  foreach($players as $player)
				{ ?>
				
					<tr>
						<td>
							<table class="CityTable" rules='all'>
								<thead>
									<th><?= $player['first_name'] ?></th>
									<td><?= $player['wins'] ?></td>
									<td><?= $player['losses'] ?></td>
									<td><?= $player['win_pct'] ?></td>
									<td><?= $player['avgscore'] ?></td>
									<td><?= $player['oppavgscore'] ?></td>
								</thead>
								<tbody>
								<?php  foreach($players as $playa)
								{ ?>
								<tr>
									<td><?= $playa['first_name'] ?></td>
									<td><?= $playa['wins'] ?></td>
									<td><?= $playa['losses'] ?></td>
									<td><?= $playa['win_pct'] ?></td>
									<td><?= $playa['avgscore'] ?></td>
									<td><?= $playa['oppavgscore'] ?></td>
								</tr>
								<?php  } ?>
								</tbody>
							</table>
						</td>
					</tr>
			
			
				<?php } ?> 
					</tbody>	
				
			</table>
		</div> -->


		<table  class="table StateTable" rules="all">
   <thead>
      <tr class='dont-hide statetablerow'>
						<th>Name</th>
						<th>Wins</th>
						<th>Losses</th>
						<th class='winp-column'>Win %</th>
						<th>Avg. Score</th>
						<th>Opp Avg. Score</th>
					</tr>
   </thead>
   <tbody>
     
      

<?php  foreach($players as $player)
				{ ?>
				
					<tr>
						<td colspan='3'>
							<table class="table CityTable" rules="all">
								<thead>
									<tr>
									<th><?= $player['first_name'] ?></th>
									<th><?= $player['wins'] ?></th>
									<th><?= $player['losses'] ?></th>
									<th><?= $player['win_pct'] ?></th>
									<th><?= $player['avgscore'] ?></th>
									<th><?= $player['oppavgscore'] ?></th>
									</tr>
								</thead>
								<tbody>

                  	<?php  foreach($players as $playa)
								{ ?>
								<tr>
									<td><?= $playa['first_name'] ?></td>
									<td><?= $playa['wins'] ?></td>
									<td><?= $playa['losses'] ?></td>
									<td><?= $playa['win_pct'] ?></td>
									<td><?= $playa['avgscore'] ?></td>
									<td><?= $playa['oppavgscore'] ?></td>
								</tr>
								<?php  } ?>
                  		</tbody>
							</table>
						</td>
					</tr>
			
			
				<?php } ?> 
                     
              </tbody>
           </table>
        </td>
     </tr>





   </tbody>
</table>
<!-- 
<table class=" table research table">
                <tbody>
                    <tr class="accordion">
                        <td colspan="3">This is the header</td>
                    </tr>
                    <tr>
                        <td>Research</td>
                        <td>Description</td>
                        <td>Partner</td>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                    </tr>
                </tbody>
            </table>

            <table class="table research">
                <tbody>
                    <tr class="accordion">
                        <td colspan="3">This is the header</td>
                    </tr>
                    <tr>
                        <td>Research</td>
                        <td>Description</td>
                        <td>Partner</td>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                    </tr>
                </tbody>
            </table>

            <table class="table research">
                <tbody>
                    <tr class="accordion">
                        <td colspan="3">This is the header</td>
                    </tr>
                    <tr>
                        <td>Research</td>
                        <td>Description</td>
                        <td>Partner</td>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</td>
                    </tr>
                </tbody>
            </table> -->

				<div class='stiff'>
				

				<!-- <div class='row singles'> -->
					<form action='stats_controller/score_process' method='post' class='form-horizontal' role='form' id='frm'>
						<h3>Input Scores</h3>
						<!-- <button class='press-singles' type='button'>Singles</button> -->
						<div class='form-group'>
						    <label for="team1" class="col-xs-2 control-label">Winner</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="team1" name='team1' placeholder="name">
						    </div>
						    <label for="team2" class="col-xs-2 control-label">Loser</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="team2" name='team2' placeholder="name">
						    </div>
						</div>
					
						<div class='form-group'>
						
						    <label for="score1" class="col-xs-2 control-label">Score</label>
						    <div class="col-xs-3">
						    	<input class='form-control score' type="text" id="score1" name='score1' placeholder="player 1 score" value='21' disabled='disabled'>
						    </div>
						    <label for="score2" class="col-xs-2 control-label">Score</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="score2" name='score2' placeholder="player 2 score">
						    </div>
						</div>

						<button class='btn btn-success' type='submit'>Submit</button>
					
					</form>
				<!-- </div>end of row singles  -->
			</div><!--end of class stiff-->
<div class='clearplease'></div>


<div class='add-player'>
					<form role='form' action='stats_controller/new_player' method='post'>
						<label for='name'><h4>Add New Player</h4></label>
						<input class='form-control' type='text' id='name' name='name' placeholder='enter first name'>
						<button id='new-player-submit' class='btn btn-sm btn-primary' type='submit'>Submit</button>
					</form>
					<div class='block'>
						<a href="<?php echo site_url('stats_controller/to_delete/uri'); ?>">Click here to delete a player</a>
					</div>		
					
					<?php
					if(isset($errors))
					{
						echo $errors;
					}
				?>

			<form action='stats_controller/match_ups' method='post'>
				<input type='text' name='name'>
				<input type='text' name='opponent'>
				<button type='submit'>get match ups</button>
			</form>
		</div>
<ul class="nav nav-tabs" id="myTab">
  <li class="active first-li" value='first-li'><a href="#home" data-toggle="tab"><h3>Singles</h3></a></li>
  <li class='second-li' value='second-li'><a href="#profile" data-toggle="tab"><h3>Doubles</h3></a></li>
  <!-- <li><a href="#messages" data-toggle="tab">Messages</a></li>
  <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
</ul>
<!-- end of input scores -->
<!--start of game log-->
<!-- <h3 class='center'><button type='button' class='press2'>Singles</button></h3> -->

	 	

<div class='singles-scores box'> <!--where singles scores tables go-->
				
				<div class='box2'>
					<table id='small-div' class='tablea table table-striped table-condensed'></table>
						<!--this is an empty table where I use jquery after() to append new tables here -->

					<?php
						foreach($scores as $score)
						 {	
					?>
						<table class='tablea table table-striped table-condensed' id='<?php echo $score['id']; ?>'>
							<thead>
								<tr class='delete-form'>
									<td>	
									<?= 
										$score['created_at'] = (date('M d, Y g:ia ', strtotime($score['created_at'])));
										$score['created_at'] 
									?>
									</td>
									<td>
										<form class='delete' action='/stats_controller/delete' method='post'>
											<input type='hidden' name='hidden' value='<?php echo $score['id']; ?>'>
											<button type='submit' class='btn btn-xs btn-danger'>delete</button>
										</form>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th><?= $score['winner_name'] ?></th>
									<td class='td'><?= $score['winner_score'] ?></td>
								</tr>
								<tr>
									<td ><?= $score['loser_name'] ?></td>
									<td class='td'><?= $score['loser_score'] ?></td>
								</tr>
							</tbody>
						</table>
					<?php  }  ?>
				</div><!--end of div box2-->
			</div><!--  end of class singles-scores --> 


	</div>




  <div class="tab-pane" id="profile">
				<div class='stats' id='doubles-table'>
					<table class='table table-striped table-condensed  table-standings'>
						<thead>
							<tr>
								<th>Name</th>
								<th>Wins</th>
								<th>Losses</th>
								<th class='winp-column'>Win %</th>
								<th>Avg. Score</th>
								<th>Opp Avg. Score</th>
							</tr>
						</thead>
						<tbody>
					<?php foreach($dubsplayers as $player)
					{ ?>
							<tr>
								<th><?= $player['first_name'] ?></th>
								<td><?= $player['wins'] ?></td>
								<td><?= $player['losses'] ?></td>
								<td><?= $player['win_pct'] ?></td>
								<td><?= $player['avgscore'] ?></td>
								<td><?= $player['oppavgscore'] ?></td>
							</tr>
					<?php } ?>		
						</tbody>
					</table>
				</div>



			<div class='stiff'>
				
					<form action='stats_controller/score_process' method='post' class='form-horizontal col-xs-12' role='form' id='dubs-frm'>
						<h3>Input Scores</h3>
						<!-- <button class='press-dubs' type='button'>Doubles</button> -->
						
						<div class="form-group">
						    <label for="team1" class="col-xs-2 control-label">Winner</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="team1" name='team1' placeholder="name">
						    </div>
						    <label for="team2" class="col-xs-2 control-label">Loser</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="team2" name='team3' placeholder="name">
						    </div>
						</div>
						<div class="form-group">
						    <label for="team1" class="col-xs-2 control-label">Winner</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="team1b" name='team2' placeholder="name">
						    </div>
						    <label for="team2" class="col-xs-2 control-label">Loser</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="team2b" name='team4' placeholder="name">
						    </div>
						</div>
						<div class="form-group">
						    <label for="dubscore1" class="col-xs-2 control-label">Score</label>
						    <div class="col-xs-3">
						    	<input class='form-control score' type="text" id="dubscore1" name='score1' placeholder="player 1 score" value='21' disabled='disabled'>
						    </div>
						    <label for="dubscore2" class="col-xs-2 control-label">Score</label>
						    <div class="col-xs-3">
						    	<input class='form-control' type="text" id="dubscore2" name='score2' placeholder="player 2 score">
						    </div>
						</div>
						<button class='btn btn-success' type='submit'>Submit</button>
					</form>
				<!--end of row doubles -->


			</div><!--end of class stiff-->

<div class='clearplease'></div>
<div class='add-player'>
					<form role='form' action='stats_controller/new_player' method='post'>
						<label for='name'><h4>Add New Player</h4></label>
						<input class='form-control' type='text' id='name' name='name' placeholder='enter first name'>
						<button id='new-player-submit' class='btn btn-sm btn-primary' type='submit'>Submit</button>
					</form>
					<div class='block'>
						<a href="<?php echo site_url('stats_controller/to_delete/uri'); ?>">Click here to delete a player</a>
					</div>		
					
					<?php
					if(isset($errors))
					{
						echo $errors;
					}
				?>
				</div>

<ul class="nav nav-tabs" id="myTab">
  <li class="active first-li" value='first-li'><a href="#home" data-toggle="tab"><h3>Singles</h3></a></li>
  <li class='second-li' value='first-li'><a href="#profile" data-toggle="tab"><h3>Doubles</h3></a></li>
  <!-- <li><a href="#messages" data-toggle="tab">Messages</a></li>
  <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
</ul>
<!-- end of input scores -->
			
<!--start of game log-->
<!-- <h3 class='center'><button type='button' class='press2'>Singles</button></h3> -->
<!-- end of input scores -->
			
<!--start of game log-->
<!-- <h3 class='center'><button type='button' class='press2'>Singles</button></h3> -->

	 		<div class='box'> <!--where doubles scores tables go-->
	 			<div class='dubs-scores' style='position:absolute; width:80%'>
	 				<!-- <h3 class='center'><button type='button' class='press2'>Doubles</button></h3> -->
	 				<div class='box2'>

		 			<table id='fake-table' class='tablea table table-striped table-condensed'></table>
						<!--this is an empty table where I use after() on new tables to append them here -->
					
					<?php
						// $i=0;
						foreach($dubs_scores as $score)
						 {	//var_dump($score['id']);
						// 	if($i%3==0) echo "<div class='tables-div row'>";
						// 	$i++
					 ?>
						<table class='tablea table table-striped table-condensed'>
							<thead>
								<tr class='delete-form'>
									<td>	
										<?= 
										$score['created_at'] = date('M d, Y g:ia ', strtotime($score['created_at']));
										$score['created_at'] ?>
									</td>
									<td>
										<form class='delete' action='/stats_controller/delete_dubs' method='post'>
											<input type='hidden' name='hidden' value='<?php echo $score['id']; ?>'>
											<button type='submit' class='btn btn-xs btn-danger'>delete</button>
										</form>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th><?= $score['winner1'] ?> <span>&</span> <?= $score['winner2'] ?></th>
									<td class='td'><?= $score['winner_score'] ?></td>
								</tr>
								<tr>
									<td ><?= $score['loser1'] ?> & <?= $score['loser2'] ?></td>
									<td class='td'><?= $score['loser_score'] ?></td>
								</tr>
							</tbody>
						</table>
					<?php } ?>
					</div><!--end of div box2-->
				</div><!--end of class dubs-scores-->
			</div><!--end of class box-->


			</div>
 <!--  <div class="tab-pane" id="messages">messages stuff</div>
  <div class="tab-pane" id="settings">settings stuff</div> -->
</div><!--end of tab content -->


			

			      <!--end of game log -->
		</div><!--end of main page-->
	</div><!--end of container-->
</body>
</html>