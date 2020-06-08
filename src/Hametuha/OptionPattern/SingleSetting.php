<?php

namespace Hametuha\OptionPattern;

use Hametuha\OptionPattern\Utility\Validator;

/**
 * Model class which represents single option setting.
 *
 * @package Hametuha\OptionPattern
 */
class SingleSetting {
	
	use Validator;
	
	private $setting = [];
	
	private function validate_setting() {
		return [
			'id'  => [ $this, 'is_not_empty'],
			'title' => [ $this, 'is_not_empty'],
			'type' => function( $var ) {
				return in_array( $var, [
					'hidden',
					'text',
					'email',
					'password',
					'url',
					'textarea',
					'select',
					'checkbox',
					'boolean',
					'radio',
				] );
			},
		];
	}
	
	/**
	 * SingleSetting constructor.
	 *
	 * @param string $page
	 * @param string $section
	 * @param array $setting
	 *
	 * @throws \Exception
	 */
	public function __construct( $page, $section, $setting ) {
		try {
			$this->validate( $this->validate_setting(), $setting );
			$this->setting = $setting;
			$setting = wp_parse_args( $setting, [
				'id'    => '',
				'title' => '',
			] );
			add_settings_field( $setting['id'], $setting['title'], [ $this, 'render' ] ,$page, $section );
			register_setting( $page, $setting['id'] );
		} catch ( \Exception $e ) {
			trigger_error( $e->getMessage(), E_USER_WARNING );
		}
	}
	
	/**
	 * Get class name.
	 *
	 * @return string[]
	 */
	public function get_setting_classes() {
		static $classes = null;
		if ( is_null( $classes ) ) {
			$dir = __DIR__ . '/' . 'Views';
			$classes = [];
			if ( is_dir( $dir ) ) {
				foreach ( scandir( $dir ) as $file ) {
					if ( ! preg_match( '/^(.*)\.php$/', $file, $matches ) ) {
						continue;
					}
					list( $match, $class_name ) = $matches;
					$class_name = "Hametuha\\OptionPattern\\Views\\{$class_name}";
					if ( ! class_exists( $class_name ) ) {
						continue;
					}
					$classes[ $class_name::TYPE ] = $class_name;
				}
			}
		}
		return apply_filters( 'option_pattern_setting_classes', $classes );
	}
	
	/**
	 * Render setting field.
	 */
	public function render() {
		$classes = $this->get_setting_classes();
		$settings = wp_parse_args( $this->setting, [
			'type'  => '',
		] );
		if ( empty( $classes[$settings['type']] ) ) {
			trigger_error( 'Specified input type doesn\'t exits.', E_USER_WARNING );
		} else {
			new $classes[$settings['type']]( $this->setting );
		}
	}
}
