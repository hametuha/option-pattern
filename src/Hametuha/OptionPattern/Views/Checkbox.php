<?php

namespace Hametuha\OptionPattern\Views;


use Hametuha\OptionPattern\Views\Pattern\Choices;

/**
 * Checkbox input fields.
 *
 * @package Hametuha\OptionPattern\Views
 */
class Checkbox extends Choices {

	const TYPE = 'checkbox';
	
	/**
	 * Returns array
	 *
	 * @return array
	 */
	protected function get_value() {
		return (array) get_option( $this->id, [] );
	}
	
	
	/**
	 * Render value
	 *
	 * @param string $value
	 * @param string $label
	 * @param mixed $current_value
	 */
	protected function render_option( $value, $label, $current_value ) {
		$current_value = (array) $current_value;
		printf(
			'<label style="display: inline-block; margin: 0 1em 1em 0;"><input name="%4$s[]" type="checkbox" value="%1$s" %3$s/> %2$s</label>',
			esc_attr( $value ),
			esc_html( $label ),
			checked( in_array( $value, $current_value ), true, false ),
			esc_attr( $this->get_name() )
		);
	}
}
