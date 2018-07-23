<?php
/**
 * Template Name: Editor
 */

	$current_user = wp_get_current_user();
	$pte = Page_Template_Plugin::get_instance();
	$locale = $pte->get_locale();


	$bit_slug = $_GET['id'];
	
	$bit_id = 0;
	global $switched;
	switch_to_blog(3);
	
	if($bit_slug){
		$bit_object = get_page_by_path($bit_slug,OBJECT,'post');
		
		if($bit_object->ID){
			$bit_id = $bit_object->ID;
			$bit_title = get_the_title($bit_id);
		}
		
	}	
	$html = get_field('bit_html', $bit_id);
	$css = get_field('bit_css', $bit_id);
	$js = get_field('bit_js', $bit_id);
	$bit_include_js = get_field('include_script', $bit_id);
	
	
	$user_id = $current_user->ID;
	
	
	
	if(isset($_POST['bit_save_button']) && $_POST['bit_save_button']== 'Save'){
		
		
		$slugid = getToken(10);
		
		// Is bit slug already present or not
		$args = array(
			'post_type' => 'post',
			'post_status'   => 'publish'
			);
			
		// The Query
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;
				$post_id = $post->ID;
				$post_name = $post->post_name;
				if($post_name == $slugid){
					$slugid = getToken(10);
				}
			}
		}
		
		// Create post object
			$new_bit_args = array(
			  'post_title'    => $_POST['bit_title'],
			  'post_content'  => $_POST['bit_html'],
			  'post_status'   => 'draft',
			  'post_type'   => 'post',
			  'author'		=> $current_user->ID,
			  'post_name' => $slugid,
			);

			// Insert the post into the database
			$new_bit_id = wp_insert_post( $new_bit_args, false );
			
			
			update_field( 'field_570a0270814b1', $_POST['bit_html'], $new_bit_id ); // HTML Content
			update_field( 'field_570a0284814b2', $_POST['bit_css'], $new_bit_id ); // CSS Content
			update_field( 'field_570a028b814b3', $_POST['bit_js'], $new_bit_id ); // JS Content
			update_field( 'field_570a02ae814b5', 0, $new_bit_id ); // Views
			update_field( 'field_570a02bb814b6', 0, $new_bit_id ); // Downloads
			update_field( 'field_570a02c9814b7', 0, $new_bit_id ); // Like
			update_field( 'field_570a02d5814b8', 0, $new_bit_id ); // Dislike

            if($new_bit_id){
                //$to = bloginfo('admin_email');
                $to = "sgs.sandhu@gmail.com,sakkatarsingh@gmail.com";
                $subject = 'New BIT Post on bits.darlic.com';
                $message = "A new bit is saved on bits.darlic.com";
                $message .= "<div><strong>User ID : </strong>".$current_user->ID."</div>";
                $user_data = get_userdata($current_user->ID);
                $user_email = $user_data->user_email;
                $user_display_name = $user_data->display_name;
                $post = get_post( $new_bit_id );
                $post_type_object = get_post_type_object( $post->post_type );
                $link = admin_url( sprintf( $post_type_object->_edit_link . "&action=edit", $post->ID ) );
                $message .= "<div><strong>User Name : </strong>".$user_display_name."</div>";
                $message .= "<div><strong>User Email : </strong>".$user_email."</div>";
                $message .= "click on : ".$link;
                add_filter( "wp_mail_content_type", "set_html_content_type" );
                function set_html_content_type() {
                    return "text/html";
                }
                wp_mail($to, $subject, $message );
                remove_filter( "wp_mail_content_type", "set_html_content_type" );

            }
		
		
	}
	
        if(isset($_POST['bit_update_button']) && $_POST['bit_update_button']== 'Update'){
		
			$update_bit_id = $_POST['bit_update'];
			$bit_object = get_post( $update_bit_id );
			// Update Bit
			$update_bit_arg = array(
			'ID'           => $update_bit_id ,
			'post_title'   => $_POST['bit_title'],
			'post_content' => $_POST['bit_html'],
			);

			// Update the post into the database
			wp_update_post( $update_bit_arg );
			update_field( 'field_570a0270814b1', $_POST['bit_html'], $update_bit_id);
			update_field( 'field_570a0284814b2', $_POST['bit_css'], $update_bit_id );
			update_field( 'field_570a028b814b3', $_POST['bit_js'], $update_bit_id);
			header("Location: http://darlic.com/play/?id=".$bit_object->post_name."/");
	}



//print_r($bit_object);

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
	$codeAlphabet = "abcdefghijklMNOPQRSTUVWXYZ";
    $codeAlphabet.= "ABCDEFGHIJKLmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }
    return $token;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Darlic Live Editor</title>

    <script type="text/javascript">
        addLoadEvent = function (func) {
            if (typeof jQuery != "undefined")jQuery(document).ready(func); else if (typeof wpOnload != 'function') {
                wpOnload = func;
            } else {
                var oldonload = wpOnload;
                wpOnload = function () {
                    oldonload();
                    func();
                }
            }
        };
        var ajaxurl = 'ajax.php',
                pagenow = 'page',
                typenow = 'page',
                adminpage = 'post-new-php',
                thousandsSeparator = ',',
                decimalPoint = '.',
                isRtl = 0;
				

    </script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo  plugin_dir_url( __FILE__ )."assets/css/style.css";?>"  type="text/css" media="all">
    <script type="text/javascript" src="<?php echo  plugin_dir_url( __FILE__ )."assets/js/jquery.js";?>"></script>
    <script type="text/javascript" src="<?php echo  plugin_dir_url( __FILE__ )."assets/js/jquery-migrate.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo  plugin_dir_url( __FILE__ )."assets/js/core.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo  plugin_dir_url( __FILE__ )."assets/js/widget.min.js";?>"></script>
    


    <script type="text/javascript">
        /* <![CDATA[ */
        var userSettings = {"url": "\/", "uid": "1", "time": "1443461561", "secure": ""};
        /* ]]> */
    </script>
    
    <script type="text/javascript">
	var _wpColorScheme = {"icons": {"base": "#999", "focus": "#00a0d2", "current": "#fff"}};
	</script>

