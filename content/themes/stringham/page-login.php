<?php
/*
 Template Name: Login
*/

opcache_reset();

get_header('login'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
			
			<div class="colorful-page-wrapper">
				<div class="center-block">
			    	<div class="login-block">
			    
						<form action="<?php echo admin_url('admin-ajax.php');?>" id="login-form" class="orb-form" method="post">
							<header>
								<div class="image-block"><img src="<?php echo get_stylesheet_directory_uri();?>/images/logo.png" alt="User" /></div>
								Login<small>Have no account? &#8212; <a class="toggle-forms" href="#">Register</a></small>
							</header>
							<fieldset>
								<section>
									<div class="row">
										<label class="label col col-4">E-mail</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="email" name="email">
											</label>
										</div>
									</div>
								</section>
								<section>
									<div class="row">
										<label class="label col col-4">Password</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-lock"></i>
												<input type="password" name="password">
											</label>
											<div class="note"><a href="#">Forgot password?</a></div>
										</div>
									</div>
								</section>
								<section>
									<div class="row">
										<div class="col col-4"></div>
										<div class="col col-8">
											<label class="checkbox">
											<input type="checkbox" name="remember" checked>
											<i></i>Keep me logged in</label>
										</div>
									</div>
								</section>
							</fieldset>
							<footer>
								<input type="hidden" name="action" value="user_login" />
								<button type="submit" class="btn btn-default">Log in</button>
							</footer>
						</form>
			      
			      
						<form action="<?php echo admin_url('admin-ajax.php');?>" id="register-form" class="orb-form" method="post">
							<header>
							<div class="image-block"><img src="<?php echo get_stylesheet_directory_uri();?>/images/logo.png" alt="User" /></div>
								Register <small>Already have an account? &#8212; <a class="toggle-forms" href="#">Login</a></small>
							</header>
							<fieldset>
								<section>
									<div class="row">
										<label class="label col col-4">E-mail</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="email" name="email">
											</label>
										</div>
									</div>
								</section>
								<section>
									<div class="row">
										<label class="label col col-4">First Name</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" name="first-name">
											</label>
										</div>
									</div>
								</section>
								<section>
									<div class="row">
										<label class="label col col-4">Last Name</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" name="last-name">
											</label>
										</div>
									</div>
								</section>
								<section>
									<div class="row">
										<label class="label col col-4">Nick Name</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" name="nick-name">
											</label>
										</div>
									</div>
								</section>
								<section>
									<div class="row">
										<label class="label col col-4">Password</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-lock"></i>
												<input type="password" name="password">
											</label>
										</div>
									</div>
								</section>
								<section>
									<div class="row">
										<label class="label col col-4">Confirm Password</label>
										<div class="col col-8">
											<label class="input"> <i class="icon-append fa fa-lock"></i>
												<input type="password" name="confirm-password">
											</label>
										</div>
									</div>
								</section>
							</fieldset>
							<footer>
								<input type="hidden" name="action" value="register_user" />
								<button type="submit" class="btn btn-default">Register</button>
							</footer>
						</form>
			      
			      <script>
				      jQuery(document).ready(function($){
					     $('#login-form').ajaxForm({
						     dataType: 'json',
						     success: function(r){
						     	if(r.success)
						     	{
							    	console.log(r.data);
							    	window.location = "<?php echo home_url(); ?>";
						     	}
							    else
							    {
							    	console.log(r.data);
							    }
							    
						     }
					     }); 
					     $('#register-form').hide();
					     $('.toggle-forms').on('click', function(){
						     
							     $('#login-form').fadeToggle();
							     $('#register-form').fadeToggle();
						     
						     
					     });
					     
					     $('#register-form').ajaxForm({
						     dataType: 'json',
						     success: function(r){
						     	if(r.success)
						     	{
							    	console.log(r.data);
							    	window.location = "<?php echo home_url(); ?>";
						     	}
							    else
							    {
							    	console.log(r.data);
							    }
							    
						     }
					     }); 
					      
					      
				      });
			      </script>
			    </div>

			    <div class="copyrights"> &copy; <?php echo date('Y');?>  <br>
			       Stringham Schools</div>
			  </div>
			</div>
				<?php the_content(); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer('login'); ?>
