<?php
/*
Plugin Name: Block Metadata
Version: 1.0.0
Description: Extract all metadata from all Gutenberg blocks inside a post
Plugin URI: https://github.com/leoloso/block-metadata
Author: Leonardo Losoviz
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