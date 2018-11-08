<?php get_header(); ?>

<?php
while(have_posts()){
    the_post();
    PageBanner();
    ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Program</a> <span class="metabox__main"><?php the_title(); ?></span></p>
        </div>
        <h2><?php the_title(); ?></h2>
        <div class="generic-content"> <?php the_content(); ?>  </div> 
        <?php 

        $relativeProfessor = new WP_Query(array(
          'posts_per_page'  =>  -1, 
          'post_type'       =>  'professor',
          'orderby'         =>  'title', 
          'order'           =>  'ASC',
          'meta_query'      =>  array(
            array(
                'key'   =>  'related_programs', 
                'compare'   =>  'LIKE',
                'value'     => '"' . get_the_ID() . '"'
            )
          )
        ));
        if($relativeProfessor->have_posts()){
            echo "<hr class='section-break'>";
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
            echo '<ul class="professor-cards">';
            while($relativeProfessor->have_posts()){
              $relativeProfessor->the_post() ?>
              <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink(); ?>">
                  <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLanscape') ?>">
                  <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
              </li>
           <?php }
           echo '</ul>';
        }
        wp_reset_postdata();

        $today = date('Ymd');
        $homepageEvent = new WP_Query(array(
          'posts_per_page'  =>  2, 
          'post_type'       =>  'event',
          'meta_key'        =>  'event_date',
          'orderby'         =>  'meta_value_num', //extra,custom data assosiate with the post
          'order'           =>  'ASC',
          'meta_query'      =>  array(
            array(
              'key'   =>  'event_date',
              'compare' =>  '>=',
              'value'   =>  $today,
              'type'    =>  'numeric'
            ),
            array(
                'key'   =>  'related_programs', //array
                'compare'   =>  'LIKE',
                'value'     => '"' . get_the_ID() . '"'
            )
          )
        ));
        if($homepageEvent->have_posts()){
            echo "<hr class='section-break'>";
            echo '<h2 class="headline headline--medium">Up comming ' . get_the_title() . ' Events</h2>';
    
            while($homepageEvent->have_posts()){
              $homepageEvent->the_post() ;
              get_template_part('template-parts/program');
            }
        }
   ?>   
    </div>
<?php } ?>


<?php get_footer(); ?>