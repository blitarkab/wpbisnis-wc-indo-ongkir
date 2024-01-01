<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $resi_items ) :

	_e( 'RESI PENGIRIMAN', 'wpbisnis-wc-indo-ongkir' );

		echo  "\n";

		foreach ( $resi_items as $resi_item ) {
			echo esc_html( $resi_item[ 'name' ] ) . "\n";
			echo esc_html( $resi_item[ 'resi' ] ) . "\n";
			echo esc_html( $resi_item[ 'date' ] ) . "\n";
			echo esc_url( $resi_item['link'] ) . "\n\n";
		}

	echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= \n\n";

endif;

?>
