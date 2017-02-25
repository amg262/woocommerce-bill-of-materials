<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

namespace WooBom;

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 2/24/17
 * Time: 6:43 PM
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
class WC_Bom_Post {

	/**
	 * @var array
	 */
	private $statuses = [];
	/**
	 * @var array
	 */
	private $cpt = [];
	/**
	 * @var array
	 */
	private $cpt_list = [];
	/**
	 * @var array
	 */
	private $tax = [];


	/**
	 * WC_Bom_Post constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'set_statuses' ] );
		add_action( 'init', [ $this, 'register_posts' ] );
		add_action( 'init', [ $this, 'register_taxonomies' ] );
	}


	/**
	 *
	 */
	public function register_posts() {

		$labels = [
			"name"               => __( 'Parts', 'twentysixteen' ),
			"singular_name"      => __( 'Part', 'twentysixteen' ),
			"menu_name"          => __( 'Parts', 'twentysixteen' ),
			"all_items"          => __( 'All Parts', 'twentysixteen' ),
			"add_new"            => __( 'Add New', 'twentysixteen' ),
			"add_new_item"       => __( 'Add New Part', 'twentysixteen' ),
			"edit_item"          => __( 'Edit Part', 'twentysixteen' ),
			"new_item"           => __( 'New Part', 'twentysixteen' ),
			"view_item"          => __( 'View Part', 'twentysixteen' ),
			"view_items"         => __( 'View Parts', 'twentysixteen' ),
			"search_items"       => __( 'Search Part', 'twentysixteen' ),
			"not_found"          => __( 'No Parts Found', 'twentysixteen' ),
			"not_found_in_trash" => __( 'No Parts found in Trash', 'twentysixteen' ),
			"parent_item_colon"  => __( 'Parent Part', 'twentysixteen' ),
			"featured_image"     => __( 'Featured Image for this Part', 'twentysixteen' ),
			"set_featured_image" => __( 'Set Featured Image for this Part', 'twentysixteen' ),
			"archives"           => __( 'Part Masterlist', 'twentysixteen' ),
			"parent_item_colon"  => __( 'Parent Part', 'twentysixteen' ),
		];

		$args = [
			"label"               => __( 'Parts', 'twentysixteen' ),
			"labels"              => $labels,
			"description"         => "",
			"public"              => true,
			"publicly_queryable"  => true,
			"show_ui"             => true,
			"show_in_rest"        => true,
			"rest_base"           => "part",
			"has_archive"         => true,
			"show_in_menu"        => true,
			"show_in_menu_string" => "wc-bom-admin",
			"exclude_from_search" => false,
			"capability_type"     => "product",
			"map_meta_cap"        => true,
			"hierarchical"        => true,
			"rewrite"             => [ "slug" => "part", "with_front" => true ],
			"query_var"           => true,
			"menu_icon"           => "dashicons-admin-tools",
			"supports"            => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				//"trackbacks",
				//"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
			"taxonomies"          => [ "product_shipping_class" ],
		];

		register_post_type( "part", $args );
	}


