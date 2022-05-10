<?php
namespace Zamaneh\RestfulBlocks;

/**
 * Manages the REST hooks
 */
class RESTHooks {

    /**
     * Register the REST hooks
     */
    public static function init() {
        /**
         * Set up filters
         */
        \add_filter( 'Zamaneh\RestfulBlocks\RESTHooks::expandImageId', [Metadata::class, 'expand_image_id'] );
        
        /**
         * Define REST fields
         */
        \add_action( 'rest_api_init', function() {
            
            $allowed_objects = \apply_filters( 'Zamaneh\RestfulBlocks\RESTHooks::objectType', array( 'post', 'page' ) );
                        
            \register_rest_field( $allowed_objects, 'restful_blocks', array(
                'get_callback'      => [RESTHooks::class, 'get_blocks'],
                'update_callback'   => null,
                'schema'            => array(
                // Can we drop the field entirely unless it's explicitly requested with `_fields`?
                'description'     => __( 'Array of post block metadata. Empty unless explicitly requested with `_fields`.' ),
                'type'            => 'array'
            ),
            ) );

        } );
    }

    public static function get_blocks( $prepared, $attr, $request, $object_type ) {

      // Shortcut invocation if field is not explicitly requested for API request
      if ( ! array_key_exists( '_fields', $request->get_query_params() ) ) {
        return array();
      }

      $post = \get_post( $prepared['id'] );
      $block_data = Data::get_block_data( $post->post_content );
      $block_metadata = Metadata::get_block_metadata( $block_data );
      return $block_metadata;

    }

}
