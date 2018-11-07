<?php get_header(); ?>
<?php
while(have_posts()){
    the_post() ?>
  <?php PageBanner(); ?>
    <div class="container container--narrow page-section">

        <h2><?php the_title(); ?></h2>
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                <?php the_post_thumbnail('professorPortrait'); ?>
                </div>
                <div class="two-third">
                <?php the_content(); ?>
                </div>
            </div>
        </div> 
        <?php
          $relatedProgram = get_field('related_programs');
          if($relatedProgram){
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>Subject(s) Taught</h2>";
            echo "<ul class='link-list min-list'>";
           foreach($relatedProgram as $program){ ?>
               <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program); ?></a></li>
            <?php  } 
            echo "</ul>";
          }
         ?>      
    </div>
<?php } ?>


<?php get_footer(); ?>