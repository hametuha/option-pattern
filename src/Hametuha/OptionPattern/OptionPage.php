<?php

namespace Hametuha\OptionPattern;


use Hametuha\OptionPattern\Utility\Validator;

class OptionPage {

	use Validator;
	
	protected $setting = [];
	
	/**
	 * Constructor
	 *
	 * @param $page_setting
	 */
	public function __construct( $page_setting ) {
		try {
			$this->validate( $this->validate_page_setting(), $page_setting );
			$this->setting = $page_setting;
			$this->register_page();
		} catch ( \Exception $e ) {
			trigger_error( $e->getMessage(), E_USER_WARNING );
		}
	}
	
	/**
	 * Register setting page.
	 */
	public function register_page() {
		$args = wp_parse_args( $this->setting, [
			'parent' => '',
			'title' => '',
			'slug' => $this->setting['id'],
			'menu_title' => $this->setting['title'],
			'position' => 99,
			'capability' => 'manage_options',
			'icon' => 'dashicons-chart-line',
		] );
		if ( $args['parent'] ) {
			add_submenu_page( $args['parent'], $args['title'], $args['menu_title'], $args['capability'], $args['slug'], [ $this, 'render' ], $args['position'] );
		} else {
			add_menu_page( $args['title'], $args['menu_title'], $args['capability'], $args['slug'], [ $this, 'render' ], $args['icon'], $args['position'] );
		}
	}
	
	public function render() {
		$setting = wp_parse_args( $this->setting, [
			'title' => '',
			'desc'  => '',
		] );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( $setting['title'] ) ?></h1>
			<?php if ( $setting['desc'] ) : ?>
				<p><?php echo nl2br( esc_html( $setting['desc'] ) ) ?></p>
				<hr />
			<?php endif; ?>
			<form method="POST" action="options.php">
				<?php
				settings_fields( $this->setting['id'] );
				do_settings_sections( $this->setting['id'] );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
	
	public function validate_page_setting() {
		return [
			'id' => [ $this, 'is_not_empty' ],
			'title' => [ $this, 'is_not_empty' ],
			'parent' => function( $var ) {
				return empty( $var ) || ! empty( $var );
			},
		];
	}
}
