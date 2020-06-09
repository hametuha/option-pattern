<?php

namespace Hametuha\OptionPatternTests;


use Hametuha\OptionPattern\Settings;
use Hametuha\OptionPattern\Utility\Source;

class General extends Settings {
	
	protected function section_setting() {
		return [
			'label' => 'My General Setting',
			'callback' => function() {
				printf( '<p class="description">%s</p>', 'This is my original settings in General page.' );
			}
		];
	}
	
	protected function get_page() {
		return 'my_general_page';
	}
	
	public function page_setting() {
		return [
			'parent' => '',
			'title'  => 'Original Options',
			'desc'   => 'This is our original page.',
		];
	}
	
	
	protected function get_section() {
		return 'my_general_section';
	}
	
	protected function get_fields() {
		return [
			[
				'id' => 'my-general-text',
				'title' => 'Text',
				'type' => 'text',
				'help' => 'This is simple text field.',
				'placeholder' => 'e.g. Lorem ipsum',
			],
			[
				'id' => 'my-general-url',
				'title' => 'URL',
				'type' => 'url',
				'placeholder' => 'e.g. https://example.com',
			],
			[
				'id' => 'my-general-password',
				'title' => 'Secret Key',
				'type' => 'password',
			],
			[
				'id' => 'my-general-email',
				'title' => 'Email',
				'type' => 'email',
			],
			[
				'id' => 'my-general-multiline',
				'title' => 'Textarea',
				'type' => 'textarea',
				'rows' => 10,
				'placeholder' => 'This textarea container mysterious setting.',
			],
			[
				'id' => 'my-general-boolean',
				'title' => 'Boolean',
				'type' => 'boolean',
				'label' => 'Enable this option',
			],
			[
				'id' => 'my-general-checkboxes',
				'title' => 'Post Types',
				'type' => 'checkbox',
				'choices' => Source::get_post_types( [ 'public' => true ] ),
			],
			[
				'id' => 'my-general-select',
				'title' => 'Representative User',
				'type' => 'select',
				'choices' => Source::get_users( [ 'role' => 'administrator' ], 'Select User' ),
			],
			[
				'id' => 'my-general-radio',
				'title' => 'Taxonomy',
				'type' => 'radio',
				'choices' => Source::get_taxonomies( [ 'public' => true ] ),
			],
		];
	}
	
	
}
