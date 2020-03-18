<?php
namespace Leoloso\BlockMetadata;

class RESTEndpoints {
    /**
     * Return the block's data
     *
     * @param [type] $request
     * @return void
     */
    public static function get_post_blocks($request)
    {
        $post = \get_post($request['post_id']);
        if (!$post) {
            return new \WP_Error('empty_post', 'There is no post with this ID', array('status' => 404));
        }

        $block_data = Data::get_block_data($post->post_content);
        $response = new \WP_REST_Response($block_data);
        $response->set_status(200);
        return $response;
    }

    /**
     * * Return the block's metadata
     *
     * @param [type] $request
     * @return void
     */
    public static function get_post_block_meta($request)
    {
        $post = \get_post($request['post_id']);
        if (!$post) {
            return new \WP_Error('empty_post', 'There is no post with this ID', array('status' => 404));
        }

        $item_metadata = array();
        $item_metadata['id'] = $post->ID;
        $item_metadata['title'] = $post->post_title;

        $block_data = Data::get_block_data($post->post_content);
        $block_metadata = Metadata::get_block_metadata($block_data);
        $item_metadata['blocks'] = $block_metadata;

        $response = new \WP_REST_Response($item_metadata);
        $response->set_status(200);
        return $response;
    }

    public static function get_all_post_block_meta($request)
    {
        $args = array(
            'numberposts' => -1
        );
        $posts = \get_posts($args);

        $result = array();
        foreach($posts as $post) {
            $item_metadata = array();
            $item_metadata['id'] = $post->ID;
            $item_metadata['title'] = $post->post_title;

            $block_data = Data::get_block_data($post->post_content);
            $block_metadata = Metadata::get_block_metadata($block_data);
            $item_metadata['blocks'] = $block_metadata;
            $result[] = $item_metadata;
        }
        $response = new \WP_REST_Response($result);
        $response->set_status(200);
        return $response;
    }
}
