<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_PANDU extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - PANDU', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Pandu Logistics (PANDU).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'PANDU';
	}

	public function get_unique_id() {
		return 'indo_ongkir_pandu';
	}

	public function get_courier() {
		return 'pandu';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'Pandu Regular Service',
				'default' => true,
			),
		);
	}

}
