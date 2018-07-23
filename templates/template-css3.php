<?php
/**
 * Template Name: Learn Html
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
<!------------------ MAIN STARTS ------------------>
<div id="main" class="main">
	<!------------------ SIDEBAR STARTS ------------------>
	<aside id="sidebar" class="sidebar">
		<div id="html-tags-list">
			<h3>CSS3 Properties</h3>
			<input class="search" placeholder="Search CSS Properties" />
			<ul class="list">
				<?php 
				$args = array(
					'orderby'			=> 'date',
					'order'				=> 'ASC',
					'post_type'			=> 'css3-property',
					'post_status'		=> 'publish',
					'posts_per_page'	=> -1
				);
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<li><a href="#'.the_slug().'tag" class="'.the_slug().'tag"> <span class="htmltaglistitem">' . get_the_title().'</span></a></li>';
					}
				} else {
					echo "No Tags";
				}
				/* Restore original Post Data */
				wp_reset_postdata();
				?>
			</ul>
		</div>
	</aside>
	<!------------------ SIDEBAR ENDS ------------------>
	<!------------------ CONTENT STARTS ------------------>
	<div id="content" class="content">
		<div id="main_content" class="main_content" >
				<?php
			
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<div class="feature-block" id="'.the_slug().'tag">';
						echo '<h1 class="feature-block-title">CSS3 '.the_slug().' Property</h1>';
						echo '<div class="feature-block-content">';
						echo '<div class="feature-block-desc">';
						echo get_the_content();
						echo '</div>';
						
						echo '<div class="feature-block-example feature-box closed">';
						echo '<h1 class="feature-box-title">Live Example for CSS3 '.the_slug().' Property</h1>';
						echo '<div class="feature-box-content">';
						
						global $switched;
						switch_to_blog(1);
						$bit_title = 'css3-'.strtolower(the_slug()).'-property';
						$bit = get_page_by_title( $bit_title, 'OBJECT', 'bit' );
						$value = get_field( "html", $bit->ID );
						echo '<textarea disabled="true" class="codebox">';
						echo $value;
						echo "</textarea>";

						restore_current_blog();

						echo '</div>';
						echo '</div>';
						
						echo '<div class="feature-block-tabs">';
						echo "";
						echo '</div>';

						echo '</div>';
						echo '</div>';
					}
				}
				wp_reset_postdata();
				?>
				<style>
				.feature-box{
					border: 1px solid #e8e8e8;
					margin: 20px 0 10px 0;
				}
				.feature-box-title{
					border-bottom: 1px solid #e8e8e8;
					margin: 0;
					padding: 0 8px 0 10px;
					display: block;
					font-size: 16px;
					line-height: 32px;
				}
				.feature-box-content{
					padding: 20px;
				}
				.feature-box-title:before{
					content: '';
					cursor: pointer;
					float: right;
					background-color: #666666;
					width: 2px;
					height: 16px;
					margin-top: 8px;
					right: 9px;
					position: relative;
					
					-webkit-transition: all 0.2s ease-in-out;
					-moz-transition: all 0.2s ease-in-out;
					-o-transition: all 0.2s ease-in-out;
					transition: all 0.2s ease-in-out;
					
				}
				.feature-box-title.minus:before{
					content: '';
					width: 2px;
					height: 0px;
					margin-top: 15px;
				}
				.feature-box-title:after{
					content: '';
					cursor: pointer;
					float: right;
					background-color: #666666;
					width: 16px;
					height: 2px;
					margin-top: 15px;
				}
				.codebox {
	border: medium none;
	margin: 0px 0px 10px;
	padding: 0px;
	min-width: 600px;
	height: 100%;
	min-height: 300px;
	background-color: #FFF;
	font-family: Consolas,Menlo,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New,monospace,serif;
	overflow: auto;
	width: auto;
}
				</style>
			<section style="display: block; color:black;" class="secondary-content  section__index  clearfix js-section-index">
			
			<div class="info-about">
                    <h3 class="ciu-section-heading">What is CSS ?</h3>

                    <p>CSS is an acronym for Cascading Style Sheets.</p>
					<p>CSS is a style sheet language used for describing the look and formatting of a document written in a markup language.</p>

                    

                    <h3 class="ciu-section-heading">USE</h3>
					<p>CSS is a style language that defines layout of HTML documents. For example, CSS covers fonts, colours, margins, lines, height, width, background images, advanced positions and many other things. Just wait and see!</p>

					<p>HTML can be (mis-)used to add layout to websites. But CSS offers more options and is more accurate and sophisticated. CSS is supported by all browsers today.</p>
					
                   <h3 class="ciu-section-heading">3 Type Of CSS Style</h3>
				   <p>
				   1.<a href="#">Internal(Embedded)Styles:</a> Internal Styles are defined in the &lt;head&gt; section of the "current" web page.<br/>
				   2.<a href="#">Inline Styles:</a> Inline Styles are defined within the HTMl markup of the particular page element. <br/>
				   3.<a href="#">External Styles:</a> External Styles are defined on the external style sheet, which is linked to the web page(s).(Best choice)<br/>
				   </p>
				   <h3 class="internal-heading">Internal(Embedded)Styles</h3>
				   <p class="internal-para"> 
				   Internal Styles are placed inside the 
				   <code>head</code>
				  section of a particular web page via the style tag. 
				   </p>
				   <ul>
				<li class="listitem-style">Internal Styles are placed inside 
					the &lt;head&gt; section of a particular web page via the style 
					tag.&nbsp; &lt;style type="text/css"&gt;&lt;/style&gt;</li>
				<li class="listitem-style">These Styles can be used only for the web page in 
					which they are embedded.&nbsp; </li>
				<li class="listitem-style">Therefore, you would need to create these styles over 
					and over again for each web page you wish to style.</li>
				<li class="listitem-style">&nbsp;When using the style builder 
					in Expression Web, Define the style in 
					the <span class="bold-red">Current Page.</span>&nbsp;&nbsp; This will 
					create an Internal Style. </li>
				<li class="listitem-style">Advanced Use of Internal Styles 
					unless you need to override an External Style.&nbsp; </li>
			</ul>
			<p><span class="bold-wine">Example:</span></p>
			<div class="highlight-code">
			<p>
			&lt;head&gt;<br/>
			&lt;meta content="text/html; charset=utf-8" http-equiv="content-type"&gt;<br/>
             &lt;title&gt;Untitled 1&lt;/title&gt;<br/><br/>
             &lt;style type="text/css"&gt;<br/>
                 #video-gallery{<br/>
			          width:350px;<br/>
			          padding:12px;<br/>
			          margin:15px auto;<br/>
			      } 	<br/>		 
			  &lt;/style&gt;<br/><br/>
			  &lt;/head&gt;<br/>
			  
			</p>
			</div>
			
			<h3 class="internal-heading">2. Inline Styles</h3>
			<p>Inline Styles cannot be resused at all, period.&nbsp; Inline 
				styles are placed directly inside an HTML element in the code.&nbsp; 
				We cannot use the Style Builder to make an Inline Style. 
				Instead, to purposely create an inline style requires you to go 
				into the HTML code and type the style yourself. </p>
			<p><span class="text-shadow">Example of an Inline Style: </span></p>
			<p class="code-example"><span class="bold-wine">&lt;p </span>
			<span class="small-text"><strong>style="font-size: 14px; color: purple;"</strong></span><span class="bold-wine">&gt;&lt;/p&gt;</span></p>
			<h3 class="internal-heading">3. External Style Sheet</h3>
			<p>For the most part, we will want to place the majority of our 
				Style Rules on an External Style Sheet.&nbsp; This will allow us 
				to <strong>reuse the styles</strong> as many times as we would 
				like simply by linking the External Style Sheet to other web 
				pages.&nbsp; <em>It also means we only have to create the Styles one time!</em></p>
			<div class="content-box">
					&lt;head&gt;<br>&lt;title&gt;The Title&lt;/title&gt;<br><br>
				<span class="bold-wine">&lt;link href="main.css" 
				rel="stylesheet" type="text/css" &gt;</span><br><br>&lt;/head&gt;</div>
			
                </div>
				
                </section>
		</div>
	</div>
	<div class="clear"></div>
	<!------------------ CONTENT ENDS ------------------>
