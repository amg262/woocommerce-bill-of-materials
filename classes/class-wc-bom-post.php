<?php
/**
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
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
		add_action( 'init', 'my_custom_post_status' );
	}


	/**
	 *
	 */
	public function register_status() {

		foreach ( $this->get_statuses() as $status ) {
			register_post_status( $status );
		}
	}


	/**
	 * @return array
	 */
	public function get_cpt_list() {
		return $this->cpt_list;
	}


	/**
	 * @return array
	 */
	public function set_cpt_list() {
		//$this->cpt_list = [ 'part', 'subassembly', 'assembly', 'vendor', 'requistion', 'shipping', 'product' ];
		//$this->cpt_list = [ 'part', 'subassembly', 'assembly', 'vendor', 'requistion', 'shipping', 'product' ];
		$this->cpt_list = [ 'part', 'subassembly', 'assembly', 'vendor', 'requistion', 'shipping', 'product' ];

		return $this->cpt_list;
	}


	/**
	 * @return array
	 */
	public function get_statuses() {

		if ( ! $this->statuses ) {
			$this->set_statuses();
		}

		return $this->statuses;
	}


	/**
	 *
	 */
	public function set_statuses() {

		$cpt = $this->get_cpt_list();

		$this->statuses = [
			'received',
			[
				'label'                     => _x( 'Received', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Received <span class="count">(%s)</span>', 'Received <span class="count">(%s)</span>' ),
			],
			'shipped',
			[
				'label'                     => _x( 'Shipped', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>' ),
			],
			'outofstock',
			[
				'label'                     => _x( 'Out of Stock', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Out of Stock <span class="count">(%s)</span>', 'Out of Stock <span class="count">(%s)</span>' ),
			],
			'req',
			[
				'label'                     => _x( 'Requisitioned', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Requisitioned <span class="count">(%s)</span>', 'Requisitioned <span class="count">(%s)</span>' ),
			],
			'finished',
			[
				'label'                     => _x( 'Finished', $cpt ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Finished <span class="count">(%s)</span>', 'Finished <span class="count">(%s)</span>' ),
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