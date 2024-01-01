<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_POS extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - POS', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari POS Indonesia (POS).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'POS';
	}

	public function get_unique_id() {
		return 'indo_ongkir_pos';
	}

	public function get_courier() {
		return 'pos';
	}

	public function get_services() {
		return array(
			// 'Surat Kilat Khusus' => array(
			// 	'name' => 'POS Surat Kilat Khusus',
			// ),
			'Paket Kilat Khusus' => array(
				'name' => 'POS Paket Kilat Khusus',
				'default' => true,
			),
			// 'Express Next Day Dokumen' => array(
			// 	'name' => 'POS Express Next Day Dokumen',
			// ),
			'Express Next Day Barang' => array(
				'name' => 'POS Express Next Day Barang',
			),
			// 'Express Sameday Dokumen' => array(
			// 	'name' => 'POS Express Sameday Dokumen',
			// ),
			'Express Sameday Barang' => array(
				'name' => 'POS Express Sameday Barang',
			),
		);
	}

}
