<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_FIRST extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - FIRST', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari First Logistics (FIRST).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'FIRST';
	}

	public function get_unique_id() {
		return 'indo_ongkir_first';
	}

	public function get_courier() {
		return 'first';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'FIRST Regular Service',
				'default' => true,
			),
			'ONS' => array(
				'name' => 'FIRST Over Night Service',
			),
		);
	}

}
