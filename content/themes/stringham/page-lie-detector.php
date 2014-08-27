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

get_header(); 

$user = wp_get_current_user();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
			
			<?php get_template_part( 'content', 'page' ); ?>
			
				<div class="row lie-container">
				
					<div class="lie-detector">
					
						<div class="col-md-9" style="position: relative;">
							<div class="lie-timer">
							<div class="greenLight"></div><div class="green-black"></div>
							<div class="redLight"></div><div class="red-black"></div>
								<span id="counter"></span>
							</div>					
						</div>
						
						
						<div class="col-md-9 lie-questions">
							<h2 id="questionTitle">True or False:</h2>
						</div>
						
						<div class="col-md-9">
							<div class="progress">
			                  <div class="progress-bar progress-bar-success" style="width: 60%;"></div>
			                </div>
			            </div>
						
						<div class="col-md-3 lie-buttons">
						
							<div class="begin">
								<button id="startGame" class="btn btn-large">Ready?</button>
								<button id="restart" class="btn btn-large">Restart?</button>
							</div>
						
							
							
							<div id="trueButton"><h3>True</h3><button id="answerTrue" class="btn btn-large"></button><small class="hide-mobile">Keyboard: T</small></div>
							
							<div id="quitButton"><button id="quitGame" class="btn btn-large">Quit</button><small class="hide-mobile">Keyboard: Q</small></div>
						
							<div id="falseButton"><h3>False</h3><button id="answerFalse" class="btn btn-large"></button><small class="hide-mobile">Keyboard: F</small></div>
							
							
							<div id="testResults"></div>
							
						</div>
					</div>
				</div><!--/row-->
                    
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.greenLight, .redLight, #restart').hide();
			$('.green-black, .red-black').show();
			
			var iCounter = 0,
				iCorrect = 0,
				iQuestion = 0,
				iTotalQuestions = 0;
				
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
				$('.green-black').hide().delay(201).fadeIn();
				
				++iCorrect;
				
				$('.progress-bar').css({
					width: function(){
						var percent = iCorrect / 20 * 100;	
						return percent + '%';
					}
				});
				
				if( iCorrect == 20 )
				{
					finishGame();
				}
				else {	
					++iQuestion;		
					loadNewQuestion();	
				}
			};
			
			incorrectAnswer = function(){
				$('.redLight').show().delay(200).fadeOut();
				$('.red-black').hide().delay(201).fadeIn();
				
				var m = 0;
				var s = 100;
				iCounter += (m * 60) + s;
				++iQuestion;
				loadNewQuestion();
			};
			
			gradeQuestion = function(answer){
				if ( answer == questions[iQuestion].answer ){
					correctAnswer();
				}
				else {
					incorrectAnswer();
				}
			};
			
			shuffle = function(array) {
			  	var 	currentIndex = array.length, 
			  			temporaryValue, 
			  			randomIndex;
			
				// While there remain elements to shuffle...
				while (0 !== currentIndex) {
				
					// Pick a remaining element...
					randomIndex = Math.floor(Math.random() * currentIndex);
					currentIndex -= 1;
					
					// And swap it with the current element.
					temporaryValue = array[currentIndex];
					array[currentIndex] = array[randomIndex];
					array[randomIndex] = temporaryValue;
				}
			
				return array;
			};
			
			loadNewQuestion = function(){
				//set title element html to questions[iQuestion].question
				iTotalQuestions++;
				if(iQuestion == (questions.length-1) )
				{
					//shuffle questions and start over
					questions = shuffle(questions);
					iQuestion = 0;
				}
				
				$('#questionTitle').html( questions[iQuestion].question );
			};
			
			startGame = function(){
				$('#testResults').html('');
				
				$('#startGame').css('display', 'none');
				
				$('#questionTitle, #trueButton, #quitButton, #falseButton, #answerTrue, #quitGame, #answerFalse').show();
				$('#restart').hide();
				
				scoreTimer = setInterval(function() {
					format(iCounter);
					iCounter++;
				},10);
				
				$('.progress-bar').css({
					width: '0%'
				});
				
			};
			
			finishGame = function(){
				clearInterval(scoreTimer);	//stop the clock!
				
				$('#testResults').html('Congrantulations, you finished in ' + eDisplay.innerHTML + ' and ' + iTotalQuestions + ' questions!');
					
				iCounter = 0;
				iCorrect = 0;
				iTotalQuestions = 0;
							
				// clear the question
				// clear the board
				$('#questionTitle, #trueButton, #falseButton, #quitButton, #answerTrue, #quitGame, #answerFalse').hide();
				
				$('#restart').show();
				
				$('.progress-bar').css({
					width: '0%'
				});
				
			};
			
			format(0);
			var scoreTimer;
			
			var questions = [
				{
					question: "Is Mike awesome?",
					answer: "t"
				},
				{
					question: "Do dogs rule?",
					answer: "t"
				},
				{
					question: "Do cats drool?",
					answer: "t"
				},
				{
					question: "Tienes un grande gato en tus pantalones?",
					answer: "f"
				}
			];
			
			$('#startGame').on('click', function(){
				startGame();
			});
			
			$('#restart').on('click', function(){
				startGame();
			});
			
	     
			$('#answerTrue').on('click', function(){
				gradeQuestion("t");
			});
			$('#answerFalse').on('click', function(){
				gradeQuestion("f");
			});

			$('#quitGame').on('click', function(){
				window.location = "<?php echo home_url('/games');?>";
			});
			
			
			
				// Uses lie detector by pressing keys
				$(window).keypress(function(event){
					var keycode = (event.keyCode ? event.keyCode : event.which);
					
					// Ready
					if(keycode == '114')
					{
						scoreTimer = setInterval(function() {
							format(iCounter);
							iCounter++;
						},10);
						
						$('#startGame').css('display', 'none');
						
						// set title element html to questions[iQuestion].question
						loadNewQuestion();
					}
					
					// True
					if(keycode == '116')
					{
						gradeQuestion("t");
					}
					
					// False
					if(keycode == '102')
					{
						gradeQuestion("f");
					}
					
					// Quit
					if(keycode == '113')
					{
						window.location = "<?php echo home_url('/games');?>";
					}
					
				});
				
				// Progress Bar
				
				$('.progress-bar').css({
					width: '0%'
				});
				
				
    	});
	</script>

<?php get_footer(); ?>