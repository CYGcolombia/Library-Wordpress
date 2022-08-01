<?php

function facebook_footer_function() {
    $facebook_app_ID = get_theme_mod('facebook_app_ID', '');
        $facebook_app_ID_script =  "<script type='text/javascript'> var facebook_app_ID = {$facebook_app_ID} </script>";
        echo $facebook_app_ID_script;
    ?>
    <script type="text/javascript">
	    (function(d){
	        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	        if (d.getElementById(id)) {return;}
	        js = d.createElement('script'); js.id = id; js.async = true;
	        js.src = "//connect.facebook.net/en_US/all.js";
	        ref.parentNode.insertBefore(js, ref);
	    }(document));
	    window.fbAsyncInit = function() {
	      		FB.init({
	            	appId: facebook_app_ID,
	            	status: true,
	            	cookie: true,
	            	xfbml: true
	        	});  
	    };
		function login() {
			FB.login(function(response) {
				FB.api('/me', { locale: 'en_US', fields: 'name, email' },
					function(response2) {
						if (typeof response2.error == 'undefined') {
							jQuery(document).ready(function($){'use strict';
      					//console.log(response2);
								$.ajax({
							        type: 'POST',
							        dataType: 'json',
							        url: ajax_object.ajaxurl,
							        data: { 
							            'action': 'ajaxfacebooklogin', //calls wp_ajax_nopriv_ajaxlogin
							            'id_token': response.authResponse.accessToken,
							            'useremail': response2.email,
							            'username': response2.name,
							            'security': $( 'form#login #security2').val() },
							        success: function(data){
							            //$('form#login div.login-error').text(data.message);
							            if (data.loggedin == true){
      												$('form#login div.login-error').removeClass('alert-danger').addClass('alert-success');
      												$('form#login div.login-error').text(data.message);
							                document.location.href = ajax_object.redirecturl;
							            }else{
      												$('form#login div.login-error').removeClass('alert-success').addClass('alert-danger');
      												$('form#login div.login-error').text(data.message);
      										}
							            if($('.login-error').text() == ''){
							                $('form#login div.login-error').hide();
							            }else{
							                $('form#login div.login-error').show();
							            }
							        }
							    });
						    });
							// console.log('FB Login Working!');
							// console.log(response2);
						}else{
							// console.log('FB Login Error!');
							// console.log(response);
						}
					}
				);
			}, {scope: 'public_profile,user_friends,email'});    
		}
	</script>
<?php }

$facebook_app_ID = get_theme_mod('facebook_app_ID', '');
if(!empty($facebook_app_ID)){
    add_action( 'wp_footer', 'facebook_footer_function' );
}

//Google Login
add_action( 'wp_ajax_nopriv_ajaxfacebooklogin', 'themeum_ajax_facebook_login' );
function themeum_ajax_facebook_login(){
    check_ajax_referer( 'ajax-login-nonce2', 'security' );
    
    $usermail = $_POST['useremail'];
    if( $usermail ){
        $userdata = get_user_by( 'email', $usermail );
        if(isset($userdata->ID)){
            wp_set_current_user( $userdata->ID );
            wp_set_auth_cookie( $userdata->ID );
            echo json_encode(array( 'loggedin'=>true, 'message'=> __('Login successful, redirecting...', 'Skillate-core') ));
        }else{
            $user_name = substr( $usermail, 0, strpos( $usermail, '@' ));
            
            if( username_exists( $user_name ) ){
                while( 2 > 1 ){
                    $random     = substr( str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 2 );
                    $user_name  = $user_name + $random;
                    if( !username_exists( $user_name ) ){ break; }
                } 
            }
            $f_name = $l_name = '';
            if( isset($_POST['username']) ){
            	$temp = explode(" ", $_POST['username'] );
            	if( isset($temp[0]) ){ $f_name = $temp[0]; }
            		if( isset($temp[1]) ){ $l_name = $temp[1]; }
            }
            $user_input = array(
                'first_name'    =>  $f_name,
                'last_name'     =>  $l_name,
                'user_login'    =>  $user_name,
                'user_email'    =>  $usermail,
              	'display_name'	=>  $user_name,
                'user_pass'     =>  NULL
            );
            $user_id = wp_insert_user( $user_input );
            if ( ! is_wp_error( $user_id ) ) {
                wp_set_current_user( $user_id );
                wp_set_auth_cookie( $user_id );
                echo json_encode(array( 'loggedin'=>true, 'message'=> __('Login successful, redirecting...', 'Skillate-core') ));
            } else {
                echo json_encode( array('loggedin'=>false, 'message'=> __('Wrong username or password.', 'Skillate-core')) );
            } 
        }
        die();
    }
}