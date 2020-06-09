<?php

namespace Hametuha\OptionPattern\Views;


use Hametuha\OptionPattern\Views\Pattern\AbstractInput;

/**
 * Password input field.
 *
 * @package option-pattern
 */
class Password extends AbstractInput {
	
	const TYPE = 'password';
	
	protected function get_attributes( $value ) {
		return array_merge( parent::get_attributes( $value ), [
			'autocomplete' => 'off',
		] );
	}
}
