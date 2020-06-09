<?php

namespace Hametuha\OptionPattern\Views\Pattern;


abstract class Choices extends AbstractInput {
	
	
	protected function get_validator() {
		return array_merge( parent::get_validator(), [
			'choices' => function( $var ) {
				return is_array( $var ) && ! empty( $var );
			}
		] );
	}
	
	protected function input( $value ) {
		$this->before_choices();
		foreach ( $this->setting['choices'] as $val => $label ) {
			$this->render_option( $val, $label, $value );
		}
		$this->after_choices();
	}
	
	/**
	 * Render option Item.
	 *
	 * @param string $value
	 * @param string $label
	 * @param mixed $current_value
	 *
	 * @return void
	 */
	abstract protected function render_option( $value, $label, $current_value );
	
	/**
	 * If wrap needed, render something.
	 */
	protected function before_choices() {
		// Do nothing.
	}
	
	/**
	 * If wrap needed, render something.
	 */
	protected function after_choices() {
		// Do nothing.
	}
	
}
