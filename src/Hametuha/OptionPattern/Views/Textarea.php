<?php

namespace Hametuha\OptionPattern\Views;


use Hametuha\OptionPattern\Views\Pattern\AbstractInput;

/**
 * Textarea field.
 *
 * @package Hametuha\OptionPattern\Views
 */
class Textarea extends AbstractInput {
	
	const TYPE = 'textarea';
	
	protected function arg_parser() {
		return array_merge( parent::arg_parser(), [
			'rows' => 3,
		] );
	}
	
	
	protected function get_attributes( $value ) {
		$attributes = parent::get_attributes( $value );
		unset( $attributes['value'] );
		unset( $attributes['type'] );
		$attributes['rows'] = $this->setting['rows'];
		$attributes['class'] = 'widefat';
		return $attributes;
	}
	
	protected function input( $value ) {
		printf( '<textarea %s>%s</textarea>', $this->attributes_rendered( $value ), esc_textarea( $value ) );
	}
	
	
}
