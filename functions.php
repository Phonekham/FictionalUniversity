<?php

function university_files(){
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js', NULL, microtime(), true);
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
    add_theme_support('post-thumbnails');
    add_image_size('professorLanscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('PageBanner', 1500, 350, true);
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
              'compare' =>  '>=',
              'value'   =>  $today,
              'type'    =>  'numeric'
            )
            ));
    }

    if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
        $query->set('orderby','title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
}

function PageBanner($args = null){ 
    if(!$args['title']){
        $args['title'] = get_the_title();
    }
    if(!$args['subtitle']){
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if(!$args['photo']){
        if(get_field('page_banner_background_image')){
          $args['photo'] = get_field('page_banner_background_image')['sizes']['PageBanner'];
        }else{
          $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle'] ?></p>
            </div>
        </div>  
    </div>
<?php }
add_action('pre_get_posts','university_adjust_queries');