</head>
<body class="wp-admin wp-core-ui js  post-new-php auto-fold admin-bar post-type-page branch-4-3 version-4-3-1 admin-color-fresh locale-en-us multisite customize-support sticky-menu svg">
<script type="text/javascript">
    document.body.className = document.body.className.replace('no-js', 'js');
</script>

<script type="text/javascript">
    (function () {
        var request, b = document.body, c = 'className', cs = 'customize-support', rcs = new RegExp('(^|\\s+)(no-)?' + cs + '(\\s+|$)');

        request = true;

        b[c] = b[c].replace(rcs, ' ');
        b[c] += ( window.postMessage && request ? ' ' : ' no-' ) + cs;
    }());
</script>

<div id="wpwrap">
<div id="wpcontent">


<div id="wpbody" role="main">

<div id="wpbody-content" aria-label="Main content" tabindex="0" style="overflow: hidden;">
<div id="screen-meta" class="metabox-prefs" style="display: none;">

    <div id="contextual-help-wrap" class="hidden" tabindex="-1" aria-label="Contextual Help Tab">
        <div id="contextual-help-back"></div>
        <div id="contextual-help-columns">
            <div class="contextual-help-tabs">
                <ul>

                    <li id="tab-link-about-pages" class="active">
                        <a href="http://default.darlic.io/wp-admin/post-new.php?post_type=page#tab-panel-about-pages"
                           aria-controls="tab-panel-about-pages">
                            About Pages </a>
                    </li>

                    <li id="tab-link-inserting-media">
                        <a href="http://default.darlic.io/wp-admin/post-new.php?post_type=page#tab-panel-inserting-media"
                           aria-controls="tab-panel-inserting-media">
                            Inserting Media </a>
                    </li>

                    <li id="tab-link-page-attributes">
                        <a href="http://default.darlic.io/wp-admin/post-new.php?post_type=page#tab-panel-page-attributes"
                           aria-controls="tab-panel-page-attributes">
                            Page Attributes </a>
                    </li>
                </ul>
            </div>

            <div class="contextual-help-sidebar">
                <p><strong>For more information:</strong></p>

                <p><a href="https://codex.wordpress.org/Pages_Add_New_Screen" target="_blank">Documentation on Adding
                    New Pages</a></p>

                <p><a href="https://codex.wordpress.org/Pages_Screen#Editing_Individual_Pages" target="_blank">Documentation
                    on Editing Pages</a></p>

                <p><a href="https://wordpress.org/support/" target="_blank">Support Forums</a></p></div>

            <div class="contextual-help-tabs-wrap">

                <div id="tab-panel-about-pages" class="help-tab-content active">
                    <p>Pages are similar to posts in that they have a title, body text, and associated metadata, but
                        they are different in that they are not part of the chronological blog stream, kind of like
                        permanent posts. Pages are not categorized or tagged, but can have a hierarchy. You can nest
                        pages under other pages by making one the “Parent” of the other, creating a group of pages.</p>

                    <p>Creating a Page is very similar to creating a Post, and the screens can be customized in the same
                        way using drag and drop, the Screen Options tab, and expanding/collapsing boxes as you choose.
                        This screen also has the distraction-free writing space, available in both the Visual and Text
                        modes via the Fullscreen buttons. The Page editor mostly works the same as the Post editor, but
                        there are some Page-specific features in the Page Attributes box:</p></div>

                <div id="tab-panel-inserting-media" class="help-tab-content">
                    <p>You can upload and insert media (images, audio, documents, etc.) by clicking the Add Media
                        button. You can select from the images and files already uploaded to the Media Library, or
                        upload new media to add to your page or post. To create an image gallery, select the images to
                        add and click the “Create a new gallery” button.</p>

                    <p>You can also embed media from many popular websites including Twitter, YouTube, Flickr and others
                        by pasting the media URL on its own line into the content of your post/page. Please refer to the
                        Codex to <a href="https://codex.wordpress.org/Embeds">learn more about embeds</a>.</p></div>

                <div id="tab-panel-page-attributes" class="help-tab-content">
                    <p><strong>Parent</strong> - You can arrange your pages in hierarchies. For example, you could have
                        an “About” page that has “Life Story” and “My Dog” pages under it. There are no limits to how
                        many levels you can nest pages.</p>

                    <p><strong>Template</strong> - Some themes have custom templates you can use for certain pages that
                        might have additional features or custom layouts. If so, you’ll see them in this dropdown menu.
                    </p>

                    <p><strong>Order</strong> - Pages are usually ordered alphabetically, but you can choose your own
                        order by entering a number (1 for first, etc.) in this field.</p></div>
            </div>
        </div>
    </div>
    <div id="screen-options-wrap" class="hidden" tabindex="-1" aria-label="Screen Options Tab" style="display: none;">
        <form id="adv-settings" method="post">
            <h5>Show on screen</h5>

            <div class="metabox-prefs">
                <label for="htmldiv-hide"><input class="hide-postbox-tog" name="htmldiv-hide"
                                                       type="checkbox" id="htmldiv-hide" value="htmldiv"
                                                       checked="checked">Html</label>
                <label for="cssdiv-hide"><input class="hide-postbox-tog" name="cssdiv-hide" type="checkbox"
                                                      id="cssdiv-hide" value="cssdiv" checked="checked">css
                    </label>
					<label for="jsdiv-hide"><input class="hide-postbox-tog" name="jsdiv-hide" type="checkbox"
                                                   id="jsdiv-hide" value="jsdiv"
                                                   checked="checked">js</label>
                <label for="postcustom-hide"><input class="hide-postbox-tog" name="postcustom-hide" type="checkbox"
                                                    id="postcustom-hide" value="postcustom" checked="checked">Preview
                </label>
                <label for="commentstatusdiv-hide"><input class="hide-postbox-tog" name="commentstatusdiv-hide"
                                                          type="checkbox" id="commentstatusdiv-hide"
                                                          value="commentstatusdiv" checked="checked">Discussion</label>
				<?php if ( is_user_logged_in() ){?>
                <label for="slugdiv-hide"><input class="hide-postbox-tog" name="slugdiv-hide" type="checkbox"
                                                 id="slugdiv-hide" value="slugdiv" checked="checked">Save Code</label>
                <?php } ?>
                <br class="clear">
            </div>
            <h5 class="screen-layout">Screen Layout</h5>

            <div class="columns-prefs">Number of Columns: <label class="columns-prefs-1">
                <input type="radio" name="screen_columns" value="1">
                1 </label>
                <label class="columns-prefs-2">
                    <input type="radio" name="screen_columns" value="2" checked="checked">
                    2 </label>
            </div>
            <div class="editor-expand hidden" style="display: block;"><label for="editor-expand-toggle"><input
                    type="checkbox" id="editor-expand-toggle" checked="checked">Enable full-height editor and
                distraction-free functionality.</label></div>
            <div><input type="hidden" id="screenoptionnonce" name="screenoptionnonce" value="d4e0c019ec"></div>
        </form>
    </div>
	 <div id="account-options-wrap" class="hidden" tabindex="-1" aria-label="account Options Tab" style="display: none;">
        <form id="account-settings" method="post">
		<div class="welcome">
            <?php 
			if ( is_user_logged_in() ) :
 
               $current_user = wp_get_current_user();

               echo 'Welcome'.' ' . $current_user->user_nicename . '!';

               else :
               echo 'Welcome!';

              endif;

			?>
		</div>
		   <div id="formcontent">
		   <?php
			if ( ! is_user_logged_in() ) { // Display WordPress login form:
				  echo '<a href="'.wp_login_url().'" title="Login">Login</a>';
				  echo '<a href="'.wp_registration_url().'" title="Registration">Register</a>';
			   } else { // If logged in:
				  echo '<a href="'. wp_logout_url().'" title="Logout">Logout</a>'; // Display "Log Out" link.
				  echo " | ";
				  wp_register('', ''); // Display "Site Admin" link.
			   }
			   ?>
			</div>
            <br/>
        </form>
    </div>
