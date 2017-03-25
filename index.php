<?php  
	/*
		Plugin Name: Social Meta Tags
		Description: Share the right title, description, image for all new posts.
		Plugin URI: https://wordpress.org/plugins/facebook-ogg-meta-tags/
		Version: 1.7.1
		Author: Bassem Rabia
		Author URI: mailto:bassem.rabia@gmail.com
		License: GPLv2
	*/

	require_once(dirname(__FILE__).'/metaTags/metaTags.php');
	new metaTags('1.7.1');
?>