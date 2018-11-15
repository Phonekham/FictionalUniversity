<?php get_header(); 
      PageBanner(array(
        'title' =>  'Search Results',
        'subtitle'  => 'You search for &ldquo;' . esc_html(get_search_query()) . '&rdquo;'
      ));
?>
  <div class="container container--narrow page-section">
  <?php 
  if(have_posts()){
  while(have_posts()){
    the_post();
    get_template_part('template-parts/content', get_post_type());
    
    ?>
  
  <?php }
  }else{
      echo "No search Results";
  }
  get_search_form();
  echo paginate_links();
  ?>
  </div>

<?php get_footer(); ?>