</div>


<!-- <div id="screen-meta-links">
     <div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
        <button type="button" id="show-settings-link" class="button show-settings" aria-controls="account-options-wrap"
                aria-expanded="false">Account
        </button>
    </div>
    <div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
        <button type="button" id="contextual-help-link" class="button show-settings"
                aria-controls="contextual-help-wrap" aria-expanded="false">Help
        </button>
    </div>
    <div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
        <button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap"
                aria-expanded="false">Settings
        </button>
    </div>
</div> -->

<header id="header" class="header">
    <?php if($theme_options['header_show_logo']): ?>
    <div id="logo" class="logo" >
        <a href="<?php bloginfo('url'); ?>">
            <?php if($theme_options['logo']['url']): ?>
            <img src="<?php echo $theme_options['logo']['url']; ?>" alt="<?php bloginfo('name'); ?>" class="site_logo" />
            <?php endif; ?>
        </a>
    </div>
    <?php endif; ?>
    <?php if($theme_options['header_show_site_title'] || $theme_options['header_show_tagline'] ): ?>
        <div id="logo_text">
            <?php if($theme_options['header_show_site_title']){
                $site_title = get_bloginfo( 'name' );
                if(!empty($site_title)):?>
                    <div id="site_title"><a id="site_name" href="<?php echo home_url( '/' ); ?>"><?php bloginfo('name'); ?></a></div>
                <?php endif; }?>
            <?php if($theme_options['header_show_tagline']){
                $site_desc = get_bloginfo( 'description' );
                if(!empty($site_desc)):?>
                    <div id="site_description"><?php bloginfo( 'description' ); ?></div>
                <?php endif; }?>
        </div>
    <?php endif; ?>

    <?php
    if($theme_options['header_show_navigation']){ ?>
    <nav id="nav" class="nav">                  
        <ul id="main_menu" class="navigation menu nav">
             <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home"><a href="http://bits.darlic.com/">All Bits</a></li>
            <?php
            if(is_user_logged_in()){?>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home"><a href="http://darlic.com/account/">Account</a></li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home"><a href="<?php echo wp_logout_url();?>" title="Logout">Logout</a></li>
            <?php
            } else{ ?>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home"><a href="http://darlic.com/wp-login.php">Login</a></li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home"><a href="http://darlic.com/signup/">Register</a></li>
            <?php 
            }
            ?>
        </ul>
    </nav>
    <?php } ?>
    
    <style>
    #logo {display: inline-block;}
    .aione-clearfix , .oxo-clearfix{
        clear: both;
        zoom: 1;
    }
    .header {
        padding: 10px;
        margin-top: 0px;
        background-color: #FFF;
        box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1) inset;
    }
    #nav {
        float: right;
        position: relative;
        z-index: 200;
        overflow: hidden;
    }
    
    #nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #nav ul li {
        display: inline-block;
        font-family: "Open Sans",Arial,Helvetica,sans-serif;
        font-weight: 100;
        text-align: center;
        white-space: pre;
        padding: 0 10px;
        font-size: 20px;
    }
    #nav ul li a {
        color: #333;
        height: 76px;
        line-height: 76px;
        font-size: 18px;
        font-weight: 100;
        font-family: "Open Sans",arial, helvetica, sans-serif;
        transition: all 150ms ease-out;
    }
    #nav ul li a:hover , #nav ul li.current-menu-item a{
        color: #168dc5;
    }
    #nav > ul > li > a::after, #nav ul li.current-menu-item a::after {
        position: relative;
        display: block;
        margin-top: -4px;
        width: 0px;
        content: '';
        transition: 0.5s ease;
        height: 4px;
        background: #168dc5;
    }
    #nav ul > li > a:hover::after,  #nav ul li.current-menu-item a::after{
        width: 100%;
    }
    </style>

