<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_INDAH extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - INDAH', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Indah Logistic (INDAH).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'INDAH';
	}

	public function get_unique_id() {
		return 'indo_ongkir_indah';
	}

	public function get_courier() {
		return 'indah';
	}

	public function get_services() {
		return array(
			'Paket Darat' => array(
				'name' => 'Indah Paket Darat',
				'default' => true,
			),
		);
	}

}
