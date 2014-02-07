<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset='utf-8'>
	<title>Dojo Ping Pong</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
	<script type="text/javascript" src='/assets/js/jquery.tablesorter.js'></script>
	<script type="text/javascript" src='/assets/js/bootstrap.js'></script>
	<link rel='stylesheet' href='/assets/css/bootstrap.css'>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link href="/assets/textillate/animate.css" rel="stylesheet">
 <!--  <link href="/assets/textillate/style.css" rel="stylesheet"> -->
    <script type="text/javascript" src='/assets/textillate/jquery.textillate.js'></script>
    <script type="text/javascript" src='/assets/textillate/jquery.lettering.js'></script>
    <script type="text/javascript" src="/assets/js/bootstrap-select.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/stats_css.css">

  

 	<style type="text/css">
 	body{background-image:url('assets/img/pingpong6.jpg');}

 	.hidebutton {min-width:80px; text-align:left;}
 	.short-word{visibility:hidden; font-size:1px;}

	 @media only screen and (max-device-width: 480px)
	{
	  	.short-word{visibility:visible; font-size:14px;}
	  	.full-word{display:none;}

	  	div.mobile {
	  		display:none;
	  	}
	  	div.main-page{margin-left:5px;}
		  	.nav > li > a {
		  padding: 0px 5px 2px 5px;
		}

		/*.li .h2, .nav {margin-top:50px; margin-bottom:50px; padding:0px;}*/

		.navbar,.navbar-default, #navbar {height: 55px; margin-top:-20px;}
		.table-standings { margin-top:-15px;}
		tr .hoverme{width:500px;}
		.table-standings #name-col{width:520px;}
		.table-standingsnew td:nth-child(7), .table-standingsnew td:nth-child(7){padding-left:0;}
		.table-standings td:nth-child(n+3):nth-child(-n+4), .table-standings th:nth-child(n+3):nth-child(-n+4) {width:30px;}
		.table-standing td:nth-child(n+3):nth-child(-n+4), .table-standing th:nth-child(n+3):nth-child(-n+4) {width:30px;}
		.td3{width:10px;margin:0px; padding:0px;}
		.td4{width:10px;margin:0px; padding:0px;}
	}	
 	</style>

	<script type="text/javascript">
									//GOOGLE ANALYTICS
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-45691909-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	<?php //$this->load->view('stats_jquery.php') ?>
	<script type="text/javascript">
		$(document).ready(function(){
			 $(".table-standing").tablesorter(); 
			 $(".table-standingsnew").tablesorter();
			$('h2').textillate({ in: { effect: 'swing', shuffle:true } });
			
			 // $('h4').textillate({in: {effect:'tada', shuffle:true}});

			//  $('.table-standing').tablesorter({
			// 	 sortList: [[3,1],[1,1],[2,1]] 
			// });
			// $('.hidethis').on('click', function(){
					// 	$(this).hide();
					// });
			 
			$('.delete').hide(); //HIDES ALL THE DELETE BUTTONS ON PAGE LOAD

				
			
 			$(".opponents").hide(); //HIDES INDIVIDUAL STATS ON PAGE LOAD
 			
 			
			
			$(document).on('mouseenter','.opp-record',function(){
				$(this).submit();
				// console.log("mouse is entering");
				// console.log($(this));
			}); //SHOWS INDIVIDUAL STATS ON HOVER

			

			$(document).on('submit', '.delete', function(){ 
				$(this).closest('.tablea').hide();
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
					}, 'json');
				return false;
			});

			$(document).on('click','.listy', function(){ //THIS SYNCS THE TWO TAB BARS TOGETHER
				if(($(this).attr('value') === 'first-li')){
					$('.first-li').addClass('active');
					$('.second-li').removeClass('active');	
				}else{
					$('.first-li').removeClass('active');
					$('.second-li').addClass('active');	
				}
			});
			
		
			 $('.table-standings').tablesorter({
				 sortList: [[1,1]] 
			});



