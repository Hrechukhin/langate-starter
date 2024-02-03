<?php

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain('theme', get_theme_file_uri('languages'));

		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support(
			'html5',
			array(
				'search-form',
				'gallery',
				'caption',
			)
		);
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height' => 200,
				'width' => 50,
				'flex-width' => true,
				'flex-height' => true,
			)
		);

		register_nav_menus(
			array(
				'primary' => __('Primary Menu', 'theme'),
			)
		);
	}
);
