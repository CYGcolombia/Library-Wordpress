<?php
// Course Price Type
function skillate_course_price_type($type = null){
    $types = apply_filters('skillate_course_level', array(
        'free'    => __('Free', 'Skillate-core'),
        'paid'      => __('Paid', 'Skillate-core'),
    ));

    if ($type){
        if (isset($types[$type])){
            return $types[$type];
        }else{
            return '';
        }
    }

    return $types;
}

//Course Complete Update option
function skillate_course_complete_notify(){
    update_option( 'skillate_course_complete', 'course-completed' );
}
add_action('tutor_course_complete_after', 'skillate_course_complete_notify');

//Course Complete Show Animation
function skillate_show_course_complete_animation(){
    if ( get_option( 'skillate_course_complete' ) == 'course-completed' ) {	
        //include_once( 'course-complete-notify.php' );
        delete_option('skillate_course_complete');
    }
}
add_action( 'wp_footer', 'skillate_show_course_complete_animation' );


// Limit Word display function
function skillate_limit_word($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]);
    }
    return $text;
}


// add User favourite check Field
add_action( 'show_user_profile', 'skillate_add_profile_fields' );
add_action( 'edit_user_profile', 'skillate_add_profile_fields' );
function skillate_add_profile_fields( $user ) { 
    if(!current_user_can('administrator')){
        return;
    }
    ?>
    <h2><?php echo __("Make Instructor Favourite", 'Skillate-core'); ?></h2>
    <table class="form-table">
        <tr>
            <th><label for="favorite_subject"><?php echo __("Favourite Instructor", 'Skillate-core'); ?></label></th>
            <td>
            <input type="checkbox" name="favourite_instructor" value="yes" <?php if(get_user_meta($user->ID, 'favourite_instructor', true)=='yes') echo 'checked="checked"'; ?> /><?php echo __('Yes', 'Skillate-core'); ?><br />
            </td>
        </tr>
    </table>
<?php } 

// Save user favourite check Field
add_action( 'personal_options_update', 'skillate_save_add_profile_fields' );
add_action( 'edit_user_profile_update', 'skillate_save_add_profile_fields' );
function skillate_save_add_profile_fields( $user_id ) {
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    update_user_meta( $user_id, 'favourite_instructor', $_POST['favourite_instructor'] );
}


/* -------------------------------------------
* 			Course Search.
* -------------------------------------------- */
function skillate_core_course_search_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'class' 		=> '',
        'placeholder' 	=> __('Search tutorial & article', 'Skillate-core')
    ), $atts));
    ob_start();
    $action = function_exists('tutor_utils') ? tutor_utils()->course_archive_page_url() : site_url('/'); ?>
    
    <form class="<?php echo esc_attr($class); ?> search_form_shortcode" role="search" action="<?php echo esc_url($action); ?>" method="get">
      	<div class="search-wrap">
            <div class="header_search_input">
                <input 
                    type="text" 
                    placeholder="<?php echo esc_attr($placeholder); ?>" 
                    value="<?php echo esc_attr( get_search_query()); ?>" 
                    name="s" id="searchwordd" />
                <button type="submit">
                    <img src="<?php echo get_template_directory_uri();?>/images/search-icon.svg" alt="">
                </button>
                    
            </div>
      	</div>
    </form>

    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('course_search', 'skillate_core_course_search_shortcode');

/*--------------------------------------------------------------
 *          Register Language Taxonomies
 *-------------------------------------------------------------*/
function skillate_course_language(){
    $labels = array(    
        'name'              => _x( 'Course Language', 'taxonomy general name','Skillate-core'),
        'singular_name'     => _x( 'Language', 'taxonomy singular name','Skillate-core' ),
        'search_items'      => __( 'Search Language','Skillate-core'),
        'all_items'         => __( 'All Language','Skillate-core'),
        'parent_item'       => __( 'Parent Language','Skillate-core'),
        'parent_item_colon' => __( 'Parent Language:','Skillate-core'),
        'edit_item'         => __( 'Edit Language','Skillate-core'),
        'update_item'       => __( 'Update Language','Skillate-core'),
        'add_new_item'      => __( 'Add New Language','Skillate-core'),
        'new_item_name'     => __( 'New Language Name','Skillate-core'),
        'menu_name'         => __( 'Language','Skillate-core')
    );
    $args = array(  
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
    );
    register_taxonomy('course-language', array( 'courses' ), $args);
}
add_action('init','skillate_course_language');
add_action('tutor_admin_register', 'language_categories_add_to_tutor_menu');
function language_categories_add_to_tutor_menu(){
    $course_post_type = 'courses';
    add_submenu_page('tutor', __('Languages', 'Skillate-core'), __('Languages', 'Skillate-core'), 'manage_tutor', 'edit-tags.php?taxonomy=course-language&post_type='.$course_post_type, null );
}

// Logout Redirect
add_action('wp_logout','skillate_redirect_after_logout');
function skillate_redirect_after_logout(){
    $home_url = home_url();
    wp_redirect( $home_url );
    exit();
}

// Remove woocommerce checkout field
add_filter( 'woocommerce_checkout_fields' , 'skillate_remove_woo_checkout_fields' );
function skillate_remove_woo_checkout_fields( $fields ) {
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);
   
    // remove shipping fields 
    unset($fields['shipping']['shipping_first_name']);      
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_state']);
    return $fields;
}

// Rename Woocommerce checkout label
add_filter( 'woocommerce_checkout_fields' , 'skillate_rename_wc_checkout_fields' );
// Change placeholder and label text
function skillate_rename_wc_checkout_fields( $fields ) {
    $fields['billing']['billing_first_name']['placeholder'] = 'Full Name';
    $fields['billing']['billing_first_name']['label'] = 'Full Name';
    return $fields;
}

// Change Place order button text
add_filter( 'woocommerce_order_button_text', 'skillate_custom_button_text' );
function skillate_custom_button_text( $button_text ) {
   return 'Purchase Now'; // new text is here 
}

//Custom Thank you Page Redirect
add_action( 'woocommerce_thankyou', 'bbloomer_redirectcustom');
function bbloomer_redirectcustom( $order_id ){
    $order = wc_get_order( $order_id );
    $url = home_url().'/checkout-success';
    if ( ! $order->has_status( 'failed' ) ) {
        wp_safe_redirect( $url );
        exit;
    }
}