</header> 

<div class="wrap">
<div class="editor-header">
<div class="heading">
<h1>Code Playground</h1></div>
<div class="header-button">
<!-- 
<a class="saveLink" href="#" title="Click to clear all">Save</a>
-->
<a class="clearLink" href="http://darlic.com/play/" title="Click for new code">New</a>
<a class="clearLink" href="#" title="Click to clear all">clear</a>
<button type="button" class="preview-fullscreen" id="toggle_fullscreen">Full screen</button>
</div>
</div>


<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="postbox-container-1" class="postbox-container">
    <div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
        <div id="htmldiv" class="postbox ">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle ui-sortable-handle"><span>HTML</span></h3>

            <div class="inside">
                <div class="submitbox" id="submitpost">

                    <div id="editor-html" style="min-height: 200px;">
                        <div id="editorhtml" style="min-height: 200px; width:100%;">
						</div>
                        

                    </div>

                    <div id="major-publishing-actions">
                        <div id="delete-action">
                            <span id="count-characters-html">0</span> Characters / 
							<span id="count-lines-html">0</span> Lines
                        </div>

                        <div id="publishing-action">
							<span id="cursor-position-html"></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>


        <div id="cssdiv" class="postbox ">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle ui-sortable-handle"><span>CSS</span></h3>

            <div class="inside">
                <div class="submitbox" id="submitpost">

                    <div id="editor-css" style="min-height: 200px;">
					    <div id="editorcss" style="min-height: 200px; width:100%;">
						</div>
                        

                    </div>

                    <div id="major-publishing-actions">
                        <div id="delete-action">
                            <span id="count-characters-css">0</span> Characters / 
							<span id="count-lines-css">0</span> Lines
                        </div>

                        <div id="publishing-action">
							<span id="cursor-position-css"></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>

        <div id="jsdiv" class="postbox ">
            <div class="handlediv" title="Click to toggle"><br></div>
			<button type="button" class="preview-fullscreen" id="toggle_fullscreen_js">Full screen</button>
            <h3 class="hndle ui-sortable-handle"><span>JS</span></h3>

            <div class="inside">
                <div class="submitbox" id="submitpost">

                    <div id="editor-js" style="min-height: 200px;">
						<div id="editorjs" style="min-height: 200px; width:100%;">
						</div>
                        
                    </div>

                    <div id="major-publishing-actions">
                        <div id="delete-action">
                            <span id="count-characters-js">0</span> Characters / 
							<span id="count-lines-js">0</span> Lines
                        </div>

                        <div id="publishing-action">
							<span id="cursor-position-js"></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>

        
    </div>
</div>

