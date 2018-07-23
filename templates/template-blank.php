<?php
/**
 * Template Name: Darlic Blank
 */

	$pte = Page_Template_Plugin::get_instance();
	$locale = $pte->get_locale();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US" class="">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>
	<meta name="viewport" content="width=device-width">
	<style>
	<?php 
		//Custom CSS for each page

		$c_pageID = Aione::c_pageID();
		$pyre_custom_css = get_post_meta( $c_pageID, 'pyre_custom_css', true );
		echo $pyre_custom_css;
	?>
	</style>
</head>
<body >
	<?php
	if(have_posts()): 
	the_post();
	the_content();
	wp_link_pages(); 
	endif;
	wp_reset_query();
	?>
</body>
</html>