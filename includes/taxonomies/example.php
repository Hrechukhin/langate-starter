<?php
class Custom_Taxonomy {
    public function __construct() {
        add_action('init', array($this, 'register_custom_taxonomy'));
    }

    public function register_custom_taxonomy() {
		$textdomain = 'textdomain';
        $labels = array(
            'name'                       => _x('Custom Categories', 'taxonomy general name', $textdomain),
            'singular_name'              => _x('Custom Category', 'taxonomy singular name', $textdomain),
            'search_items'               => __('Search Custom Categories', $textdomain),
            'all_items'                  => __('All Custom Categories', $textdomain),
            'parent_item'                => __('Parent Custom Category', $textdomain),
            'parent_item_colon'          => __('Parent Custom Category:', $textdomain),
            'edit_item'                  => __('Edit Custom Category', $textdomain),
            'update_item'                => __('Update Custom Category', $textdomain),
            'add_new_item'               => __('Add New Custom Category', $textdomain),
            'new_item_name'              => __('New Custom Category Name', $textdomain),
            'menu_name'                  => __('Custom Categories', $textdomain),
        );

        $args = array(
            'labels'                     => $labels,
            'public'                     => true,
            'hierarchical'               => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'query_var'                  => true,
            'rewrite'                    => array('slug' => 'custom-category'),
        );

        register_taxonomy('custom_category', array('custom_post'), $args);
    }
}

$custom_taxonomy = new Custom_Taxonomy();
