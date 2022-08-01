<?php
function skillate_core_before_login_init()
{

	//Twitter Login
	require_once(SKILLATE_CORE_PATH  . '/lib/login/twitter/twitter.php');

	//Wordpress Default
	require_once(SKILLATE_CORE_PATH  . '/lib/login/wordpress/wordpress.php');

	//Google Login
	require_once(SKILLATE_CORE_PATH  . '/lib/login/google/google.php');

	//Facebook Login
	require_once(SKILLATE_CORE_PATH  . '/lib/login/facebook/facebook.php');
}

if (!is_user_logged_in()) {
	add_action('init', 'skillate_core_before_login_init');
}

# General Registration Login
add_action('wp_ajax_nopriv_ajaxregister', 'skillate_core_ajax_register_new_user');
function skillate_core_ajax_register_new_user()
{
	check_ajax_referer('ajax-register-nonce', 'security');
	if (!$_POST['username']) {
		echo json_encode(array('loggedin' => false, 'message' => __('Wrong!!! Username field is empty.', 'Skillate-core')));
		die();
	} elseif (!$_POST['email']) {
		echo json_encode(array('loggedin' => false, 'message' => __('Wrong!!! Email field is empty.', 'Skillate-core')));
		die();
	} elseif (!$_POST['password']) {
		echo json_encode(array('loggedin' => false, 'message' => __('Wrong!!! Password field is empty.', 'Skillate-core')));
		die();
	} else {
		if (username_exists($_POST['username'])) {
			echo json_encode(array('loggedin' => false, 'message' => __('Wrong!!! Username already exits.', 'Skillate-core')));
			die();
		} elseif (strlen($_POST['password']) <= 6) {
			echo json_encode(array('loggedin' => false, 'message' => __('Wrong!!! Password must 7 character or more.', 'Skillate-core')));
			die();
		} elseif (!is_email($_POST['email'])) {
			echo json_encode(array('loggedin' => false, 'message' => __('Wrong!!! Email address is not correct.', 'Skillate-core')));
			die();
		} elseif (email_exists($_POST['email'])) {
			echo json_encode(array('loggedin' => false, 'message' => __('Wrong!!! Email user already exits in this site.', 'Skillate-core')));
			die();
		} else {
			$user_input = array(
				'user_login'    => sanitize_text_field($_POST['username']),
				'first_name'	=> sanitize_text_field(trim($_POST['first_name'])),
				'last_name'		=> sanitize_text_field(trim($_POST['last_name'])),
				'user_email'    => sanitize_text_field($_POST['email']),
				'user_pass'     => sanitize_text_field($_POST['password']),
			);


			$user_id = wp_insert_user($user_input);
			if (!is_wp_error($user_id)) {
				echo json_encode(array('loggedin' => true, 'message' => __('Registration successful you can login now.', 'Skillate-core')));
				die();
			} else {
				echo json_encode(array('loggedin' => false, 'message' => __('Wrong username or password.', 'Skillate-core')));
				die();
			}
		}
	}
}
