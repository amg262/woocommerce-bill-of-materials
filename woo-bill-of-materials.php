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
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

const WC_BOM_PREFIX = 'wc_bom';

require_once __DIR__ . '/classes/class-wc-bom-post.php';
require_once __DIR__ . '/classes/class-wc-bom-settings.php';


class WC_Bom {

	/**
	 * @var
	 */
	private $options;
	/**
	 * @var
	 */
	private $posts;


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
		$this->check_requirements();
		$this->plugin_options();
		$this->load_assets();
		add_action( 'wp_enqueue_scripts', [ $this, 'load_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_assets' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		add_filter( 'acf/settings/path', 'my_acf_settings_path' );
		add_filter( 'acf/settings/dir', 'my_acf_settings_dir' );
		add_filter( 'acf/settings/show_admin', '__return_false' );
		include_once( get_stylesheet_directory() . '/acf/acf.php' );

		/**
		 * Including files in other directories
		 */
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		//register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
	}


// 1. customize ACF path

	function my_acf_settings_path( $path ) {

		// update path
		$path = get_stylesheet_directory() . '/acf/';

		// return
		return $path;
	}


// 2. customize ACF dir

	function my_acf_settings_dir( $dir ) {

		// update path
		$dir = plugins_url( 'assets/vendor/advanced-custom-fields-pro.js', __FILE__ ) . '/acf/';

		// return
		return $dir;
	}


	/**
	 *
	 */
	public function activate() {
		flush_rewrite_rules();
	}


	/**
	 *
	 */
	public function check_requirements() {
		if ( ! function_exists( 'is_woocommerce_activated' ) ) {
			function is_woocommerce_activated() {
				if ( class_exists( 'woocommerce' ) ) {
					return true;
				} else {
					return false;
				}
			}
		}
	}


	/**
	 * @return mixed|void
	 */
	public function plugin_options() {

		$this->options = get_option( 'wc_bom_options' );

		if ( ! $this->options ) {
			$args = [ 'init' => true, 'upgrade' => false ];
			add_option( 'wc_bom_options', $args );
		}

		if ( function_exists( 'acf_add_options_page' ) ) {

			$option_page = acf_add_options_page( [
				                                     'page_title' => 'Theme General Settings',
				                                     'menu_title' => 'Theme Settings',
				                                     'menu_slug'  => 'theme-general-settings',
				                                     'capability' => 'edit_posts',
				                                     'redirect'   => false,
			                                     ] );
		}
	}


	/**
	 *
	 */
	public function load_vendor_assets() {
		/*wp_register_script( 'wc_bom_js', plugins_url( 'assets/js/wc_bom.js' ), [ 'jquery' ] );
		wp_register_script( 'wc_bom_min_js', plugins_url( 'assets/js/wc_bom.min.js' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_css', plugins_url( 'assets/css/wc_bom.css' ), [ 'jquery' ] );
		wp_register_style( 'wc_bom_min_css', plugins_url( 'assets/css/wc_bom.min.css' ), [ 'jquery' ] );

		wp_enqueue_script( 'wc_bom_js' );
		wp_enqueue_script( 'wc_bom_min_js' );
		wp_enqueue_style( 'wc_bom_css' );
		wp_enqueue_style( 'wc_bom_min_css' );*/
	}


	/**
	 *
	 */
	public function load_assets() {
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
	public function load_admin_assets() {
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
	public function plugin_links( $actions, $plugin_file ) {
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


//add_filter('acf/settings/show_admin', '__return_false');

include __DIR__ . '/assets/vendor/advanced-custom-fields-pro/acf.php';
