<?php
/**
 * Template Name: Darlic Tutorial
 */
 ?>
 
 <?php

	$pte = Page_Template_Plugin::get_instance();
	$locale = $pte->get_locale();
	
	include("includes/header.php");
?>
<?php 
function the_slug($echo){
  $slug = basename(get_permalink());
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  if( $echo ) //echo $slug;
  do_action('after_slug', $slug);
  return $slug;
}
?>
<div id="main" class="main">
    <div id="tutorial">
      <h1>Darlic Live Tutorials</h1>
		   <ul class="tutorial-list">
				<?php 
				$args = array(
					'orderby'			=> 'title',
					'order'				=> 'ASC',
					'post_type'			=> 'tutorial',
					'post_status'		=> 'publish',
					'posts_per_page'	=> -1
				);
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {
					
					while ( $the_query->have_posts() ) {
						
						$the_query->the_post();
						//echo '<li><a href="#" class="'.the_slug().'">' . get_the_title().'</a></li>';
						echo '<li><a href="'.get_permalink().'" class="'.the_slug().'">' . get_the_title().'</a></li>';
						//echo get_the_title();
					}
				} else {
					echo "No Tags";
				}
				/* Restore original Post Data */
				wp_reset_postdata();
				?>
			</ul>
		</div>
</div>
<?php 
include("includes/footer.php");
?>
