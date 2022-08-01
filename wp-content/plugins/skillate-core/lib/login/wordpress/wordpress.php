<?php

add_action( 'wp_ajax_nopriv_ajaxlogin', 'themeum_ajax_login' );
function themeum_ajax_login(){
    check_ajax_referer( 'ajax-login-nonce2', 'security' );
    $info = array();
    $info['user_login'] = sanitize_text_field( $_POST['username'] );
    $info['user_password'] = sanitize_text_field( $_POST['password'] );
    $info['remember'] = true;
  
    $user_signon = wp_signon( $info, is_ssl() );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','Skillate-core')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...','Skillate-core')));
    }
    die();
}
