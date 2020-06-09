<?php

namespace Hametuha\OptionPattern\Views;


use Hametuha\OptionPattern\Views\Pattern\AbstractInput;

/**
 * Single checkbox to represent boolean field.
 *
 * @package Hametuha\OptionPattern\Views
 */
class Boolean extends AbstractInput {
	
	const TYPE = 'boolean';
	
	protected function input( $value ) {
		$setting = wp_parse_args( $this->setting, [
			'label' => '',
			'title' => '',
		] );
		$label = $setting['label'] ?: $setting['title'];
		printf( '<label><input %s /> %s</label>', $this->attributes_rendered( $value ), esc_html( $label ) );
	}
	
	protected function get_attributes( $value ) {
		$attributes = array_merge( parent::get_attributes( $value ), [
			'type'  => 'checkbox',
			'value' => 1,
		] );
		unset( $attributes['class'] );
		if ( $value ) {
			$attributes['checked'] = 'checked';
		}
		return $attributes;
	}
}
