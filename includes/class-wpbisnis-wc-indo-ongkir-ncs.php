<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_NCS extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - NCS', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Nusantara Card Semesta (NCS).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'NCS';
	}

	public function get_unique_id() {
		return 'indo_ongkir_ncs';
	}

	public function get_courier() {
		return 'ncs';
	}

	public function get_services() {
		return array(
			'NRS' => array(
				'name' => 'NCS Regular Service',
				'default' => true,
			),
			'ONS' => array(
				'name' => 'NCS Over Night Service',
			),
		);
	}

}
