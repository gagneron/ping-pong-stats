<!--START OF DOUBLES TAB -->
		  		<div class="tab-pane" id="profile">
					<div class='stats' id='doubles-table'><!--DOUBLES STANDINGS -->
						<h4 style='margin-bottom:0px;'>Doubles Standings</h4>
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

					<div class='stiff'><!--INPUT DOUBLES SCORES -->
						<form action='stats_controller/score_process' method='post' class='form-horizontal col-xs-12' role='form' id='dubs-frm'>
							<h3 style='margin-top:10px;'>Input Scores</h3>
							<div>
								<div class="select">
										<label for="combobox5" class="">Winner</label>
									  <select name='team1' id="combobox5">

									    <option value="">Select one...</option>
									    <?php foreach($players as $player)
										{ ?>
											<option value="<?= $player['first_name'] ?>"><?= $player['first_name'] ?></option>
																			
										<?php } ?>
									  </select>				
								</div>

								<div class="select" >
									<label for="combobox6" class="">Wnner</label>
									<select name='team2' id="combobox6">
									    <option value="">Select one...</option>
									    <?php foreach($players as $player)
										{ ?>
											<option value='<?= $player['first_name'] ?>'><?= $player['first_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div>
								<div class="select">									
									<label for="combobox7" class="">Loser</label>
									<select name='team3' id="combobox7">
									    <option value="">Select one...</option>
									    <?php foreach($players as $player)
										{ ?>
											<option value="<?= $player['first_name'] ?>"><?= $player['first_name'] ?></option>								
										<?php } ?>
									</select>
								</div>

								<div class="select" >
									  <label for="combobox8" class="">Loser</label>
									  <select name='team4' id="combobox8">
									    <option value="">Select one...</option>
									    <?php foreach($players as $player)
										{ ?>
											<option value='<?= $player['first_name'] ?>'><?= $player['first_name'] ?></option>
																			
										<?php } ?>
									  </select>
								</div>
							</div>

							<div>
								<div class="select">
									<label for="combobox9" class="">Score</label>
									<select id="combobox9" name='score1'>
									    <option value="21">21</option>
										<option value='11'>11</option>						
									</select>
								</div>

								<div class="select">

									<label for="combobox10" class="">Score</label>
									<select id="combobox10" name='score2'>
									    <option value="">Select one...</option>
									    <?php for($i=20; $i>-1; $i--)
										{ ?>
											<option value='<?= $i ?>'><?= $i ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<button class='btn btn-success' type='submit'>Submit</button>
						</form>
					<!--end of row doubles -->


					</div><!--end of class stiff--><!--END OF INPUT DOUBLES SCORES -->

					<div class='clearplease'></div>

				<ul class="nav nav-tabs" id="myTab">
				  <li class="active first-li listy" value='first-li'><a href="#home" data-toggle="tab"><h3>Singles</h3></a></li>
				  <li class='second-li listy' value='first-li'><a href="#profile" data-toggle="tab"><h3>Doubles</h3></a></li>
				</ul>
	<!-- end of input scores -->
		

	<!--start of SCORES log-->
			 		<div class='box'> <!--where doubles scores tables go-->
			 			<div class='dubs-scores'>
			 				<!-- <h3 class='center'><button type='button' class='press2'>Doubles</button></h3> -->
			 				<div class='box2'>

				 			<table id='fake-table' class='tablea table table-striped table-condensed'></table>
								<!--this is an empty table where I use after() on new tables to append them here -->
							
							<?php
								
								foreach($dubs_scores as $score)
								 {	
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
				</div><!--end of doubles tab-->
