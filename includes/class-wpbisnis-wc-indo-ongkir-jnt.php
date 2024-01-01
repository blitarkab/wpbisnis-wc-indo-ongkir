<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_JNT extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - J&T', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari J&T Express (J&T).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'J&T';
	}

	public function get_unique_id() {
		return 'indo_ongkir_jnt';
	}

	public function get_courier() {
		return 'jnt';
	}

	public function get_services() {
		return array(
			'EZ' => array(
				'name' => 'J&T Regular Service',
				'default' => true,
			),
		);
	}

}
