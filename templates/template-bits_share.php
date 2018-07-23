<?php
/**
 * Template Name: Darlic Bits
 */
 
 ?>
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<?php
/*add_action('wp_head', 'bitshare_ajaxurl');
function bitshare_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}
add_action('wp_ajax_sharebitimage', 'sharebitimage');
add_action('wp_ajax_nopriv_sharebitimage', 'sharebitimage');
function sharebitimage() {
	if (isset($_REQUEST) ) {
		$sid = $_REQUEST['sid'];
		$photo = $_REQUEST['photo'];
		$post_id = $_REQUEST['pageID'];
		$meta_key_viz = "sharebitimage_".$sid;

		$photo = str_replace('data:image/jpeg;base64,', '', $photo);
		$photo = str_replace(' ', '+', $photo);
		$photo = base64_decode($photo); 
		
		$filePath = get_home_path().'/shared_images/'.$sid.'.png';
		file_put_contents($filePath, $photo);
		wp_die();
	}
}*/
?>
 <?php
 
	$pte = Page_Template_Plugin::get_instance();
	$locale = $pte->get_locale();
	
	include("includes/header.php");
	
	global $switched;
	switch_to_blog(3);
	
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; 
	
	$args = array(
		'post_type'		=> 'post',
		'post_status'   => 'publish',
		'posts_per_page'=> 20,
		'paged'			=> $paged,

		
	);

// The Query
$query = new WP_Query( $args );
		
	// The Query
	$the_query = new WP_Query( $args );
	
	$bit_args = array(
		'orderby'           => 'name', 
		'order'             => 'ASC',
		'hide_empty'        => false, 
		'exclude'           => array(), 
		'exclude_tree'      => array(), 
		'include'           => array(),
		'number'            => '', 
		'fields'            => 'all', 
		'slug'              => '',
		'parent'            => '',
		'hierarchical'      => true, 
		'child_of'          => 0,
		'childless'         => false,
		'get'               => '', 
		'name__like'        => '',
		'description__like' => '',
		'pad_counts'        => false, 
		'offset'            => '', 
		'search'            => '', 
		'cache_domain'      => 'core',
		'type'      		=> 'post',
		'show_count'        => 1,
		'taxonomy'          => 'bit_category',
		
	); 
	
	//$bit_categories = get_terms( 'bit_category', $bit_args);
	
	
	//echo "<pre>";
	//print_r($bit_categories);
	//echo "</pre>";
	
	
	
	
	$published_posts = $the_query->found_posts; ?>
	
<!------------------ MAIN STARTS ------------------>
<div id="main" class="main">
	<div class="bits-filter">
		<h1> Bit Categories</h1>
		<div class="filter-container">
		<?php echo $bit_categories = wp_list_categories ( $bit_args ); ?>
			<!--<ul>
			<?php //foreach($bit_categories as $bit_category){ ?>
				<li id="<?php //echo $bit_category->slug;?>" class="filter-selection"><a href=""><?php //echo $bit_category->name."(".$bit_category->count.")"; ?></a></li>
			<?php //} ?>
			</ul>-->
		</div>
	</div>
	<div class="" id="websites">
		<div class="user-sites-header">
			<div class="user-site-item float-left"><h1 class="user-site-title">All BITS ( <?php echo $published_posts ?> )</h1></div>
			<div class="aione-clearfix"></div>
		</div>
		<div class="bits-container">