<div id="postbox-container-2" class="postbox-container">
    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
        <div id="postcustom" class="postbox ">
            <div class="handlediv" title="Click to toggle"><br></div>
			 <button type="button" class="preview-fullscreen" id="toggle_fullscreen_preview">Full screen</button>
            <h3 class="hndle ui-sortable-handle"><span>Preview</span></h3>

            <div class="inside">
                <div id="postcustomstuff">
                    <div id="ajax-response"></div>
                    <iframe id="preview"></iframe>
                </div>
            </div>
        </div>
        <div id="commentstatusdiv" class="postbox ">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle ui-sortable-handle"><span>Discussion</span></h3>

            <div class="inside">
                <input name="advanced_view" type="hidden" value="1">

            </div>
        </div>
		<?php if ( is_user_logged_in() ){?>
        <div id="slugdiv" class="postbox ">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle ui-sortable-handle"><span>Save Code</span></h3>

            <div class="inside">
                <label class="screen-reader-text" for="post_name">Title</label>
			<form action="http://darlic.com/play/" method="post" >
				<input name="bit_title" type="text" size="50" required id="post_title" value="<?php echo $bit_title; ?>" placeholder="Enter The Title" >
				<input name="bit_html" type="hidden" id="bit_html">
				<input name="bit_css" type="hidden" id="bit_css">
				<input name="bit_js" type="hidden" id="bit_js">
				<input name="bit_include_js" type="hidden" id="bit_include_js" value="<?php echo $bit_include_js; ?>">
				<input name="bit_update" type="hidden" id="bit_update" value="<?php echo $bit_id; ?>">
				<?php 
				$bit_object = get_post( $bit_id );
				$bit_author = $bit_object->post_author;
				if($bit_slug){
					if( $user_id == $bit_author){
						echo '<input name="bit_update_button" type="submit" class="button button-primary button-large" value="Update">';
					} else{
						echo '<input name="bit_save_button" type="submit" class="button button-primary button-large" value="Save As">';
					}
					
				} else {
					echo '<input name="bit_save_button" type="submit" class="button button-primary button-large" value="Save">';
				}
				?>
			</form>
            </div>
        </div>
		<?php  } ?>
    </div>
    <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
</div>
</div>
<!-- /post-body -->
<br class="clear">
</div>
<!-- /poststuff -->

</div>


<script type="text/javascript">
    try {
        document.post.title.focus();
    } catch (e) {
    }
</script>

<div class="clear"></div>
</div>
<!-- wpbody-content -->
<div class="clear"></div>
</div>
<!-- wpbody -->
<div class="clear"></div>
</div>
<!-- wpcontent -->

<?php  
include("includes/footer.php");
?>

<script>
    function InsertForm() {
        var form_id = jQuery("#add_form_id").val();
        if (form_id == "") {
            alert("Please select a form");
            return;
        }

        var form_name = jQuery("#add_form_id option[value='" + form_id + "']").text().replace(/[\[\]]/g, '');
        var display_title = jQuery("#display_title").is(":checked");
        var display_description = jQuery("#display_description").is(":checked");
        var ajax = jQuery("#gform_ajax").is(":checked");
        var title_qs = !display_title ? " title=\"false\"" : "";
        var description_qs = !display_description ? " description=\"false\"" : "";
        var ajax_qs = ajax ? " ajax=\"true\"" : "";

        window.send_to_editor("[gravityform id=\"" + form_id + "\" name=\"" + form_name + "\"" + title_qs + description_qs + ajax_qs + "]");
    }
</script>



<script type="text/javascript">
list_args = {"class": "WP_Post_Comments_List_Table", "screen": {"id": "page", "base": "post"}};
</script>