//START OF INPUT SCORES SELECT NAME AND SCORE MENU FUNCTION 
			(function( $ ) {
			    $.widget( "custom.combobox", {
			      _create: function() {
			        this.wrapper = $( "<span>" )
			          // .addClass( "custom-combobox" )
			          .insertAfter( this.element );
			 
			        this.element.hide();
			        this._createAutocomplete();
			        this._createShowAllButton();
			      },
			 
			      _createAutocomplete: function() {
			        var selected = this.element.children( ":selected" ),
			          value = selected.val() ? selected.text() : "";
			 
			        this.input = $( "<input>" )
			          .appendTo( this.wrapper )
			          .val( value )
			          .attr( "title", "" )
			          .attr("type", "text")
			          // .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
			          .autocomplete({
			            delay: 0,
			            minLength: 0,
			            source: $.proxy( this, "_source" )
			          })
			          .tooltip({
			            tooltipClass: "ui-state-highlight"
			          });
			 
			        this._on( this.input, {
			          autocompleteselect: function( event, ui ) {
			            ui.item.option.selected = true;
			            this._trigger( "select", event, {
			              item: ui.item.option
			            });
			          },
			 
			          autocompletechange: "_removeIfInvalid"
			        });
			      },
			 
			      _createShowAllButton: function() {
			        var input = this.input,
			          wasOpen = false;
			 
			        $( "<a>" )
			          .attr( "tabIndex", -1 )
			          .attr( "title", "Show All Items" )
			          .tooltip()
			          .appendTo( this.wrapper )
			          .button({
			          	// .attr{'height',"50px"}
			            icons: {
			              primary: "ui-icon-triangle-1-s"
			            },
			            text: false
			          })
			          .removeClass( "ui-corner-all" )
			          .addClass( "custom-combobox-toggle ui-corner-right" )
			          .mousedown(function() {
			            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
			          })
			          .click(function() {
			            input.focus();
			 
			            // Close if already visible
			            if ( wasOpen ) {
			              return;
			            }
			 
			            // Pass empty string as value to search for, displaying all results
			            input.autocomplete( "search", "" );
			          });
			      },
			 
			      _source: function( request, response ) {
			        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
			        response( this.element.children( "option" ).map(function() {
			          var text = $( this ).text();
			          if ( this.value && ( !request.term || matcher.test(text) ) )
			            return {
			              label: text,
			              value: text,
			              option: this
			            };
			        }) );
			      },
			 
			      _removeIfInvalid: function( event, ui ) {
			 
			        // Selected an item, nothing to do
			        if ( ui.item ) {
			          return;
			        }
			 
			        // Search for a match (case-insensitive)
			        var value = this.input.val(),
			          valueLowerCase = value.toLowerCase(),
			          valid = false;
			        this.element.children( "option" ).each(function() {
			          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
			            this.selected = valid = true;
			            return false;
			          }
			        });
			 
			        // Found a match, nothing to do
			        if ( valid ) {
			          return;
			        }
			 
			        // Remove invalid value
			        this.input
			          .val( "" )
			          .attr( "title", value + " didn't match any item" )
			          .tooltip( "open" );
			        this.element.val( "" );
			        this._delay(function() {
			          this.input.tooltip( "close" ).attr( "title", "" );
			        }, 2500 );
			        this.input.data( "ui-autocomplete" ).term = "";
			      },
			 
			      _destroy: function() {
			        this.wrapper.remove();
			        this.element.show();
			      }
			    });
			  })( jQuery );