</div>
<!------------------ MAIN ENDS ------------------>

<?php 
include("includes/footer.php");
?>
<style>
#html-tags-list ul li a span::before {
	content: "";
	color: #666;
}
#html-tags-list ul li a span::after {
	content: "";
	color: #666;
}
.info-about {
	max-width: 60em;
	margin: 0px auto;
}
.info-about p{
	margin-top: 20px;
}
.info-about .internal-heading {
	text-align: center;
	font-size: 28px;
}
.info-about .internal-para {
	margin-left: 137px;
	font-size: 17px;
}
.info-about ul {
	font-size: 13px;
	line-height: 1.8;
	color: #222;
	padding: 10px;
	box-shadow: 1px 1px 2px #777;
	margin: 15px auto;
	width: 581px;
	background-color: #FFF;
	font-family: "Open Sans";
	font-weight: normal;
}
code {
	font-size: 105%;
	color: #DC143C;
	background-color: #F1F1F1;
	padding: 1px 4px;
}
.bold-wine {
	color: #C00;
	font-weight: bold;
	font-family: arial,Helvetica,sans-serif;
}
.highlight-code {
	box-shadow: 0px 0px 3px #838383;
	border: 2px solid #FFF;
	background-color: #F9F9F9;
	padding: 18px;
	margin: 22px 35px;
	text-align: left;
	font-size: 14px;
	color: #004080;
	line-height: 1.3;
}
.info-about p {
	line-height: 1.5;
	font-size: 17px;
}
.content-box {
	box-shadow: 0px 0px 3px #838383;
	border: 2px solid #FFF;
	background-color: #F9F9F9;
	padding: 18px;
	margin: 22px 35px;
	text-align: left;
	font-size: 14px;
	color: #004080;
	line-height: 1.3;
}

#html-tags-list .search {
	width: 92%;
	padding: 0px;
	margin: 10px 0px 10px 3%;
	line-height: 30px;
	text-indent: 10px;
	border-radius: 0px;
}

</style>