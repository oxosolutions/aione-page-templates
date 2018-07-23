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
			<h3>HTML Tags</h3>
			<input class="search" placeholder="Search HTML Tags" />
			<ul class="list">
				<?php 
				$args = array(
					'orderby'			=> 'title',
					'order'				=> 'ASC',
					'post_type'			=> 'html-tag',
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
				$before_tag = "&lt;";
				$after_tag = "&gt;";
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<div class="feature-block" id="'.the_slug().'tag">';
						echo '<h1 class="feature-block-title">HTML '.$before_tag.the_slug().$after_tag.' Tag</h1>';
						echo '<div class="feature-block-content">';
						echo '<div class="feature-block-desc">';
						echo get_the_content();
						echo '</div>';
						
						echo '<div class="feature-block-example feature-box closed">';
						echo '<h1 class="feature-box-title">Live Example for HTML '.$before_tag.the_slug().$after_tag.' Tag</h1>';
						echo '<div class="feature-box-content">';
						
						global $switched;
						switch_to_blog(1);
						$bit_title = strtolower(the_slug()).'tag';
						$bit = get_page_by_title( $bit_title, 'OBJECT', 'bit' );
						$value = get_field( "html", $bit->ID );
						echo '<textarea disabled="true" class="codebox">';
						echo $value;
						echo "</textarea>";
						//print_r($bit);
						//echo "BIT-ID : ".$bit->ID;

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
				#sidebar {
					background-color: #fff;
					margin-top: 10px;
				}
				#content {
					width: 76%;
					float: right;
					margin-top: 10px;
				}
				.feature-block{
					background-color: #fff;
					padding: 10px;
					margin-bottom: 10px;
				}
				.section__index #cat_JS_API{
					float: left !important;
					margin-right: 3% !important;
				}
				.section__index h3{
					color: #ba2f00;
				}
				.codebox{
					border: none;
					margin: 0;
					padding:0;
					width: 100%;
					min-width:600px;
					height: 100%;
					min-height:300px;
					background-color: white;
					font-family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;
					margin-bottom: 10px;
					overflow: auto;
					width: auto;
				}
				.feature-box{
					border: 1px solid #e8e8e8;
					margin: 20px 0 10px 0;
				}
				.feature-box.closed {
					border-bottom:none;
				}
				.feature-box-title{
					border-bottom: 1px solid #e8e8e8;
					margin: 0;
					padding: 0 8px 0 10px;
					display: block;
					font-size: 16px;
					line-height: 32px;
					cursor: pointer;
				}
				.feature-box-content{
					padding: 20px;
				}
				.feature-box-title:before{
					content: '';
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
				.feature-box-title.open:before{
					content: '';
					width: 2px;
					height: 0px;
					margin-top: 15px;
				}
				.feature-box-title:after{
					content: '';
					float: right;
					background-color: #666666;
					width: 16px;
					height: 2px;
					margin-top: 15px;
					
				}
				.feature-block-desc {
	                  line-height: 32px;
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
			
				<div style="width:99%;border:1px solid grey;padding:3px;margin:0px;background-color:#fff" class="feature-block" id="page">&lt;html&gt;
				<div style="width:90%;border:1px solid grey;padding:3px;margin:20px">&lt;head&gt;
				<div style="width:90%;border:1px solid grey;padding:5px;margin:20px">&lt;title&gt;Page title&lt;/title&gt;
				</div>
				&lt;/head&gt;
				</div>
				<div style="width:90%;border:1px solid grey;padding:3px;margin:20px;background-color:#fff">&lt;body&gt;
				<div style="width:90%;border:1px solid grey;padding:5px;margin:20px">&lt;h1&gt;This is a heading&lt;/h1&gt;</div>
				<div style="width:90%;border:1px solid grey;padding:5px;margin:20px">&lt;p&gt;This is a paragraph.&lt;/p&gt;</div>
				<div style="width:90%;border:1px solid grey;padding:5px;margin:20px">&lt;p&gt;This is another paragraph.&lt;/p&gt;</div>
				&lt;/body&gt;
				</div>
				&lt;/html&gt;
				</div>
				
				
				
				
				<section style="display: block; color:black;" class="secondary-content  section__index  clearfix js-section-index">
			<div class="heading">
				<h3 class="ciu-section-heading">What is HTML?</h3>
				<p class="">
			   
				HTML is a markup language for describing web documents (web pages).
				<br/>
				HTML stands for Hyper Text Markup Language
				<br/>
				A markup language is a set of markup tags<br/>
				HTML documents are described by HTML tags<br/>
				Each HTML tag describes different document content<br/>
				<a href="#page"class="page">HTML Page Structure</a>


				</p>
				</div>
			
				<div class="col">
				
				
				<div id="cat_JS_API">
				<h3>HTML Forms</h3>
				<ol>
				<li> <a href="#form" class="form">HTML Forms</a></li>
				<li> <a href="#FormElements" class="FormElements">HTML Form Elements</a></li>
				<li> <a href="#inputTypes" class="inputTypes">HTML Input Types</a>
				<ul id="inputTypes1" class="feature-block1">
				<li><a href="#text" class="text">Input Type: text</a></li>
				<li><a href="#password" class="password">Input Type: password</a></li>
				<li><a href="#submit" class="submit">Input Type: submit</a></li>
				<li><a href="#radio" class="radio">Input Type: radio</a></li>
				<li><a href="#checkbox" class="checkbox">Input Type: checkbox</a></li>
				<li><a href="#button" class="button">Input Type: button</a></li>
				<li><a href="#number" class="number">Input Type: number</a></li>
				<li><a href="#date" class="date">Input Type: date</a></li>
				<li><a href="#color" class="color">Input Type: color</a></li>
				<li><a href="#range" class="range">Input Type: range</a></li>
				<li><a href="#month" class="month">Input Type: month</a></li>
				<li><a href="#week" class="week">Input Type: week</a></li>
				<li><a href="#time" class="time">Input Type: time</a></li>
				<li><a href="#datetime" class="datetime">Input Type: datetime</a></li>
				<li><a href="#email" class="email">Input Type: email</a></li>
				<li><a href="#search" class="search">Input Type: search</a></li>
				<li><a href="#tel" class="tel">Input Type: tel</a></li>
				<li><a href="#url" class="url">Input Type: url</a></li>
				</ul>
				</li>
				<li> <a href="#InputAttributes" class="InputAttributes">HTML Input Attributes</a>
				<ul id="inputTypes1" class="feature-block1">
				<li><a href="#value" class="value">The value Attribute</a></li>
				<li><a href="#disabled" class="disabled">The disabled Attribute</a></li>
				<li><a href="#size" class="size">The size Attribute</a></li>
				<li><a href="#maxlength" class="maxlength">The maxlength Attribute</a></li>
				<li><a href="#autocomplete" class="autocomplete">The autocomplete Attribute</a></li>
				
				<li><a href="#autofocus" class="autofocus">The autofocus Attribute</a></li>
				<li><a href="#formAttribute" class="formAttribute">The form Attribute</a></li>
				<li><a href="#formaction" class="formaction">The formaction Attribute</a></li>
				<li><a href="#formenctype" class="formenctype">The formenctype Attribute</a></li>
				<li><a href="#formmethod" class="formmethod">The formmethod Attribute</a></li>
				<li><a href="#formnovalidate" class="formnovalidate">The formnovalidate Attribute</a></li>
				<li><a href="#formtarget" class="formtarget">The formtarget Attribute</a></li>
				<li><a href="#heightandwidth" class="heightandwidth">The height and width Attributes</a></li>
				<li><a href="#list" class="list">The list Attribute</a></li>
				<li><a href="#minandmax" class="minandmax">The min and max Attributes</a></li>
				<li><a href="#multiple" class="multiple">The multiple Attribute</a></li>
				<li><a href="#pattern" class="pattern">The pattern Attribute</a></li>
				<li><a href="#placeholder" class="placeholder">The placeholder Attribute</a></li>
				<li><a href="#required" class="required">The required Attribute</a></li>
				<li><a href="#step" class="step">The step Attribute</a></li>
				</ul>
				</li>
				</ol>
				
				
	            </div>
				
				<div id="cat_JS_API">
				<h3>HTML Styles</h3>
				<ol>
				<li><a href="#StyleAttributes" class="StyleAttributes">HTML Style Attributes</a></li>
				<li><a href="#TextColor" class="TextColor">HTML Text Color</a></li>
				<li><a href="#HTMLFonts" class="HTMLFonts">HTML Fonts</a></li>
				<li><a href="#TextSize" class="TextSize">HTML Text Size</a></li>
				<li><a href="#TextAlignment" class="TextAlignment">HTML Text Alignment</a></li>
				</ol>
				
				<h3>HTML Lists</h3>
				<ol>
				<li><a href="#UnorderedLists" class="UnorderedLists">Unordered HTML Lists</a></li>
				<li><a href="#OrderedLists" class="OrderedLists">Ordered HTML Lists</a></li>
				<li><a href="#Description" class="Description">HTML Description Lists</a></li>
				<li><a href="#NestedLists" class="NestedLists">Nested HTML Lists</a></li>
				<li><a href="#HorizontalLists" class="HorizontalLists">Horizontal Lists</a></li>
				</ol>
				
				<h3>HTML Comments</h3>
				<ol>
				<li><a href="#CommentTags" class="CommentTags">HTML Comment Tags</a></li>
				<li><a href="#Conditional" class="Conditional">Conditional Comments</a></li>
	            </ol>
				<h3>HTML Attributes</h3>
				<ol>
				<li> <a href="#langAttributes" class="langAttributes">lang Attribute</a></li>
				<li> <a href="#titleAttributes" class="titleAttributes">title Attribute</a></li>
				<li> <a href="#hrefAttributes" class="hrefAttributes">href Attribute</a></li>
				<li> <a href="#SizeAttributes" class="SizeAttributes">Size Attributes</a></li>
				<li> <a href="#altAttribute" class="altAttribute">alt Attribute</a></li>
				
				</ol>
				
				<!--<h3>HTML Blocks</h3>
				<ol>
				<li><a href="" class="">Block-level Elements</a></li>
				<li><a href="" class="">Inline Elements</a></li>
				<li><a href="" class="">The &lt;div&gt; Element</a></li>
				<li><a href="" class="">The &lt;span&gt; Element</a></li>
				<li><a href="" class="">HTML Grouping Tags</a></li>
	            </ol>-->
				
		        </div>
				
				<div id="cat_JS_API">
				<h3>HTML Images</h3>
				<ol>
				<li><a href="#ImagesSyntax" class="ImagesSyntax">HTML Images Syntax</a></li>
				<li><a href="#alt" class="alt">The alt Attribute</a></li>
				<li><a href="#WidthandHeight" class="WidthandHeight">Image Size - Width and Height</a></li>
				<li><a href="#AnimatedImages" class="AnimatedImages">Animated Images</a></li>
				<li><a href="#Link" class="Link">Using an Image as a Link</a></li>
				<li><a href="#Floating" class="Floating">Image Floating</a></li>
				<li><a href="#Maps" class="Maps">Image Maps</a></li>
				</ol>
				
				<h3>HTML Tables</h3>
				<ol>
				<li><a href="#HTMLTables" class="HTMLTables">Defining HTML Tables</a></li>
				<li><a href="#TableAttribute" class="TableAttribute">An HTML Table with a Border Attribute</a></li>
				<li><a href="#TableBorders" class="TableBorders">An HTML Table with Collapsed Borders</a></li>
				<li><a href="#TablePadding" class="TablePadding">An HTML Table with Cell Padding</a></li>
				<li><a href="#TableHeadings" class="TableHeadings">HTML Table Headings</a></li>
				<li><a href="#TableSpacing" class="TableSpacing">An HTML Table with Border Spacing</a></li>
				<li><a href="#TableColumns" class="TableColumns">Table Cells that Span Many Columns</a></li>
				<li><a href="#TableRows" class="TableRows">Table Cells that Span Many Rows</a></li>
				<li><a href="#TableCaption" class="TableCaption">An HTML Table With a Caption</a></li>
				<li><a href="#StyleTable" class="StyleTable">A Special Style for One Table</a></li>
				</ol>
				
				<h3>HTML Formatting</h3>
				<ol>
				<li><a href="#Formatting" class="Formatting">HTML Formatting Elements</a></li>
				<li><a href="#BoldandStrong" class="BoldandStrong">HTML Bold and Strong Formatting</a></li>
				<li><a href="#Italic" class="Italic">HTML Italic and Emphasized Formatting</a></li>
				<li><a href="#Small" class="Small">HTML Small Formatting</a></li>
				<li><a href="#Marked" class="Marked">HTML Marked Formatting</a></li>
				<li><a href="#Deleted" class="Deleted">HTML Deleted Formatting</a></li>
				<li><a href="#Inserted" class="Inserted">HTML Inserted Formatting</a></li>
				<li><a href="#Subscript" class="Subscript">HTML Subscript Formatting</a></li>
				<li><a href="#Superscript" class="Superscript">HTML Superscript Formatting</a></li>
				
				</ol>
				
				<!--<h3>HTML Quotations</h3>
				<ol>
				<li><a href="" class="">HTML &lt;q&gt; for Short Quotations</a></li>
				<li><a href="" class="">HTML &lt;blockquote&gt; for Long Quotations</a></li>
				<li><a href="" class="">HTML &lt;abbr&gt; for Abbreviations</a></li>
				<li><a href="" class="">HTML &lt;address&gt; for Contact Information</a></li>
				<li><a href="" class="">HTML &lt;cite&gt; for Work Title</a></li>
				<li><a href="" class="">HTML &lt;bdo&gt; for Bi-Directional Override</a></li>
				<li><a href="" class="">HTML Quotation and Citation Elements</a></li>
				
				</ol>-->
		        </div>
            	</div>	
                </section>
		</div>
	</div>
	<div class="oxo-clearfix"></div>
	<!------------------ CONTENT ENDS ------------------>
</div>
<!------------------ MAIN ENDS ------------------>

<?php 
include("includes/footer.php");
?>