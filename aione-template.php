<?php
/**
 * Plugin Name:       Aione Page Templates
 * Plugin URI:        https://oxosolutions.com/products/wordpress-plugins/aione-page-templates
 * Description:       Page templates for Aione theme
 * Version:           1.0.0.1
 * Author:            OXO Solutions®
 * Author URI:        https://oxosolutions.com/
 * Text Domain:       aione-page-templates
 * License:           GPL-2.0+
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/oxosolutions/aione-page-templates
 * GitHub Branch: master
 */




// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

require_once( plugin_dir_path( __FILE__ ) . 'class-aione-template.php' );
add_action( 'plugins_loaded', array( 'Page_Template_Plugin', 'get_instance' ) );


/***************************/
add_action('wp_ajax_bit_view', 'bit_view');
add_action('wp_ajax_nopriv_bit_view', 'bit_view');
function bit_view() {
	if ( isset($_REQUEST) ) {
		$post_id = $_REQUEST['postID'];
		$key_values = get_field( "bit_views", $post_id );
		$key_values = $key_values+1;
		$done = update_field("bit_views", $key_values, $post_id);
		if($done){
			echo $key_values;
		}
		
	}
	wp_die();
} 
/***************************/
/***************************/
/*add_action('wp_ajax_bit_like', 'bit_like');
add_action('wp_ajax_nopriv_bit_like', 'bit_like');
function bit_like() {
	if ( isset($_REQUEST) ) {
		$post_id = $_REQUEST['postID'];
		$counter = $_REQUEST['counter'];
		

		$key_values = get_field( "bit_like", $post_id );
		if($counter == 'true'){
			$key_values = $key_values+1;
		} else {
			if($key_values > 0){
				$key_values = $key_values-1;
			}
		}
		
		$done = update_field("bit_like", $key_values, $post_id);
		

		if($done){
			echo $key_values;
		}
		
		
	}
	wp_die();
} */
/***************************/
/***************************/
/*add_action('wp_ajax_bit_dislike', 'bit_dislike');
add_action('wp_ajax_nopriv_bit_dislike', 'bit_dislike');
function bit_dislike() {
	if ( isset($_REQUEST) ) {
		$post_id = $_REQUEST['postID'];
		$counter = $_REQUEST['counter'];

		$key_values = get_field( "bit_dislike", $post_id );

		if($counter == 'true'){
			$key_values = $key_values+1;
		} else {
			if($key_values > 0){
				$key_values = $key_values-1;
			}
		}

		$done = update_field("bit_dislike", $key_values, $post_id);
		if($done){
			echo $key_values;
		}
		
	}
	wp_die();
}*/
 
/***************************/
/***************************/
add_action('wp_ajax_bit_download', 'bit_download');
add_action('wp_ajax_nopriv_bit_download', 'bit_download');
function bit_download(){
	if ( isset($_REQUEST) ){
		$post_id = $_REQUEST['postID'];
		$title = get_the_title($post_id);

		$bit_html = get_field( "bit_html", $post_id );
		$bit_css = get_field( "bit_css", $post_id );
		$bit_js = get_field( "bit_js", $post_id );

		$key_values = get_field( "bit_downloads", $post_id );
		$key_values = $key_values+1;
		$done = update_field("bit_downloads", $key_values, $post_id);

		$content = "";
    	$content .= htmlspecialchars_decode($bit_html);
    	$content .= "<style>".$bit_css."</style>";
    	$content .= "<script>".$bit_js."</script>";

    	$output = array("name"=>$title , "number"=> $key_values, "content" => $content);
    	$final_output =json_encode($output);
    	echo $final_output;


    	wp_die();
	}
}


/***************************/
/***************************/

add_action('wp_ajax_sharebitimage', 'sharebitimage');
add_action('wp_ajax_nopriv_sharebitimage', 'sharebitimage');
function sharebitimage() {
	if (isset($_REQUEST) ) {
		$sid = $_REQUEST['sid'];
		$photo = $_REQUEST['photo'];
		$post_id = $_REQUEST['pageID'];
		$meta_key_viz = "sharebitimage_".$sid;
		$filePath = get_home_path().'/shared_images/'.$sid.'.png';

		$photo = str_replace('data:image/jpeg;base64,', '', $photo);
		$photo = str_replace(' ', '+', $photo);
		$photo = base64_decode($photo); 
		
		file_put_contents($filePath, $photo);

		wp_die();
	}
}

/***************************/
/***************************/
add_action('wp_ajax_screenshot_copy', 'screenshot_copy');
add_action('wp_ajax_nopriv_screenshot_copy', 'screenshot_copy');
function screenshot_copy() {
	if ( isset($_REQUEST) ) {
		$sourceLink = $_REQUEST['sourceLink'];
		$filename = $_REQUEST['filename'];
		
		
		
		$destinationLink = get_home_path()."/bit_screenshot/".$filename.".png";

		$copy = copy( $sourceLink, $destinationLink );
		if( !$copy ) {
		    echo "Doh! failed to copy ...\n";
		}
		else{
		    echo "WOOT! success to copy ...\n";
		}

		/*$content = file_get_contents($sourceLink);
		$fp = fopen($destinationLink, "w");
		//fwrite($fp, $content);
		if (fwrite($fp, $content) === FALSE){
			echo "false";
		} else {
			echo "true";
		}
		fclose($fp);*/
	}
	wp_die();
} 


/***************************/
/***************************/
add_action('wp_ajax_LikeDislike', 'LikeDislike');
add_action('wp_ajax_nopriv_LikeDislike', 'LikeDislike');
function LikeDislike(){
	if (isset($_REQUEST) ) {
		$type=$_REQUEST['type'];
		$post_id=$_REQUEST['postID'];
		$value=$_REQUEST['value'];
		$counter=$_REQUEST['counter'];

		if($counter == "true"){
			$key_values = $value+1;
		} else {
			$key_values = $value-1;
		}
		
		$done = update_field("bit_".$type, $key_values, $post_id);

	    if($done){
			echo $key_values;
		}
		

		wp_die();
	}
}




