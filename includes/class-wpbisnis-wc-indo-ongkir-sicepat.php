<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_SICEPAT extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - SICEPAT', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari SiCepat Express (SICEPAT).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'SICEPAT';
	}

	public function get_unique_id() {
		return 'indo_ongkir_sicepat';
	}

	public function get_courier() {
		return 'sicepat';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'SiCepat Layanan Reguler',
				'default' => true,
			),
			'BEST' => array(
				'name' => 'SiCepat Besok Sampai Tujuan',
			),
		);
	}

}
