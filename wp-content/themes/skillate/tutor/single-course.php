<?php

/**
 * Template for displaying single course
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 */
?>
<?php
get_header();
global $post;
$idd = get_the_ID();
$user_id = get_current_user_id();
$is_enrolled = tutor_utils()->is_enrolled();
$is_announcement_enabled = tutor_utils()->get_option('enable_course_announcements');
$is_completed_course = tutor_utils()->is_completed_course();
$is_completed = tutor_utils()->is_completed_course($idd, $user_id);
$lesson_url = tutor_utils()->get_course_first_lesson();
$course_details_best_sell_tag = get_theme_mod('course_details_best_sell_tag', true);
$course_details_rating = get_theme_mod('course_details_rating', true);
$single_course_tab_sticky_menu = get_theme_mod('single_course_tab_sticky_menu', true);
$is_purchasable = tutor_utils()->is_course_purchasable();
$is_privileged_user    = tutor_utils()->has_user_course_content_access();
$max_new_post = get_theme_mod('new_course_count', 5);
$rcp_en_class = '';
$retake_course       = tutor_utils()->can_user_retake_course();
$course_id           = get_the_ID();
$course_progress     = tutor_utils()->get_course_completed_percent($course_id, 0, true);

if (function_exists('tutor') && tutor()->course_post_type === get_post_type($idd)) {
    $student_must_login_to_view_course = (int) tutor_utils()->get_option('student_must_login_to_view_course');
    $is_public = \TUTOR\Course_List::is_public($idd);
    if (!is_user_logged_in() && !$is_public && $student_must_login_to_view_course) {
        tutor_load_template('login');
        return;
    }
}


$total_posts = get_posts(
    array(
        'numberposts'  => $max_new_post,
        'post_status'  => 'publish',
        'post_type'    => 'courses',
    )
);
$post_array = array();
foreach ($total_posts as $total_post) {
    $post_array[] += $total_post->ID;
}
?>


