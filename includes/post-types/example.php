<?php

class Custom_Post_Type
{
	public function __construct()
	{
		add_action('init', array($this, 'register_custom_post_type'));
	}

	public function register_custom_post_type()
	{
		$textdomain = 'textdomain';

		$labels = array(
			'name' => _x('Custom Posts', 'post type general name', $textdomain),
			'singular_name' => _x('Custom Post', 'post type singular name', $textdomain),
			'menu_name' => _x('Custom Posts', 'admin menu', $textdomain),
			'name_admin_bar' => _x('Custom Post', 'add new on admin bar', $textdomain),
			'add_new' => _x('Add New', 'custom post', $textdomain),
			'add_new_item' => __('Add New Custom Post', $textdomain),
			'new_item' => __('New Custom Post', $textdomain),
			'edit_item' => __('Edit Custom Post', $textdomain),
			'view_item' => __('View Custom Post', $textdomain),
			'all_items' => __('All Custom Posts', $textdomain),
			'search_items' => __('Search Custom Posts', $textdomain),
			'parent_item_colon' => __('Parent Custom Posts:', $textdomain),
			'not_found' => __('No custom posts found.', $textdomain),
			'not_found_in_trash' => __('No custom posts found in Trash.', $textdomain)
		);

		$args = array(
			'labels' => $labels,
			'description' => __('Description.', $textdomain),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'custom-post'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
		);

		register_post_type('custom_post', $args);
	}
}

$custom_post_type = new Custom_Post_Type();
