<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_CAHAYA extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - CAHAYA', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Cahaya Logistik (CAHAYA).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'CAHAYA';
	}

	public function get_unique_id() {
		return 'indo_ongkir_cahaya';
	}

	public function get_courier() {
		return 'cahaya';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'CAHAYA Regular Service',
				'default' => true,
			),
		);
	}

}
