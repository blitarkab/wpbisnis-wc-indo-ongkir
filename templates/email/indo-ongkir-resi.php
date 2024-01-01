<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $resi_items ) : ?>
	<h2><?php _e( 'Resi Pengiriman', 'wpbisnis-wc-indo-ongkir' ); ?></h2>

	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%;" border="1">

		<thead>
			<tr>
				<th class="indo-ongkir-resi-name" scope="col" class="td" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;"><?php _e( 'Pengiriman', 'wpbisnis-wc-indo-ongkir' ); ?></th>
				<th class="indo-ongkir-resi-resi" scope="col" class="td" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;"><?php _e( 'Nomor Resi', 'wpbisnis-wc-indo-ongkir' ); ?></th>
				<th class="indo-ongkir-resi-date" scope="col" class="td" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;"><?php _e( 'Tanggal', 'wpbisnis-wc-indo-ongkir' ); ?></th>
				<th class="order-actions" scope="col" class="td" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">&nbsp;</th>
			</tr>
		</thead>

		<tbody><?php
		foreach ( $resi_items as $resi_item ) {
				?><tr class="tracking">
					<td class="indo-ongkir-resi-name" data-title="<?php _e( 'Pengiriman', 'wpbisnis-wc-indo-ongkir' ); ?>" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">
						<?php echo esc_html( $resi_item['name'] ); ?>
						<?php if ( $resi_item['items'] ) : ?>
							<?php echo '<br/><em>'.$resi_item['items'].'</em>'; ?>
						<?php endif; ?>
					</td>
					<td class="indo-ongkir-resi-resi" data-title="<?php _e( 'Nomor Resi', 'wpbisnis-wc-indo-ongkir' ); ?>" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">
						<?php echo esc_html( $resi_item['resi'] ); ?>
					</td>
					<td class="indo-ongkir-resi-date" data-title="<?php _e( 'Tanggal', 'wpbisnis-wc-indo-ongkir' ); ?>" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">
						<time datetime="<?php echo $resi_item['date']; ?>" title="<?php echo $resi_item['date']; ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $resi_item['date'] ) ); ?></time>
					</td>
					<td class="order-actions" style="text-align: center; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">
						<?php if ( $resi_item['link'] ) : ?>
							<a href="<?php echo esc_url( $resi_item['link'] ); ?>" target="_blank"><?php _e( 'Cek Status', 'wpbisnis-wc-indo-ongkir' ); ?></a>
						<?php endif; ?>
					</td>
				</tr><?php
		}
		?></tbody>
	</table>

<?php
endif;
