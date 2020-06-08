<?php

namespace Hametuha\OptionPattern\Utility;

/**
 * Trait Validator
 *
 * @package option-pattern
 */
trait Validator {
	
	/**
	 * Check if value is not empty.
	 *
	 * @param mixed $var
	 *
	 * @return bool
	 */
	protected function is_not_empty( $var ) {
		return ! empty( $var );
	}
	
	/**
	 * Validate array settings.
	 *
	 * @param array $validator
	 * @param array $setting
	 *
	 * @throws \Exception
	 * @return bool
	 */
	private function validate( $validator, $setting ) {
		foreach ( $validator as $key => $callback ) {
			if ( ! isset( $setting[ $key ] ) ) {
				throw new \Exception( sprintf( 'Key %s is required, but not set.', $key ) );
			}
			if ( ! is_callable( $callback ) ) {
				throw new \Exception( sprintf( 'Key %s should be callback function.', $key ) );
			}
			$result = $callback( $setting[ $key ] );
			if ( true === $result ) {
				continue;
			}
			$message = $result ?: sprintf( 'Key %s is invalid.', $key );
			throw new \Exception( $message );
		}
		return true;
	}
	
}
