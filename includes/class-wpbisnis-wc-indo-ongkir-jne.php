<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_JNE extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - JNE', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari Jalur Nugraha Ekakurir (JNE).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'JNE';
	}

	public function get_unique_id() {
		return 'indo_ongkir_jne';
	}

	public function get_courier() {
		return 'jne';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'JNE REG',
				'alias' => 'CTC',
				'default' => true,
			),
			'YES' => array(
				'name' => 'JNE YES',
				'alias' => 'CTCYES',
				'default' => true,
			),
			'OKE' => array(
				'name' => 'JNE OKE',
			),
			// 'JTR' => array(
			// 	'name' => 'JNE JTR',
			// ),
			// 'JTR250' => array(
			// 	'name' => 'JNE JTR250',
			// ),
			// 'JTR<150' => array(
			// 	'name' => 'JNE JTR<150',
			// ),
			// 'JTR>250' => array(
			// 	'name' => 'JNE JTR>250',
			// ),
		);
	}

}
