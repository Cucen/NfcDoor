<div class="page-header">
  <h1>
    <?php echo kadence_title(); ?>
  </h1>
   <?php global $post; 
  if(is_page()) {$bsub = get_post_meta( $post->ID, '_kad_subtitle', true ); if($bsub != '') echo '<p class="subtitle"> '.__($bsub).' </p>'; }
   else if(is_category()) {  echo '<p class="subtitle">'.__(category_description()).' </p>';}
   	?>
</div>