<script type="text/javascript">
		$(document).ready(function(){
			 $(".table-standing").tablesorter(); 
			 $('.table-standings').tablesorter({
				 sortList: [[1,1],[4,1]] 
			});

			//  $('.table-standing').tablesorter({
			// 	 sortList: [[3,1],[1,1],[2,1]] 
			// });
			// $('.hidethis').on('click', function(){
					// 	$(this).hide();
					// });

			 
			$('.delete').hide(); //HIDES ALL THE DELETE BUTTONS ON PAGE LOAD

			
 			$(".opponents").hide(); //HIDES INDIVIDUAL STATS ON PAGE LOAD

			$(".opp-record").click(function(){
			 	$(".opponents").show();
			 	console.log("opp-record is clicked");
			 }); //SHOWS INDIVIDUAL STATS WHEN NAME IS CLICKED
			
			$(document).on('mouseenter','.opp-record',function(){
				$(this).submit();
				console.log("mouse is entering");
			}); //SHOWS INDIVIDUAL STATS ON HOVER

			$('.opp-record').on('submit', function(){ // SHOWS INDIVIDUAL STATS WHEN NAME IS CLICKED
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
			            // var sorting = [[3,1],[1,1],[2,1]] 
			            // $(".table-standing").trigger("sorton", [sorting]);		
					}, 'json' );
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

						$html= "<table class='tablea table table-striped table-condensed' id='"+$game['id']+"'>\
									<thead>\
									   <tr class='delete-form'><td>"+$game['created_at']+"</td>\
									   <td class='td'><form class='delete' action='/stats_controller/delete' method='post' style='display:none;'>\
														<input type='hidden' name='hidden' value='"+$game['id']+"'>\
														<button type='submit' class='btn btn-xs btn-danger'>delete</button>\
										</form></td></tr>\
									</thead>\
									<tbody>\
										<tr><th>"+$game['winner_name']+"</th><td>"+$game['winner_score']+"</td></tr><tr><td>"+$game['loser_name']+"</td><td>"+$game['loser_score']+"</td></tr>\
									</tbody>\
						</table>";
						

						$('#small-div').after($html); //PUTS NEW TABLE POSITIONED AFTER DIV "SMALL DIV"

						$success = "Congratulations "+$game['winner_name']+"!";
						$('#congrats').html($success);
						$('#congrats').fadeIn(1000); //DISPLAYS CONFIRM MESSAGE AFTER SUBMITTING SCORE

						// $STATS WILL BE USED TO DISPLAY NEW RATINGS
						// $stats = "<p>"+data.players[0]['first_name']+data.players[0]['rating']+"</p><p>"+data.players[1]['first_name']+data.players[1]['rating']+"</p><p>"+data.players[2]['first_name']+data.players[2]['rating']+"</p><p>"+data.players[3]['first_name']+data.players[3]['rating']+"</p><p>"+data.players[4]['first_name']+data.players[4]['rating']+"</p>"; 
						// console.log($stats);
						// $.each(data.players, function(key,value){
						// 	console.log(value);
						// });	
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
						   <td class='td'><form class='delete' action='/stats_controller/delete_dubs' method='post'>\
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

			
	// $('.delete').on('submit', function(){
	// 			$(this).closest('.tablea').hide();
	// 			$.post(
	// 				$(this).attr('action'),
	// 				$(this).serialize(),
	// 				function(data){


	// 				}, 'json');
	// 			return false;
	// 		});


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
			
			// $('.table-standing').tablesorter({
			// 	 sortList: [[3,1],[1,1],[2,1]] 
			// });

			// $('.table-standings').on('click',function(){
			// 	 $(this).tablesorter({
			// 	 sortList: [[3,1],[1,1],[2,1]] 
			// });
			// });

			// $('.table-standing').on('click',function(){
			// 	 $(this).tablesorter({
			// 	 sortList: [[3,1],[1,1],[2,1]] 
			// });
			// });
		

			$('.tablea').on('mouseenter', function(){
				$(this).find('.delete').show();
			});

			$('.tablea').on('mouseleave', function(){
				$(this).find('.delete').hide();
			});

			// $('.tablea').on('mouseenter', function(){
			// 	$(this).find('.delete').fadeIn(200);
			// });

			// $('.tablea').on('mouseleave', function(){
			// 	$(this).find('.delete').fadeOut(200);
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


			$('form').submit(function() {
			    $('.score').removeAttr('disabled');
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
		    $( "#combobox" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox" ).toggle();
		    });
		  });

		    $(function() {
		    $( "#combobox2" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox2" ).toggle();
		    });
		  });

		     $(function() {
		    $( "#combobox3" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox3" ).toggle();
		    });
		  });

		      $(function() {
		    $( "#combobox4" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#combobox4" ).toggle();
		    });
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

		});

	</script>