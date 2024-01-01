<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_RPX extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - RPX', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari RPX Holding (RPX).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'RPX';
	}

	public function get_unique_id() {
		return 'indo_ongkir_rpx';
	}

	public function get_courier() {
		return 'rpx';
	}

	public function get_services() {
		return array(
			'RGP' => array(
				'name' => 'RPX Regular Package',
				'default' => true,
			),
			// 'REP' => array(
			// 	'name' => 'RPX Retail Package',
			// ),
			// 'ERP' => array(
			// 	'name' => 'RPX Ecommerce Package',
			// ),
			'NDP' => array(
				'name' => 'RPX Next Day Package',
			),
			// 'MDP' => array(
			// 	'name' => 'RPX MidDay Package',
			// ),
			// 'SDP' => array(
			// 	'name' => 'RPX SameDay Package',
			// ),
		);
	}

}
