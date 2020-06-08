<?php

namespace Hametuha\OptionPattern\Views;


use Hametuha\OptionPattern\Utility\Validator;

/**
 * Base class for input[type=text]
 *
 * @property-read string $id
 * @property-read string $help
 * @property-read string $placeholder
 * @package option-pattern
 */
class Input {
	
	use Validator;
	
	const TYPE = 'text';
	
	protected $setting = [];
	
	protected $raw_setting = [];
	
	public function __construct( $setting ) {
		try {
			$this->validate( $this->get_validator(), $setting );
			$this->raw_setting = $setting;
			$this->setting = wp_parse_args( $setting, $this->arg_parser() );
			$this->render();
		} catch ( \Exception $e ) {
			trigger_error( $e->getMessage(), E_USER_WARNING );
		}
	}
	
	/**
	 * Should return default array for `wp_parse_args`
	 *
	 * @return string[]
	 */
	protected function arg_parser() {
		return [
			'id' => '',
			'type' => '',
			'placeholder' => '',
			'help' => '',
		];
	}
	
	protected function get_value() {
		return get_option( $this->id );
	}
	
	protected function get_validator() {
		return [
			'id' => [ $this, 'is_not_empty' ],
		];
	}
	
	public function render() {
		$this->before_input();
		$this->after_input();
		$this->input( $this->get_value() );
		$this->render_help();
		$this->after_help();
	}
	
	/**
	 * Executed just after input.
	 */
	protected function before_input() {
		// Do nothing.
	}
	
	/**
	 * Render input element.
	 *
	 * @param string $value
	 */
	protected function input( $value ) {
		printf( '<input %s />', $this->attributes_rendered( $value ) );
	}
	
	/**
	 * Rendered attributes.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	protected function attributes_rendered( $value ) {
		$rendered = [];
		foreach ( $this->get_attributes( $value ) as $key => $value ) {
			$rendered[] = sprintf( '%s="%s"', $key, esc_attr( $value ) );
		}
		return implode( ' ', $rendered );
	}
	
	/**
	 * Get attributes pair.
	 *
	 * @param string $value
	 * @return string[];
	 */
	protected function get_attributes( $value ) {
		return [
			'id' => $this->id,
			'name' => $this->get_name(),
			'type' => static::TYPE,
			'value' => $value,
			'class' => $this->get_class_name(),
			'placeholder' => $this->placeholder,
		];
	}
	
	/**
	 * Class name for input.
	 *
	 * @return string
	 */
	protected function get_class_name() {
		return 'regular-text';
	}
	
	/**
	 * Executed just after input.
	 */
	protected function after_input() {
		// Do nothing.
	}
	
	/**
	 * Executed just after input.
	 */
	protected function after_help() {
		// Do nothing.
	}
	
	/**
	 * Display help if set.
	 */
	protected function render_help() {
		if ( $this->help ) {
			printf( '<p class="description">%s</p>', wp_kses_post( $this->help ) );
		}
	}
	
	/**
	 * Get name attributes.
	 *
	 * @return string
	 */
	protected function get_name() {
		return $this->id;
	}
	
	/**
	 * Getter
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get( $name ) {
		switch ( $name ) {
			case 'id':
			case 'placeholder':
			case 'help':
				return $this->setting[ $name ];
			default:
				return null;
		}
	}
}
