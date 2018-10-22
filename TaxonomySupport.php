<?php

use wpscholar\WordPress\FeatureSupport;

if ( defined( 'add_action' ) ) {

	// Automatically register features for custom taxonomies
	add_action( 'registered_taxonomy', function ( $taxonomy, $object_type, $args ) {
		if ( isset( $args['supports'] ) && is_array( $args['supports'] ) ) {
			foreach ( $args['supports'] as $key => $value ) {
				if ( is_numeric( $key ) ) {
					// Only a feature name is provided
					add_taxonomy_support( $taxonomy, $value );
				} else {
					// A feature name and value is provided
					add_taxonomy_support( $taxonomy, $key, $value );
				}
			}
		}
	}, 10, 3 );

}

if ( ! defined( 'taxonomy_supports' ) ) {

	/**
	 * Check if a taxonomy supports a specific feature.
	 *
	 * @param string $taxonomy
	 * @param string $feature
	 *
	 * @return bool
	 */
	function taxonomy_supports( $taxonomy, $feature ) {
		$support = FeatureSupport::getInstance( 'taxonomy' );

		return $support->has( $taxonomy, $feature );
	}

}

if ( ! defined( 'add_taxonomy_support' ) ) {

	/**
	 * Add support for a specific feature to a taxonomy.
	 *
	 * @param string $taxonomy
	 * @param string|array $feature
	 */
	function add_taxonomy_support( $taxonomy, $feature ) {
		$support = FeatureSupport::getInstance( 'taxonomy' );
		$support->add( ...func_get_args() );
	}

}

if ( ! defined( 'remove_taxonomy_support' ) ) {

	/**
	 * Remove support for a specific feature from a taxonomy.
	 *
	 * @param string $taxonomy
	 * @param string $feature
	 */
	function remove_taxonomy_support( $taxonomy, $feature ) {
		$support = FeatureSupport::getInstance( 'taxonomy' );
		$support->remove( $taxonomy, $feature );
	}

}

if ( ! defined( 'get_all_taxonomy_supports' ) ) {

	/**
	 * Get all features supported by a taxonomy.
	 *
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	function get_all_taxonomy_supports( $taxonomy ) {
		$support = FeatureSupport::getInstance( 'taxonomy' );

		return $support->all( $taxonomy );
	}

}

if ( ! defined( 'get_taxonomies_by_support' ) ) {

	/**
	 * Get all taxonomies that support a specific feature.
	 *
	 * @param string|array $feature
	 * @param string $operator
	 *
	 * @return array
	 */
	function get_taxonomies_by_support( $feature, $operator = 'and' ) {
		$support = FeatureSupport::getInstance( 'taxonomy' );

		return $support->where( $feature, $operator );
	}

}