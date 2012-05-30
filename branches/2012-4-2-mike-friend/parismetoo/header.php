<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php
	/*
	* Print the <title> tag based on what is being viewed.
	*/
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
	echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
	echo ' | ' . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );

	?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/less" href="<?php echo get_template_directory_uri() ?>/css/style.less" media="all">
	<!--[if IE 6]>
	<link href="<?php echo get_template_directory_uri() ?>/css/ie6.min.css" rel="stylesheet">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="<?php bloginfo( 'name' ); ?>">
	<meta name="msapplication-tooltip" content="<?php bloginfo( 'description' ); ?>">
	<meta name="author" content="Dazake">
	<meta name="copyright" content="Copyright Dazake 2012. All Rights Reserved.">	

	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/images/apple-touch-icon.png">
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php wp_head(); ?>
	
	</head>

<body <?php body_class(); ?>>
	<!-- <embed src="<?php bloginfo('template_url'); ?>/music/helene.mp3" autostart="true" loop="true" hidden="true"> -->
	<div class="container">
		<!-- #header -->
		<div id="header">
			<div id="logoarea">
				<span class="span4 offset4">
					Parismetoo
					<!-- <img src="" alt="" id="logoimg"> -->
				</span>
			</div>
			
			<div id="menucontainer" class="<?php if(is_home()){echo "menuActive";} ?>">
				<?php
					if(function_exists('wp_nav_menu')):
							wp_nav_menu(
									array(
									'menu' =>'primary_nav',
									'container'=>'',
									'depth' => 1,
									'menu_id' => 'menu' )
							);
					else:
				?>
					<ul id="menu">
						<?php wp_list_pages('title_li=&depth=1'); ?>
					</ul>
				<?php
					endif;
				?>
				<ul id="picmenu">
					<li><span id="pichome" class="eachpicmenu"></span></li>
					<li><span id="picabout" class="eachpicmenu"></span></li>
					<li><span id="picworks" class="eachpicmenu"></span></li>
					<li><span id="picprice" class="eachpicmenu"></span></li>
					<li><span id="picflow" class="eachpicmenu"></span></li>
					<li><span id="picgallery" class="eachpicmenu"></span></li>
					<li><span id="piccontact" class="eachpicmenu"></span></li>
				</ul>
			</div>
			<div id="qqcontact">
				<div class="row">
					<div class="span3 offset9">
						<a href="" ><img id="qqboy" class="qqcontact" title="Vincent" src="<?php bloginfo('template_url'); ?>/images/qqboy.png" alt=""></a>
						<a href="" ><img id="qqgirl" class="qqcontact" title="Marie" src="<?php bloginfo('template_url'); ?>/images/qqgirl.png" alt=""></a>
					</div>
				</div>
			</div>
		</div>
		<!-- end #header -->

		<!-- #main -->
		<div id="main">
	