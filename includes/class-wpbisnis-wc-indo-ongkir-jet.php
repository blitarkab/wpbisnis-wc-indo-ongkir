<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_JET extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - JET', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari JET Express (JET).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'JET';
	}

	public function get_unique_id() {
		return 'indo_ongkir_jet';
	}

	public function get_courier() {
		return 'jet';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'JET Reguler',
				'default' => true,
			),
		);
	}

}
