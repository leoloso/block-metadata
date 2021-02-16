<?php
/*
Plugin Name: Restful Blocks
Plugin URI: https://github.com/zamanehmedia/restful-blocks
Description: Extract all metadata from all Gutenberg blocks inside a post
Version: 1.1.0
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

if ( defined( 'REST_PER_PAGE_DEFAULT' ) || defined( 'REST_PER_PAGE_MAXIMUM' ) ) {
  $object_types = defined( 'REST_PER_PAGE_OBJECTS' ) ? explode(',', REST_PER_PAGE_OBJECTS) : array( 'post' );
  foreach ( $object_types as $type ) {
    // from https://wordpress.stackexchange.com/questions/281881/increase-per-page-limit-in-rest-api
    add_filter( "rest_${type}_collection_params", function( $query_params ) {
      defined( 'REST_PER_PAGE_DEFAULT' ) && $query_params['per_page']['default'] = REST_PER_PAGE_DEFAULT;
      defined( 'REST_PER_PAGE_MAXIMUM' ) && $query_params['per_page']['maximum'] = REST_PER_PAGE_MAXIMUM;
      // Sanity check
      if ($query_params['per_page']['maximum'] < $query_params['per_page']['default'])
        $query_params['per_page']['default'] = $query_params['per_page']['maximum'];
      return $query_params;
    } );
  }
}

// Include all source code
include_once 'src/load.php';

// Initialize hooks
\Zamaneh\RestfulBlocks\RESTHooks::init();

// That's it... Enjoy!
