<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_NINJA extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - NINJA', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Ninja Xpress (NINJA).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'NINJA';
	}

	public function get_unique_id() {
		return 'indo_ongkir_ninja';
	}

	public function get_courier() {
		return 'ninja';
	}

	public function get_services() {
		return array(
			'STANDARD' => array(
				'name' => 'Ninja Xpress Standard Service',
				'default' => true,
			),
			'NEXTDAY' => array(
				'name' => 'Ninja Xpress Next Day Service',
			),
		);
	}

}
