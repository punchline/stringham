<?php


function get_user_name($user_id){
	$first = get_user_meta($user_id,'first_name',true);
	$nick  = get_user_meta($user_id,'nickname',true);
	$last  = get_user_meta($user_id,'last_name',true);
	
	return ('' == $nick)? $first.' '.$last : $nick.' '.$last ;
}

add_action('wp_ajax_nopriv_user_login','pnch_user_login');
add_action('wp_ajax_user_login','pnch_user_login');
function pnch_user_login(){
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// retrieve user from DB using email address supplied
	$user = get_user_by('email', $email);
	if(!$user)
	{
		wp_send_json_error('Could not find an account matching email address');
	}
	
	// compare password supplied with hashed password in DB
	if( !wp_check_password( $password, $user->data->user_pass, $user->ID ) )
	{
		wp_send_json_error( array($password, $user->data->user_pass, 'Incorrect Password') );
	}
	
	//user exists and password was correct.. let 'em in!
	$creds = array();
	$creds['user_login'] = $user->user_login;
	$creds['user_password'] = $password;
	$creds['remember'] = array_key_exists( 'remember', $_POST );
	$signon = wp_signon( $creds, true );
	
	if ( is_wp_error($signon) )
		wp_send_json_error( $signon->get_error_message() );
	
	wp_send_json_success($user);
}

add_action('wp_ajax_nonpriv_register_user','pnch_register_user');
add_action('wp_ajax_register_user','pnch_register_user');

function register_user(){
	
	$email = $_POST['email'];
	$user_name = $_POST['nick-name'];
	if($_POST['password'] === $_POST['confirm-password']) $password = $_POST['password'];
	
	wp_create_user($user_name, $password, $email);
}