//END OF INPUT SCORES SELECT NAME AND SCORE MENU FUNCTION 
 
		 

		      $(function() {
		     $( "#combobox5" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox5" ).toggle();
		    });
		     $( "#combobox6" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox6" ).toggle();
		    });
		     $( "#combobox7" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox7" ).toggle();
		    });
		     $( "#combobox8" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox8" ).toggle();
		    });
		     $( "#combobox9" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox9" ).toggle();
		    });
		     $( "#combobox10" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox10" ).toggle();
		    });

		  });

		         $('.selectpicker').selectpicker();

		});

	$(document).ready(function () {		
	var bouncetime = 800;
	var ballheight = 260;
	var ballsize = 80;

	$('#ball').css({'width':ballsize, 'height':ballsize, 'margin-left':-(ballsize/2),'display':'block', 'bottom':ballheight});
	$('#shadow').css({'width':ballsize*1.5, 'height':ballsize/3, 'margin-left':-(ballsize*0.75),'display':'block', 'opacity':0.2});

	ballbounce();
	ballshadow();

	function ballbounce() {
		$('#ball').animate({'bottom':20}, bouncetime, 'easeInQuad', function() {
			$('#ball').animate({'bottom':ballheight}, bouncetime, 'easeOutQuad', function() {
				ballbounce();
			});
		});
	}
	function ballshadow() {
		$('#shadow').animate({'width':ballsize, 'height':ballsize/4, 'margin-left':-(ballsize/2), 'opacity':1}, bouncetime, 'easeInQuad', function() {
			$('#shadow').animate({'width':ballsize*1.5, 'height':ballsize/3, 'margin-left':-(ballsize*0.75), 'opacity':0.2}, bouncetime, 'easeOutQuad', function() {
				ballshadow();
			});
		});
	}
});


	</script>

</head>
<body>
	<div class='container'>
		<nav class='navbar navbar-default' id= 'navbar' role='navigation'>
			<ul class='nav navbar-nav'>
				<li><h2>Dojo Ping Pong</h2></li>
			</ul>
			<p class='float-right'></p>
		</nav>
		<div class='main-page'><!--used to give left margin without affecting navbar's margin -->
			
		<!-- 	<div id="ball">
				<p style='margin:25px 25px;'>stiga</p>
				<p style='margin:-20px 25px;'>* * *</p>
			</div>
 			 <div id="shadow"></div> -->
 			 


		<ul class="nav nav-tabs" id="myTab">
		  <li class="active first-li listy" value='first-li'><a href="#home" data-toggle="tab"><h3>Singles</h3></a></li>
		  <li class='second-li listy' value='second-li'><a href="#profile" data-toggle="tab"><h3>Doubles</h3></a></li>
		</ul> 
			<div class="tab-content"> <!--MOST PAGE CONTENT IS UNDER THIS TAB CLASS-->
			  	<div class="tab-pane active" id="home"><!--SINGLES TAB -->
			  		<div class='top-section'> <!--TOP SECTION -->
			  		<div class='stats' id='singles-table'><!--STANDINGS TABLE-->
			  			<h4 style='margin-bottom:0px;'>Singles Standings</h4>
						<table class='table table-striped table-condensed table-standings'>
							<thead>
								<tr>
									<th class='name-col' id='name-col'>Name</th>
									<th>Rating</th>
									<th class='wins-col'><b class='full-word'>Wins</b><b class='short-word'>W<b></th>
									<th class='loss-col'><b class='full-word'>Losses</b><b class='short-word'>L<b></th>
									<th class='winp-column'><b class='full-word'>Win %</b><b class='short-word'>W%<b></th>
									<th>Avg. Score</th>
									<th><abbr title="Opponents' average score"><b class='full-word'>Opp Avg. Score</b><b class='short-word'>O.A.S.<b></abbr></th>						
								</tr>
							</thead>
							<tbody class='tbody'>	
										<!--  variable $players is an array of all users that was generated from a query in stats model-->
							<?php $i = 1; foreach($players as $player)
							{ 
								if (($player['wins']+$player['losses'])!==0)
								{
										
									if (($player['wins']+$player['losses'])<3)
									{
										$playerrating = 'prov';
									}
									else
									{
										$playerrating = floatval(round($player['rating'], 1));
									}
								 ?>
									<tr>			
										<th class='hoverme' id='hoverme'>
											<form class='opp-record' action='stats_controller/indiv_stats' method='post'>
												<input type='hidden' name='name' value='<?= $player['first_name'] ?>'>
												<button type='submit' class='hidebutton'><b><?php echo $i." ".$player['first_name']; ?><b></button>
											</form>		
										</th>
										<td class='td1'><?= $playerrating ?></td>
										<td class='td2'><?= $player['wins'] ?></td>
										<td class='td3'><?= $player['losses'] ?></td>
										<td class='td4'><?= $player['win_pct'] ?></td>
										<td class='td5'><?= $player['avgscore'] ?></td>
										<td class='td6'><?= $player['oppavgscore'] ?></td>	
									</tr>		
							<?php $i++; } } ?>			
							</tbody>
						</table>
					</div>