	/**
	 *
	 */
	public function register_taxonomies() {

		/**
		 * Taxonomy: Part Categories.
		 */

		$labels = [
			"name"          => __( 'Part Categories', 'twentysixteen' ),
			"singular_name" => __( 'Part Category', 'twentysixteen' ),
		];

		$args = [
			"label"              => __( 'Part Categories', 'twentysixteen' ),
			"labels"             => $labels,
			"public"             => true,
			"hierarchical"       => true,
			"label"              => "Part Categories",
			"show_ui"            => true,
			"show_in_menu"       => true,
			"show_in_nav_menus"  => true,
			"query_var"          => true,
			"rewrite"            => [ 'slug' => 'part_category', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"  => true,
			"show_in_rest"       => true,
			"rest_base"          => "part-category",
			"show_in_quick_edit" => true,
		];
		register_taxonomy( "part_category", [ "part" ], $args );

		/**
		 * Taxonomy: Material Tags.
		 */

		$labels = [
			"name"          => __( 'Material Tags', 'twentysixteen' ),
			"singular_name" => __( 'Material Tag', 'twentysixteen' ),
		];

		$args = [
			"label"              => __( 'Material Tags', 'twentysixteen' ),
			"labels"             => $labels,
			"public"             => true,
			"hierarchical"       => false,
			"label"              => "Material Tags",
			"show_ui"            => true,
			"show_in_menu"       => true,
			"show_in_nav_menus"  => true,
			"query_var"          => true,
			"rewrite"            => [ 'slug' => 'material_tag', 'with_front' => true, ],
			"show_admin_column"  => true,
			"show_in_rest"       => true,
			"rest_base"          => "material-tag",
			"show_in_quick_edit" => true,
		];
		register_taxonomy( "material_tag", [ "product", "part" ], $args );
	}


	/**
	 *
	 */
	public function register_statuses() {
		$obj = $this->set_statuses();
		//$s = $this->get_statuses();
		foreach ( $obj as $status ) {
			register_post_status( $status );
		}
	}


	/**
	 * @return array
	 */
	public
	function get_cpt_list() {
		return $this->cpt_list;
	}


	/**
	 * @return array
	 */
	public
	function set_cpt_list() {
		//$this->cpt_list = [ 'part', 'subassembly', 'assembly', 'vendor', 'requistion', 'shipping', 'product' ];
		//$this->cpt_list = [ 'part', 'subassembly', 'assembly', 'vendor', 'requistion', 'shipping', 'product' ];
		$this->cpt_list = [ 'part', 'subassembly', 'assembly', 'vendor', 'requistion', 'shipping', 'product' ];

		return $this->cpt_list;
	}


	/**
	 *
	 */
	public function set_statuses() {

		//$this->statuses = [
		register_post_status( 'received',
		                      [
			                      'label'                     => _x( 'Received', 'part' ),
			                      'public'                    => true,
			                      'exclude_from_search'       => false,
			                      'show_in_admin_all_list'    => true,
			                      'show_in_admin_status_list' => true,
			                      'label_count'
			                                                  => _n_noop( 'Received <span class="count">(%s)</span>', 'Received <span class="count">(%s)</span>' ),
		                      ] );

		register_post_status( 'shipped',
		                      [
			                      'label'                     => _x( 'Shipped', 'part' ),
			                      'public'                    => true,
			                      'exclude_from_search'       => false,
			                      'show_in_admin_all_list'    => true,
			                      'show_in_admin_status_list' => true,
			                      'label_count'
			                                                  => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>' ),
		                      ] );
		register_post_status( 'outofstock',
		                      [
			                      'label'                     => _x( 'Out of Stock', 'part' ),
			                      'public'                    => true,
			                      'exclude_from_search'       => false,
			                      'show_in_admin_all_list'    => true,
			                      'show_in_admin_status_list' => true,
			                      'label_count'
			                                                  => _n_noop( 'Out of Stock <span class="count">(%s)</span>', 'Out of Stock <span class="count">(%s)</span>' ),
		                      ] );
		register_post_status( 'req',
		                      [
			                      'label'                     => _x( 'Requisitioned', 'part' ),
			                      'public'                    => true,
			                      'exclude_from_search'       => false,
			                      'show_in_admin_all_list'    => true,
			                      'show_in_admin_status_list' => true,
			                      'label_count'
			                                                  => _n_noop( 'Requisitioned <span class="count">(%s)</span>', 'Requisitioned <span class="count">(%s)</span>' ),
		                      ] );
		register_post_status( 'finished',
		                      [
			                      'label'                     => _x( 'Finished', 'part' ),
			                      'public'                    => true,
			                      'exclude_from_search'       => false,
			                      'show_in_admin_all_list'    => true,
			                      'show_in_admin_status_list' => true,
			                      'label_count'
			                                                  => _n_noop( 'Finished <span class="count">(%s)</span>', 'Finished <span class="count">(%s)</span>' ),
		                      ] );

		//];


		return $this->statuses;
	}
}


$post = new WC_Bom_Post();