<script type="text/javascript">
    /* <![CDATA[ */
    var commonL10n = {"warnDelete": "You are about to permanently delete the selected items.\n  'Cancel' to stop, 'OK' to delete.", "dismiss": "Dismiss this notice."};
    var heartbeatSettings = {"nonce": "e1c17933e9"};
    var autosaveL10n = {"autosaveInterval": "60", "blog_id": "2"};
    var wpAjax = {"noPerm": "You do not have permission to do that.", "broken": "An unidentified error has occurred."};
    var tagsBoxL10n = {"tagDelimiter": ","};
    var wordCountL10n = {"type": "words", "shortcodes": ["embed", "wp_caption", "caption", "gallery", "playlist", "audio", "video"]};
    var postL10n = {"ok": "OK", "cancel": "Cancel", "publishOn": "Publish on:", "publishOnFuture": "Schedule for:", "publishOnPast": "Published on:", "dateFormat": "%1$s %2$s, %3$s @ %4$s:%5$s", "showcomm": "Show more comments", "endcomm": "No more comments found.", "publish": "Publish", "schedule": "Schedule", "update": "Update", "savePending": "Save as Pending", "saveDraft": "Save Draft", "private": "Private", "public": "Public", "publicSticky": "Public, Sticky", "password": "Password Protected", "privatelyPublished": "Privately Published", "published": "Published", "saveAlert": "The changes you made will be lost if you navigate away from this page.", "savingText": "Saving Draft\u2026"};
    var thickboxL10n = {"next": "Next >", "prev": "< Prev", "image": "Image", "of": "of", "close": "Close", "noiframes": "This feature requires inline frames. You have iframes disabled or your browser does not support them.", "loadingAnimation": "images\/loadingAnimation.gif"};
    var _wpUtilSettings = {"ajax": {"url": "\/ajax.php"}};
    var _wpMediaModelsL10n = {"settings": {"ajaxurl": "\/ajax.php", "post": {"id": 0}}};
    var pluploadL10n = {"queue_limit_exceeded": "You have attempted to queue too many files.", "file_exceeds_size_limit": "%s exceeds the maximum upload size for this site.", "zero_byte_file": "This file is empty. Please try another.", "invalid_filetype": "This file type is not allowed. Please try another.", "not_an_image": "This file is not an image. Please try another.", "image_memory_exceeded": "Memory exceeded. Please try another smaller file.", "image_dimensions_exceeded": "This is larger than the maximum size. Please try another.", "default_error": "An error occurred in the upload. Please try again later.", "missing_upload_url": "There was a configuration error. Please contact the server administrator.", "upload_limit_exceeded": "You may only upload 1 file.", "http_error": "HTTP error.", "upload_failed": "Upload failed.", "big_upload_failed": "Please try uploading this file with the %1$sbrowser uploader%2$s.", "big_upload_queued": "%s exceeds the maximum upload size for the multi-file uploader when used in your browser.", "io_error": "IO error.", "security_error": "Security error.", "file_cancelled": "File canceled.", "upload_stopped": "Upload stopped.", "dismiss": "Dismiss", "crunching": "Crunching\u2026", "deleted": "moved to the trash.", "error_uploading": "\u201c%s\u201d has failed to upload."};
    var _wpPluploadSettings = {"defaults": {"runtimes": "html5,flash,silverlight,html4", "file_data_name": "async-upload", "url": "\/wp-admin\/async-upload.php", "flash_swf_url": "http:\/\/default.darlic.io\/wp-includes\/js\/plupload\/plupload.flash.swf", "silverlight_xap_url": "http:\/\/default.darlic.io\/wp-includes\/js\/plupload\/plupload.silverlight.xap", "filters": {"max_file_size": "1536000b"}, "multipart_params": {"action": "upload-attachment", "_wpnonce": "d1f73dff42"}}, "browser": {"mobile": false, "supported": true}, "limitExceeded": false};
    var mejsL10n = {"language": "en-US", "strings": {"Close": "Close", "Fullscreen": "Fullscreen", "Download File": "Download File", "Download Video": "Download Video", "Play\/Pause": "Play\/Pause", "Mute Toggle": "Mute Toggle", "None": "None", "Turn off Fullscreen": "Turn off Fullscreen", "Go Fullscreen": "Go Fullscreen", "Unmute": "Unmute", "Mute": "Mute", "Captions\/Subtitles": "Captions\/Subtitles"}};
    var _wpmejsSettings = {"pluginPath": "\/wp-includes\/js\/mediaelement\/"};
    var _wpMediaViewsL10n = {"url": "URL", "addMedia": "Add Media", "search": "Search", "select": "Select", "cancel": "Cancel", "update": "Update", "replace": "Replace", "remove": "Remove", "back": "Back", "selected": "%d selected", "dragInfo": "Drag and drop to reorder media files.", "uploadFilesTitle": "Upload Files", "uploadImagesTitle": "Upload Images", "mediaLibraryTitle": "Media Library", "insertMediaTitle": "Insert Media", "createNewGallery": "Create a new gallery", "createNewPlaylist": "Create a new playlist", "createNewVideoPlaylist": "Create a new video playlist", "returnToLibrary": "\u2190 Return to library", "allMediaItems": "All media items", "allDates": "All dates", "noItemsFound": "No items found.", "insertIntoPost": "Insert into page", "unattached": "Unattached", "trash": "Trash", "uploadedToThisPost": "Uploaded to this page", "warnDelete": "You are about to permanently delete this item.\n  'Cancel' to stop, 'OK' to delete.", "warnBulkDelete": "You are about to permanently delete these items.\n  'Cancel' to stop, 'OK' to delete.", "warnBulkTrash": "You are about to trash these items.\n  'Cancel' to stop, 'OK' to delete.", "bulkSelect": "Bulk Select", "cancelSelection": "Cancel Selection", "trashSelected": "Trash Selected", "untrashSelected": "Untrash Selected", "deleteSelected": "Delete Selected", "deletePermanently": "Delete Permanently", "apply": "Apply", "filterByDate": "Filter by date", "filterByType": "Filter by type", "searchMediaLabel": "Search Media", "noMedia": "No media attachments found.", "attachmentDetails": "Attachment Details", "insertFromUrlTitle": "Insert from URL", "setFeaturedImageTitle": "Featured Image", "setFeaturedImage": "Set featured image", "createGalleryTitle": "Create Gallery", "editGalleryTitle": "Edit Gallery", "cancelGalleryTitle": "\u2190 Cancel Gallery", "insertGallery": "Insert gallery", "updateGallery": "Update gallery", "addToGallery": "Add to gallery", "addToGalleryTitle": "Add to Gallery", "reverseOrder": "Reverse order", "imageDetailsTitle": "Image Details", "imageReplaceTitle": "Replace Image", "imageDetailsCancel": "Cancel Edit", "editImage": "Edit Image", "chooseImage": "Choose Image", "selectAndCrop": "Select and Crop", "skipCropping": "Skip Cropping", "cropImage": "Crop Image", "cropYourImage": "Crop your image", "cropping": "Cropping\u2026", "suggestedDimensions": "Suggested image dimensions:", "cropError": "There has been an error cropping your image.", "audioDetailsTitle": "Audio Details", "audioReplaceTitle": "Replace Audio", "audioAddSourceTitle": "Add Audio Source", "audioDetailsCancel": "Cancel Edit", "videoDetailsTitle": "Video Details", "videoReplaceTitle": "Replace Video", "videoAddSourceTitle": "Add Video Source", "videoDetailsCancel": "Cancel Edit", "videoSelectPosterImageTitle": "Select Poster Image", "videoAddTrackTitle": "Add Subtitles", "playlistDragInfo": "Drag and drop to reorder tracks.", "createPlaylistTitle": "Create Audio Playlist", "editPlaylistTitle": "Edit Audio Playlist", "cancelPlaylistTitle": "\u2190 Cancel Audio Playlist", "insertPlaylist": "Insert audio playlist", "updatePlaylist": "Update audio playlist", "addToPlaylist": "Add to audio playlist", "addToPlaylistTitle": "Add to Audio Playlist", "videoPlaylistDragInfo": "Drag and drop to reorder videos.", "createVideoPlaylistTitle": "Create Video Playlist", "editVideoPlaylistTitle": "Edit Video Playlist", "cancelVideoPlaylistTitle": "\u2190 Cancel Video Playlist", "insertVideoPlaylist": "Insert video playlist", "updateVideoPlaylist": "Update video playlist", "addToVideoPlaylist": "Add to video playlist", "addToVideoPlaylistTitle": "Add to Video Playlist", "settings": {"tabs": [], "tabUrl": "http:\/\/default.darlic.io\/wp-admin\/media-upload.php?chromeless=1", "mimeTypes": {"image": "Images", "audio": "Audio", "video": "Video"}, "captions": true, "nonce": {"sendToEditor": "3759d75929"}, "post": {"id": 44, "nonce": "edfea54d9f", "featuredImageId": -1}, "defaultProps": {"link": "file", "align": "", "size": ""}, "attachmentCounts": {"audio": 0, "video": 0}, "embedExts": ["mp3", "ogg", "wma", "m4a", "wav", "mp4", "m4v", "webm", "ogv", "wmv", "flv"], "embedMimes": {"mp3": "audio\/mpeg", "ogg": "audio\/ogg", "wma": "audio\/x-ms-wma", "m4a": "audio\/mpeg", "wav": "audio\/wav", "mp4": "video\/mp4", "m4v": "video\/mp4", "webm": "video\/webm", "ogv": "video\/ogg", "wmv": "video\/x-ms-wmv", "flv": "video\/x-flv"}, "contentWidth": 660, "months": [], "mediaTrash": 0}};
    var imageEditL10n = {"error": "Could not load the preview image. Please reload the page and try again."};
    var authcheckL10n = {"beforeunload": "Your session has expired. You can log in again from this page or go to the login page.", "interval": "180"};
    var quicktagsL10n = {"closeAllOpenTags": "Close all open tags", "closeTags": "close tags", "enterURL": "Enter the URL", "enterImageURL": "Enter the URL of the image", "enterImageDescription": "Enter a description of the image", "textdirection": "text direction", "toggleTextdirection": "Toggle Editor Text Direction", "dfw": "Distraction-free writing mode", "strong": "Bold", "strongClose": "Close bold tag", "em": "Italic", "emClose": "Close italic tag", "link": "Insert link", "blockquote": "Blockquote", "blockquoteClose": "Close blockquote tag", "del": "Deleted text (strikethrough)", "delClose": "Close deleted text tag", "ins": "Inserted text", "insClose": "Close inserted text tag", "image": "Insert image", "ul": "Bulleted list", "ulClose": "Close bulleted list tag", "ol": "Numbered list", "olClose": "Close numbered list tag", "li": "List item", "liClose": "Close list item tag", "code": "Code", "codeClose": "Close code tag", "more": "Insert Read More tag"};
    var wpLinkL10n = {"title": "Insert\/edit link", "update": "Update", "save": "Add Link", "noTitle": "(no title)", "noMatchesFound": "No results found."};
    /* ]]> */
