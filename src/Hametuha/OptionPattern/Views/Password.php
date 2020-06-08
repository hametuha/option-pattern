<?php

namespace Hametuha\OptionPattern\Views;


class Password extends Input {
	
	const TYPE = 'password';
	
	protected function get_attributes( $value ) {
		return array_merge( parent::get_attributes( $value ), [
			'autocomplete' => 'off',
		] );
	}
}
