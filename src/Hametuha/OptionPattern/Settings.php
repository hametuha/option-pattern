<?php

namespace Hametuha\OptionPattern;


use Hametuha\OptionPattern\Utility\Validator;
use Hametuha\SingletonPattern\Singleton;

/**
 * Model class for Settings API
 *
 * @package option-pattern
 */
abstract class Settings extends Singleton {

	use Validator;
	
	/**
	 * Constructor to register hooks.
	 */
	protected function init() {
		add_action( 'admin_init', [ $this, 'register_section' ], 10 );
		add_action( 'admin_init', [ $this, 'register_field' ], 11 );
		add_action( 'admin_menu', [ $this, 'register_page' ] );
	}
	
	/**
	 * Register section if registered.
	 *
	 * @return void
	 */
	final public function register_section() {
		$sections_setting = $this->section_setting();
		if ( ! $sections_setting ) {
			// Do nothing.
			return;
		} elseif ( is_wp_error( ( $validations = $this->test_section_setting( $sections_setting ) ) ) ) {
			error_log( $validations->get_error_message() );
		} else {
			add_settings_section(
				$this->get_section(),
				$sections_setting['label'],
				$sections_setting['callback'],
				$this->get_page()
			);
		}
	}
	
	/**
	 * Setting for new section.
	 *
	 * If new section should be created, returns array.
	 * ```
	 * return [
	 *   'label'    => __( 'Section Name e.g. SEO Setting', 'domain' ),
	 *   'callback' => function() {
	 *       printf( '<p class="description">%s</p>', esc_html__( __( 'This section setup site settings.', 'domain' ) ) );
	 *   },
	 * ];
	 * ```
	 * @return array
	 */
	protected function section_setting() {
		return [];
	}
	
	/**
	 * Check if section setting is valid.
	 *
	 * @param array $setting
	 *
	 * @return bool|\WP_Error
	 */
	public function test_section_setting( $setting ) {
		if ( empty( $setting ) ) {
			return true;
		} else {
			try {
				return $this->validate( [
					'label'    => [ $this, 'is_not_empty' ],
					'callback' => function( $callable ) {
						return is_null( $callable ) || is_callable( $callable );
					}
				], $setting );
			} catch ( \Exception $e ) {
				return new \WP_Error( 'invalid_section_setting', $e->getMessage() );
			}
		}
	}
	
	/**
	 * Override this function to add new page.
	 *
	 * @return array
	 */
	public function page_setting() {
		return [];
	}
	
	/**
	 * Register new page if exists.
	 */
	public function register_page() {
		$page_setting = $this->page_setting();
		if ( $page_setting ) {
			new OptionPage( $page_setting );
		}
	}
	
	/**
	 * Register all fields.
	 */
	public function register_field() {
		foreach ( $this->get_fields() as $field ) {
			try {
				new SingleSetting( $this->get_page(), $this->get_section(), $field );
			} catch ( \Exception $e ) {
				trigger_error( $e->getMessage(), E_USER_WARNING );
			}
		}
	}
	
	/**
	 * Should returns section id.
	 *
	 * @return string e.g. 'my-new-section'
	 */
	abstract protected function get_section();
	
	/**
	 * Should return page id.
	 *
	 * @return string e.g. 'reading'
	 */
	abstract protected function get_page();
	
	/**
	 * Array of fields.
	 *
	 * Return values should be
	 *
	 * @return array
	 */
	abstract protected function get_fields();
}
