<?php
/*
Plugin Name: WP Auth API
*/

add_action('plugins_loaded', function () {
    add_action('wp_enqueue_scripts', function () {
        wp_enqueue_script('wp-auth-api', plugins_url('wp-auth-api.js', __FILE__), [], '1.0', true);

        wp_localize_script('wp-auth-api', 'authApi', [
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ]);
    });

    add_action('rest_api_init', function () {
        register_rest_route('wp-auth-api/v1', '/login', [
            'methods' => 'GET',
            'callback' => 'wp_auth_api_login'
        ]);
    });

    function wp_auth_api_login()
    {
        $isLoggedIn = is_user_logged_in();

        return [
            'isLoggedIn' => $isLoggedIn,
            'userId' => $isLoggedIn ? get_current_user_id() : null,
        ];
    }

    function custom_login_redirect()
    {
        return 'home_url()?nextJsAdminRedirect=http://localhost:3000/';
    }

    add_filter('login_redirect', 'custom_login_redirect');
});
