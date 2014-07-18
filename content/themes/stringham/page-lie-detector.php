<?php
/*
Template Name: Lie Detector
*/

/**
 * The template for displaying the course list to logged in users.
 *
 * This is the template that displays the dynamic course page.
 *
 * @package Stringham
 */

opcache_reset();

get_header(); 

$user = wp_get_current_user();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
			
			<?php get_template_part( 'content', 'page' ); ?>
			
				<div class="row">
				
					<div class="lie-detector col-md-9" style="position: relative;">
						<div class="lie-timer" style=" background: url('<?php echo get_stylesheet_directory_uri();?>/images/lie-timer.png') center center no-repeat; background-size: 100%; width: 700px; height: 200px;">
						<div class="greenLight"></div>
						<div class="redLight"></div>
							<span id="counter"></span>
						</div>					
					</div>
					
					<div class="begin">
						<button id="startGame" class="btn btn-large">Ready?</button>
					</div>
					
					<div class="col-md-9 lie-buttons">
					
						<span id="correctNumber">0</span><br/>
						<button id="correctAnswer" class="btn btn-large">Correct</button>
						
						<button id="quitGame" class="btn btn-large">Quit</button>
					
						<button id="penalty" class="btn btn-large">Incorrect</button>
						
					</div>
				</div><!--/row-->
                    
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.greenLight, .redLight').hide();
		
			var iCounter = 0,
				iCorrect = 0
			eDisplay = document.getElementById("counter");
			format = function(t) {
				var minutes = Math.floor(t/6000),
	            	seconds = Math.floor( (t/100) % 60),
	            	milliseconds = Math.floor(t % 100);
	            	minutes = (minutes < 10) ? "0" + minutes.toString() : minutes.toString();
	            	seconds = (seconds < 10) ? "0" + seconds.toString() : seconds.toString();
	            	milliseconds = Math.floor(milliseconds/4.0)*4;
	            	milliseconds = (milliseconds < 10) ? "0" + milliseconds.toString() : milliseconds.toString();
	            eDisplay.innerHTML = minutes + ":" + seconds + "." + milliseconds;
	            
			};
			
			
			correctAnswer = function(){
				
				$('.greenLight').show().delay(200).fadeOut();
			}
			
			incorrectAnswer = function(){
				
				$('.redLight').show().delay(200).fadeOut();
			}
			
			format(0);
			var scoreTimer;
			
			$('#startGame').on('click', function(){
			scoreTimer = setInterval(function() {
				format(iCounter);
				iCounter++;
			},10);
		});
	     
			$('#correctAnswer').on('click', function(){
				$('#correctNumber').html(function () { 
					return ++iCorrect;
				});
				if( parseInt($('#correctNumber').html()) == 20 )
				{
					clearInterval(scoreTimer);
					console.log(eDisplay.innerHTML);
				}
				correctAnswer();
				
			});
			jQuery('#penalty').on('click', function(){
				iCounter++;
				incorrectAnswer();
			});
			$('#quitGame').on('click', function(){
				window.location = "<?php echo home_url('/games');?>";
			});
    	});
	</script>

<?php get_footer(); ?>