<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_TIKI extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - TIKI', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Citra Van Titipan Kilat (TIKI).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'TIKI';
	}

	public function get_unique_id() {
		return 'indo_ongkir_tiki';
	}

	public function get_courier() {
		return 'tiki';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'TIKI REGULAR SERVICE',
				'default' => true,
			),
			'ONS' => array(
				'name' => 'TIKI OVER NIGHT SERVICE',
			),
			'ECO' => array(
				'name' => 'TIKI ECONOMY SERVICE',
			),
			// 'SDS' => array(
			// 	'name' => 'TIKI SAMEDAY SERVICE',
			// ),
			// 'HDS' => array(
			// 	'name' => 'TIKI HOLIDAY SERVICE',
			// ),
		);
	}

}
