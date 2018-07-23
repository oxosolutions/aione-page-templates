<?php
/**
 * Template Name: Darlic Bits
 */
 
 ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

 <?php
 
	$pte = Page_Template_Plugin::get_instance();
	$locale = $pte->get_locale();
	
	include("includes/header.php");
	
	global $switched;
	switch_to_blog(3);
	
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; 

	if( isset( $_POST["bitsearchsubmit"]) && isset($_POST["search"]) && $_POST["search"] == "bitsearch"){
		$search_keyword = $_POST["bit_s"];
		$search_category = $_POST["bit_cat"];
	} else {
		$search_keyword = "";
		$search_category = "-1";
	} 
	
	$args = array(
		'wpse_search_or_tax_query' => true,    // <-- New parameter for search. Class Initiate in class-aione-template.php
		'post_type'		=> 'post',
		'post_status'   => 'publish',
		'posts_per_page'=> 20,
		'paged'			=> $paged,
		'meta_key' => 'bit_like',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
	);
	if($search_keyword !== ""){
		$args['s'] = $search_keyword;
	}
	if($search_category !== "-1"){
		$args['tax_query']  = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => array( $search_category ),
            'operator' => 'IN',
        ),
    );
	}
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
	
	$published_posts = $the_query->found_posts; ?>

	
<!------------------ MAIN STARTS ------------------>
<div id="main" class="main">
	<div class="bits-filter">
		<form method="post" id="advanced-searchform" role="search" action="<?php echo  home_url( '/home' );?>">
			<input type="hidden" name="search" value="bitsearch">
			<div class="one_third left">
			<label for="name" class=""><?php _e( 'Keyword: ', 'textdomain' ); ?></label>
			<input type="text" value="<?php echo $search_keyword;?>" placeholder="<?php _e( 'Search...', 'textdomain' ); ?>" name="bit_s" id="name" />
			</div>
			<div class="one_third left">
			<label for="bit_cat" class=""><?php _e( 'Category: ', 'textdomain' ); ?></label>
			<?php 
		    $args = array(
				'show_option_all'    => '',
				'show_option_none'   => __( 'Select category', 'textdomain' ),
				'option_none_value'  => '-1',
				'orderby'            => 'name',
				'order'              => 'ASC',
				'show_count'         => 1,
				'hide_empty'         => 1,
				'child_of'           => 0,
				'exclude'            => '',
				'include'            => '',
				'echo'               => 1,
				'selected'           => $search_category,
				'hierarchical'       => 1,
				'name'               => 'bit_cat',
				'id'                 => '',
				'class'              => '',
				'depth'              => 0,
				'tab_index'          => 0,
				'taxonomy'           => 'category',
				'hide_if_empty'      => false,
				'value_field'	     => 'term_id',
			);
		    wp_dropdown_categories( $args ); ?>
		    </div>
		    <div class="one_third right">
    		<input type="submit" name = "bitsearchsubmit" id="searchsubmit" value="Search" />
    		</div>
		</form>
	</div>
	<div class="" id="websites">
		<div class="user-sites-header">
			<div class="user-site-item float-left"><h1 class="user-site-title">All BITS ( <?php echo $published_posts ?> )</h1></div>
			<div class="aione-clearfix"></div>
		</div>
		<div class="bits-container">
