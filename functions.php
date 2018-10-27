<?php

function university_files(){
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    wp_enqueue_style('university_main_style', get_stylesheet_uri()); //Enqueue style.css
}
add_action('wp_enqueue_scripts', 'university_files');