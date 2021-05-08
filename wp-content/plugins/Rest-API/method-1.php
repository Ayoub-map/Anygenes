<?php
add_action( 'rest_api_init', 'register_rest_route' );

// Register post fields.
function register_post_fields() {
    register_rest_field( 'post', 'post_views', array(
        'get_callback'    => 'get_post_views',
        'update_callback' => 'update_post_views',
        'schema' => array(
            'description' => __( 'Post views.' ),
            'type'        => 'integer'
        ),
    ));
}

?>