<?php

function university_files(){
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
    wp_enqueue_style('university_main_style', get_stylesheet_uri(),NULL,microtime()); //Enqueue style.css
    wp_enqueue_style('font-awesome', get_theme_file_uri('/font-awesome/css/font-awesome.min.css'));
}
add_action('wp_enqueue_scripts', 'university_files');