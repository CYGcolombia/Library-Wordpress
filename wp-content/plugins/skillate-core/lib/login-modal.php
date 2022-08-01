<?php if(!is_user_logged_in()) { ?>
    <!-- Modal Login -->
    <div class="modal right fade" id="modal-login" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="skillate-signin-popup-inner modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="skillate-login-body modal-body">
                    <div class="skillate-signin-modal-form">
                        <h2><?php esc_html_e('Login', 'Skillate-core'); ?></h2>
                        <h4 class="title-small">
                            <?php esc_html_e('Hello there, haven’t we seen you before?', 'Skillate-core'); ?>
                        </h4>
                        <form action="login" id="login" method="post">
                            <p class="status"></p>
                            <input type="text" id="username2" name="username" placeholder="<?php esc_attr_e('Username','Skillate-core');?>">
                            <input type="password" id="password2" placeholder="<?php esc_attr_e('Password','Skillate-core');?>" name="password">
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <label for="rememberme" class="skillate-login-remember">
                                        <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
                                        <span class="fas fa-check"></span><?php _e('Remember Me', 'Skillate-core'); ?>
                                    </label>
                                </div> 
                                <div class="col-6 col-md-6 text-right">
                                <?php
                                    $lostpass_url =  wp_lostpassword_url();
                                    printf(__('%s forget your password? %s', 'Skillate-core'), "<a class='forgot-pass' href='$lostpass_url'>", "</a>");
                                ?>
                                </div>
                            </div>
                            <input class="skillate_btn btn-fill" value="<?php echo esc_attr__('Login Now','Skillate-core'); ?>" type="submit">
                            <?php wp_nonce_field( 'ajax-login-nonce2', 'security2' ); ?>
                        </form>
                    </div>
                    <?php
                        $en_social_login = get_theme_mod('en_social_login', true);
                        $google_client_ID = get_theme_mod('google_client_ID', '');
                        $facebook_app_ID = get_theme_mod('facebook_app_ID', '');
                        $twitter_consumer_key = get_theme_mod('twitter_consumer_key', '');
                        $twitter_consumer_secreat = get_theme_mod('twitter_consumer_secreat', '');
                        $twitter_auth_callback_url = get_theme_mod('twitter_auth_callback_url', '');
                        $social_twitter_condition = !empty($twitter_consumer_key) && !empty($twitter_consumer_secreat) && !empty($twitter_auth_callback_url);
                        $social_condition_all = $social_twitter_condition || !empty($google_client_ID) || !empty($facebook_app_ID);
                    ?>
                    <p class="new-user-login">
                        <?php esc_html_e('New here?', 'Skillate-core'); ?>
                        <a data-toggle="modal" data-dismiss="modal" class='skillate_btn btn-fill  bg-black' href='#modal-registration'><?php esc_html_e('Sign Up', 'Skillate-core'); ?></a>
                    </p>

                    <?php if($en_social_login) {?>
                    <div class="skillate-login-divider">
                        <span><?php _e('OR', 'Skillate-core') ?></span>
                    </div>
                    <div class="skillate-login-social">
                        <?php if(!empty($google_client_ID)) : ?>
                            <a href="#" class="google-login skillate_btn btn-fill bg-google" id="gSignIn2"></a>
                        <?php endif; ?>
                        <?php if($facebook_app_ID) : ?>
                            <a href="#" class="facebook-login skillate_btn btn-fill bg-facebook" onclick="javascript:login();"> <i class="fab fa-facebook-f"></i> <?php esc_html_e('Continue with Facebook', 'Skillate-core'); ?></a>
                            <div id="fb-root"></div>
                        <?php endif; ?>
                        <?php if($social_twitter_condition) : ?>
                            <a class="twitter-login skillate_btn btn-fill bg-twitter" href="<?php echo esc_url($twitter_auth_callback_url).'?twitterlog=1'; ?>"> <i class="fab fa-twitter"></i> <?php esc_html_e('Continue with Twitter', 'Skillate-core'); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php }?>
                </div>
            </div> <!--skillate-signin-popup-inner-->
        </div>
    </div>
    

    <div class="modal right fade" id="modal-registration" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="skillate-signin-popup-inner modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="skillate-register-body modal-body">
                    <div class="skillate-signin-modal-form">
                        <h2><?php esc_html_e('Sign Up', 'Skillate-core'); ?></h2>
                        <h4 class="title-small">
                            <?php printf(__('Already have an account? %s Sign In %s', 'Skillate-core'), "<a data-toggle='modal' data-dismiss='modal' class='skillate-login-tab-toggle' href='#modal-login'>", "</a>");?>
                        </h4>
                        <form form id="registerform" action="login" method="post">
                            <p class="status"></p>

                            <input type="text" id="first_name" name="first_name" placeholder="<?php esc_attr_e('First Name','Skillate-core' ); ?>">
                            <input type="text" id="last_name" name="last_name" placeholder="<?php esc_attr_e('Last Name','Skillate-core' ); ?>">
                            <input type="text" id="username" name="username" placeholder="<?php esc_attr_e('Username','Skillate-core' ); ?>">
                            <input type="text" id="email" name="email" placeholder="<?php esc_attr_e('Email','Skillate-core' ); ?>">
                            <input type="password" id="password" name="password" placeholder="<?php esc_attr_e('Password','Skillate-core' ); ?>">
                            <input class="skillate_btn btn-fill register_button" value="<?php esc_attr_e('Register Now','Skillate-core' ); ?>" type="submit">
                            <?php wp_nonce_field( 'ajax-register-nonce', 'security' ); ?>
                        </form>
                    </div>
                </div>
            </div><!--skillate-signin-popup-inner-->
        </div>
    </div>
   
<?php } ?>

<!---Cart-->
<?php if ( class_exists( 'woocommerce' )){ ?>
<div class="modal right fade skillate-modal" id="modal-cart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            
            <div class="modal-body">
                <div class="woo-menu-item-add woocart">
                    <?php $action = function_exists('tutor_utils') ? tutor_utils()->course_archive_page_url() : site_url('/'); ?>
                    <span id="themeum-woo-cart" class="woo-cart">
                        <span class="cart-has-products">
                            <?php esc_html_e('Cart', 'Skillate-core'); ?>
                            <a class="cart-contents">
                                <span class="count"><?php echo 'Cart'; ?><?php echo wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'Skillate-core' ), WC()->cart->get_cart_contents_count() ) );?></span>
                            </a>
                        </span>
                        <?php the_widget( 'WC_Widget_Cart', 'title= ' ); ?>
                    </span>
                </div>
                <div class="woo-cart-btn woo-cart">
                    <?php the_widget( 'WC_Widget_Cart', 'title= ' ); ?>
                </div>

            </div>

        </div>
    </div>
</div>
<!---Cart-->
<?php } 
