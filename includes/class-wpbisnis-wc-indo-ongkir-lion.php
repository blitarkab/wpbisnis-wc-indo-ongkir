<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_LION extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - LION', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Lion Parcel (LION).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'LION';
	}

	public function get_unique_id() {
		return 'indo_ongkir_lion';
	}

	public function get_courier() {
		return 'lion';
	}

	public function get_services() {
		return array(
			'REGPACK' => array(
				'name' => 'Lion Parcel Regular Service',
				'default' => true,
			),
		);
	}

}
