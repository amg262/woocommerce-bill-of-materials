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
		add_action( 'init', [$this, 'register_statuses'] );
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
			"menu_icon"           => "dashicons-hammer",
			"supports"            => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
			"taxonomies"          => [ "post_tag", "product_cat", "product_tag", "product_shipping_class" ],
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

		foreach ( $this->get_statuses() as $status ) {
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
	 * @return array
	 */
	public
	function get_statuses() {

		if ( ! $this->statuses ) {
			$this->set_statuses();
		}

		return $this->statuses;
	}


	/**
	 *
	 */
	public
	function set_statuses() {

		$cpt = $this->get_cpt_list();

		$this->statuses = [
			'received',
			[
				'label'                     => _x( 'Received', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'
				                            => _n_noop( 'Received <span class="count">(%s)</span>', 'Received <span class="count">(%s)</span>' ),
			],
			'shipped',
			[
				'label'                     => _x( 'Shipped', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'
				                            => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>' ),
			],
			'outofstock',
			[
				'label'                     => _x( 'Out of Stock', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'
				                            => _n_noop( 'Out of Stock <span class="count">(%s)</span>', 'Out of Stock <span class="count">(%s)</span>' ),
			],
			'req',
			[
				'label'                     => _x( 'Requisitioned', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'
				                            => _n_noop( 'Requisitioned <span class="count">(%s)</span>', 'Requisitioned <span class="count">(%s)</span>' ),
			],
			'finished',
			[
				'label'                     => _x( 'Finished', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'
				                            => _n_noop( 'Finished <span class="count">(%s)</span>', 'Finished <span class="count">(%s)</span>' ),
			],
		];


		$this->statuses = [
			//[ 'name' => 'hold', 'label' => 'On Hold', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'damaged', 'label' => 'Damaged', 'post_types' => [ $cpt ] ],
			[ 'name' => 'receieved', 'label' => 'Recieved', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'raw', 'label' => 'Raw Material', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'devlivered', 'label' => 'Devlivered', 'post_types' => [ $cpt ] ],
			[ 'name' => 'shipped', 'label' => 'Shipped', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'missing', 'label' => 'Missing', 'post_types' => [ $cpt ] ],
			[ 'name' => 'outofstock', 'label' => 'Out of Stock', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'instock', 'label' => 'In Stock', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'overstock', 'label' => 'Overstock', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'production', 'label' => 'In Production', 'post_types' => [ $cpt ] ],
			[ 'name' => 'reqd', 'label' => 'Requisitioned', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'scrap', 'label' => 'Scrap', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'active', 'label' => 'Active', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'inactive', 'label' => 'Inactive', 'post_types' => [ $cpt ] ],
			[ 'name' => 'finished', 'label' => 'Finished', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'late', 'label' => 'Late', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'stalled', 'label' => 'Stalled', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'sold', 'label' => 'Sold', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'urgent', 'label' => 'Urgent', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'enqueue', 'label' => 'Enqueue', 'post_types' => [ $cpt ] ],
			//[ 'name' => 'stalled', 'label' => 'Stalled', 'post_types' => [ $cpt ] ],
		];
	}
}