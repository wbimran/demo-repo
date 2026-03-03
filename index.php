<?php
function my_custom_register_user() {

    $username = 'imran123';
    $password = 'StrongPassword@123';
    $email    = 'imran@example.com';

    // Check if username exists
    if ( username_exists( $username ) ) {
        return new WP_Error( 'username_exists', 'Username already exists' );
    }

    // Check if email exists
    if ( email_exists( $email ) ) {
        return new WP_Error( 'email_exists', 'Email already registered' );
    }

    // Create user
    $user_id = wp_create_user( $username, $password, $email );

    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }

    // Set user role
    $user = new WP_User( $user_id );
    $user->set_role( 'subscriber' );

    return $user_id;
}

/**
 * Plugin Name: Custom Table Demo
 */

register_activation_hook( __FILE__, 'my_plugin_create_table' );

function my_plugin_create_table() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'custom_quotes';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        product_id BIGINT(20) UNSIGNED NOT NULL,
        message TEXT NOT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY product_id (product_id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}