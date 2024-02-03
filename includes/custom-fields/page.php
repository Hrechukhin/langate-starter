<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'custom_page_fields');

function custom_page_fields()
{
	Container::make('post_meta', 'Page Settings')
		->where('post_type', '=', 'page')
		->add_fields(
			array(
				Field::make('text', 'page_subtitle', 'Page Subtitle')
					->set_width(50),
			)
		);
}
