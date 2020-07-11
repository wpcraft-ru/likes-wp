<?php
/*
* Plugin Name: Likes by WPCraft
* Description: Likes [likes-wpc]
* Plugin URI: https://github.com/wpcraft-ru/likes-wp
* Author: uptimizt
* GitHub Plugin URI: wpcraft-ru/likes-wp
* Version: 0.1
*/

add_action('plugins_loaded', function(){
    require_once __DIR__ . '/src-back/Likes.php';
});

add_action('wp_enqueue_scripts', function(){
    wp_enqueue_style( 'likes-wpc', plugins_url('public/style.css', __FILE__) );
});