<?php 
$output = '';
		// The Loop
		if ( $the_query->have_posts() ) {
			$output .= '<ul class="user-sites">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;
				$post_id = $post->ID;
				$post_name = $post->post_name;
				
				$image_field = get_field('thumbnail', $post_id);
				
				$user_id = $post->post_author;
				$user_info = get_userdata($user_id);
				$user_name = $user_info->user_login ;
				$first_name = $user_info->first_name;
				$last_name = $user_info->last_name;
				$url =  esc_url( get_permalink($post_id) );
				
				$bit_enabled = get_field( 'bit_enabled',$post_id);
				
				//echo "=".$bit_enabled;
				/*
				if(!$bit_enabled){
					continue;;
				}
				*/
				
				$bit_views = get_field( 'bit_views',$post_id);
				$bit_downloads = get_field( 'bit_downloads',$post_id);
				$bit_like = get_field( 'bit_like',$post_id);
				$bit_dislike = get_field( 'bit_dislike',$post_id);
				$thumbnail = get_field('bit_thumbnail');
				
				//print_r($user_info);
				$bit_slug = str_replace( 'bit/', 'play/#', get_permalink() );
				$bit_slug = $post->post_name;
				$bit_slug = "http://darlic.com/play/?id=".$bit_slug;
				$output .= '<li class="user-site">';
				$output .= '<div class="thumb-nail">';
				$output .= '<div class="thumb-nail-img">';
				if(!empty($thumbnail)){
					$output .= '<img src="'.$thumbnail['url'].'" alt="'.$thumbnail['alt'].'" width="200px" height="140px" />';
				}
				$output .= '</div>'; 
				$output .= '</div>';
				$output .= '<div class="bit-content">';
				$output .= '<div class="user-site-item">
							<h1 class="user-site-title">'.get_the_title().'</h1>
							<h3 class="">By <span><a href="">'.$user_name.' </a></span></h3>';
				$output .= '<div class="bottom-links">';
				$output .= '<a href="'.$url.'" title="Run" target="_blank" id="'.$post_id.'_view" class="bottom-link view-demo"><span class="user-site-desc">
				<i class="fa fa-eye"></i> View Demo</span></a>';
				/*
				$output .= '<a href="#" title="Download" target="_blank" class="bottom-link download">
				<span class="user-site-desc"><i class="fa fa-download"></i> Download</span></a>';
				*/
				$output .= '<a href="'.$bit_slug.'" title="Edit" target="_blank" class="bottom-link edit">
				<span class="user-site-desc"><i class="fa fa-pencil"></i> Edit In Darlic Play</span></a>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '<div class="aione-clearfix"></div>';
				$output .= '<div class="comment-section">';
				$output .= '<div class="bit-stat">';
				$output .= '<a id = "view_demo_'.$post_id.'" class="bit-stat-view"><span class="view-icon"><i class="fa fa-eye"></i></span> <span>'.$bit_views.'</span></a>';
				$output .= '<a href="#" id="'.$post_id.'_like" class="bit-stat-like"><span class=""><i class="fa fa-thumbs-up"></i></span> <span>'.$bit_like.'</span></a> ';
				$output .= '<a href="#" id="'.$post_id.'_dislike" class="bit-stat-dislike"><span class=""><i class="fa fa-thumbs-down"></i></span> <span>'.$bit_dislike.'</span></a> ';
				$output .= '<a class="bit-stat-download"><span class="download-icon"><i class="fa fa-download"></i></span> <span>'.$bit_downloads.'</span></a>';
				$output .= '</div>';
				$output .= '<div class="bit-stat-share" >';
				$output .= '<p>Share<span><i class="fa fa-angle-double-right"></i></span></p>';
				$output .= '<a href="#" id="fbshare_button" bit-id="'.$post_id.'_fb" title="Facebook" target="_blank"><i class="fa fa-facebook-official"></i></a>';
				$output .= '<a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>';
				$output .= '</div>';
				$output .= '<div class="aione-clearfix"></div>';
				$output .= '</div>';
				$output .= '</li>';
			}
			$output .= '</ul>';
			restore_current_blog();
			
			
			$big = 999999999; // need an unlikely integer
			$output .= '<div class="pagenav">';
			$output .= paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '/?paged=%#%',
				'current' => max( 1, get_query_var('page') ),
				'total' => $the_query->max_num_pages
			) );
			$output .= '</div>';
		} 
		/* Restore original Post Data */
		wp_reset_postdata();
		$output .= '<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>';
		/*$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/base64.js',__FILE__ ).'"></script>';
	
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/html2canvas(0.5.0-alpha1).js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/html2canvas.svg(0.5.0-alpha1).js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/rgbcolor.js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/StackBlur.js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/canvg.js',__FILE__ ).'"></script>';*/
		$output .= '<script>
			jQuery( document ).ready(function(){
				jQuery( ".filter-selection" ).change(function() {
						filterCall();
					});
				function filterCall() {
					
					
				}
				jQuery(".view-demo").click(function(){
					var postID = jQuery(this).attr( "id" );
					postID = postID.replace("_view", "");
					jQuery.ajax({
						type: "POST",
						url: "/wp-admin/admin-ajax.php",
						data: {
							"action":"bit_view",
							"postID":postID
						},
						success:function(data) {
							jQuery( "#view_demo_"+postID+" span:first-child" ).addClass( "view-icon" );
							jQuery( "#view_demo_"+postID+" span:nth-child(2)" ).html(data);
						},
						error: function(errorThrown){
							alert("Something is wrong. Please try again.");
						}
					});
				});
				
				
				jQuery(".bit-stat-like").click(function(){
					event.preventDefault();
					var postID = jQuery(this).attr( "id" );
					postID = postID.replace("_like", "");
					jQuery.ajax({
						type: "POST",
						url: "/wp-admin/admin-ajax.php",
						data: {
							"action":"bit_like",
							"postID":postID
						},
						success:function(data) {
							jQuery( "#"+postID+"_like span:first-child" ).addClass( "like-icon" );
							jQuery( "#"+postID+"_like span:nth-child(2)" ).html(data);
						},
						error: function(errorThrown){
							alert("Something is wrong. Please try again.");
						}
					});
				});
				
				jQuery(".bit-stat-dislike").click(function(){
					event.preventDefault();
					var postID = jQuery(this).attr( "id" );
					postID = postID.replace("_dislike", "");
					jQuery.ajax({
						type: "POST",
						url: "/wp-admin/admin-ajax.php",
						data: {
							"action":"bit_dislike",
							"postID":postID
						},
						success:function(data) {
							jQuery( "#"+postID+"_dislike span:first-child" ).addClass( "dislike-icon" );
							jQuery( "#"+postID+"_dislike span:nth-child(2)" ).html(data);
						},
						error: function(errorThrown){
							alert("Something is wrong. Please try again.");
						}
					});
				});

				/************ Share Bit on Social Media**************/

				/*jQuery( "#fbshare_button" ).click(function(e) {
					e.preventDefault();
					var d = new Date();
					d = Number(d);
					var pageID = jQuery(this).attr("bit-id");
					pageID = pageID.replace("_fb", "");
					var svgElements = jQuery(this).siblings(".bit-content");
					var canvas, xml;
					svgElements.each(function () {

					    canvas = document.createElement("canvas");
					    canvas.className = "screenShotTempCanvas";

					    //convert SVG into a XML string
					    xml = (new XMLSerializer()).serializeToString(this);

					    // Removing the name space as IE throws an error
					    xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, '');

					    //draw the SVG onto a canvas
					    canvg(canvas, xml); 
					    jQuery(canvas).insertAfter(this);
					    //hide the SVG element
					    this.className = "tempHide";
					    jQuery(this).hide();
					});
					html2canvas(jQuery(this).siblings(".bit-content"), {
						onrendered: function(canvas) {
							  var photo = canvas.toDataURL("image/jpeg"); 
							  jQuery.ajax({
									type: "POST",
									url: ajaxurl,
									data: {
										"action":"sharebitimage",
										"sid":d,
										"pageID":pageID,
										"photo": photo
									},
									success:function(data) {
										//console.log(data);
										
										var link = location.protocol + "//" + location.host + location.pathname+"?sid="+d;
									
										FB.ui({ 
											method: "share_open_graph", 
											action_type: "og.shares", 
											action_properties: 
													JSON.stringify({ 
														object : { 
															"og:url": link, 
															"og:title": "Darlic Bits", 
															"og:description": "Darlic Bits", 
															"og:image": "http://darlic.com/shared_images/"+d+".png", 
															"og:image:width": "579", 
															"og:image:height": "940" 
														} 
													}) 
												}, function(response){ 
													console.log(response); 
											});

									}
								});

			            
						},
					});*/
				/************ END Share Bit on Social Media**************/
			});
		</script>';
		
		
	echo $output;

