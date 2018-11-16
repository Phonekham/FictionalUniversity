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
                    <?php 
                    $likeCount = new WP_Query(array(
                        'post_type'     =>  'like',
                        'meta_query'      =>  array(
                            array(
                                'key'       =>  'liked_professor_id',
                            'compare'       =>  '=',
                            'value'         =>  get_the_ID()
                            )
                        )
                    )); 

                    $existsStatus = 'no';
                    $existsQuery = new WP_Query(array(
                        'author'     =>  get_current_user_id(),
                        'post_type'     =>  'like',
                        'meta_query'      =>  array(
                            array(
                                'key'       =>  'liked_professor_id',
                            'compare'       =>  '=',
                            'value'         =>  get_the_ID()
                            )
                        )
                    )); 
                    if ($existsQuery->found_posts) {
                        $existsStatus = 'yes';
                    }
                    ?>
                    <span class="like-box" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existsStatus; ?>">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                    </span>
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