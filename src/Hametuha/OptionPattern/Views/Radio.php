<?php

namespace Hametuha\OptionPattern\Views;


use Hametuha\OptionPattern\Views\Pattern\Choices;

/**
 * Radio buttons.
 *
 * @package option-pattern
 */
class Radio extends Choices {
	
	const TYPE = 'radio';
	
	/**
	 * Render value
	 *
	 * @param string $value
	 * @param string $label
	 * @param mixed $current_value
	 */
	protected function render_option( $value, $label, $current_value ) {
		printf(
			'<label style="display: inline-block; margin: 0 1em 1em 0;"><input name="%4$s" type="radio" value="%1$s" %3$s/> %2$s</label>',
			esc_attr( $value ),
			esc_html( $label ),
			checked( $value, $current_value, false ),
			esc_attr( $this->get_name() )
		);
	}
	
}
