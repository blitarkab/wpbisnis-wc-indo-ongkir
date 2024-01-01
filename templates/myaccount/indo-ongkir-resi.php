<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $resi_items ) : ?>

	<h2><?php _e( 'Resi Pengiriman', 'wpbisnis-wc-indo-ongkir' ); ?></h2>

	<table class="shop_table shop_table_responsive shop_table_indo-ongkir-resi">
		<thead>
			<tr>
				<th class="indo-ongkir-resi-name"><span class="nobr"><?php _e( 'Pengiriman', 'wpbisnis-wc-indo-ongkir' ); ?></span></th>
				<th class="indo-ongkir-resi-resi"><span class="nobr"><?php _e( 'Nomor Resi', 'wpbisnis-wc-indo-ongkir' ); ?></span></th>
				<th class="indo-ongkir-resi-date"><span class="nobr"><?php _e( 'Tanggal', 'wpbisnis-wc-indo-ongkir' ); ?></span></th>
				<th class="order-actions">&nbsp;</th>
			</tr>
		</thead>
		<tbody><?php
		foreach ( $resi_items as $resi_item ) {
				?><tr class="indo-ongkir-resi">
					<td class="indo-ongkir-resi-name" data-title="<?php _e( 'Pengiriman', 'wpbisnis-wc-indo-ongkir' ); ?>">
						<?php echo esc_html( $resi_item['name'] ); ?>
						<?php if ( $resi_item['items'] ) : ?>
							<?php echo '<br/><small>'.$resi_item['items'].'</small>'; ?>
						<?php endif; ?>
					</td>
					<td class="indo-ongkir-resi-resi" data-title="<?php _e( 'Nomor Resi', 'wpbisnis-wc-indo-ongkir' ); ?>">
						<?php echo esc_html( $resi_item['resi'] ); ?>
					</td>
					<td class="indo-ongkir-resi-date" data-title="<?php _e( 'Tanggal', 'wpbisnis-wc-indo-ongkir' ); ?>" style="text-align:left; white-space:nowrap;">
						<time datetime="<?php echo $resi_item['date']; ?>" title="<?php echo $resi_item['date']; ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $resi_item['date'] ) ); ?></time>
					</td>
					<td class="order-actions" style="text-align: center;">
						<?php if ( $resi_item['link'] ) : ?>
							<a href="<?php echo esc_url( $resi_item['link'] ); ?>" target="_blank" class="button"><?php _e( 'Cek Status', 'wpbisnis-wc-indo-ongkir' ); ?></a>
						<?php endif; ?>
					</td>
				</tr><?php
		}
		?></tbody>
	</table>

<?php
endif;
