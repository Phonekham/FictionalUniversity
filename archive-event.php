<?php get_header(); 
      PageBanner(array(
        'title' =>  'All Events',
        'subtitle'  => 'See what going on on our world.'
      ));
?>

  <div class="container container--narrow page-section">
  <?php while(have_posts()){
    the_post() ;
    get_template_part('template-parts/event');
  }
  echo paginate_links();
  ?>\
  <hr class="section-break">
  <p>Looking for past events <a href="<?php echo site_url("/past-events"); ?>">Checkout past events</a></p>
  </div>

<?php get_footer(); ?>