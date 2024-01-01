<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_NSS extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - NSS', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Nusantara Surya Sakti Express (NSS).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'NSS';
	}

	public function get_unique_id() {
		return 'indo_ongkir_nss';
	}

	public function get_courier() {
		return 'nss';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'NSS Regular Service',
				'default' => true,
			),
			'ODS' => array(
				'name' => 'NSS One Day Service',
			),
		);
	}

}
