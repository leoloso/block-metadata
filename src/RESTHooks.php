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
         * Define REST fields
         */
        \add_action( 'rest_api_init', function() {

          \register_rest_field( 'post', 'blocks', array(
            'get_callback'      => [RESTHooks::class, 'get_blocks'],
            'update_callback'   => null,
            'schema'            => array(
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

      $post = \get_post( $prepared );
      $block_data = Data::get_block_data( $post->post_content );
      $block_metadata = Metadata::get_block_metadata( $block_data );
      return $block_metadata;

    }

}