/***************************************/	
	
?>
	</div>
	</div> 
	<div style="clear:both"></div>

<?php  
include("includes/footer.php");
?>

<style>
.bits-filter {
	width: 20%;
	background-color: #fff;
	border: 1px solid #f2f2f2;
	float: left;
}
.bits-filter ul {
	border: 1px solid rgb(242, 242, 242);
}
.filter-container {
	padding: 15px;
}
#header .themeform input[type="text"] {
	background: rgba(255, 255, 255, 0.2);
	border: 1px solid #ddd;
	color: #666;
	line-height: 34px;
	font-size: 16px;
	width: 85%;
	display: inline;
	float: left;
}
#header .themeform input[type="submit"] {
	padding-left: 14px;
	line-height: 26px;
	margin-right: 15px;
	position: relative;
	display: inline;
	font-size: 16px;
	background-color: #82b965;
	color: #fff;
	padding: 5px 9px;
	font-weight: 600;
	display: inline-block;
	border: none;
	cursor: pointer;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}
.bits-filter ul li {
	list-style: outside none none;
	line-height: 40px;
	font-size: 20px;
	font-weight: 400;
	padding-left: 15px;
	border-bottom: 1px dotted rgb(191, 188, 188);
}
.bits-filter ul li:hover {
	border-left: 3px solid blue;
	background: #f5f5f5;
}
#websites {
	/* display: block; */
	/* margin-left: 270px; */
	width: 79%;
	float: right;
}
.bits-filter h1 {
	font-size: 30px;
	line-height: 40px;
	color: rgb(18, 113, 158);
	font-weight: 400;
	letter-spacing: -0.2px;
	padding: 0px 0px 0px 15px;
	margin: 0px;
	font-family: "Open Sans","HelveticaNeue","Helvetica Neue",Helvetica,Arial,sans-serif;
	border-bottom: 1px dotted rgb(215, 213, 213);
	display: block;
}
.pagenav {
	float: right;
	font-size: 16px;
	margin: 10px;
	line-height: 25px;
	word-spacing: 8px;
	font-family: "Open Sans", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
	display: block;
	width: 100%;
	text-align: center;
}
.pagenav span {
    margin: 0 6px;
    font-weight: bold;
    color: #168DC5;
}
.user-sites {
	list-style: none;
	padding: 0;
	margin: 0;
	font-family: "Open Sans", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
}
.user-sites li {
	list-style: none;
	padding: 15px;
	background-color: #FFFFFF;
	margin: 0px 0px 15px 0px;
	-webkit-transition: all 200ms ease-in-out;
	-moz-transition: all 200ms ease-in-out;
	-ms-transition: all 200ms ease-in-out;
	-o-transition: all 200ms ease-in-out;
	transition: all 200ms ease-in-out;
	display: block;
}
.user-sites .user-site .user-site-title, #main h1.user-site-title {
	font-size: 30px;
	line-height: 40px;
	color: RGBA(218, 8, 8, 0.89);
	font-weight: 400;
	letter-spacing: -0.2px;
	padding: 0px;
	margin: 0px 0;
	font-family: "Open Sans", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
	border-bottom: 1px dotted rgb(215, 213, 213);
	display: block;
	padding-left: 15px;
}
.user-sites .user-site .user-site-item a {
	line-height: 34px;
	color: #454545;
	width: 48px;
	height: 34px;
	padding: 0 10px;
	overflow: hidden;
	-webkit-transition: all 200ms ease-in-out;
	-moz-transition: all 200ms ease-in-out;
	-ms-transition: all 200ms ease-in-out;
	-o-transition: all 200ms ease-in-out;
	transition: all 200ms ease-in-out;
}
.user-sites .user-site .user-site-item a:hover {
	color: #168dc5;
	width: 155px;
}
.aione-clearfix {
	clear: both;
}
.user-sites .user-site a span.user-site-desc {
	font-size: 16px;
	line-height: 34px;
	height: 34px;
	color: #fff;
	position: relative;
}
.thumb-nail{
	width: 200px;
	float: left;
}
.thumb-nail-img {
	border: 1px solid rgb(215, 213, 213);
	min-height: 140px;
	width: 100%;
	background: url(http://bits.darlic.com/wp-content/uploads/sites/3/2016/04/img_not_available.jpg);
	background-size: 185px 145px;
}
.bit-content {
	border: 1px solid #e8e8e8;
	margin-left: 215px;
	padding-bottom: 10px;
}
.bottom-links {
	margin-top: 20px;
	padding-left: 15px;
}
#websites .bottom-links a.bottom-link {
	padding: 3px 13px;
	border-radius: 20px;
	margin-right: 15px;
}
#websites .bottom-links a.view-demo {
	background-color: rgb(160, 206, 78);
}
#websites .bottom-links a.download{
	background-color: #4c9ed9;
}
#websites .bottom-links a.edit {
	background-color: #ED6F1D;
}
.user-site-item h3 {
	margin: 0px;
	font-size: 16px;
	padding-left: 15px;
}
.user-site-item h3 span a{
	padding: 0px !important;
	color: #178dc5 !important;
}
.comment-section{
	border: 1px solid #e8e8e8;
	margin-top: 15px;
	padding-left: 15px;
}
.comment-section a {
	color: #666;
	margin-right: 15px;
	line-height: 35px;
	font-size: 20px;
}
.comment-section p {
	margin: 0px;
	line-height: 30px;
	display: inline;
	margin-right: 15px;
}
.user-sites-header {
	border: 1px solid rgb(215, 213, 213);
	background: rgb(255, 255, 255) none repeat scroll 0% 0%;
	margin-bottom: 5px;
	padding-left: 10px;
}
.bit-stat {
	width: 50%;
	float: left;
}
.like-icon {
	color: rgb(160, 206, 78);
}
.dislike-icon {
	color: rgb(234, 67, 53);
}
.download-icon {
	color: rgb(22, 141, 197);
}
.bit-stat-share {
	width: 50%;
	float: left;
	text-align:right;
}
.bit-stat-share span {
	font-size: 20px;
	margin-left: 7px;
}
</style>