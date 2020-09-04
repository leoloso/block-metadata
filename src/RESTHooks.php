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
            'schema'            => null,
          ) );

        } );
    }

    public static function get_blocks( $object, $attr, $request, $object_type ) {

      $post = \get_post( $object );
      $block_data = Data::get_block_data( $post->post_content );
      $block_metadata = Metadata::get_block_metadata( $block_data );
      return $block_metadata;

    }

}
