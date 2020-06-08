<?php
/**
 * Plugin Name: Option Pattern Library
 * Plugin URI:  https://github.com/hametuha/option-pattern
 * Description: Settings API helper.
 * Version:     0.0.0
 * Author:      Hametuha INC.
 * Author URI:  https://hametuha.co.jp
 * License:     GPLv3 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-3.0.html
 * Text Domain: option-pattern
 * Domain Path: /languages
 */

// This file actually do nothing.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}
require __DIR__ . '/vendor/autoload.php';

$dir = [ __DIR__ . '/tests/src/Hametuha/OptionPatternTests' ];

foreach ( $dir as $d ) {
	if ( ! is_dir( $d ) ) {
		continue;
	}
	Hametuha\SingletonPattern\BulkRegister::enable( "Hametuha\\OptionPatternTests", $d );
}
