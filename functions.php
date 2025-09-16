<?php
/**
 * BeatNight WordPress Theme Functions
 * Functions and definitions for the BeatNight nightclub theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function beatnight_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    add_theme_support('custom-background');
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom header
    add_theme_support('custom-header', array(
        'default-image' => get_template_directory_uri() . '/assets/images/header-bg.jpg',
        'width' => 1920,
        'height' => 1080,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'beatnight'),
        'footer' => __('Footer Menu', 'beatnight'),
    ));

    // Add support for featured images
    set_post_thumbnail_size(400, 300, true);
    add_image_size('event-thumbnail', 400, 300, true);
    add_image_size('gallery-thumbnail', 300, 300, true);
    add_image_size('hero-image', 1920, 1080, true);
}
add_action('after_setup_theme', 'beatnight_theme_setup');

// Enqueue styles and scripts
function beatnight_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('beatnight-style', get_stylesheet_uri(), array(), '1.0.0');

    // Enqueue custom styles
    wp_enqueue_style('beatnight-main-style', get_template_directory_uri() . '/style.css', array(), '1.0.0');

    // Enqueue Google Fonts
    wp_enqueue_style('beatnight-fonts', 'https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap', array(), null);

    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Enqueue JavaScript
    wp_enqueue_script('beatnight-script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0.0', true);

    // Localize script for AJAX
    wp_localize_script('beatnight-script', 'beatnight_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('beatnight_nonce'),
    ));

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'beatnight_scripts');

// Register widget areas
function beatnight_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'beatnight'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'beatnight'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area 1', 'beatnight'),
        'id' => 'footer-1',
        'description' => __('Add widgets here for the first footer column.', 'beatnight'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area 2', 'beatnight'),
        'id' => 'footer-2',
        'description' => __('Add widgets here for the second footer column.', 'beatnight'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area 3', 'beatnight'),
        'id' => 'footer-3',
        'description' => __('Add widgets here for the third footer column.', 'beatnight'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area 4', 'beatnight'),
        'id' => 'footer-4',
        'description' => __('Add widgets here for the fourth footer column.', 'beatnight'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'beatnight_widgets_init');

// Custom post type for Events
function beatnight_create_event_post_type() {
    register_post_type('event',
        array(
            'labels' => array(
                'name' => __('Events', 'beatnight'),
                'singular_name' => __('Event', 'beatnight'),
                'add_new' => __('Add New Event', 'beatnight'),
                'add_new_item' => __('Add New Event', 'beatnight'),
                'edit_item' => __('Edit Event', 'beatnight'),
                'new_item' => __('New Event', 'beatnight'),
                'view_item' => __('View Event', 'beatnight'),
                'search_items' => __('Search Events', 'beatnight'),
                'not_found' => __('No events found', 'beatnight'),
                'not_found_in_trash' => __('No events found in Trash', 'beatnight'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'events'),
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'menu_icon' => 'dashicons-calendar-alt',
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'beatnight_create_event_post_type');

// Custom post type for Gallery Albums
function beatnight_create_gallery_post_type() {
    register_post_type('gallery_album',
        array(
            'labels' => array(
                'name' => __('Gallery Albums', 'beatnight'),
                'singular_name' => __('Gallery Album', 'beatnight'),
                'add_new' => __('Add New Album', 'beatnight'),
                'add_new_item' => __('Add New Album', 'beatnight'),
                'edit_item' => __('Edit Album', 'beatnight'),
                'new_item' => __('New Album', 'beatnight'),
                'view_item' => __('View Album', 'beatnight'),
                'search_items' => __('Search Albums', 'beatnight'),
                'not_found' => __('No albums found', 'beatnight'),
                'not_found_in_trash' => __('No albums found in Trash', 'beatnight'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'gallery'),
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-format-gallery',
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'beatnight_create_gallery_post_type');

// Add custom meta boxes for events
function beatnight_add_event_meta_boxes() {
    add_meta_box(
        'event_details',
        __('Event Details', 'beatnight'),
        'beatnight_event_details_callback',
        'event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'beatnight_add_event_meta_boxes');

// Event details meta box callback
function beatnight_event_details_callback($post) {
    wp_nonce_field('beatnight_save_event_details', 'beatnight_event_nonce');

    $event_date = get_post_meta($post->ID, '_event_date', true);
    $event_time = get_post_meta($post->ID, '_event_time', true);
    $event_venue = get_post_meta($post->ID, '_event_venue', true);
    $event_price = get_post_meta($post->ID, '_event_price', true);
    $ticket_url = get_post_meta($post->ID, '_ticket_url', true);
    $event_address = get_post_meta($post->ID, '_event_address', true);

    echo '<table class="form-table">';
    echo '<tr><th><label for="event_date">' . __('Event Date', 'beatnight') . '</label></th>';
    echo '<td><input type="date" id="event_date" name="event_date" value="' . esc_attr($event_date) . '" /></td></tr>';

    echo '<tr><th><label for="event_time">' . __('Event Time', 'beatnight') . '</label></th>';
    echo '<td><input type="time" id="event_time" name="event_time" value="' . esc_attr($event_time) . '" /></td></tr>';

    echo '<tr><th><label for="event_venue">' . __('Venue Name', 'beatnight') . '</label></th>';
    echo '<td><input type="text" id="event_venue" name="event_venue" value="' . esc_attr($event_venue) . '" class="regular-text" /></td></tr>';

    echo '<tr><th><label for="event_address">' . __('Venue Address', 'beatnight') . '</label></th>';
    echo '<td><textarea id="event_address" name="event_address" class="regular-text">' . esc_textarea($event_address) . '</textarea></td></tr>';

    echo '<tr><th><label for="event_price">' . __('Ticket Price', 'beatnight') . '</label></th>';
    echo '<td><input type="text" id="event_price" name="event_price" value="' . esc_attr($event_price) . '" class="regular-text" placeholder="e.g., ₹1,200" /></td></tr>';

    echo '<tr><th><label for="ticket_url">' . __('Ticket Booking URL', 'beatnight') . '</label></th>';
    echo '<td><input type="url" id="ticket_url" name="ticket_url" value="' . esc_attr($ticket_url) . '" class="regular-text" placeholder="https://bookmyshow.com/..." /></td></tr>';

    echo '</table>';
}

// Save event meta data
function beatnight_save_event_details($post_id) {
    if (!isset($_POST['beatnight_event_nonce']) || !wp_verify_nonce($_POST['beatnight_event_nonce'], 'beatnight_save_event_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'event' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    $fields = array('event_date', 'event_time', 'event_venue', 'event_price', 'ticket_url', 'event_address');

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'beatnight_save_event_details');

// Custom excerpt length
function beatnight_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'beatnight_excerpt_length', 999);

// Custom excerpt more text
function beatnight_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'beatnight_excerpt_more');

// AJAX handler for contact form
function beatnight_handle_contact_form() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'beatnight_nonce')) {
        wp_die('Security check failed');
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    // Send email
    $to = get_option('admin_email');
    $email_subject = 'New Contact Form Submission - ' . $subject;
    $email_body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\n\nMessage:\n$message";
    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>');

    $sent = wp_mail($to, $email_subject, nl2br($email_body), $headers);

    if ($sent) {
        wp_send_json_success('Message sent successfully!');
    } else {
        wp_send_json_error('Failed to send message. Please try again.');
    }
}
add_action('wp_ajax_beatnight_contact_form', 'beatnight_handle_contact_form');
add_action('wp_ajax_nopriv_beatnight_contact_form', 'beatnight_handle_contact_form');

// Add theme customizer options
function beatnight_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('beatnight_hero_section', array(
        'title' => __('Hero Section', 'beatnight'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default' => 'Experience The Night',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'beatnight'),
        'section' => 'beatnight_hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Premium nightclub events & unforgettable experiences in Bangalore',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'beatnight'),
        'section' => 'beatnight_hero_section',
        'type' => 'textarea',
    ));

    // Contact Info
    $wp_customize->add_section('beatnight_contact_section', array(
        'title' => __('Contact Information', 'beatnight'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default' => '+91 98765 43210',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label' => __('Phone Number', 'beatnight'),
        'section' => 'beatnight_contact_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_email', array(
        'default' => 'info@beatnight.in',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label' => __('Email Address', 'beatnight'),
        'section' => 'beatnight_contact_section',
        'type' => 'email',
    ));

    $wp_customize->add_setting('contact_address', array(
        'default' => '123 Brigade Road, Bangalore, Karnataka 560025',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label' => __('Address', 'beatnight'),
        'section' => 'beatnight_contact_section',
        'type' => 'textarea',
    ));

    // Social Media
    $wp_customize->add_section('beatnight_social_section', array(
        'title' => __('Social Media', 'beatnight'),
        'priority' => 50,
    ));

    $social_platforms = array(
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'youtube' => 'YouTube'
    );

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting($platform . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control($platform . '_url', array(
            'label' => $label . ' URL',
            'section' => 'beatnight_social_section',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'beatnight_customize_register');

// Custom walker for navigation menu
class BeatNight_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-link';

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<a href="' . esc_attr($item->url) . '"' . $class_names . '>';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        $output .= '</a>';
    }
}

// Helper function to get events
function beatnight_get_events($limit = -1) {
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => $limit,
        'meta_key' => '_event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_event_date',
                'value' => date('Y-m-d'),
                'compare' => '>='
            )
        )
    );

    return get_posts($args);
}

// Helper function to get gallery albums
function beatnight_get_gallery_albums($limit = -1) {
    $args = array(
        'post_type' => 'gallery_album',
        'posts_per_page' => $limit,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    return get_posts($args);
}

// Add schema markup for events
function beatnight_add_event_schema() {
    if (is_singular('event')) {
        global $post;

        $event_date = get_post_meta($post->ID, '_event_date', true);
        $event_time = get_post_meta($post->ID, '_event_time', true);
        $event_venue = get_post_meta($post->ID, '_event_venue', true);
        $event_price = get_post_meta($post->ID, '_event_price', true);
        $ticket_url = get_post_meta($post->ID, '_ticket_url', true);

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => get_the_title(),
            'description' => get_the_excerpt(),
            'startDate' => $event_date . 'T' . $event_time,
            'location' => array(
                '@type' => 'Place',
                'name' => $event_venue,
            ),
            'organizer' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url()
            ),
        );

        if ($event_price && $ticket_url) {
            $schema['offers'] = array(
                '@type' => 'Offer',
                'price' => preg_replace('/[^0-9]/', '', $event_price),
                'priceCurrency' => 'INR',
                'url' => $ticket_url
            );
        }

        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'beatnight_add_event_schema');

// Add custom admin styles
function beatnight_admin_styles() {
    echo '<style>
        .post-type-event .dashicons-calendar-alt:before,
        .post-type-gallery_album .dashicons-format-gallery:before {
            color: #ff0080;
        }
        #event_details .form-table th {
            width: 150px;
        }
        #event_details .form-table input[type="text"],
        #event_details .form-table input[type="url"],
        #event_details .form-table input[type="date"],
        #event_details .form-table input[type="time"],
        #event_details .form-table textarea {
            width: 100%;
        }
    </style>';
}
add_action('admin_head', 'beatnight_admin_styles');

// Add theme support for WooCommerce (if needed for merchandise)
function beatnight_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'beatnight_woocommerce_support');

?>