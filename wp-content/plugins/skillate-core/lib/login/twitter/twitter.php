<?php if ( ! headers_sent() && '' == session_id() ) session_start();

$twitter_consumer_key = get_theme_mod('twitter_consumer_key', '');
$twitter_consumer_secreat = get_theme_mod('twitter_consumer_secreat', '');
$twitter_auth_callback_url = get_theme_mod('twitter_auth_callback_url', '');

define('CONSUMER_KEY', $twitter_consumer_key);
define('CONSUMER_SECRET', $twitter_consumer_secreat);
define('OAUTH_CALLBACK', $twitter_auth_callback_url);

include_once("inc/twitteroauth.php");

if( isset($_GET['twitterlog']) ){
	if(isset($_REQUEST['oauth_token']) && $_SESSION['token']  !== $_REQUEST['oauth_token']) {
		session_destroy();
	}elseif(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']) {
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		if($connection->http_code == '200'){
			$_SESSION['status'] = 'verified';
			$_SESSION['request_vars'] = $access_token;
			$user_info = $connection->get('account/verify_credentials'); 
			

			if( isset($user_info->screen_name) ){
		        
		        $user_data = get_users( array( 'meta_key' => 'twitter_user', 'meta_value' => $user_info->screen_name ) );
		        if( isset($user_data[0]->ID) ){
		            wp_set_current_user( $user_data[0]->ID );
		            wp_set_auth_cookie( $user_data[0]->ID );
		            //echo json_encode(array( 'loggedin'=>true, 'message'=> 'Login successful, redirecting...' ));
		        } else {
		            $user_name = $user_info->screen_name;
		            if( username_exists( $user_name ) ){
		                while( 2 > 1 ){
		                    $random     = substr( str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 2 );
		                    $user_name  = $user_name + $random;
		                    if( !username_exists( $user_name ) ){ break; }
		                } 
		            }
		            $f_name = $l_name = '';
		            if( isset( $user_info->name ) ){
		            	$temp = explode( " ", $user_info->name );
		            	if( isset($temp[0]) ){ $f_name = $temp[0]; }
		            	if( isset($temp[1]) ){ $l_name = $temp[1]; }
		            }
		            $user_input = array(
		                'first_name'    =>  $f_name,
		                'last_name'     =>  $l_name,
		                'user_login'    =>  $user_name,
                  	'display_name'	=>  $user_name,
		                'user_pass'     =>  NULL
		            );
		            $user_id = wp_insert_user( $user_input );
		            if ( ! is_wp_error( $user_id ) ) {
		            	update_user_meta( $user_id, 'twitter_user', $user_info->screen_name );
		                wp_set_current_user( $user_id );
		                wp_set_auth_cookie( $user_id );
		                //echo json_encode(array( 'loggedin'=>true, 'message'=> 'Login successful, redirecting...' ));
		            } else {
		                //echo json_encode( array('loggedin'=>false, 'message'=> 'Wrong username or password.') );
		            }
		            
		        }
		        //die();
		    }


			unset($_SESSION['token']);
			unset($_SESSION['token_secret']);
		}else{
			die("error, try again later!");
		}
			
	}else{
		if(isset($_GET["denied"])){
			header('Location: index.php');
			die();
		}
		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET );
		$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

		$_SESSION['token'] 			= $request_token['oauth_token'];
		$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
		if($connection->http_code == '200'){	
			$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
			$user_info = $connection->get('account/verify_credentials'); 
			wp_redirect( $twitter_url );
			die();		
		}else{
			die("error connecting to twitter! try again later!");
		}
	}
}