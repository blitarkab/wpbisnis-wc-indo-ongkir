<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_DSE extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - DSE', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari 21 Express (DSE).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'DSE';
	}

	public function get_unique_id() {
		return 'indo_ongkir_dse';
	}

	public function get_courier() {
		return 'dse';
	}

	public function get_services() {
		return array(
			'ECO' => array(
				'name' => 'DSE Regular Service',
				'default' => true,
			),
			'ONS' => array(
				'name' => 'DSE Over Night Service',
			),
		);
	}

}
