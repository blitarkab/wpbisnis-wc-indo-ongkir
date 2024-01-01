<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_SAP extends WPBisnis_WC_Indo_Ongkir_Base {

	public function get_method_title() {
		return __( 'Indo Ongkir - SAP', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_method_description() {
		return __( 'Modul Indo Ongkir yang menghitung ongkir otomatis dari SAP Express (SAP).', 'wpbisnis-wc-indo-ongkir' );
	}

	public function get_instance_title() {
		return 'SAP';
	}

	public function get_unique_id() {
		return 'indo_ongkir_sap';
	}

	public function get_courier() {
		return 'sap';
	}

	public function get_services() {
		return array(
			'REG' => array(
				'name' => 'SAP Regular Service',
				'default' => true,
			),
			'ODS' => array(
				'name' => 'SAP One Day Service',
			),
		);
	}

}
