<?php
namespace Zamaneh\RestfulBlocks;
/**
 * Define WPGraphQL field "jsonencoded_block_metadata"
 */
\add_action('graphql_register_types', function() {
    \register_graphql_field(
        'Post',
        'jsonencoded_block_metadata',
        [
            'type' => 'String',
            'description' => __('Post block metadata encoded as JSON', 'block-metadata'),
            'resolve' => function($post) {
                $post = \get_post($post->ID);
                $block_data = Data::get_block_data($post->post_content);
                $block_metadata = Metadata::get_block_metadata($block_data);
                return json_encode($block_metadata);
            }
        ]
    );
});
