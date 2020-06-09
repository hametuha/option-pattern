<?php

namespace Hametuha\OptionPattern\Utility;

/**
 * Utility class for choices.
 *
 * @package option-patttern
 */
class Source {
	
	/**
	 * Get post type for choices.
	 *
	 * @param array $param
	 * @param string $add_empty If set, this is empty selection.
	 * @return string[]
	 */
	public static function get_post_types( $param = [], $add_empty = '' ) {
		$result = [];
		if ( $add_empty ) {
			$result[''] = $add_empty;
		}
		foreach ( get_post_types( $param, OBJECT ) as $post_type ) {
			$result[ $post_type->name ] = $post_type->label;
		}
		return $result;
	}
	
	/**
	 * Get WP_User for choices
	 *
	 * @param array $query
	 * @param string $add_empty If set, this will be empty selection.
	 * @return string[]
	 */
	public static function get_users( $query = [], $add_empty = '' ) {
		$query = new \WP_User_Query( $query );
		$users = [];
		if ( $add_empty ) {
			$users[ 0 ] = $add_empty;
		}
		foreach ( $query->get_results() as $user ) {
			/** @var \WP_User $user */
			$users[ $user->ID ] = sprintf( '%s(%s)', $user->display_name, implode( ', ', array_map( function( $role ) {
				return translate_user_role( $role );
			}, $user->roles ) ) );
		}
		return $users;
	}
	
	/**
	 * Get taxonomies.
	 *
	 * @param array  $args      Array for taxonomy query.
	 * @param string $add_empty If set, add empty choice.
	 *
	 * @return string[]
	 */
	public static function get_taxonomies( $args = [], $add_empty = '' ) {
		$taxonomies = [];
		if ( $add_empty ) {
			$taxonomies[''] = $add_empty;
		}
		foreach ( get_taxonomies( $args, OBJECT ) as $taxonomy ) {
			$taxonomies[ $taxonomy->name ] = $taxonomy->label;
		};
		return $taxonomies;
	}
}
