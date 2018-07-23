<!DOCTYPE html>
<!-- saved from url=(0030)http://caniuse.com/#comparison -->
<html dir="ltr" lang="en-US" class=""><!--<![endif]--><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>

	<meta name="viewport" content="width=device-width">

    <link href="http://fonts.googleapis.com/css?family=Inconsolata|Open+Sans:300,700" rel="stylesheet">
	<link rel="icon" href="<?php bloginfo('url'); ?>/assets/images/favicon.png" sizes="16x16 32x32 64x64 128x128" type="image/png">
	<link rel="apple-touch-icon" href="<?php bloginfo('url'); ?>/assets/images/favicon.png">

	<meta name="keywords" content="web browser compatibility support html css svg html5 css3 opera chrome firefox safari internet explorer">

	<style>
	<?php 
		global $theme_content;
		echo $theme_content['custom_css']; 
		
		//Custom CSS for each page

		$c_pageID = Aione::c_pageID();
		$pyre_custom_css = get_post_meta( $c_pageID, 'pyre_custom_css', true );
		echo $pyre_custom_css;

			
	?>
	</style>

</head>
<body class="">
	<?php global $theme_options,  $main_menu;
	?>
	
	<div id="wrapper" class="wrapper">
	<?php if($theme_options['header_show_top_bar']): ?>
	  <div class='top-menu'>
			<ul id="snav" class="menu">
				<?php
				if ( has_nav_menu( 'top_navigation' ) ) {
					wp_nav_menu(array('theme_location' => 'top_navigation', 'depth' => 5, 'container' => false, 'menu_id' => 'snav', 'items_wrap' => '%3$s'));
				}
				?>
			</ul>
			<?php if(tf_checkIfMenuIsSetByLocation('top_navigation')): ?>
				<div class="mobile-topnav-holder"></div>
			<?php endif; ?>
		</div>
		<?php endif ?>
		<header id="header" class="header">
			<?php if($theme_options['header_show_logo']): ?>
			<div id="logo" class="logo" >
				<a href="<?php bloginfo('url'); ?>">
					<?php if($theme_options['logo']['url']): ?>
					<img src="<?php echo $theme_options['logo']['url']; ?>" alt="<?php bloginfo('name'); ?>" class="site_logo" />
					<?php endif; ?>
					<?php if($theme_options['logo_retina']['url']): ?>
					<img src="<?php echo $theme_options["logo_retina"]['url']; ?>" alt="<?php bloginfo('name'); ?>" class="site_logo ratina" />
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
				<?php 
					//echo $main_menu;
					if ( has_nav_menu( 'main_navigation' ) ) {
						wp_nav_menu(array('theme_location' => 'main_navigation', 'depth' => 5, 'container' => false, 'menu_id' => 'main_menu', 'items_wrap' => '%3$s'));
					}

				?>
				<?php
				if(is_user_logged_in()){?>
					<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home"><a href="http://darlic.com/account/">Account</a></li>
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

        </header> 
        
		<style>
		#logo {display: inline-block;}
		#main_search {display: inline-block;float: right;}
		.aione-clearfix , .oxo-clearfix{
			clear: both;
		    zoom: 1;
		}
		body {
			background-color: #d9d9d9;
		}
		.top-menu {
			display: block;
			width: 100%;
			background-color: #FFF;
			margin-top: 10px;
			border-bottom: 1px solid #E8E8E8;
		}
		.top-menu #snav {
			color: rgb(255, 255, 255);
			padding: 0;
    		margin: 0;
    		list-style: none;
    		display: block;
		}
		.top-menu ul li {
			font-size: 16px;
    		line-height: 1.33;
		}
		.top-menu > ul > li {
			position: relative;
    	display: inline-block;
    	float: left;
    	margin-right: 3px;
		}
		.top-menu > ul > li > a {
		    padding: 0 15px 0 15px;
		    margin: 0;
		    line-height: 40px;
		    display: inline-block;
		    background-color: rgba(0, 0, 0, 0.1);
		}
		.top-menu > ul > li > ul {
		    display: none;
		    position: absolute;
		    top: 100%;
		    left: 0;
		    background-color: #FFFFFF;
		    width: 300px;
		    z-index: 999;
		    border: 1px solid #e8e8e8;
		}
		.top-menu > ul > li > ul > li {
		    border-bottom: 1px solid #e8e8e8;
		}
		.top-menu > ul > li > ul > li > a {
		    padding: 0 10px;
		    line-height: 36px;
		    display: block;
		    font-size: 15px;
		}
		.top-menu > ul > li:hover > ul {
		    display: block;
		}
		.header {
			padding: 10px;
			margin-top: 0px;
			background-color: #FFF;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1) inset;
		}
		 #snav li::after {
			content: "/";
			color: rgb(186, 47, 0);
			position: absolute;
			right: 18px;
			top: 1px;
		}
		#snav li:last-child::after {
			content: "";
			display:none;
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