<?php

function university_files(){
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
    wp_enqueue_style('university_main_style', get_stylesheet_uri(),NULL,microtime()); //Enqueue style.css
    wp_enqueue_style('font-awesome', get_theme_file_uri('/font-awesome/css/font-awesome.min.css'));
}
add_action('wp_enqueue_scripts', 'university_files');

function university_features(){
    register_nav_menu('HeaderMenuLocation', 'Header Menu Location');
    register_nav_menu('FooterMenuLocation1', 'Footer Menu Location 1');
    register_nav_menu('FooterMenuLocation2', 'Footer Menu Location 2');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query){
    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query',  array(
            array(
              'key'   =>  'event_date',
              'compare' =>  '<=',
              'value'   =>  $today,
              'type'    =>  'numeric'
            )
            ));
    }
}
add_action('pre_get_posts','university_adjust_queries');