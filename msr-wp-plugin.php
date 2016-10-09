<?php
/*
 * Plugin Name: MSR_WP_Plugin
 * Version: 1.0.2
 * Plugin URI: http://www.atorres757.com/
 * Description: This is a plugin to make your Wordpress site work with your MotorsportReg account.
 * Author: Allen Torres
 * Author URI: http://www.atorres757.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: msr-wp-plugin
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Allen Torres
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

// Load plugin class files
require_once( 'includes/class-msr-wp-plugin-logger.php' );
require_once( 'includes/class-msr-wp-plugin.php' );
require_once( 'includes/class-msr-wp-plugin-settings.php' );
require_once( 'includes/class-msr-wp-plugin-widget.php');

// Load plugin libraries
require_once( 'includes/lib/class-msr-wp-plugin-admin-api.php' );
require_once( 'includes/lib/class-msr-wp-plugin-post-type.php' );
require_once( 'includes/lib/class-msr-wp-plugin-taxonomy.php' );

/**
 * Returns the main instance of MSR_WP_Plugin to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object MSR_WP_Plugin
 */
function MSR_WP_Plugin () {
	$instance = MSR_WP_Plugin::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = MSR_WP_Plugin_Settings::instance( $instance );
	}

	return $instance;
}

MSR_WP_Plugin();
