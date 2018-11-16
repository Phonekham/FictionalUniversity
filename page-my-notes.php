<?php
if(!is_user_logged_in()){
    wp_redirect(esc_url(site_url('/')));
}

get_header(); ?>
<?php while(have_posts()){   
    the_post();
    ?>
    <?php
     PageBanner(array(
      'title'  =>  'My Notes',
      'subtitle' =>  'tHIS IS SUBTITLE '
    )); ?>
  <div class="container container--narrow page-section">
    <ul class="link-list min-list" id="my-notes">
        <?php
        $userNotes = new WP_Query(array(
            'post_type'     =>  'note' ,
            'posts_per_page'    =>  -1,
            "author"        =>  get_current_user_id()
        ));
        while($userNotes->have_posts()){
            $userNotes->the_post(); ?>
            <li>
                <input class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                <textarea class="note-body-field"><?php echo esc_attr(get_the_content()); ?></textarea>
            </li>
       <?php }
        ?>
    </ul>
  </div>
<?php } ?>
<?php get_footer(); ?>