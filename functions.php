<?php
require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

function university_custom_rest(){
    register_rest_field('post','authorName',array(
        'get_callback'      =>  function(){return get_the_author();}
    ));
    register_rest_field('note','userNoteCount',array(
        'get_callback'      =>  function(){return count_user_posts(get_current_user_id(),'note');}
    )); //remove warning message after delete

}
add_action('rest_api_init', 'university_custom_rest');
function university_files(){
    //wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js', NULL, microtime(), true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
    wp_enqueue_style('university_main_style', get_stylesheet_uri(),NULL,microtime()); //Enqueue style.css
    wp_enqueue_style('font-awesome', get_theme_file_uri('/font-awesome/css/font-awesome.min.css'));
    wp_localize_script('main-university-js', 'universityData', array(
        'root_url'      =>  get_site_url(),
        'nonce'         =>  wp_create_nonce('wp_rest')
    )); //To make domain name flexible 
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

//Redirect Subscriber account sto homepage
add_action('admin_init', 'redirectSubsToFrontend');
function redirectSubsToFrontend(){
    $ourCurrentUSer = wp_get_current_user();
    if (count($ourCurrentUSer->roles) == 1 AND $ourCurrentUSer->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('wp_loaded', 'noSubAdminBar');
function noSubAdminBar(){
    $ourCurrentUSer = wp_get_current_user();
    if (count($ourCurrentUSer->roles) == 1 AND $ourCurrentUSer->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

//Customize login screen
add_filter('login_headerurl', 'ourHeaderUrl');
function ourHeaderUrl(){
    return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');
function ourLoginCSS(){
    wp_enqueue_style('university_main_style', get_stylesheet_uri(),NULL,microtime()); //Enqueue style.css
}

add_filter('login_headertitle', 'ourLoginTitle');
function ourLoginTitle(){
    return get_bloginfo('name');
}

//Force note post to be private
add_filter('wp_insert_post_data', 'makeNotePrivate',10,2);
function makeNotePrivate($data, $postarr){
    //Not allow post html tag
    if ($data['post_type'] == 'note') {
        $data['post_content'] = sanitize_text_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);

        if (count_user_posts(get_current_user_id(),'note') > 4 AND !$postarr['ID']) {
            die("You have reach your note limit");
        }
    }
    if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
        $data['post_status'] = "private";
    }
    
    return $data;
}