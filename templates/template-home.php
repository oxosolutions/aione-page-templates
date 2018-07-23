<?php
/**
 * Template Name: Darlic Home
 */
 ?>

 <?php
	$pte = Page_Template_Plugin::get_instance();
	$locale = $pte->get_locale();
	
	include("includes/header.php");
?>

<!------------------ MAIN STARTS ------------------>
<div id="main" class="main">
	<!------------------ SIDEBAR STARTS ------------------>
	<?php get_sidebar(); ?>
	<!------------------ SIDEBAR ENDS ------------------>
	<!------------------ CONTENT STARTS ------------------>
	<div id="content" class="content">
		<div id="main_content" class="main_content" >
			<div class="post-content">
				<?php
				if(have_posts()): 
				the_post();
				the_content();
				wp_link_pages(); 
				endif;
				wp_reset_query();
				?>
			</div>
        
		</div>
	</div>
	<div class="aione-clearfix"></div>
	<!------------------ CONTENT ENDS ------------------>
</div>
<!------------------ MAIN ENDS ------------------>

<?php 
include("includes/footer.php");
?>
<style>

#sidebar {
	width:20%;
	float: left;
}
#content {
	width: 80%;
	float: left;
}
#main_content {
	background-color: #fff;
    margin-top: 10px;
    margin-left: 10px;
}
#sidebar .widget .heading h4{
    color: #138dc5;
    text-align: center;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
    margin: 0 0 15px 0;
    padding: 12px 0;
}
#sidebar .widget {
margin-bottom: 30px;
background-color: #fff;
    margin-top: 10px;
}
    

#sidebar ul.menu{
	list-style: none;
}
#sidebar ul.menu li a{
    color: #ba2f00;
    text-decoration: none;
    padding: 6px 10px;
    border-bottom: 1px dotted #e8e8e8;
    display: block;
}
.aione-column.one_third , .oxo-one-third.oxo-layout-column{
	width: 32%;
	float: left;
	box-sizing: border-box;
	border: 1px solid #E5E5E5;
	box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.4);
	margin: 0px 2% 20px 0px;
	/* padding: 20px; */
}
.aione-column.one_third .aione-title.title ,  .oxo-one-third.oxo-layout-column .oxo-title.title{
	margin-top: -15px;
}
#hometabs .title-heading-center {
	font-family: "Open Sans",Arial,Helvetica,sans-serif;
	font-weight: 100;
	transition: all 0.2s ease-in-out 0s;
	display: block;
	float: none;
	text-align: center;
	white-space: pre;
	line-height: 20px;
	padding: 10px 0px;
	border-bottom: 1px solid #11B2FC;
	background-color: #4C9ED9;
	color: #FFF;
}
#hometabs .one_third p , #hometabs .oxo-one-third p{
	text-align: center;
	line-height: 20px;
}
#hometabs .one_third a , #hometabs .oxo-one-third a {
	background: #F2F2F2 none repeat scroll 0px 0px;
	box-shadow: none;
	display: block;
	font-size: 18px;
	font-weight: 100;
	line-height: 38px;
	padding: 0px;
	text-align: center;
	text-decoration: none;
	text-shadow: none;
	text-transform: none;
	transition: all 0.2s ease 0s;
	visibility: visible;
	width: 50%;
	margin: 20px auto auto;
	color: #000;
	border-radius: 20px;
	border: 1px solid #4C9ED9;
}
#hometabs .one_third a:hover , #hometabs .oxo-one-third a:hover {
	background-color: #FFF;
	border: 1px solid #BA2F00;
}
#hometabs .title-heading-center::after {
	background-color: #666;
	content: "";
	display: block;
	height: 4px;
	margin: 0px auto;
	top: 13px;
	transition: all 0.2s ease-in-out 0s;
	/* width: 50px; */
	position: relative;
}
#hometabs .title-heading-center:hover::after {
	background-color: #12719E;
	content: "";
	display: block;
	height: 4px;
	margin: 0px auto;
	top: 13px;
	transition: all 0.2s ease-in-out 0s;
	width: 100%;
}
.aione-column.one_third.last , .oxo-one-third.oxo-layout-column.oxo-column-last{
    margin-right: 0;
}
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
.w3-table-all {
    border: 1px solid #ccc;
}
.w3-table-all table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    display: table;
}
.w3-table-all tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}
.w3-table-all tr:nth-child(odd) {
    background-color: #fff;
}
.w3-bordered tr, .w3-table-all tr {
    border-bottom: 1px solid #d0d0d0;
}
tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}
.w3-table td, .w3-table th, .w3-table-all td, .w3-table-all th {
    padding: 6px 8px;
    display: table-cell;
    text-align: left;
    vertical-align: top;

</style>