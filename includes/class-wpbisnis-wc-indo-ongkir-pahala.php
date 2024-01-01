<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_PAHALA extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - PAHALA', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Pahala Kencana Express (PAHALA).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'PAHALA';
	}

	public function get_unique_id() {
		return 'indo_ongkir_pahala';
	}

	public function get_courier() {
		return 'pahala';
	}

	public function get_services() {
		return array(
			'EXPRESS' => array(
				'name' => 'PAHALA EXPRESS',
				'default' => true,
			),
			'PRIMA EXPRESS' => array(
				'name' => 'PAHALA PRIMA EXPRESS',
			),
			'SUPER EXPRESS' => array(
				'name' => 'PAHALA SUPER EXPRESS',
			),
		);
	}

}
