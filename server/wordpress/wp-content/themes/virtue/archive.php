  <div id="pageheader" class="titleclass">
    <div class="container">
      <?php get_template_part('templates/page', 'header'); ?>
    </div><!--container-->
  </div><!--titleclass-->
  
    <div id="content" class="container">
      <div class="row">
        <?php global $virtue; if(isset($virtue['blog_archive_full']) && $virtue['blog_archive_full'] == 'full')
        {$summery = 'full'; $postclass = "single-article fullpost";} else {$summery = 'normal'; $postclass = 'postlist';} ?>
      <div class="main <?php echo kadence_main_class(); ?>  <?php echo $postclass;?>" role="main">

<?php if (!have_posts()) : ?>
  <div class="alert">
    <?php _e('Sorry, no results were found.', 'virtue'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>
<?php 
      if($summery == 'full') {
               while (have_posts()) : the_post();
                get_template_part('templates/content', 'fullpost');
               endwhile;
             } else {
                while (have_posts()) : the_post(); 
                 get_template_part('templates/content', get_post_format());
                endwhile;
             }

    if ($wp_query->max_num_pages > 1) : ?>
        <?php $bignumber = 999999999;
        $pagargs = array(
          'base' => str_replace( $bignumber, '%#%', esc_url( get_pagenum_link( $bignumber ) ) ),
          'format'       => '?page=%#%',
          'total' => $wp_query->max_num_pages,
          'current' => max( 1, get_query_var('paged') ),
          'prev_next'    => True,
          'prev_text'    => '«',
          'next_text'    => '»',
          'type'         => 'plain',
        ); ?>
        <div class="wp-pagenavi">
        <?php echo paginate_links( $pagargs ); ?>
        </div>
        
        <?php endif; ?>

</div><!-- /.main -->