<!-- HIDDEN -->
					<div class='stats opponents'><!--OPPONENTS STATS ARE HIDDEN ON PAGE LOAD-->
						<h4 class='opponents-head'></h4>
						<table class='table table-striped table-condensed table-standing'>
							<thead>
								<tr>
									<th style='width:60px;'><abbr title='opponent name'>Opp Name</abbr></th>
									<th><abbr title='number of wins against opponent'>Wins<abbr></th>
									<th>Losses</th>
									<th class='winp-column'>Win %</th>
									<th><abbr title='average points scored against opponent'>Avg. Score Against</abbr></th>
									<th>Opp Avg. Score</th>
									<th>Opp Rating</th>
								</tr>
							</thead>
							<tbody id='spacer'>
								<!--OPPONENTS RECORDS WILL APPEND HERE WHEN YOU CLICK ON A NAME IN THE SINGLES STANDINGS TABLE-->
							</tbody>
						</table>

					</div>

					<div class='clearplease'></div>
					<div class='stiff' id='stiff'>  <!--INPUT SCORES HERE-->
					<!-- <div class='row singles'> -->
					



<div class='mobile' style='color:red;'><p>*Players with fewer than 3 games played will have a provisional rating</p></div>




					<form action='stats_controller/score_process' method='post' id='frm' role='form'>
							<h3 style='margin-top:10px;'>Input Scores</h3>
							<div>
								<div class="select">
									
										<label for="combobox" class="">Winner</label>
									  <select name='team1' id="combobox" class='selectpicker show-tick'>
									  	 <option value=""> </option>
									    <?php foreach($players as $player)
										{ ?>
											<option value="<?= $player['first_name'] ?>"><?= $player['first_name'] ?></option>
																			
										<?php } ?>
									  </select>	
								</div>

								<div class="select" >

										<label for="combobox2" class="">Loser</label>
									  <select name='team2' id="combobox2"  class='selectpicker show-tick' >
									    <option value=""> </option>
									    <?php foreach($players as $player)
										{ ?>
											<option value='<?= $player['first_name'] ?>'><?= $player['first_name'] ?></option>				
										<?php } ?>
									  </select>
								</div>
							</div>

							<div>
								<div class="select">
									
										<label for="combobox3" class="">Score</label>
									  <select id="combobox3" name='score1' class='selectpicker show-tick'>

									    <option value="21">21</option>
									    <option value="11">11</option>
									 
									  </select>
									
								</div>

								<div class="select">
<!-- // I MADE SOME CHANGES HERE -->
										<label for="combobox4" class="">Score</label>
									  <select id="combobox4" name='score2'  class='selectpicker show-tick'>
		
									    <!-- <option value="">Select one...</option> -->
									    <?php for($i=20; $i>-1; $i--)
										{ ?>
											<option value='<?= $i ?>'><?= $i ?></option>
																			
										<?php } ?>
									  </select>
								</div>
								
							</div>
							<!--SUBMIT BUTTON FOR INPUT SCORES -->
						<button class='btn btn-success' type='submit'>Submit</button>
						<p id='congrats' style='display:none; float:right; margin-right:5px; color:darkgreen;'></p>
					</form>





					<!-- </div>end of row singles  -->
					</div><!--end of class stiff END OF INPUT SCORES-->
						<!--SUBMIT NAMES TO VIEW MATCH UP DO NOT DELTE!!! -->
						<!-- <form action='stats_controller/match_ups' method='post'>
							<input type='text' name='name'>
							<input type='text' name='opponent'>
							<button type='submit'>get match ups</button>
						</form> -->

					</div><!--end of top-section -->
					<div class='clearplease'></div>

				<ul class="nav nav-tabs" id="myTab"> <!--ANOTHER PLACE TO SWITCH TABS -->
				  <li class="active first-li listy" value='first-li'><a href="#home" data-toggle="tab"><h3>Singles</h3></a></li>
				  <li class='second-li listy' value='second-li'><a href="#profile" data-toggle="tab"><h3>Doubles</h3></a></li>
				</ul>

