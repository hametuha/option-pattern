<?php

namespace Hametuha\OptionPattern\Views;


use Hametuha\OptionPattern\Views\Pattern\Choices;

/**
 * Select option
 *
 * @package option-pattern
 */
class Select extends Choices {
	
	const TYPE = 'select';
	
	protected function render_option( $value, $label, $current_value ) {
		printf(
			'<option value="%1$s" %3$s>%2$s</option>',
			esc_attr( $value ),
			esc_html( $label ),
			selected( $value, $current_value, false )
		);
	}
	
	protected function before_choices() {
		printf( '<select id="%1$s" name="%2$s">', esc_attr( $this->id ), esc_attr( $this->get_name() ) );
	}
	
	protected function after_choices() {
		echo '</select>';
	}
}
