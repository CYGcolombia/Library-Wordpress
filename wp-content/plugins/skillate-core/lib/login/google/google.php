<?php

function google_footer_function_login_script()
{
    $google_client_ID = get_theme_mod('google_client_ID', '');
    $google_client_ID_script =  "<script type='text/javascript'> var google_client_ID = '{$google_client_ID}' </script>";
    echo $google_client_ID_script;

?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            /**
             * Decode JWT response
             */
            function decodeJwtResponse (token) {
                var base64Url = token.split('.')[1];
                var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''));

                return JSON.parse(jsonPayload);
            };

            /**
             * Handle response after user consent
             */
            function handleCredentialResponse(response) {
                const responsePayload = decodeJwtResponse(response.credential);
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_object.ajaxurl,
                    data: {
                        'action': 'ajaxgooglelogin', //calls wp_ajax_nopriv_ajaxlogin
                        'id_token': responsePayload.sub,
                        'useremail': responsePayload.email,
                        'userfirst': responsePayload.given_name,
                        'userlast': responsePayload.family_name,
                        'security': $('form#login #security2').val()
                    },
                    success: function(data) {
                        //$('form#login div.login-error').text(data.message);
                        if (data.loggedin == true) {
                            $('form#login div.login-error').removeClass('alert-danger').addClass('alert-success');
                            $('form#login div.login-error').text(data.message);
                            document.location.href = ajax_object.redirecturl;
                        } else {
                            $('form#login div.login-error').removeClass('alert-success').addClass('alert-danger');
                            $('form#login div.login-error').text(data.message);
                        }
                        if ($('.login-error').text() == '') {
                            $('form#login div.login-error').hide();
                        } else {
                            $('form#login div.login-error').show();
                        }
                    }
                });
            }
            // Render button
            google.accounts.id.initialize({
                client_id: google_client_ID,
                callback: handleCredentialResponse
            });
            google.accounts.id.renderButton(
                document.getElementById("gSignIn2"),
                { theme: "outline", size: "large" }
            );
        });
    </script>
<?php }


$google_client_ID = get_theme_mod('google_client_ID', '');

if ($google_client_ID) {
    add_action('wp_footer', 'google_footer_function_login_script');
}




//Google Login
add_action('wp_ajax_nopriv_ajaxgooglelogin', 'themeum_ajax_google_login');
function themeum_ajax_google_login()
{
    check_ajax_referer('ajax-login-nonce2', 'security');

    $usermail = $_POST['useremail'];
    if ($usermail) {
        $userdata = get_user_by('email', $usermail);
        if (isset($userdata->ID)) {
            wp_set_current_user($userdata->ID);
            wp_set_auth_cookie($userdata->ID);
            echo json_encode(array('loggedin' => true, 'message' => __('Login successful, redirecting...', 'Skillate-core')));
        } else {
            $user_name = substr($usermail, 0, strpos($usermail, '@'));

            if (username_exists($user_name)) {
                while (2 > 1) {
                    $random     = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 2);
                    $user_name  = $user_name + $random;
                    if (!username_exists($user_name)) {
                        break;
                    }
                }
            }
            $user_input = array(
                'first_name'    =>  $_POST['userfirst'],
                'last_name'     =>  $_POST['userlast'],
                'user_login'    =>  $user_name,
                'user_email'    =>  $usermail,
                'display_name'    =>  $user_name,
                'user_pass'     =>  NULL
            );
            $user_id = wp_insert_user($user_input);
            if (!is_wp_error($user_id)) {
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
                echo json_encode(array('loggedin' => true, 'message' => __('Login successful, redirecting...', 'Skillate-core')));
            } else {
                echo json_encode(array('loggedin' => false, 'message' => __('Wrong username or password.', 'Skillate-core')));
            }
        }
        die();
    }
}


if ($google_client_ID) {
    add_action('wp_enqueue_scripts', 'load_google_login_script');
}


if (!function_exists('load_google_login_script')) {
    function load_google_login_script()
    {
        wp_enqueue_script('google-login-api-client', 'https://accounts.google.com/gsi/client', array(), false, false);
    }
}
