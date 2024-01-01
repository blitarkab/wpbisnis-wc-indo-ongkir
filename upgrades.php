<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'init', 'wpbisnis_wc_indo_ongkir_upgrades_init', 20 );
function wpbisnis_wc_indo_ongkir_upgrades_init() {
	// delete_option( 'wpbisnis_wc_indo_ongkir_version' ); /* debug */
	// update_option( 'wpbisnis_wc_indo_ongkir_version', '0.2.9' ); /* debug */
	$wpbisnis_wc_indo_ongkir_version = get_option( 'wpbisnis_wc_indo_ongkir_version' );
	if ( $wpbisnis_wc_indo_ongkir_version == WPBISNIS_WC_INDO_ONGKIR_VERSION  ) {
		return;
	}
	wpbisnis_wc_indo_ongkir_upgrades_check( $wpbisnis_wc_indo_ongkir_version );
	update_option( 'wpbisnis_wc_indo_ongkir_version', WPBISNIS_WC_INDO_ONGKIR_VERSION );
}

function wpbisnis_wc_indo_ongkir_upgrades_check( $wpbisnis_wc_indo_ongkir_version ) {
	if ( ! $wpbisnis_wc_indo_ongkir_version ) {
		$wpbisnis_wc_indo_ongkir_version = '0.2.9';
		wpbisnis_wc_indo_ongkir_upgrade_fresh();
	}
	$wpbisnis_wc_indo_ongkir_upgrades = get_option( 'wpbisnis_wc_indo_ongkir_upgrades', [] );
	$upgrades = [
		'1.0.0'   => 'wpbisnis_wc_indo_ongkir_upgrade_v100',
		'1.2.0'   => 'wpbisnis_wc_indo_ongkir_upgrade_v120',
		'1.3.0'   => 'wpbisnis_wc_indo_ongkir_upgrade_v130',
		'1.3.2'   => 'wpbisnis_wc_indo_ongkir_upgrade_v132',
		'1.3.3'   => 'wpbisnis_wc_indo_ongkir_upgrade_v133',
		'1.3.3.3' => 'wpbisnis_wc_indo_ongkir_upgrade_v133',
	];
	foreach ( $upgrades as $version => $function ) {
		if ( version_compare( $wpbisnis_wc_indo_ongkir_version, $version, '<' ) && ! isset( $wpbisnis_wc_indo_ongkir_upgrades[ $version ] ) ) {
			call_user_func( $function );
			$wpbisnis_wc_indo_ongkir_upgrades[ $version ] = true;
			update_option( 'wpbisnis_wc_indo_ongkir_upgrades', $wpbisnis_wc_indo_ongkir_upgrades );
		}
	}
}

function wpbisnis_wc_indo_ongkir_delete_transient() {
	delete_transient( 'wpbisnis_wc_indo_ongkir_jne' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_tiki' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_pos' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_jnt' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_sicepat' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_wahana' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_indah' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_rpx' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_pandu' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_pahala' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_cahaya' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_dse' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_first' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_jet' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_ncs' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_nss' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_sap' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_ninja' );
	delete_transient( 'wpbisnis_wc_indo_ongkir_lion' );
}

function wpbisnis_wc_indo_ongkir_upgrade_fresh() {
	update_option( 'woocommerce_ship_to_destination', 'billing_only' );
	wpbisnis_wc_indo_ongkir_delete_transient();
}

function wpbisnis_wc_indo_ongkir_upgrade_v100() {
	update_option( 'woocommerce_ship_to_destination', 'billing_only' );
	wpbisnis_wc_indo_ongkir_delete_transient();
}

function wpbisnis_wc_indo_ongkir_upgrade_v120() {
	wpbisnis_wc_indo_ongkir_delete_transient();
}

function wpbisnis_wc_indo_ongkir_upgrade_v130() {
	wpbisnis_wc_indo_ongkir_delete_transient();
}

function wpbisnis_wc_indo_ongkir_upgrade_v132() {
	wpbisnis_wc_indo_ongkir_delete_transient();
}

function wpbisnis_wc_indo_ongkir_upgrade_v133() {
	delete_transient( 'wpbisnis_wc_indo_ongkir_cache' );
}
