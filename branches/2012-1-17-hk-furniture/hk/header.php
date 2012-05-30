<title>Ztem</title>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/main.js"></script>
<link href='http://fonts.googleapis.com/css?family=Lato|Open+Sans|Fresca|Iceberg' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" media="all">
</head>
<body>

<div id="header" class="justify">
	<div id="logo"><img src="<?php bloginfo('template_directory'); ?>/images/logo2.jpg" alt="" /></div>
	<!-- <div id="navi"> -->
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
	<!-- </div> -->
</div>
<div id="main" class="justify">
