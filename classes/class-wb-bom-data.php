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
 *
 * @property  data
 */
/**
 * Class WC_Bom_Database
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Database
 *
 * @package WooBom
 */
/**
 * Class WC_Bom_Data
 *
 * @package WooBom
 */
class WC_Bom_Data {

	/**
	 * @var
	 */
	private $db;
	/**
	 * @var
	 */
	private $record;
	/**
	 * @var
	 */
	private $query;
	/**
	 * @var
	 */
	private $view;
	/**
	 * @var
	 */
	private $output;
	/**
	 * @var
	 */
	private $salt;
	/**
	 * @var
	 */
	private $key;
	/**
	 * @var
	 */
	private $format;
	/**
	 * @var
	 */
	private $encode;
	/**
	 * @var
	 */
	private $decode;
	/**
	 * @var
	 */
	private $encrypt;
	/**
	 * @var
	 */
	private $decrypt;
	/**
	 * @var
	 */
	private $file;
	/**
	 * @var
	 */
	private $data;
	/**
	 * @var
	 */
	private $outcome;

	/**
	 *
	 */
	public function init() {
	}

	/**
	 *
	 */
	public function install_db() {
	}

	/**
	 *
	 */
	public function delete_db() {
	}

	/**
	 * @param $record
	 */
	public function create_record( $record ) {
	}

	/**
	 * @param $record
	 */
	public function update_record( $record ) {
	}

	/**
	 * @param $record
	 */
	public function delete_record( $record ) {
	}

	/**
	 * @param $query
	 */
	public function query_data( $query ) {
	}

	/**
	 * @param $view
	 */
	public function data_view( $view ) {
	}

	/**
	 * @param $query_args
	 *
	 * @return string
	 */
	public function encrypt_data( $query_args ) {

		$args = wp_parse_args( $query_args, [
			'format' => 'base64',
			'encode' => WC_BOM_PREFIX,
		] );

		$this->format = $args->format;
		$this->decode = $args->data;

		if ( $this->format === 'base64' ) {
			$this->encode = base64_encode( $this->data );
		} elseif ( $this->format === 'str_rot13' ) {
			$this->encode = str_rot13( $this->data );
		} elseif ( $this->format === 'gzdeflate' ) {
			$this->encode = gzdeflate( $this->data );
		} elseif ( $this->format === 'gzcompress' ) {
			$this->encode = gzcompress( $this->data );
		} elseif ( $this->format === 'gzdecode' ) {
			$this->encode = gzdecode( $this->data );
		} elseif ( $this->format === 'crypt' ) {
			$this->salt   = uniqid( WC_BOM_PREFIX, true );
			$this->encode = crypt( $this->data, $this->salt );
		} elseif ( $this->format === 'openssl' ) {
			$this->encode = openssl_encrypt( $this->data, 'AES-128-CBC', WC_BOM_PREFIX );
		} elseif ( $this->format === 'md5' ) {
			$this->encode = md5( $this->data );
		} elseif ( $this->format === 'sha1' ) {
			$this->encode = sha1( $this->data );
		}

		return $this->encode;

	}

	/**
	 * @param $query_args
	 *
	 * @return string
	 */
	public function decrypt_data( $query_args ) {

		/** @var TYPE_NAME $query_args */
		$args = wp_parse_args( $query_args, [
			'format' => $this->format,
			'encode' => $this->encode,
		] );

		$this->format = $args->format;
		$this->decode = $args->data;

		if ( $this->format === 'base64' ) {
			$this->decode = base64_decode( $this->data );
		} elseif ( $this->format === 'str_rot13' ) {
			$this->decode = str_rot13( $this->data );
		} elseif ( $this->format === 'gzdeflate' ) {
			$this->decode = gzinflate( $this->data );
		} elseif ( $this->format === 'gzcompress' ) {
			$this->decode = gzuncompress( $this->data );
		} elseif ( $this->format === 'gzdecode' ) {
			$this->decode = gzencode( $this->data );
		} elseif ( $this->format === 'crypt' ) {
			//$this->salt   = uniqid( WC_BOM_PREFIX, true );
			//$this->encode = crypt( $this->data, $this->salt );
		} elseif ( $this->format === 'openssl' ) {
			//$this->encode = openssl_encrypt( $this->data, 'AES-128-CBC', WC_BOM_PREFIX );
		} elseif ( $this->format === 'md5' ) {
			//$this->encode = md5( $this->data );
		} elseif ( $this->format === 'sha1' ) {
			//$this->encode = sha1( $this->data );
		}

		return $this->decode;
	}

	/**
	 * @param $query_args
	 *
	 * @return bool|string
	 */
	public function handle_file( $query_args ) {

		/** @var TYPE_NAME $query_args */
		$args = wp_parse_args( $query_args, [
			'option' => 'write',
			'file'   => 'file.txt',
			'data'   => __FILE__,
			'append' => true,
		] );


		$option        = $args->option;
		$file          = $args->file;
		$data          = $args->data;
		$append        = $args->append;
		$this->outcome = false;

		//var_dump($args);
		if ( 'write' === $option || 'overwrite' === $option ) {
			file_put_contents( $file, $data, $append );
			$this->outcome = true;
		} elseif ( 'read' === $option ) {
			if ( file_exists( $file ) ) {
				$this->outcome = file_get_contents( $file, $append );
			} else {
				$this->outcome = false;
			}
		}

		return $this->outcome;
	}
}
