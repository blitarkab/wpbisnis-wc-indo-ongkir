<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_WAHANA extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - WAHANA', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Wahana Prestasi Logistik (WAHANA).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'WAHANA';
	}

	public function get_unique_id() {
		return 'indo_ongkir_wahana';
	}

	public function get_courier() {
		return 'wahana';
	}

	public function get_services() {
		return array(
			'Normal' => array(
				'name' => 'WAHANA Normal Service',
				'default' => 'true',
			),
		);
	}

}
