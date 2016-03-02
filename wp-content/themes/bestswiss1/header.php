<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?php wp_title(); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/reset.css" type="text/css" media="screen" />
<link rel="stylesheet/less" href="<?php bloginfo('stylesheet_directory'); ?>/style.less" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Baumans' rel='stylesheet' type='text/css'/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/2.1.4.jquery.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/modernizr.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/respond.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/prefixfree.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/less.js" type="text/javascript"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/familybrowser.js"></script>
</head>
<?php wp_head(); ?>
<body>
<header>
<div id="headerwrap">
	<a href="<?php bloginfo('url'); ?>" title="Bestswiss.ch" id="sitelogo">Bestwiss</a>
	<!--<div id="sitelogo" href="<?php bloginfo('url'); ?>"><a style="text-decoration:none;" href="<?php bloginfo('url'); ?>"><h1><?php bloginfo('name'); ?></h1></a></div>-->
	<div id="siteclaim"><p class="test"><?php bloginfo('description'); ?></p></div>
	<div id="pnav"><nav class="primary"><?php wp_nav_menu( array( 'theme_location' => 'main' ) ); ?></nav></div>
</div>
</header>
</div>
<div id="contentwrap">