<?php 
$output = '';
$output .= '<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>';
$output .= '<script type="text/javascript">
	function changeLikeDislike(type,id,value){
		event.preventDefault();
      	var type =  type;
      	var postID =  id;
      	var value = value;
      	var pushValue = id+"_"+type;
      	var obj = [];
      	var bitsStorageJson = JSON.parse(localStorage.getItem("bitsStorage") || "[]");
		 
      	var already = jQuery( "#"+postID+"_"+type+" span:first-child" ).hasClass( "icon-color" );
      	if(!already){
      		var incement = (parseInt(value) + parseInt(1));
      		jQuery( "#"+postID+"_"+type+" span:nth-child(2)" ).html( incement );
      		jQuery( "#"+postID+"_"+type+" span:first-child" ).addClass( "icon-color" );
	    	Array.prototype.containsSubString = function( text ){
		        for ( var i in this )
		        {
		            if ( this[i].toString().indexOf( text ) != -1 )
		                return i;
		        }
	        	return -1;
	    	}
	    	var foundID = function( postID, bitsStorageJson ){
	        if ( bitsStorageJson.containsSubString( postID ) !== -1 ){
	        	return true;
	        } else {
	        	return false;
	        }
	            
	    };
	    var found = foundID( postID, bitsStorageJson );
	    if(found == true){
	    	if(type=="like"){
	    		jQuery( "#"+postID+"_dislike span:first-child" ).removeClass( "icon-color" );
	    		var oppVal = jQuery( "#"+postID+"_dislike span:nth-child(2)" ).text();
	    		var decrement =  (parseInt(oppVal) - parseInt(1));
      			jQuery( "#"+postID+"_dislike span:nth-child(2)" ).html( decrement );
	    		bitsStorageJson = bitsStorageJson.filter(function(elem){
				   return elem != postID+"_dislike"; 
				});
	    		ajaxCall("dislike",postID,oppVal,false);
	    	}
	    	else{
	    		jQuery( "#"+postID+"_like span:first-child" ).removeClass( "icon-color" );
	    		var oppVal = jQuery( "#"+postID+"_like span:nth-child(2)" ).text();
	    		var decrement = (parseInt(oppVal) - parseInt(1));
      			jQuery( "#"+postID+"_like span:nth-child(2)" ).html( decrement );
	    		bitsStorageJson = bitsStorageJson.filter(function(elem){
				   return elem != postID+"_like"; 
				});
	    		ajaxCall("like",postID,oppVal,false);
	    	}
	    }
      	bitsStorageJson.push(pushValue);
			localStorage.setItem("bitsStorage",JSON.stringify(bitsStorageJson));
      	ajaxCall(type,postID,value,true);
      }
     
	}
	function ajaxCall(type,postID,value,counter){
		jQuery.ajax({
		    type: "POST",
		    url: "/wp-admin/admin-ajax.php",
		    data: {
						"action":"LikeDislike",
						"type":type,
						"postID":postID,
						"value":value,
						"counter":counter,
					},
		    cache: false,
		    success: function(result){
		              // console.log(result);
		    }
	    });
	}
	jQuery( document ).ready(function(){
		var bitsStorage = localStorage.getItem("bitsStorage");
		if(bitsStorage){
			var bitsStorageJson = JSON.parse(bitsStorage);
			jQuery.each(bitsStorageJson, function( index, value ) {
			  jQuery( "#"+value+" span:first-child" ).addClass( "icon-color" );
			});
		}
 	});	 
	</script>';
		// The Loop
		if ( $the_query->have_posts() ) {
			$pending = array();
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
				
				$bit_views = get_field( 'bit_views',$post_id);
				$bit_downloads = get_field( 'bit_downloads',$post_id);
				$bit_like = get_field( 'bit_like',$post_id);
				$bit_dislike = get_field( 'bit_dislike',$post_id);
				
				$bit_slug = str_replace( 'bit/', 'play/#', get_permalink() );
				$bit_slug = $post->post_name;
				$bit_slug = "http://darlic.com/play/?id=".$bit_slug;

			
				//$screenshot_link = 'http://adminpie.com/api/screenshots/'.$post_name.'.png';
				$screenshot_link = get_home_url() .'/bit_screenshot/'.$post_name.'.png';

				
				if (getimagesize($screenshot_link) !== false) {
					$has_screenshot = true;
 				} else {
 					$has_screenshot = false;
 					array_push($pending,$post_id);
 				}
 				

				$output .= '<li class="user-site">';
				$output .= '<div class="thumb-nail">';
				$output .= '<div id="'.$post_id.'_img" class="thumb-nail-img';
				if($has_screenshot == false){
					$output .= " load-img ";
				}
				$output .= '">';
				
				if($has_screenshot == true){
					$output .= '<img src="'.$screenshot_link.'"  data-src = "'.$screenshot_link.'" width="200px" height="140px" />';
				} else {
					$output .= '<img src="http://bits.darlic.com/wp-content/uploads/sites/3/2016/04/img_not_available.jpg"  data-src = "'.$screenshot_link.'" width="200px" height="140px" />';
				}

				$output .= '</div>'; 
				$output .= '</div>';
				$output .= '<div class="bit-content" id="'.$post_id.'">';
				$output .= '<div class="user-site-item">
							<h1 class="user-site-title">'.get_the_title().'</h1>
							<h3 class="">By <span><a href="">'.$user_name.' </a></span></h3>';
				$output .= '<div class="bottom-links">';
				$output .= '<a href="'.$url.'" title="Run" target="_blank" id="'.$post_id.'_view" class="bottom-link view-demo"><span class="user-site-desc">
				<i class="fa fa-eye"></i> View Demo</span></a>';
				
				$output .= '<a href="'.$bit_slug.'" title="Edit" target="_blank" class="bottom-link edit">
				<span class="user-site-desc"><i class="fa fa-pencil"></i> Edit In Darlic Play</span></a>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '<div class="aione-clearfix"></div>';
				$output .= '<div class="comment-section">';
				$output .= '<div class="bit-stat">';
				$output .= '<a id = "view_demo_'.$post_id.'" class="bit-stat-view"><span class="view-icon"><i class="fa fa-eye"></i></span> <span>'.$bit_views.'</span></a>';
				
				$output .= '<a href="#" id="'.$post_id.'_like" data-tooltip="Like this Bit" class="bit-stat-like tooltip-bottom" onclick=changeLikeDislike("like","'.$post_id.'","'.$bit_like.'")><span class=""><i class="fa fa-thumbs-up"></i></span> <span class="like">'.$bit_like.'</span></a> ';
				$output .= '<a href="#" id="'.$post_id.'_dislike" data-tooltip="Dislike this Bit" class="bit-stat-dislike tooltip-bottom" onclick=changeLikeDislike("dislike","'.$post_id.'","'.$bit_dislike.'")><span class=""><i class="fa fa-thumbs-down"></i></span> <span class="dislike">'.$bit_dislike.'</span></a>';


				$output .= '<a href="#" id="'.$post_id.'_download" data-tooltip="Download this Bit" class="bit-stat-download tooltip-bottom"><span class=""><i class="fa fa-download"></i></span> <span>'.$bit_downloads.'</span></a>';
				$output .= '</div>';
				$output .= '<div class="bit-stat-share" >';
				$output .= '<p>Share<span><i class="fa fa-angle-double-right"></i></span></p>';
				$output .= '<a href="#" title="Facebook" class="fbshare_button" bit-url="'.$bit_slug.'" bit-id="'.$post_id.'_fb" target="_blank"><i class="fa fa-facebook-official"></i></a>';
				$output .= '<a href="#" title="Twitter" class="twshare_button" bit-url="'.$bit_slug.'" bit-id="'.$post_id.'_tw" target="_blank"><i class="fa fa-twitter"></i></a>';
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
			$output .= '<div id="pending" style="display:none;">'.json_encode($pending).'</div>';
		} else {
			$output .= '<div class="user-site-header"><h1 class="user-site-title">No bit found.</h1></div>';
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/base64.js',__FILE__ ).'"></script>';
	
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/html2canvas(0.5.0-alpha1).js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/html2canvas.svg(0.5.0-alpha1).js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/rgbcolor.js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/StackBlur.js',__FILE__ ).'"></script>';
		$output .= '<script type="text/javascript" src="'.plugins_url('js-bitshare/canvg.js',__FILE__ ).'"></script>';
		$output .= '<script>
			jQuery( document ).ready(function(){
				jQuery.ajaxSetup({ cache: false });
				jQuery.getScript("//connect.facebook.net/en_US/sdk.js", function(){
					FB.init({
						appId: "1844385042467656",
						version: "v2.10" // or v2.1, v2.2, v2.3, ...
					});     
				});	
				
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
				
				jQuery(".bit-stat-download").click(function(){
					event.preventDefault();
					var postIDdownload = jQuery(this).attr( "id" );
					postID = postIDdownload.replace("_download", "");

					jQuery.ajax({
						type: "POST",
						url: "/wp-admin/admin-ajax.php",
						data: {
							"action":"bit_download",
							"postID":postID
						},
						success:function(data) {
							var jsonData = JSON.parse(data);
							var element = document.createElement("a");
						    element.setAttribute("href", "data:text/plain;charset=utf-8," + encodeURIComponent(jsonData.content));
						    element.setAttribute("download", jsonData.name+".html");

						    element.style.display = "none";
						    document.body.appendChild(element);

						    element.click();

						    document.body.removeChild(element);
							
					        jQuery( "#"+postID+"_download span:first-child" ).addClass( "download-icon" );
					        jQuery( "#"+postID+"_download span:nth-child(2)" ).html(jsonData.number);
						},
						error: function(errorThrown){
							alert("Something is wrong. Please try again.");
						}
					});
				});
				

				/************ Share Bit on Social Media Facebook **************/

				jQuery( ".fbshare_button" ).click(function(e) {
					e.preventDefault();
					var d = new Date();
					d = Number(d);
					var pageURL = jQuery(this).attr("bit-url");
					var pageID = jQuery(this).attr("bit-id");
					pageID = pageID.replace("_fb", "");

					
					var $container = jQuery("#"+pageID+"_img");
					//var $container = jQuery("#"+pageID+ " .user-site-item");
					
					html2canvas($container, {
						onrendered: function(canvas) {
							var photo = canvas.toDataURL("image/jpeg"); 
						    jQuery.ajax({
								type: "POST",
								url: "/wp-admin/admin-ajax.php",
								data: {
									"action":"sharebitimage",
									"sid":d,
									"pageID":pageID,
									"photo": photo
								},
								success:function(data) {
									FB.ui({ 
										method: "share_open_graph", 
										action_type: "og.shares", 
										action_properties: 
											JSON.stringify({ 
												object : { 
													"og:url": pageURL, 
													"og:title": "Darlic Bits", 
													"og:description": "Darlic Bits", 
													//"og:image": "http://darlic.com/wp-content/uploads/2014/04/logo.png",
													"og:image": "http://darlic.com/shared_images/"+d+".png", 
													"og:image:width": "1200", 
													"og:image:height": "650" 
												} 
											}) 
									}, function(response){ 
										console.log(response); 
									});
								}
							});
						},
					});	
				});
				/************ END Share Bit on Social Media Facebook **************/	
				/************  Share Bit on Social Media Twitter **************/	
				jQuery( ".twshare_button" ).click(function(e) {
					e.preventDefault()
					var d = new Date();
					d = Number(d);
					var pageURL = jQuery(this).attr("bit-url");
					window.open("http://twitter.com/intent/tweet?url=" + encodeURI(pageURL) + "&text=Darlic Bits&", "twitterwindow", "height=450, width=550, toolbar=0, location=0, menubar=0, directories=0, scrollbars=0");
					
				});
				/************ END Share Bit on Social Media Twitter **************/	

				var pending = jQuery( "#pending").text();
				if(pending.length > 0) { 
					var pending = JSON.parse(pending);
					jQuery.each(pending, function(key, value) {
						var bitLink = jQuery("#"+value+"_view").attr("href");
						var slug = bitLink.split("/");
						slug = slug[slug.length - 2];
						jQuery.ajax({
							type: "POST",
							dataType: "json",
							url: "http://adminpie.com/api/index.php",
							data: {
								"action":"gulp",
								"source": bitLink,
								"filename":slug,
								"directory":"/home/oxo/public_html/aioneframework/aioneframework",
								"return":"api",
								"command":"capture",
							},
							success:function(createddata) { console.log(createddata);
								if(createddata.status == "success"){
									jQuery.ajax({
										type: "POST",
										url: "/wp-admin/admin-ajax.php",
										data: {
											"action":"screenshot_copy",
											"filename":slug,
											"sourceLink":createddata.url,
											//"sourceLink":"http://darlic.oxosolutions.com/api/screenshots/"+slug+".png",
										},
										success:function(copydata) { console.log(copydata);
											//if(copydata.status == "success"){
												var Image = jQuery("#"+value+"_img").children("img").attr("data-src");
												jQuery("#"+value+"_img").children("img").attr("src",Image);
												jQuery("#"+value+"_img").removeClass("load-img");
												jQuery("#"+value+"_img").css("background", "none");
											//} 
										},
										error: function(errorThrown){
											console.log("Something is wrong. Please try again.");
										}
									});
								}
							},
							error: function(errorThrown){
								console.log("Something is wrong. Please try again.");
							}
						}); // Ajax
					}); // Each loop
				}

			}); // jquery ready function 
		</script>';
	echo $output;
?>
	</div>
	</div> 
	<div style="clear:both"></div>

<?php  
include("includes/footer.php");
?>

<style>
.bits-filter {
	width: 100%;
	background-color: #fff;
	border: 1px solid #f2f2f2;
	float: left;
	margin: 2px 0;
}
.bits-filter ul {
	border: 1px solid rgb(242, 242, 242);
}
.one_third{
	width: 31%;
	text-align: center;
	padding: 1%;
}
.left{
	float: left;
}
.right{
	float: right;
}
#advanced-searchform input[type="text"],#advanced-searchform select{
	width:80%;
	margin-left: 10px;
	font-size: 18px;
    line-height: 28px;
    font-weight: 400;
    min-height: 40px;
    padding: 0;
    margin: 0;
    text-indent: 15px;
    color: #747474;
    background-color: #faf8f7;
    border: 1px solid #e8e8e8;
    outline: 0;
    text-shadow: none;
    box-shadow: none;
    font-family: "Open Sans",Arial,Helvetica,sans-serif;
    -moz-border-radius: 0;
    -webkit-border-radius: 0;
    border-radius: 0;
    -moz-transition: all .2s ease-in-out;
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}
input[type=submit] {
    font-size: 18px;
    line-height: 24px;
    font-weight: 400;
    margin: 0 0 5px 0;
    font-family: "Open Sans",Arial,Helvetica,sans-serif;
    border: none;
    color: #fff;
    background-color: #454545;
    padding: 12px 30px 13px 30px;
    cursor: pointer;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    -moz-transition: all .2s ease-in-out;
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}
input[type=submit]:hover {
    color: #fff;
    background-color: #121212;
    border: none;
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
	width: 100%;
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
.user-sites .user-site .user-site-item{
	background: #fff;
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
	/*background: url(http://bits.darlic.com/wp-content/uploads/sites/3/2016/04/img_not_available.jpg);
	background-size: 185px 145px;*/
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
.bit-stat-like .icon-color{
	color: rgb(160, 206, 78);
}
.bit-stat-dislike .icon-color{
	color: rgb(234, 67, 53);
}
/* .like-icon {
	color: rgb(160, 206, 78);
}
.dislike-icon {
	color: rgb(234, 67, 53);
} */
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
[data-tooltip] {
  position: relative;
  cursor: pointer;
}

/* Base styles for the entire tooltip */
[data-tooltip]:before,
[data-tooltip]:after {
  position: absolute;
  visibility: hidden;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
  opacity: 0;
  -webkit-transition: 
      opacity 0.2s ease-in-out,
        visibility 0.2s ease-in-out,
        -webkit-transform 0.2s cubic-bezier(0.71, 1.7, 0.77, 1.24);
    -moz-transition:    
        opacity 0.2s ease-in-out,
        visibility 0.2s ease-in-out,
        -moz-transform 0.2s cubic-bezier(0.71, 1.7, 0.77, 1.24);
    transition:         
        opacity 0.2s ease-in-out,
        visibility 0.2s ease-in-out,
        transform 0.2s cubic-bezier(0.71, 1.7, 0.77, 1.24);
  -webkit-transform: translate3d(0, 0, 0);
  -moz-transform:    translate3d(0, 0, 0);
  transform:         translate3d(0, 0, 0);
  pointer-events: none;
  bottom: 100%;
  left: 50%;
}

/* Show the entire tooltip on hover and focus */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
  opacity: 1;
   -webkit-transform: translateY(-12px);
  -moz-transform:    translateY(-12px);
  transform:         translateY(-12px); 
}

/* Base styles for the tooltip's directional arrow */
[data-tooltip]:before {
  z-index: 1001;
  border: 6px solid transparent;
  background: transparent;
  content: "";
  margin-left: -6px;
  margin-bottom: -12px;
  border-top-color: #000;
  border-top-color: hsla(0, 0%, 20%, 0.9);
}

/* Base styles for the tooltip's content area */
[data-tooltip]:after {
  z-index: 1000;
  padding: 8px;
  width: 160px;
  background-color: #000;
  background-color: hsla(0, 0%, 20%, 0.9);
  color: #fff;
  content: attr(data-tooltip);
  font-size: 14px;
  line-height: 1.2;
  text-align: center;
  border-radius: 20px;
  margin-left: -80px;
}

/* Bottom */
.tooltip-bottom:before,
.tooltip-bottom:after {
  top: 100%;
  bottom: auto;
  left: 50%;
}

.tooltip-bottom:before {
  margin-top: -12px;
  margin-bottom: 0;
  border-top-color: transparent;
  border-bottom-color: #000;
  border-bottom-color: hsla(0, 0%, 20%, 0.9);
}

.tooltip-bottom:hover:before,
.tooltip-bottom:hover:after {
  -webkit-transform: translateY(12px);
  -moz-transform:    translateY(12px);
  transform:         translateY(12px); 
}
a.fbshare_button{
	color:#3b5998;
}
a.twshare_button {
	color:#0084b4;
}
</style>