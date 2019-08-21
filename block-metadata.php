<?php
/*
Plugin Name: Block Metadata
Plugin URI: https://github.com/leoloso/block-metadata
Description: Extract all metadata from all Gutenberg blocks inside a post
Version: 1.0.0
Author: Leonardo Losoviz
Author URI: https://leoloso.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

// Register the languages
add_action( 'init', 'block_metadata_init' );
function block_metadata_init() {
    load_plugin_textdomain('block-metadata', false, dirname(plugin_basename(__FILE__)).'/languages');
}

// Include all source code
include_once 'src/load.php';

// Initialize hooks
\Leoloso\BlockMetadata\RESTHooks::init();

// That's it... Enjoy!