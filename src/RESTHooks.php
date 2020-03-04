<?php
namespace Leoloso\BlockMetadata;

/**
 * Manages the REST hooks
 */
class RESTHooks {

    /**
     * Register the REST hooks
     */
    public static function init() {
        /**
         * Define REST endpoints
         */
        \add_action('rest_api_init', function () {
            // Endpoint: /wp-json/block-metadata/v1/data/{POST_ID}
            \register_rest_route(RESTUtils::get_namespace(), 'data/(?P<post_id>\d+)', [
                'methods'    => 'GET',
                'callback' => [RESTEndpoints::class, 'get_post_blocks']
            ]);
        });
        \add_action('rest_api_init', function () {
            // Endpoint: /wp-json/block-metadata/v1/metadata/{POST_ID}
            \register_rest_route(RESTUtils::get_namespace(), 'metadata/(?P<post_id>\d+)', [
                'methods'    => 'GET',
                'callback' => [RESTEndpoints::class, 'get_post_block_meta']
            ]);
        });
        \add_action('rest_api_init', function () {
            // Endpoint: /wp-json/block-metadata/v1/metadata/
            \register_rest_route(RESTUtils::get_namespace(), 'metadata', [
                'methods'    => 'GET',
                'callback' => [RESTEndpoints::class, 'get_all_post_block_meta']
            ]);
        });
    }
}