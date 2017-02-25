<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 *
 */
namespace WooBom;

/*
* Plugin Name: WooCommerce Bill of Materials
* Plugin URI: https/nextraa.us
* Description: Bill of Materials add-on for WooCommerce for raw material tracking, inventory, and production metrics.
* Version: 1.0
* Author: Andrew Gunn, Ryan Van Ess
* Author URI: https/nextraa.us
* Text Domain: woo-custom-overlays
* License: GPL2
*/


class WC_Bom {

	/**
	 * @var
	 */
	private $options;


	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		$this->init();
	}


	/**
	 *
	 */
	public function init() {
		/**
		 * Including files in other directories
		 */
		include_once __DIR__ . '/admin/class-wco-options.php';
		include_once __DIR__ . '/inc/script-styles.php';

		add_action( 'wp_enqueue_scripts', [ $this, 'load_includes' ] );
		add_filter( 'plugin_action_links', [ $this, 'wco_settings_link' ], 10, 5 );

		$this->options();
	}


	/**
	 * @return mixed|void
	 */
	public function options() {

		$this->options = get_option( WCO_OPTIONS );

		if ( ! $this->options ) {
			$args = [ 'init' => true, 'upgrade' => false ];
			add_option( WCO_OPTIONS, $args );
		}
	}


	/**
	 *
	 */
	public function wc_bom_vendor_assets() {
		wp_register_script( 'wc_bom_js', plugins_url( 'assets/js/wc_bom.js' ), [ 'jquery' ] );
		wp_register_script( 'wc_bom_min_js', plugins_url( 'assets/js/wc_bom.min.js' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_css', plugins_url( 'assets/css/wc_bom.css' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_min_css', plugins_url( 'assets/css/wc_bom.min.css' ), [ 'jquery' ] );

		wp_enqueue_script( 'wc_bom_js' );
		wp_enqueue_script( 'wc_bom_min_js' );
		wp_enqueue_style( 'wc_bom_css' );
		wp_enqueue_style( 'wc_bom_min_css' );
	}


	/**
	 *
	 */
	public function wc_bom_assets() {
		wp_register_script( 'wc_bom_js', plugins_url( 'assets/js/wc_bom.js' ), [ 'jquery' ] );
		wp_register_script( 'wc_bom_min_js', plugins_url( 'assets/js/wc_bom.min.js' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_css', plugins_url( 'assets/css/wc_bom.css' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_min_css', plugins_url( 'assets/css/wc_bom.min.css' ), [ 'jquery' ] );

		wp_enqueue_script( 'wc_bom_js' );
		wp_enqueue_script( 'wc_bom_min_js' );
		wp_enqueue_style( 'wc_bom_css' );
		wp_enqueue_style( 'wc_bom_min_css' );
	}


	/**
	 *
	 */
	public function wc_bom_admin_assets() {
		wp_register_script( 'wc_bom_admin_js', plugins_url( 'assets/js/wc_bom_admin.js' ), [ 'jquery' ] );
		wp_register_script( 'wc_bom_admin_min_js', plugins_url( 'assets/js/wc_bom_admin.min.js' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_admin_css', plugins_url( 'assets/css/wc_bom_admin.css' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_admin_min_css', plugins_url( 'assets/css/wc_bom_admin.min.css' ), [ 'jquery' ] );

		wp_enqueue_script( 'wc_bom_admin_js' );
		wp_enqueue_script( 'wc_bom_admin_min_js' );
		wp_enqueue_style( 'wc_bom_admin_css' );
		wp_enqueue_style( 'wc_bom_admin_min_css' );
	}


	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function wc_bom_plugin_links( $actions, $plugin_file ) {
		static $plugin;

		if ( ! isset( $plugin ) ) {
			$plugin = plugin_basename( __FILE__ );
		}

		if ( $plugin == $plugin_file ) {

			$settings = [
				'settings' => '<a href="admin.php?page=wc-settings&tab=settings_tab_wco">' . __( 'Settings', 'General' ) . '</a>',
				'support'  => '<a href="http://andrewgunn.org/support" target="_blank">' . __( 'Support', 'General' ) . '</a>'
				//,
				//'pro' => '<a href="http://andrewgunn.xyz/woocommerce-custom-overlays-pro" target="_blank">' . __('Pro', 'General') . '</a>'
			];

			$actions = array_merge( $settings, $actions );
		}

		return $actions;
	}
}