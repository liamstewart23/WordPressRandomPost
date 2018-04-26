<?php
/*
Plugin Name: Random Post
Plugin URI: https://github.com/liamstewart23/WordPressRandomPost
Description: Shortcode that creates a link to random post
Version: 1.0.0
Author: Liam Stewart
Author URI: https://liamstewart.ca
*/


function ls_random_post( $atts ) {
    shortcode_atts( array(
        'posts' => 1,
        'type'  => 'post'
    ), $atts );

    query_posts( array(
        'post_type'      => $type,
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'orderby'        => 'rand'
    ) );

    $title = 'Random Post';//default title

    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            if ( get_the_title() ) {//if title is set pick that title
                $title = get_the_title();
            }
            $post = '<a href="' . get_permalink() . '">' . $title . '</a>';
        endwhile;
    endif;

    wp_reset_query();

    return $post;
}





function ls_randompost_register_shortcodes() {
    add_shortcode( 'random', 'ls_random_post' );
    add_shortcode( 'randompost', 'ls_random_post' );
    add_shortcode( 'rp', 'ls_random_post' );
    add_filter( 'widget_text', 'do_shortcode' );// shortcodes in widgets
    add_filter( 'the_excerpt', 'do_shortcode' );// shortcodes in excerpts
    add_filter( 'comment_text', 'do_shortcode' );// shortcodes in comments
}

add_action( 'init', 'ls_randompost_register_shortcodes' );// init
