<?php
class Helper_Functions{
	/**
	 * Returns general configuration tab options located in the CMS settings
	 *
	 * @access public
	 * @return string
	 */
	public static function get_general_config_options( $val ) {

		$option = get_option( 'bdtravel_theme_options', array() );

		if ( isset( $option['general_configuration'] ) && ! empty( $option['general_configuration'][ $val ] ) ) {
			return $option['general_configuration'][ $val ];
		}

		return false;

	}

	/**
	 * Returns the pages configuration
	 *
	 * @access public
	 * @return string
	 */
	public static function get_pages_configuration( $val ) {

		$option = get_option( 'bdtravel_theme_options', array() );

		if ( isset( $option['pages_configuration'] ) && ! empty( $option['pages_configuration'][ $val ] ) ) {
			return $option['pages_configuration'][ $val ];
		}

		return false;

	}
}