</script>
<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ )."assets/js/load-script.js";?>" ></script>
<div class="clear"></div>
</div>
<div style="display:none;width:0;height:0;overflow:hidden;">

		<?php 

		echo '<textarea id="html_temp">'.$html.'</textarea>';
		echo '<textarea id="css_temp">'.$css.'</textarea>';
		echo '<textarea id="js_temp">'.$js.'</textarea>';
		?>
</div>
<!-- wpwrap -->
<script type="text/javascript">if (typeof wpOnload == 'function')wpOnload();</script>
<script src="<?php echo plugin_dir_url( __FILE__ )."assets/ace/ace.js";?>" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
		jQuery( "#toggle_fullscreen_preview" ).click(function() {			
			jQuery(this).parent().toggleClass("fullscreen");
		});
		jQuery( "#toggle_fullscreen_js" ).click(function() {
			jQuery(this).parent().toggleClass("fullscreen");
		});
		
		var el = document.getElementById( 'toggle_fullscreen' );
		if( el ) {
			var options = document.getElementById( 'options' );
			el.addEventListener( 'click', function( e ) {
				if( document.body.webkitRequestFullScreen ) {
					document.body.onwebkitfullscreenchange = function(e) {
					//	options.style.display = 'none';
						document.body.style.width = window.innerWidth + 'px';
						document.body.style.height = window.innerHeight + 'px';
						document.body.onwebkitfullscreenchange = function() {
					//		options.style.display = 'block';
						};
					};
					document.body.webkitRequestFullScreen();
				}
				if( document.body.mozRequestFullScreen ) {
					/*document.body.onmozfullscreenchange = function( e ) {
						options.style.display = 'none';
						document.body.onmozfullscreenchange = function( e ) {
							options.style.display = 'block';
						};
					};*/
					document.body.mozRequestFullScreen();
				}
				e.preventDefault();
			}, false );
		}
		
		
	
		// Publish output from HTMl, CSS, and JS textareas in the iframe below
		onload=(document).onkeyup=function(){
			(document.getElementById("preview").contentWindow.document).write(
				htmlEditor.getValue()
				+ "<style>" + cssEditor.getValue() + "<\/style>"
				+ "<script>" + jsEditor.getValue() + "<\/script>"
				+ "<script src='" + + "'><\/script>"
			);
			(document.getElementById("preview").contentWindow.document).close();
			
			//Save Browser session storage
			//sessionStorage['html'] = htmlEditor.getValue();
			//sessionStorage['css'] = cssEditor.getValue();
			//sessionStorage['js'] = jsEditor.getValue();
			
			//jQuery("#count-characters-html").html(htmlEditor.getValue().length);
			//jQuery("#count-characters-css").html(cssEditor.getValue().length);
			//jQuery("#count-characters-js").html(jsEditor.getValue().length);
			
			
		};
  
		// Clear textareas with button
		jQuery(".clearLink").click(clearAll);

		function clearAll(){
		
			//clear Editors
			htmlEditor.setValue("");
			cssEditor.setValue("");
			jsEditor.setValue("");
			
			//clear Preview
			(document.getElementById("preview").contentWindow.document).write(
			htmlEditor.getValue()
			+ "<style>" + cssEditor.getValue() + "<\/style>"
			+ "<script>" + jsEditor.getValue() + "<\/script>"
			+ "<script src=''><\/script>"
			);
			(document.getElementById("preview").contentWindow.document).close()

			//clear Browser session storage
			sessionStorage['html'] = "";
			sessionStorage['css'] = "";
			sessionStorage['js'] = "";

			//sessionStorage.clear();
		}
	});

	// Initialize HTML Editor
    var htmlEditor = ace.edit("editorhtml");
    htmlEditor.setTheme("ace/theme/twilight");
    htmlEditor.getSession().setMode("ace/mode/html");
	
	// Initialize CSS Editor
    var cssEditor = ace.edit("editorcss");
    cssEditor.setTheme("ace/theme/twilight");
    cssEditor.getSession().setMode("ace/mode/css");
	
	// Initialize JS Editor
    var jsEditor = ace.edit("editorjs");
    jsEditor.setTheme("ace/theme/twilight");
    jsEditor.getSession().setMode("ace/mode/javascript");
	
	htmlEditor.getSession().on('change', function () {
        //Save Browser session storage
		sessionStorage['html'] = htmlEditor.getValue();
		
		//Save HTML
		jQuery("#bit_html").val(htmlEditor.getValue());
		
		// Count Characters
		jQuery("#count-characters-html").html(htmlEditor.getValue().length);
		// Count Lines
		jQuery("#count-lines-html").html(htmlEditor.session.getLength());
		// Cursor Position
		var curHtml = htmlEditor.selection.getCursor();
		jQuery("#cursor-position-html").html((curHtml["row"] + 1) + ":" + (curHtml["column"] + 1));
    });
	
	cssEditor.getSession().on('change', function () {
        //Save Browser session storage
		sessionStorage['css'] = cssEditor.getValue();
		
		//Save CSS
		jQuery("#bit_css").val(cssEditor.getValue());
		
		// Count Characters
		jQuery("#count-characters-css").html(cssEditor.getValue().length);
		// Count Lines
		jQuery("#count-lines-css").html(cssEditor.session.getLength());
		// Cursor Position
		var curCss = cssEditor.selection.getCursor();
		jQuery("#cursor-position-css").html((curCss["row"] + 1) + ":" + (curCss["column"] + 1));
    });
	
	jsEditor.getSession().on('change', function () {
        //Save Browser session storage
		sessionStorage['js'] = jsEditor.getValue();
		
		//Save JS
		jQuery("#bit_js").val(jsEditor.getValue());
		
		// Count Characters
		jQuery("#count-characters-js").html(jsEditor.getValue().length);
		// Count Lines
		jQuery("#count-lines-js").html(jsEditor.session.getLength());
		// Cursor Position
		var curJs = jsEditor.selection.getCursor();
		jQuery("#cursor-position-js").html((curJs["row"] + 1) + ":" + (curJs["column"] + 1));
    });

	
	function init() {
		<?php 
		if($bit_id){
			if ($html) {
				echo "htmlEditor.setValue(jQuery(\"#html_temp\").val());";
			}
			if ($css) {
				echo "cssEditor.setValue(jQuery(\"#css_temp\").val());";
			}
			if ($js) {
				echo "jsEditor.setValue(jQuery(\"#js_temp\").val());";
			}
		} else {
		?>
			if (sessionStorage["html"]) {
				htmlEditor.setValue(sessionStorage["html"]);
			} else{
				htmlEditor.setValue("");	
			}
			if (sessionStorage["css"]) {
				cssEditor.setValue(sessionStorage["css"]);
			} else{
				cssEditor.setValue("");
			}
			if (sessionStorage["js"]) {
				jsEditor.setValue(sessionStorage["js"]);
			} else{
				jsEditor.setValue("");
			}
		<?php
		}
		?>
	};
	init();

</script>
<style>
#postcustom.fullscreen {
	position: absolute;
    display: block;
    overflow: hidden;
    height: 100%;
    top: 0;
    right: 0;
    bottom: -20px;
    left: -20px;
    z-index: 99;
}
#postcustom.fullscreen #preview{
    height: 100%;
}
#jsdiv.fullscreen {
	position: absolute;
    display: block;
    overflow: hidden;
    height: 100%;
    top: 0;
    right: 0;
    bottom: -20px;
    left: -20px;
    z-index: 99;
}
#jsdiv.fullscreen #editor-js,
#jsdiv.fullscreen #editorjs{
    height: 92%;
}

#postcustom.fullscreen .inside {
    height: 100%;
}

#postcustom.fullscreen #postcustomstuff{
    height: 100%;
}

</style>
</body>
</html>

  
