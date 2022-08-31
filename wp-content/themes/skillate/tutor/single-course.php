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
                <!-- <?php tutor_course_loop_add_to_cart(); ?> -->
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
        <div class="col-lg-12">
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

                    <div id="tab-review">
                        <?php tutor_course_target_reviews_html(); ?>
                        <?php //tutor_course_target_review_form_html(); 
                        ?>

                        <?php do_action('tutor_course/single/after/inner-wrap'); ?>
                    </div>

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
