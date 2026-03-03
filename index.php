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

global $wpdb;

$table_name = $wpdb->prefix . 'custom_quotes';

$wpdb->insert(
    $table_name,
    array(
        'user_id'    => get_current_user_id(),
        'product_id' => 123,
        'message'    => 'Need bulk price',
        'status'     => 'pending',
    ),
    array(
        '%d',
        '%d',
        '%s',
        '%s',
    )
);