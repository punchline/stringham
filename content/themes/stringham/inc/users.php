<?php


function get_user_name($user_id){
	$first = get_user_meta($user_id,'first_name',true);
	$nick  = get_user_meta($user_id,'nickname',true);
	$last  = get_user_meta($user_id,'last_name',true);
	
	return ('' == $nick)? $first.' '.$last : $nick.' '.$last ;
}