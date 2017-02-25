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
/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
class WC_Bom_Post {

	/**
	 * WC_Bom_Post constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_posts' ] );
	}


	/**
	 *
	 */
	public function register_posts() {

		$labels = [
			'name'               => __( 'Parts', 'wc-bom' ),
			'singular_name'      => __( 'Part', 'wc-bom' ),
			'menu_name'          => __( 'Parts', 'wc-bom' ),
			'all_items'          => __( 'All Parts', 'wc-bom' ),
			'add_new'            => __( 'Add New', 'wc-bom' ),
			'add_new_item'       => __( 'Add New Part', 'wc-bom' ),
			'edit_item'          => __( 'Edit Part', 'wc-bom' ),
			'new_item'           => __( 'New Part', 'wc-bom' ),
			'view_item'          => __( 'View Part', 'wc-bom' ),
			'view_items'         => __( 'View Parts', 'wc-bom' ),
			'search_items'       => __( 'Search Part', 'wc-bom' ),
			'not_found'          => __( 'No Parts Found', 'wc-bom' ),
			'not_found_in_trash' => __( 'No Parts found in Trash', 'wc-bom' ),
			'parent_item_colon'  => __( 'Parent Part', 'wc-bom' ),
			'featured_image'     => __( 'Featured Image for this Part', 'wc-bom' ),
			'set_featured_image' => __( 'Set Featured Image for this Part', 'wc-bom' ),
			'parent_item_colon'  => __( 'Parent Part', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Parts', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => 'Parts post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'part',
			'has_archive'         => true,
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'part', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-hammer',
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'comments',
				'revisions',
				'author',
				'page-attributes',
			],
			'taxonomies'          => [ 'part_category', 'material_tag', 'material_type' ],
		];

		register_post_type( 'part', $args );

		/**
		 * Post Type: Materials.
		 */

		$labels = [
			'name'          => __( 'Materials', 'wc-bom' ),
			'singular_name' => __( 'Material', 'wc-bom' ),
			'menu_name'     => __( 'Materials', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Materials', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => 'Materials post type for the low level raw materials received by a company that are the lowest level of the Bill of Materials.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'materials',
			'has_archive'         => true,
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'material', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-clipboard',
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'comments',
				'revisions',
				'author',
				'page-attributes',
			],
			//'taxonomies' => array( 'part_category', 'material_tag', 'material_type' ),
		];

		register_post_type( 'material', $args );

		/**
		 * Post Type: Assemblies.
		 */

		$labels = [
			'name'          => __( 'Assemblies', 'wc-bom' ),
			'singular_name' => __( 'Assembly', 'wc-bom' ),
			'menu_name'     => __( 'Assemblies', 'wc-bom' ),
			'all_items'     => __( 'All Assemblies', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Assemblies', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'assembly',
			'has_archive'         => true,
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => [ 'slug' => 'assembly', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-nametag',
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'comments',
				'revisions',
				'author',
				'page-attributes',
			],
			//'taxonomies' => array( 'material_tag', 'material_type', 'part_category' ),
		];

		register_post_type( 'assembly', $args );

		/**
		 * Post Type: Requisitions.
		 */

		$labels = [
			'name'          => __( 'Requisitions', 'wc-bom' ),
			'singular_name' => __( 'Requisition', 'wc-bom' ),
		];

		$args = [
			'label'               => __( 'Requisitions', 'wc-bom' ),
			'labels'              => $labels,
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'requisitions',
			'has_archive'         => true,
			'show_in_menu'        => true,
			'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'rewrite'             => [ 'slug' => 'requisition', 'with_front' => true ],
			'query_var'           => true,
			'menu_icon'           => 'dashicons-list-view',
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'comments',
				'revisions',
				'author',
				'page-attributes',
				'post-formats',
			],
			//'taxonomies' => array( 'material_tag', 'material_type' ),
		];

		register_post_type( 'requisition', $args );
	}
}


$wc_bom_post = new WC_Bom_Post();