<?php do_action('tutor_course/single/before/wrap'); ?>
<div <?php tutor_post_class('tutor-full-width-course-top tutor-course-top-info tutor-page-wrap'); ?>>
    <div class="course-single-mobile d-lg-none">
        <div class="container">
            <div class="row">
                <div class="col-10">
                    <div class="tutor-single-course-rating d-block">
                        <?php
                        $skillate_course_rating = tutor_utils()->get_course_rating();
                        tutor_utils()->star_rating_generator($skillate_course_rating->rating_avg);
                        $product_id = tutor_utils()->get_course_product_id();
                        if (class_exists('woocommerce')) {
                            $product = wc_get_product($product_id);
                        } ?>
                        <p class="tutor-single-rating-count d-inline-block">
                            ( <span><?php echo esc_attr($skillate_course_rating->rating_count); ?></span>
                            <?php
                            if ($skillate_course_rating->rating_count > 1) {
                                echo esc_html__('Reviews', 'skillate');
                            } else {
                                echo esc_html__('Review', 'skillate');
                            }
                            ?> )
                        </p>
                    </div>
                </div>
                <div class="col-2 text-right">
                    <?php
                    $is_wishlisted = tutor_utils()->is_wishlisted($idd);
                    $has_wish_list = '';
                    if ($is_wishlisted) {
                        $has_wish_list = 'has-wish-listed';
                    }
                    echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-bookmark-line tutor-course-wishlist-btn ' . $has_wish_list . ' " data-course-id="' . $idd . '"></a> </span>';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container course-single-title-top mb-sm-2">
        <div class="row">
            <div class="col-md-8 col-11 mb-sm-2">
                <?php
                if ($course_details_best_sell_tag) :
                    $best_selling = get_post_meta(get_the_ID(), 'skillate_best_selling', true);
                    if ($best_selling == !false) { ?>
                        <span class="best-sell-tag d-none d-lg-block">
                            <?php echo esc_html__('Featured', 'skillate'); ?>
                        </span>
                    <?php } else if (get_the_ID() == in_array(get_the_ID(), $post_array)) { ?>
                        <span class="best-sell-tag new-tag d-none d-lg-block">
                            <?php echo esc_html__('New', 'skillate'); ?>
                        </span>
                <?php }
                endif;
                ?>
                <h1 class="tutor-course-header-h1">
                    <?php the_title(); ?>
                </h1>
            </div>
            <div class="col-md-4 ml-auto text-md-right d-none d-lg-block">
                <div class="course-single-price mt-4">
                    <?php tutor_course_price(); ?>
                </div>
                <?php
                if ($course_details_rating) :
                ?>
                    <div class="tutor-single-course-rating d-sm-inline-block">
                        <?php
                        $skillate_course_rating = tutor_utils()->get_course_rating();
                        tutor_utils()->star_rating_generator($skillate_course_rating->rating_avg);
                        $product_id = tutor_utils()->get_course_product_id();
                        if (class_exists('woocommerce')) {
                            $product = wc_get_product($product_id);
                        } ?>
                        <p class="tutor-single-rating-count">
                            ( <span><?php echo esc_attr($skillate_course_rating->rating_count); ?></span>
                            <?php
                            if ($skillate_course_rating->rating_count > 1) {
                                echo esc_html__('Reviews', 'skillate');
                            } else {
                                echo esc_html__('Review', 'skillate');
                            }
                            ?> )
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <?php do_action('tutor_course/single/lead_meta/after'); ?>
    </div>
    <div class="container course-single-attribute">
        <div class="row align-items-lg-center">
            <?php if (!empty(get_tutor_course_level())) {
                $disable_course_level = get_tutor_option('disable_course_level');
                if (!$disable_course_level) {
            ?>
                    <div class="col-lg-2 col-4 mb-sm-0 mb-1">
                        <div class="course-attribute-single">
                            <span><?php echo esc_html__('Course Level', 'skillate'); ?></span>
                            <h3><?php echo esc_html(get_tutor_course_level()); ?></h3>
                        </div>
                    </div>
            <?php }
            } ?>

            <?php
            $course_duration = get_tutor_course_duration_context_skillate();
            if (!empty($course_duration)) { ?>
                <div class="col-lg-2 col-4 mb-sm-0 mb-1">
                    <div class="course-attribute-single">
                        <span><?php echo esc_html__('Total Hour', 'skillate'); ?></span>
                        <h3 class="duration">
                            <?php echo $course_duration; ?>
                        </h3>
                    </div>
                </div>
            <?php } ?>

            <?php $skillate_pro_tutor_lesson_count = tutor_utils()->get_lesson_count_by_course(get_the_ID());
            if ($skillate_pro_tutor_lesson_count) { ?>
                <div class="col-lg-2 col-4 mb-sm-0 mb-1">
                    <div class="course-attribute-single d-none d-lg-block">
                        <span><?php echo esc_html__('Video Tutorials', 'skillate'); ?></span>
                        <h3><?php echo esc_html($skillate_pro_tutor_lesson_count); ?></h3>
                    </div>
                </div>
            <?php } ?>
            <?php if (!$is_enrolled) { ?>
                <div class="col-lg-6 col-sm-12 ml-auto text-left text-lg-right mt-lg-0 mt-3">
                    <?php
                    $is_wishlisted = tutor_utils()->is_wishlisted($idd);
                    $has_wish_list = '';
                    if ($is_wishlisted) {
                        $has_wish_list = 'has-wish-listed';
                    }

                    $rcp_en_class = class_exists('RCP_Requirements_Check') ? 'rcp-exits' : '';

                    ?>
                    <?php if ($is_purchasable) { ?>
                        <div class="skillate-course-cart-btn d-none d-lg-flex align-items-center justify-content-end <?php echo esc_attr($rcp_en_class); ?>">
                            <div>
                                <?php
                                if (is_user_logged_in()) {
                                    echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-bookmark-line tutor-course-wishlist-btn ' . $has_wish_list . ' " data-course-id="' . $idd . '"></a> </span>';
                                } else {
                                    echo '<span class="tutor-course-wishlist"><a class="tutor-icon-fav-line" data-toggle="modal" href="#modal-login"></a></span>';
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                if ($is_privileged_user) :
                                    $first_lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID(), tutor()->lesson_post_type);
                                    if (!$first_lesson_url) {
                                        $first_lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID());
                                    }
                                ?>
                                    <a href="<?php echo esc_url($first_lesson_url); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-ml-20">
                                        <?php esc_html_e('Start Learning', 'tutor'); ?>
                                    </a>
                                <?php
                                endif;
                                ?>
                            </div>
                            <?php
                            $product_id = tutor_utils()->get_course_product_id();
                            if (class_exists('woocommerce')) {
                                $product = wc_get_product($product_id);
                            }
                            if (!class_exists('Easy_Digital_Downloads') && class_exists('woocommerce') && tutor_utils()->is_course_purchasable() && !$is_privileged_user) { ?>
                                <form class="cart" action="<?php echo wc_get_checkout_url(); ?>" method="post" enctype='multipart/form-data'>
                                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="tutor-btn tutor-btn-outline-primary tutor-ml-20 course-buy-now "> <?php echo esc_html__('Buy Now', 'skillate'); ?>
                                    </button>
                                </form>
                            <?php }
                            if (tutor_utils()->is_course_added_to_cart($product_id, true)) { ?>
                                <a href="<?php echo wc_get_cart_url(); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-add-to-cart-button tutor-ml-20">
                                    <span class="tutor-icon-cart-line tutor-mr-8"></span>
                                    <span><?php _e('View Cart', 'tutor'); ?></span>
                                </a>
                            <?php
                            } else if (!$is_privileged_user) {
                            ?>
                                <form action="<?php echo esc_url(apply_filters('tutor_course_add_to_cart_form_action', get_permalink(get_the_ID()))); ?>" method="post" enctype="multipart/form-data">
                                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-ml-20 tutor-add-to-cart-button <?php echo $required_loggedin_class; ?>">
                                        <span class="tutor-icon-cart-line tutor-mr-8"></span>
                                        <span><?php echo esc_html($product->single_add_to_cart_text()); ?></span>
                                    </button>
                                </form>
                            <?php
                            }
                            ?>

                        </div>
                </div>
            <?php } else { ?>

                <div class="skillate-course-cart-btn d-none d-lg-block <?php echo esc_attr($rcp_en_class); ?>">
                    <div>
                        <?php
                        if ($is_privileged_user) :
                            $first_lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID(), tutor()->lesson_post_type);
                            if (!$first_lesson_url) {
                                $first_lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID());
                            }
                        ?>
                            <a href="<?php echo esc_url($first_lesson_url); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-ml-20">
                                <?php esc_html_e('Start Learning', 'tutor'); ?>
                            </a>
                        <?php
                        endif;
                        ?>
                    </div>
                    <?php if (!is_user_logged_in() && !$is_privileged_user) { ?>
                        <form class="tutor-enrol-course-form" method="post">
                            <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
                            <input type="hidden" name="tutor_course_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                            <input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">
                            <a type="submit" class="button product_type_simple tutor-btn" data-toggle="modal" href="<?php if (!is_user_logged_in()) {
                                                                                                                        echo "#modal-login";
                                                                                                                    } ?>">
                                <?php esc_html_e('Enroll Course', 'tutor'); ?>
                            </a>
                        </form>
                    <?php } ?>
                    <?php if (is_user_logged_in() && !$is_privileged_user) { ?>
                        <form class="tutor-enrol-course-form" method="post">
                            <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
                            <input type="hidden" name="tutor_course_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                            <input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">
                            <button type="submit" class="button product_type_simple tutor-btn tutor-enroll-course-button">
                                <?php esc_html_e('Enroll Course', 'tutor'); ?>
                            </button>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if ($is_enrolled) { ?>
        <div class="col-lg-6 col-sm-12 ml-auto text-left text-lg-right mt-lg-0 mt-3">
            <div class="skillate-course-cart-btn enrolled">

                <?php
                $start_content = '';

                // The user is enrolled anyway. No matter manual, free, purchased, woocommerce, edd, membership
                // do_action( 'tutor_course/single/actions_btn_group/before' );

                // Show Start/Continue/Retake Button
                if ($lesson_url) {
                    $button_class = 'tutor-btn tutor-btn-outline-primary tutor-btn-md' . ($retake_course ? ' tutor-course-retake-button' : '');

                    // Button identifier class
                    $button_identifier = 'start-continue-retake-button';
                    $tag               = $retake_course ? 'button' : 'a';
                    ob_start();

                ?>
                    <<?php echo $tag; ?> <?php echo $retake_course ? 'disabled="disabled"' : ''; ?> href="<?php echo esc_url($lesson_url); ?>" class="<?php echo esc_attr($button_class . ' ' . $button_identifier); ?>" data-course_id="<?php echo esc_attr(get_the_ID()); ?>">
                        <?php
                        if ($retake_course) {
                            esc_html_e('Retake This Course', 'tutor');
                        } elseif ($course_progress <= 0) {
                            esc_html_e('Start Learning', 'tutor');
                        } else {
                            esc_html_e('Continue Learning', 'tutor');
                        }
                        ?>
                    </<?php echo $tag; ?>>
                <?php
                    $start_content = ob_get_clean();
                }
                echo apply_filters('tutor_course/single/start/button', $start_content, get_the_ID()); ?>

                <?php
                if (!$is_completed_course) {
                    ob_start();
                ?>
                    <form method="post">
                        <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>

                        <input type="hidden" value="<?php echo esc_attr(get_the_ID()); ?>" name="course_id" />
                        <input type="hidden" value="tutor_complete_course" name="tutor_action" />

                        <button type="submit" class="button product_type_simple" name="complete_course_btn" value="complete_course">
                            <?php esc_html_e('Complete Course', 'tutor'); ?>
                        </button>
                    </form>
                <?php
                    echo apply_filters('tutor_course/single/complete_form', ob_get_clean());
                }
                ?>
                <?php do_action('tutor_course/single/actions_btn_group/before'); ?>
                <?php do_action('tutor_course/single/actions_btn_group/after'); ?>
            </div>
        </div>
    <?php } ?>
    </div>

</div>

<div class="container tutor-course-preview-thumbnail">
    <?php do_action('tutor_course/single/before/inner-wrap');
    $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'skillate-large');
    ?>
    <style>
        .tutor-single-lesson-segment .plyr__poster:before {
            background: url(<?php echo esc_url($thumb_url[0]); ?>);
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <?php
            if (tutor_utils()->has_video_in_single()) {
                tutor_course_video();
            } else {
                get_tutor_course_thumbnail();
            }
            ?>
        </div>
    </div>

    <div class="skillate-course-cart-btn d-md-none <?php echo esc_attr($rcp_en_class); ?>">
        <div class="row">
            <div class="col-6">
                <?php
                $product_id = tutor_utils()->get_course_product_id();
                if (class_exists('woocommerce')) {
                    $product = wc_get_product($product_id);
                }
                if (!class_exists('Easy_Digital_Downloads') && class_exists('woocommerce') && tutor_utils()->is_course_purchasable()) { ?>
                    <form class="cart" action="<?php echo wc_get_checkout_url(); ?>" method="post" enctype='multipart/form-data'>
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="course-buy-now"> <?php echo esc_html__('Buy Now', 'skillate'); ?>
                        </button>
                    </form>
                <?php } ?>

            </div>
            <div class="col-6">
                <?php tutor_course_loop_add_to_cart(); ?>
            </div>
        </div>
    </div>
</div>

<div class="skillate-tab-menu-wrap" data-isSticky="<?php echo esc_attr($single_course_tab_sticky_menu); ?>">
    <div class="container">
        <ul class="nav nav-pills single-course-item-tab">
            <li class="nav-item tab current" data-tab="tab-1">
                <a href="#tab-1"><?php echo esc_html__('course Topics Content', 'skillate'); ?></a>
            </li>
            <li class="nav-item tab" data-tab="tab-2">
                <a class="course-content-tab-link" href="#tab-about">
                    <?php echo esc_html__('About Course', 'skillate'); ?>
                </a>
                <a class="course-content-tab-link" href="#tab-learn">
                    <?php echo esc_html__('What to learn', 'skillate'); ?>
                </a>

                <a class="course-content-tab-link" href="#tab-requirement">
                    <?php echo esc_html__('Requirement', 'skillate'); ?>
                </a>

                <a class="course-content-tab-link" href="#tab-audience">
                    <?php echo esc_html__('Target Audience', 'skillate'); ?>
                </a>

                <?php if ($is_announcement_enabled || $is_privileged_user) { ?>
                    <a class="course-content-tab-link" href="#tab-announcements">
                        <?php echo esc_html__('Announcements', 'skillate'); ?>
                    </a>
                <?php } ?>

                <?php if ($is_enrolled || $is_privileged_user) { ?>
                    <a class="course-content-tab-link" href="#tab-qa">
                        <?php echo esc_html__('Q&A', 'skillate'); ?>
                    </a>
                <?php } ?>

                <?php if ($is_enrolled || $is_privileged_user) { ?>
                    <a class="course-content-tab-link" href="#tab-attachments">
                        <?php echo esc_html__('Attachments', 'skillate'); ?>
                    </a>
                <?php } ?>

                <a class="course-content-tab-link" href="#tab-instructor">
                    <?php echo esc_html__('Instructor', 'skillate'); ?>
                </a>
                <a class="course-content-tab-link" href="#tab-review">
                    <?php echo esc_html__('Review', 'skillate'); ?>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="skillate-tab-content-wrap">
                <div id="tab-1" class="skillate-tab-content current">
                    <?php tutor_course_topics(); ?>
                </div>
                <div id="tab-2" class="skillate-tab-content">
                    <?php do_action('tutor_course/single/before/content'); ?>
                    <div id="tab-about" class="tutor-course-content">
                        <?php tutor_course_content(); ?>
                    </div>
                    <?php do_action('tutor_course/single/after/content'); ?>

                    <div id="tab-learn" class="clearfix">
                        <h4 class="tutor-course-details-widget-title tutor-fs-5 tutor-color-black tutor-fw-bold tutor-mb-16"><?php echo esc_html__('What to learn?', 'skillate'); ?></h4>
                        <?php
                        echo wp_kses_post($learn_content = get_post_meta($idd, '_tutor_course_benefits', true));
                        ?>
                        <?php //tutor_course_benefits_html(); 
                        ?>
                    </div>

                    <div id="tab-requirement">
                        <?php tutor_course_requirements_html(); ?>
                    </div>
                    <div id="tab-audience">
                        <?php tutor_course_target_audience_html(); ?>
                    </div>

                    <?php
                    $display_course_instructors = tutor_utils()->get_option('display_course_instructors');
                    if ($display_course_instructors == 1) { ?>
                        <div id="tab-instructor">
                            <?php do_action('tutor_course/single/enrolled/before/instructors');
                            $instructors = tutor_utils()->get_instructors_by_course();
                            if ($instructors) {
                            ?>
                                <h4 class="tutor-course-details-widget-title tutor-fs-5 tutor-color-black tutor-fw-bold tutor-mb-16"><?php _e('Instructor', 'skillate'); ?></h4>

                                <div class="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">
                                    <?php
                                    foreach ($instructors as $instructor) {
                                        global $authordata;
                                        $author_id = $post->post_author;
                                        $profile_url = tutor_utils()->profile_url($authordata->ID, true);
                                    ?>
                                        <div class="single-instructor-wrap">
                                            <div class="row no-gutters">
                                                <div class="col-lg-4">
                                                    <div class="instructor-avatar">
                                                        <a href="<?php echo $profile_url; ?>">
                                                            <?php
                                                            echo tutor_utils()->get_tutor_avatar($instructor->ID, 'skillate-square');
                                                            ?>
                                                        </a>

                                                        <div class="ratings">
                                                            <i class="fas fa-star"></i>
                                                            <?php
                                                            $instructor_rating = tutor_utils()->get_instructor_ratings($instructor->ID);
                                                            echo " <span class='rating-digits'>{$instructor_rating->rating_avg}</span> ";
                                                            echo " <span class='rating-total-meta'>" . __('/5', 'skillate') . "</span> ";
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="p-4">
                                                        <div class="instructor-name">
                                                            <h3>
                                                                <a href="<?php echo $profile_url; ?>">
                                                                    <?php echo $instructor->display_name; ?>
                                                                </a>
                                                            </h3>

                                                        </div>
                                                        <div class="courses">
                                                            <p>
                                                                <?php echo tutor_utils()->get_course_count_by_instructor($instructor->ID); ?> <span class="tutor-text-mute"> <?php _e('Courses', 'skillate'); ?></span>
                                                            </p>
                                                        </div>
                                                        <div class="instructor-bio">
                                                            <?php echo wp_trim_words($instructor->tutor_profile_bio, 30); ?>
                                                        </div>
                                                        <?php
                                                        $tutor_user_social_icons = tutor_utils()->tutor_user_social_icons();
                                                        if (count($tutor_user_social_icons)) {
                                                        ?>
                                                            <div class="single-tutor-social-icons">
                                                                <?php
                                                                $i = 0;
                                                                foreach ($tutor_user_social_icons as $key => $social_icon) {
                                                                    $icon_url = get_user_meta($instructor->ID, $key, true);
                                                                    if ($icon_url) {
                                                                        echo "<a href='" . esc_url($icon_url) . "' target='_blank' class='" . $social_icon['icon_classes'] . "'></a>";
                                                                    }
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            do_action('tutor_course/single/enrolled/after/instructors'); ?>
                        </div>
                    <?php } ?>

                    <?php if ($is_enrolled || $is_privileged_user) { ?>
                        <div id="tab-announcements">
                            <h4 class="tutor-course-details-widget-title tutor-fs-5 tutor-color-black tutor-fw-bold tutor-mb-16"><?php echo _e('Announcements', 'skillate'); ?></h4>
                            <?php tutor_course_announcements(); ?>
                            <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam eius tempora, fugiat saepe voluptatibus eveniet fugit perspiciatis excepturi, aut nulla odio pariatur architecto sequi culpa? Iusto qui consequatur debitis eius nulla delectus provident quam quia, quibusdam quasi vitae praesentium ipsum, voluptatibus repellat dolore cumque sint ad iste a accusantium nobis!</div>
                        </div>
                    <?php } ?>

                    <?php if ($is_enrolled || $is_privileged_user) { ?>
                        <div id="tab-attachments">
                            <h4 class="tutor-course-details-widget-title tutor-fs-5 tutor-color-black tutor-fw-bold tutor-mb-16"><?php echo _e('Attachments', 'skillate'); ?></h4>
                            <?php get_tutor_posts_attachments(); ?>
                        </div>
                    <?php } ?>

                    <?php if ($is_enrolled || $is_privileged_user) { ?>
                        <div id="tab-qa">
                            <?php
                            $disable_qa_for_this_course = get_post_meta($post->ID, '_tutor_enable_qa', true) != 'yes';
                            $enable_q_and_a_on_course = tutor_utils()->get_option('enable_q_and_a_on_course');

                            do_action('tutor_course/question_and_answer/before');
                            if (!$disable_qa_for_this_course) {
                                echo '<div class="tutor-course-details-widget-title tutor-fs-5 tutor-color-black tutor-fw-bold tutor-mb-16">' . __('Question & Answer', 'tutor') . '</div>';

                                // New qna form
                                tutor_load_template_from_custom_path(tutor()->path . '/views/qna/qna-new.php', array(
                                    'course_id' => get_the_ID(),
                                    'context' => 'course-single-qna-single'
                                ), false);

                                // Previous qna list
                                $questions = tutor_utils()->get_qa_questions(0, 20, $search_term = '', $question_id = null, $meta_query = null, $asker_id = null, $question_status = null, $count_only = false, $args = array('course_id' => get_the_ID()));
                                foreach ($questions as $question) {
                                    tutor_load_template_from_custom_path(tutor()->path . '/views/qna/qna-single.php', array(
                                        'question_id' => $question->comment_ID,
                                        'context' => 'course-single-qna-single'
                                    ), false);
                                }
                            } else {
                                echo '<div class="tutor-course-details-widget-title tutor-fs-5 tutor-color-black tutor-fw-bold tutor-mb-16">' . __('This feature has been disabled by the administrator', 'tutor') . '</div>';
                            }
                            do_action('tutor_course/question_and_answer/after');
                            ?>
                        </div>
                    <?php } ?>

                    <div id="tab-review">
                        <?php tutor_course_target_reviews_html(); ?>
                        <?php //tutor_course_target_review_form_html(); 
                        ?>

                        <?php do_action('tutor_course/single/after/inner-wrap'); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="skillate-single-course-sidebar">
                <div class="course-single-price">
                    <?php tutor_course_price(); ?>
                </div>
                <?php tutor_course_material_includes_html(); ?>
                <?php
                if ($is_privileged_user) {
                    $first_lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID(), tutor()->lesson_post_type);
                    if (!$first_lesson_url) {
                        $first_lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID());
                    }
                ?>
                    <div class="tutor-mt-20">
                        <a href="<?php echo esc_url($first_lesson_url); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block">
                            <?php esc_html_e('Start Learning', 'tutor'); ?>
                        </a>
                    </div>
                <?php
                }
                ?>


                <?php if ($is_enrolled) { ?>
                    <div class="skillate-course-cart-btn enrolled tutor-mt-28">
                        <?php
                        $start_content = '';

                        // The user is enrolled anyway. No matter manual, free, purchased, woocommerce, edd, membership
                        // do_action( 'tutor_course/single/actions_btn_group/before' );

                        // Show Start/Continue/Retake Button
                        if ($lesson_url) {
                            $button_class = 'tutor-btn tutor-btn-outline-primary tutor-btn-md tutor-btn-block' . ($retake_course ? ' tutor-course-retake-button' : '');

                            // Button identifier class
                            $button_identifier = 'start-continue-retake-button';
                            $tag               = $retake_course ? 'button' : 'a';
                            ob_start();

                        ?>
                            <<?php echo $tag; ?> <?php echo $retake_course ? 'disabled="disabled"' : ''; ?> href="<?php echo esc_url($lesson_url); ?>" class="<?php echo esc_attr($button_class . ' ' . $button_identifier); ?>" data-course_id="<?php echo esc_attr(get_the_ID()); ?>">
                                <?php
                                if ($retake_course) {
                                    esc_html_e('Retake This Course', 'tutor');
                                } elseif ($course_progress <= 0) {
                                    esc_html_e('Start Learning', 'tutor');
                                } else {
                                    esc_html_e('Continue Learning', 'tutor');
                                }
                                ?>
                            </<?php echo $tag; ?>>
                        <?php
                            $start_content = ob_get_clean();
                        }
                        echo apply_filters('tutor_course/single/start/button', $start_content, get_the_ID()); ?>

                        <?php
                        if (!$is_completed_course) {
                            ob_start();
                        ?>
                            <form method="post">
                                <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>

                                <input type="hidden" value="<?php echo esc_attr(get_the_ID()); ?>" name="course_id" />
                                <input type="hidden" value="tutor_complete_course" name="tutor_action" />

                                <button type="submit" class="button product_type_simple" name="complete_course_btn" value="complete_course">
                                    <?php esc_html_e('Complete Course', 'tutor'); ?>
                                </button>
                            </form>
                        <?php
                            echo apply_filters('tutor_course/single/complete_form', ob_get_clean());
                        }
                        ?>
                        <?php do_action('tutor_course/single/actions_btn_group/before'); ?>
                        <?php do_action('tutor_course/single/actions_btn_group/after'); ?>
                    </div>
                <?php } ?>

                <?php
                // Displaying -> Buy Now and Add to Cart/View Cart  ( Sidebar )
                $rcp_en_class = class_exists('RCP_Requirements_Check') ? 'rcp-exits' : '';
                ?>
                <?php if ($is_purchasable && !$is_privileged_user) { ?>
                    <?php
                    if (!$is_enrolled) {
                    ?>
                        <div class="<?php echo esc_attr($rcp_en_class); ?> tutor-mt-20">
                            <?php
                            $product_id = tutor_utils()->get_course_product_id();
                            if (class_exists('woocommerce')) {
                                $product = wc_get_product($product_id);
                            }
                            if (!class_exists('Easy_Digital_Downloads') && class_exists('woocommerce') && tutor_utils()->is_course_purchasable()) { ?>
                                <form class="cart" action="<?php echo wc_get_checkout_url(); ?>" method="post" enctype='multipart/form-data'>
                                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-block course-buy-now "> <?php echo esc_html__('Buy Now', 'skillate'); ?>
                                    </button>
                                </form>
                            <?php }
                            if (tutor_utils()->is_course_added_to_cart($product_id, true)) { ?>
                                <a href="<?php echo wc_get_cart_url(); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-add-to-cart-button">
                                    <span class="tutor-icon-cart-line tutor-mr-8"></span>
                                    <span><?php _e('View Cart', 'tutor'); ?></span>
                                </a>
                            <?php
                            } else {
                            ?>
                                <form action="<?php echo esc_url(apply_filters('tutor_course_add_to_cart_form_action', get_permalink(get_the_ID()))); ?>" method="post" enctype="multipart/form-data">
                                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-add-to-cart-button <?php echo $required_loggedin_class; ?>">
                                        <span class="tutor-icon-cart-line tutor-mr-8"></span>
                                        <span><?php echo esc_html($product->single_add_to_cart_text()); ?></span>
                                    </button>
                                </form>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        </div>
                    <?php }
                // End of Displaying -> Buy Now and Add to Cart/View Cart ( Sidebar )
                    ?>

                    <div class="tutor-social-share tutor-mt-15"> <br />
                        <?php
                        if (tutor_utils()->get_option('enable_course_share', false, true, true)) {
                            tutor_load_template_from_custom_path(tutor()->path . '/views/course-share.php', array(), false);
                        }
                        ?>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
//do_action('tutor_course/single/after/wrap');
$related_course_slider = get_theme_mod('related_course_slider', true);
if ($related_course_slider) {
    get_template_part('lib/single-related-post');
}
get_footer();
