<?php
/*
Plugin Name: Restful Blocks
Plugin URI: https://github.com/zamanehmedia/restful-blocks
Description: Extract all metadata from all Gutenberg blocks inside a post
Version: 1.0.0
Requires at least: 5.0
Requires PHP: 5.6
Author: Marcel Oomens
Author URI: https://en.radiozamaneh.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Text Domain: restful-blocks
Domain Path: /languages
*/

// Register the languages
add_action( 'init', 'restful_blocks_init' );
function restful_blocks_init() {
    load_plugin_textdomain('restful-blocks', false, dirname(plugin_basename(__FILE__)).'/languages');
}

// Include all source code
include_once 'src/load.php';

// Initialize hooks
\Zamaneh\RestfulBlocks\RESTHooks::init();

// That's it... Enjoy!
