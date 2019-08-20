<?php
namespace Leoloso\BlockMetadata;

/**
 * REST API utility functions
 */
class RESTUtils {

	/**
	 * Provide the namespace under which to register the REST API endpoints
	 *
	 * @return void
	 */
	public static function get_namespace() {
		$version = '1';
		$provider = 'block-metadata';
		return $provider . '/v' . $version;
	}
}