<!--start of SCORE log-->

					<div class='singles-scores box'> <!--where singles scores tables go-->
					
						<div class='box2'>
							<table id='small-div' class='tablea table table-striped table-condensed'></table>
								<!--#SMALL-DIV is an empty table where I use jquery after() to append new tables here -->
							<?php $i = 0; //will be used to break loop and limit # of stats tables
								foreach($scores as $score) //received as $data[scores] from controller
								 {	
							?>
								<table class='tablea table table-striped table-condensed' id='<?php echo $score['id']; ?>'>
									<thead>
										<tr class='delete-form'>
											<td>	
											<?= 
												$score['created_at'] = (date('M d, Y g:ia ', strtotime($score['created_at'])));
												// $score['created_at'] 
											?>
											</td>
											<td>
												<form class='delete' action='stats_controller/delete' method='post'>
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
							<?php  if(++$i > 15) break;  }  ?> <!-- limit number of tables --> 
						</div><!--end of div box2-->
					</div><!--  end of class singles-scores --> 
				</div><!--end of first tabbed -->


 <?php // require_once('_doubles_tab.php') ?>
<?php $this->load->view('_doubles_tab.php') ?>
				<!--START OF DOUBLES TAB -->
		  	
			</div><!--end of tab content -->

			<!-- ADD NEW PLAYER AND NEW PLAYER'S RATING -->
			<div class='add-player'>
				<div class='in-add-player'>
					<form role='form' action='stats_controller/new_player' method='post'>
						<label for='name'><h4>Add New Player</h4></label>
						<input class='form-control' type='text' id='name' name='name' placeholder='enter first name'>
						<select name='rating'>
							<?php for($i=30; $i<=70; $i+=5){
							echo "<option value='{$i}'>{$i}</option>";}
							?>
						</select>
						<p><span style='color:red;'>New players will only show in doubles page until 1 game has been played</span><p>
						<button id='new-player-submit' class='btn btn-sm btn-primary add-player-btn' type='submit'>Submit</button>
					</form>
					<div class='block'>
						<a href="<?php echo site_url('stats_controller/to_delete/uri'); ?>">Click here to delete a player</a>
					</div>			
				</div>
			</div><!--END OF ADD PLAYER-->  
			<div class='message-section'>
				<h4>Post a nice message or some mean smack talk</h4>
				<form id='message-form' method='post' action='stats_controller/messages'>
					<label for='message-username'>Player name</label>
					<select class='form-inline' id='message-username' name='id'>
						
						<?php 
							foreach($players as $player) {
								//var_dump($player);
						?>
								<option value="<?= $player['id'] ?>"><?= $player['first_name'] ?></option>
						<?php	} ?>
					</select>
					<textarea name='message' class='form-control txlout' placeholder='enter message here'></textarea>
					<button class='btn btn-primary' type='submit'>Submit</button>
				</form>
				<div class='messages-tables'>
					<?php $i = 0; //limit # of comments shown
					foreach($messages as $message)
					{ $message['updated_at'] = (date('M d, Y g:ia ', strtotime($message['updated_at'])));
						?>
						<div class='tx'>
							<b><?= $message['first_name'] ?> wrote on <?= $message['updated_at'] ?></b>
							<p><?= $message['content'] ?></p>
						</div>
						<?php if(++$i > 7) break; } ?> <!-- limit number of messages -->
				</div>
			</div>    
		</div><!--end of main page-->
	</div><!--end of container-->
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('submit','.opp-record', function(){
				//console.log("show me something!"); // SHOWS INDIVIDUAL STATS WHEN NAME IS CLICKED or Hovered
				$('.opp-record').find('b').removeClass('green');
				$(".opponents").show();
					$.post( 
						$(this).attr('action'),
						$(this).serialize(),
						function(data){

							// console.log(data);
							//console.log('opponent record was requested- you clicked on the standings table');
							$('#spacer').html("");
							// console.log(data);
							$.each(data, function(key,value){
								
								$('#spacer').append("<tr><td>"+value['first_name']+"</td><td>"+value['wins']+"</td><td>"+value['losses']+"</td><td>"+value['win_pct']+"</td><td>"+value['ownscore']+"</td><td>"+value['oppscore']+"</td><td>"+value['rating']+"</td></tr>");

								$('.opponents-head').html(value['name']['name']);
							});
							 $(".table-standing").trigger("update");
							  $(".table-standing").tablesorter();
							   
				            // var sorting = [[3,1],[1,1],[2,1]] 
				            // $(".table-standing").trigger("sorton", [sorting]);		
						}, 'json' );
					$(this).find('b').addClass('green');
					return false;

				});

				$(document).on('submit', '#frm', function(){   //AJAX DISPLAY NEW SCORE WHEN INPUT FORM IS SUBMITTED
					$.post(
						$(this).attr('action'),
						$(this).serialize(),
						function(data){
							// console.log(data.newscore);
							// console.log(data.newscore[0]['winner_name']);
							// console.log(data.newscore[0]['winner_score']);
							$game= data.newscore[0];
							$('#congrats').css('display','none');

							$html= "<table style='display:none' class='tablea table table-striped table-condensed freshscore' id='"+$game['id']+"'>\
										<thead>\
										   <tr class='delete-form'><td>"+$game['created_at']+"</td>\
										   <td class='td'><form class='delete' action='stats_controller/delete' method='post' style='display:none;'>\
															<input type='hidden' name='hidden' value='"+$game['id']+"'>\
															<button type='submit' class='btn btn-xs btn-danger'>delete</button>\
											</form></td></tr>\
										</thead>\
										<tbody>\
											<tr><th>"+$game['winner_name']+"</th><td>"+$game['winner_score']+"</td></tr><tr><td>"+$game['loser_name']+"</td><td>"+$game['loser_score']+"</td></tr>\
										</tbody>\
							</table>";
							

							$('#small-div').after($html); //PUTS NEW TABLE POSITIONED AFTER DIV "SMALL DIV"
							$('.freshscore').fadeIn(500);

							$success = "Congratulations "+$game['winner_name']+"!";
							$('#congrats').html($success);
							$('#congrats').fadeIn(300); //DISPLAYS CONFIRM MESSAGE AFTER SUBMITTING SCORE
							$('#congrats').textillate({ in: { effect: 'tada', shuffle: true, delayScale: 0.0, } });
							// $STATS WILL BE USED TO DISPLAY NEW RATINGS
							// $stats = "<p>"+data.players[0]['first_name']+data.players[0]['rating']+"</p><p>"+data.players[1]['first_name']+data.players[1]['rating']+"</p><p>"+data.players[2]['first_name']+data.players[2]['rating']+"</p><p>"+data.players[3]['first_name']+data.players[3]['rating']+"</p><p>"+data.players[4]['first_name']+data.players[4]['rating']+"</p>"; 
							// console.log($stats);
								
								$('#singles-table').html("");
								$prehtml = "<h4 style='margin-bottom:0px;'>Singles Standings</h4>\
							<table class='table table-striped table-condensed table-standingsnew'>\
								<thead>\
									<tr>\
										<th class='name-col'>Name</th>\
										<th>Rating</th>\
										<th class='wins-col'><b class='full-word'>Wins</b><b class='short-word'>W<b></th>\
										<th class='loss-col'><b class='full-word'>Losses</b><b class='short-word'>W<b></th>\
										<th class='winp-column'><b class='full-word'>W%</b><b class='short-word'>W<b></th>\
										<th>Avg. Score</th>\
										<th><abbr title='Opponents' average score'><b class='full-word'>Opp Avg. Score</b><b class='short-word'>O.A.S.<b></abbr></th>\
										</tr>\
								</thead>\
								<tbody class='tbody'>";
								$('#singles-table').append($prehtml);
							// console.log(data.players);
							$i = 1;
							$.each(data.players, function(key,player){
								// console.log(key);
								// console.log(player['first_name']);
								
								if ((player['wins']+player['losses'])<3)
								{
									$playerrating = 'prov';
								}
								else
								{
									$playerrating = Math.round((player['rating']) * 10) / 10;
								}

								$html = "<tr>\
											<th class='hoverme'>\
												<form class='opp-record' action='stats_controller/indiv_stats' method='post'>\
													<input type='hidden' name='name' value='"+player['first_name']+"'>\
													<button type='submit' class='hidebutton'><b>"+ $i+" "+player['first_name']+"<b></button>\
												</form>\
											</th>\
											<td class='td1'>"+$playerrating +"</td>\
											<td class='td2'>"+player['wins'] +"</td>\
											<td class='td3'>"+player['losses'] +"</td>\
											<td class='td4'>"+player['win_pct'] +"</td>\
											<td class='td5'>"+player['avgscore'] +"</td>\
											<td class='td6'>"+player['oppavgscore'] +"</td>\
											</tr>";
										$('.tbody').append($html);
										$i++;
							});
							// $posthtml = "</tbody></table>";
							// $('#singles-table').append($posthtml);

							 $(".table-standingsnew").tablesorter();
						}, 'json');
					return false;
				});  



				$(document).on('submit', '#dubs-frm', function(){ //AJAX DISPLAY NEW DOUBLES SCORES
					$.post( 
						$(this).attr('action'),
						$(this).serialize(),
						function(data){
							// console.log(data.newscoredubs[0]);
							// console.log(data.newscoredubs[0]['winner1']);
							// console.log(data.newscoredubs[0]['loser_score']);
							$game= data.newscoredubs[0];

							$html='';
							$html= "<table class='tablea table table-striped table-condensed' id='"+$game['id']+"'>\
							<thead>\
							   <tr class='delete-form'><td>"+$game['created_at']+"</td>\
							   <td class='td'><form class='delete' action='stats_controller/delete_dubs' method='post'>\
												<input type='hidden' name='hidden' value='"+$game['id']+"'>\
												<button type='submit' class='btn btn-xs btn-danger'>delete</button>\
											</form></td></tr>\
							</thead>\
							<tbody>\
							<tr><th>"+$game['winner1']+" & "+$game['winner2']+"</th><th>"+$game['winner_score']+"</th></tr><tr><td>"+$game['loser1']+" & "+$game['loser2']+"</td><td>"+$game['loser_score']+"</td></tr>\
							</tbody>\
							</table>";

							$('#fake-table').after($html); //ATTACHES $HTML TABLE 
						}, 'json');
					// $('.delete').hide(); //why 
					return false;
				});

					$(document).on('submit', '#message-form', function(){   //AJAX DISPLAY NEW MESSAGE 
					$.post(
						$(this).attr('action'),
						$(this).serialize(),
						function(data){
							
						
						$message = data.newmessage[0];

						$html= "<div class='tx'>\
								<strong>"+ $message['first_name'] +" wrote on "+ $message['updated_at']+"</strong>\
								<p class='txl'>"+ $message['content'] +"</p>\
							</div>";
							
								$( ".txlout" ).animate({
						          color: "white"}, 100, function(){
						          	$(this).val('');
						          	$(this).animate({color:'black'}, 0);
						          } );
							$('.messages-tables').prepend($html); //PUTS NEW TABLE POSITIONED AFTER DIV "SMALL DIV"
							
	   						 $('.txl').fadeIn(1000).delay(10000).textillate({ in: { effect: 'rollIn', shuffle: true, delayScale: 1.0, } });

							
						}, 'json');
					return false;
				});  

						$('.tablea').on('mouseenter', function(){
					$(this).find('.delete').show();
				});

				$('.tablea').on('mouseleave', function(){
					$(this).find('.delete').delay(50).fadeOut(300);
				});


				$(document).on('mouseover', '.tablea', function(){
					$(this).find('.delete').show();
				});

				$(document).on('mouseleave', '.tablea', function(){
					$(this).find('.delete').delay(50).fadeOut(300);
				});


				$('form').submit(function() {
				    $('.score').removeAttr('disabled');
				});
			});
	</script>
</body>
</html>