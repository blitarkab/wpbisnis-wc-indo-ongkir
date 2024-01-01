<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPBisnis_WC_Indo_Ongkir_Base extends WC_Shipping_Method {

	private $services;

	private $api_url = 'ongkir.wpbisnis.com/api/';

	public function get_method_title() {
		return '';
	}

	public function get_method_description() {
		return '';
	}

	public function get_instance_title() {
		return '';
	}

	public function get_unique_id() {
		return '';
	}

	public function get_courier() {
		return '';
	}

	public function get_services() {
		return array();
	}

	public function __construct( $instance_id = 0 ) {
		$this->instance_id        = absint( $instance_id );
		$this->id                 = $this->get_unique_id();
		$this->method_title       = $this->get_method_title();
		$this->method_description = $this->get_method_description();
		$this->supports           = array(
			'shipping-zones',
			'instance-settings',
		);
		$this->init();
	}

	private function init() {
		$this->init_form_fields();
		$this->set_settings();
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	public function init_form_fields() {
		$this->instance_form_fields = array(
			'title'          => array(
				'title'       => __( 'Judul', 'wpbisnis-wc-indo-ongkir' ),
				'type'        => 'text',
				'description' => '',
				'default'     => $this->get_instance_title(),
			),
			'services'       => array(
				'type' => 'services',
			),
			'toleransi'       => array(
				'title'       => __( 'Toleransi Berat (gram)', 'wpbisnis-wc-indo-ongkir' ),
				'type'        => 'text',
				'description' => __( 'Beberapa ekspedisi pengiriman, seperti JNE dan TIKI misalnya, mempunyai toleransi berat, misalnya berat 1200 gram masih dihitung 1 kg. Hal ini bisa berubah sewaktu-waktu. Supaya aman, kami tidak menerapkan toleransi berat secara umum, silahkan gunakan fitur itu untuk mengatur toleransi berat yang diinginkan, antara 1000 gram hingga 1999 gram.', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '1000',
				'default'     => '',
			),
		);
	}

	public function generate_services_html() {
		// var_dump( $this->custom_services );
		ob_start();
?>
<tr valign="top" id="service_options">
<th scope="row" class="titledesc"><?php _e( 'Kurir', 'wpbisnis-wc-indo-ongkir' ); ?></th>
<td class="forminp">
<style type="text/css">
.indo_ongkir_services td {
	vertical-align: middle;
	padding: 4px 7px;
}
.indo_ongkir_services th {
	vertical-align: middle;
	padding: 9px 7px;
}
.indo_ongkir_services th.sort {
	width: 16px;
}
.indo_ongkir_services td.sort {
	cursor: move;
	width: 16px;
	padding: 0 16px;
	cursor: move;
	background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAAHUlEQVQYV2O8f//+fwY8gJGgAny6QXKETRgEVgAAXxAVsa5Xr3QAAAAASUVORK5CYII=) no-repeat center;
}
</style>
<script type="text/javascript">
jQuery( window ).load( function () {
	jQuery( '.indo_ongkir_services tbody' ).sortable( {
		items: 'tr',
		cursor: 'move',
		axis: 'y',
		handle: '.sort',
		scrollSensitivity: 40,
		forcePlaceholderSize: true,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'wc-metabox-sortable-placeholder',
		start: function ( event, ui ) {
			ui.item.css( 'background-color', '#f6f6f6' );
		},
		stop: function ( event, ui ) {
			ui.item.removeAttr( 'style' );
			indo_ongkir_services_row_indexes();
		}
	} );
	function indo_ongkir_services_row_indexes() {
		jQuery( '.indo_ongkir_services tbody tr' ).each( function ( index, el ) {
			jQuery( 'input.order', el ).val( parseInt( jQuery( el ).index( '.indo_ongkir_services tr' ) ) );
		} );
	};
} );
</script>
<table class="indo_ongkir_services widefat">
	<thead>
		<th class="sort">&nbsp;</th>
		<th style="padding: 10px;"><?php _e( 'Aktif', 'wpbisnis-wc-indo-ongkir' ); ?></th>
		<th style="padding: 10px;"><?php _e( 'Kurir', 'wpbisnis-wc-indo-ongkir' ); ?></th>
		<th><?php _e( 'Nama', 'wpbisnis-wc-indo-ongkir' ); ?></th>
		<th><?php echo sprintf( __( 'Markup (%s)', 'wpbisnis-wc-indo-ongkir' ), get_woocommerce_currency_symbol() ); ?></th>
	</thead>
	<tbody>
	<?php
	$sort = 0;
	$this->ordered_services = array();
	foreach ( $this->services as $code => $values ) {
		if ( is_array( $values ) ) {
			$name = $values['name'];
		}
		else {
			$name = $values;
		}
		if ( isset( $this->custom_services[ $code ] ) && isset( $this->custom_services[ $code ]['order'] ) ) {
			$sort = $this->custom_services[ $code ]['order'];
		}
		while ( isset( $this->ordered_services[ $sort ] ) ) {
			$sort++;
		}
		$this->ordered_services[ $sort ] = array( $code, $name );
		$sort++;
	}
	ksort( $this->ordered_services );
	foreach ( $this->ordered_services as $value ) {
		$code = $value[0];
		$name = $value[1];
		if ( ! isset( $this->custom_services[ $code ] ) ) {
			$this->custom_services[ $code ] = array();
		}
		if ( !isset( $this->custom_services[ $code ]['enabled'] ) ) {
			if ( isset( $this->services[ $code ]['default'] ) && $this->services[ $code ]['default'] ) {
				$this->custom_services[ $code ]['enabled'] = true;
			}
			else {
				$this->custom_services[ $code ]['enabled'] = null;
			}
		}
		?>
		<tr>
			<td class="sort">
				<input type="hidden" class="order" name="indo_ongkir_services[<?php echo $code; ?>][order]" value="<?php echo isset( $this->custom_services[ $code ]['order'] ) ? $this->custom_services[ $code ]['order'] : ''; ?>"/>
			</td>
			<td>
				<input type="checkbox" name="indo_ongkir_services[<?php echo $code; ?>][enabled]" <?php checked( $this->custom_services[ $code ]['enabled'], true ); ?> />
			</td>
			<td>
				<strong><?php echo $this->services[ $code ]['name']; ?> </strong>
			</td>
			<td>
				<input type="text" name="indo_ongkir_services[<?php echo $code; ?>][name]" placeholder="<?php echo $name; ?>" value="<?php echo isset( $this->custom_services[ $code ]['name'] ) ? $this->custom_services[ $code ]['name'] : ''; ?>" size="50"/>
			</td>
			<td><input style="text-align:right;" type="text" name="indo_ongkir_services[<?php echo $code; ?>][adjustment]" placeholder="0" value="<?php echo isset( $this->custom_services[ $code ]['adjustment'] ) ? $this->custom_services[ $code ]['adjustment'] : ''; ?>" size="12"/></td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>
</td>
</tr>
<?php 
		return ob_get_clean();
	}

	public function validate_services_field( $key ) {
		$services        = array();
		$posted_services = $_POST['indo_ongkir_services'];
		foreach ( $posted_services as $code => $settings ) {
			$services[ $code ] = array(
				'name'                  => wc_clean( $settings['name'] ),
				'order'                 => wc_clean( $settings['order'] ),
				'enabled'               => isset( $settings['enabled'] ) ? true : false,
				'adjustment'            => wc_clean( $settings['adjustment'] ),
			);
		}
		return $services;
	}

	public function process_admin_options() {
		parent::process_admin_options();
		$this->set_settings();
	}

	private function set_settings() {
		$this->title            = $this->get_option( 'title', $this->method_title );
		$this->custom_services  = $this->get_option( 'services', array() );
		$this->services         = $this->get_services();
		$this->toleransi        = $this->get_option( 'toleransi' );

		$ongkir_mode            = get_option( 'wpbisnis_wc_indo_ongkir_mode' );
		if ( !$ongkir_mode ) {
			$ongkir_mode = 'wp_remote_post';
		}
		$this->ongkir_mode      = $ongkir_mode;
	}

	private function get_api_url() {
		add_filter( 'https_ssl_verify', '__return_false' );
		if ( 'wp_remote_post_http' == $this->ongkir_mode || 'file_get_contents_http' == $this->ongkir_mode ) {
			return 'http://'.$this->api_url;
		}
		else {
			return 'https://'.$this->api_url;
		}
	}

	public function calculate_shipping( $package = array() ) {

		$shipping_country = $package['destination']['country'];
		$shipping_state = $package['destination']['state'];
		$shipping_city = $package['destination']['city'];

		if ( 'ID' !== $shipping_country ) {
			return;
		}

		if ( isset( $package['origin'] ) && !empty( $package['origin'] ) ) {
			$origin = $package['origin'];
		}
		else {
			$origin = get_option( 'wpbisnis_wc_indo_ongkir_origin' );
		}

		if ( $origin ) {
			$origin = intval( $origin );
		}
		else {
			$origin = '151';
		}

		// $this->add_rate( array( 'id' => $this->get_rate_id(1), 'label' => "1", 'cost' => 1, 'calc_tax' => 'per_item' ) );

		$destination = '';
		if ( $shipping_state && false !== strpos( $shipping_city, ', ' ) ) {
			$kecamatan_file = WPBISNIS_WC_INDO_ONGKIR_PATH.'/includes/data/kecamatan-name2id/'.$shipping_state.'.php';
			if ( file_exists( $kecamatan_file ) ) {
				$kecamatan = include( $kecamatan_file );
				if ( isset( $kecamatan[$shipping_city] ) && !empty( $kecamatan[$shipping_city] ) ) {
					$destination = intval( $kecamatan[$shipping_city] );
				}
			}
		}

		// $this->add_rate( array( 'id' => $this->get_rate_id(1), 'label' => 'destination'.$destination, 'cost' => 1, 'calc_tax' => 'per_item' ) );

		if ( !$destination ) {
			return;
		}

		// $this->add_rate( array( 'id' => $this->get_rate_id(2), 'label' => "2", 'cost' => 2, 'calc_tax' => 'per_item' ) );

		// $this->add_rate( array( 'id' => $this->get_rate_id(3), 'label' => "from $origin to $destination", 'cost' => 1, 'calc_tax' => 'per_item' ) );

		$services = $this->get_services();
		$custom_services = $this->custom_services;

		// $this->add_rate( array( 'id' => $this->get_rate_id('services'), 'label' => json_encode($services), 'cost' => 1, 'calc_tax' => 'per_item' ) );
		// $this->add_rate( array( 'id' => $this->get_rate_id('custom_services'), 'label' => json_encode($custom_services), 'cost' => 1, 'calc_tax' => 'per_item' ) );

		$services_active = array();
		$services_alias = array();
		if ( !empty( $this->custom_services ) ) {
			foreach ( $this->custom_services as $key => $value) {
				if ( isset( $value['enabled'] ) && true === $value['enabled'] ) {
					if ( isset( $services[$key] ) ) {
						$services_active[] = $key;
					}
					if ( isset($services[$key]['alias']) && $services[$key]['alias'] ) {
						$services_active[] = $services[$key]['alias'];
						$services_alias[$services[$key]['alias']] = $key;
					}
				}
			}
		}
		else {
			$custom_services = array();
			foreach ( $this->services as $key => $value) {
				$custom_services[$key]['name'] = '';
				$custom_services[$key]['order'] = '';
				$custom_services[$key]['enabled'] = false;
				$custom_services[$key]['adjustment'] = 0;
				if ( isset( $value['default'] ) && $value['default'] ) {
					$custom_services[$key]['enabled'] = true;
					$services_active[] = $key;
					if ( isset($value['alias']) && $value['alias'] ) {
						$services_active[] = $value['alias'];
						$services_alias[$value['alias']] = $key;
					}
				}
			}
		}

		// $this->add_rate( array( 'id' => $this->get_rate_id('services_active'), 'label' => json_encode($services_active), 'cost' => 1, 'calc_tax' => 'per_item' ) );

		if ( empty( $services_active ) ) {
			return;
		}

		// return;


		$weight = $this->get_weight_in_gram( $package );
		if ( !$weight )
			$weight = 1000;

		if ( $this->toleransi && $this->toleransi > 1000 && $this->toleransi < 2000 ) {
			$toleransi = $this->toleransi - 1000;
			if ( $weight > 1000 ) {
				$weight = $weight - $toleransi;
			}
		}

		$weight_multiplier = $weight / 1000;
		$weight_multiplier = ceil ( $weight_multiplier );

		// $this->add_rate( array( 'id' => $this->get_rate_id('weight'), 'label' => 'weight multiplier', 'cost' => $weight_multiplier, 'calc_tax' => 'per_item' ) );

		$courier = $this->get_courier();

		$costs = $this->get_costs( $origin, $destination );

		$rates = array();
		if ( !empty( $costs ) && is_array( $costs ) ) {
			foreach ( $costs as $service ) {
				if ( isset( $service['cost'] ) ) {
					foreach ( $service['cost'] as $cost ) {
						if ( in_array( $service['service'], $services_active ) ) {
							if ( $cost['value'] > 0 ) {
								$rate_name = $service['service'];
								if ( !isset( $services[$rate_name] ) ) {
									if ( isset( $services_alias[$rate_name] ) ) {
										$rate_name = $services_alias[$rate_name];
									}
								}
								$rate_id = str_replace( ' ', '_', strtolower($rate_name) );
								if ( isset( $custom_services[$rate_name] ) ) {
									if ( !empty( $custom_services[$rate_name]['name'] ) ) {
										$rate_label = $custom_services[$rate_name]['name'];
									}
									else {
										if ( !empty( $services[$rate_name]['name'] ) ) {
											$rate_label = $services[$rate_name]['name'];
										}
										else {
											$rate_label = strtoupper( $courier ) . " " . $service['service'];
										}
									}
								}
								// $rate_cost = $cost['value'] * $weight_multiplier;
								$rate_cost = $this->prepare_cost( $service['service'], $cost['value'], $weight_multiplier );
								if ( isset( $custom_services[$rate_name]['adjustment'] ) && 0 < $custom_services[$rate_name]['adjustment'] ) {
									$rate_cost = $rate_cost + $custom_services[$rate_name]['adjustment'];
								}
								$rates[$rate_name] = array(
									'id' => $this->get_rate_id( $rate_id ),
									'label' => $rate_label,
									'cost' => $rate_cost,
									'package' => $package,
								);
							}
						}
					}
				}
			}
			if ( !empty( $rates ) ) {
				foreach ( $services_active as $service_name ) {
					if ( isset($rates[$service_name]) ) {
						$this->add_rate( $rates[$service_name] );
					}
				}
			}
		}
	}

	private function prepare_cost ( $service, $cost, $weight_multiplier ) {
		$cost = floatval( $cost );
		$weight_multiplier = floatval( $weight_multiplier );
		if ( in_array( $service, array( 'JTR250', 'JTR<150', 'JTR>250' ) ) ) {
			$value = $cost;
		}
		elseif ( 'JTR' == $service ) {
			if ( $weight_multiplier <= 10 ) {
				$value = $cost;
			}
			elseif ( $weight_multiplier > 10 && $weight_multiplier <= 50 ) {
				$value = $cost + ( ( $weight_multiplier - 10 ) * 3 * $cost / 40 );
			}
			else {
				$value = ( $cost * 4 ) + ( ( $weight_multiplier - 50 ) * $cost / 20 );
			}
		}
		else {
			$value = $cost * $weight_multiplier;
		}
		return $value;
	}

	private function get_costs( $origin, $destination ) {

		if ( ! $origin ) {
		   return false;
		}
		if ( ! $destination ) {
		   return false;
		}

		$courier = $this->get_courier();

		if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
			$license = trim( get_option( 'wpbisnis_wc_indo_ongkir_license' ) );
		}
		else {
			$license = trim( get_option( get_template().'_license_key' ) );
		}

		if ( $license ) {
			$cache = get_transient( 'wpbisnis_wc_indo_ongkir_cache' );
			if ( isset( $cache[$courier][$origin][$destination] ) ) {
				return $cache[$courier][$origin][$destination];
			}
		}

		$postdata = array(
			'license'         => $license,
			'url'             => home_url('/'),
			'item_name'       => urlencode( WPBISNIS_WC_INDO_ONGKIR_NAME ),
			'store'           => WPBISNIS_WC_INDO_ONGKIR_STORE,
			'origin'          => $origin,
			'originType'      => 'city',
			'destination'     => $destination,
			'destinationType' => 'subdistrict',
			'weight'          => '1000',
			'courier'         => $courier,
		);

		if ( 'wp_remote_post' == $this->ongkir_mode || 'wp_remote_post_http' == $this->ongkir_mode ) {
			$response = wp_remote_post( $this->get_api_url(), array(
				'body' => $postdata
			) );
			if ( is_wp_error( $response ) ) {
			   $error_message = $response->get_error_message();
			} 
			else {
				if ( 200 == $response['response']['code'] ) {
					$output = json_decode( $response['body'], true );
					if ( !empty( $output ) ) {
						$cache[$courier][$origin][$destination] = $output;
						set_transient( 'wpbisnis_wc_indo_ongkir_cache', $cache, DAY_IN_SECONDS );
						return $output;
					}
				}
			}
		}
		elseif ( 'file_get_contents' == $this->ongkir_mode || 'file_get_contents_http' == $this->ongkir_mode ) {
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
			 		'content' => http_build_query( $postdata )
				),
			);
			$context = stream_context_create( $opts );
			$result = @file_get_contents( $this->get_api_url(), false, $context );
			if ( $result ) {
				$output = json_decode( $result, true );
				if ( !empty( $output ) ) {
					$cache[$courier][$origin][$destination] = $output;
					set_transient( 'wpbisnis_wc_indo_ongkir_cache', $cache, DAY_IN_SECONDS );
					return $output;
				}
			}
		}

		return false;
	}

	private function get_weight_in_gram( $package ) {
		if ( isset( $package['weight'] ) ) {
			$weight = $package['weight'];
		}
		else {
			$weight = WC()->cart->cart_contents_weight;
		}
		$weight = $this->wc_get_weight($weight, 'g');
		return $weight;
	}

	private function wc_get_weight( $weight, $to_unit, $from_unit = '' ) {

		if ( function_exists('wc_get_weight') ) {
			return wc_get_weight( $weight, $to_unit, $from_unit );
		}

		$weight  = (float) $weight;
		$to_unit = strtolower( $to_unit );

		if ( empty( $from_unit ) ) {
			$from_unit = strtolower( get_option( 'woocommerce_weight_unit' ) );
		}

		// Unify all units to kg first.
		if ( $from_unit !== $to_unit ) {
			switch ( $from_unit ) {
				case 'g' :
					$weight *= 0.001;
					break;
				case 'lbs' :
					$weight *= 0.453592;
					break;
				case 'oz' :
					$weight *= 0.0283495;
					break;
			}

			// Output desired unit.
			switch ( $to_unit ) {
				case 'g' :
					$weight *= 1000;
					break;
				case 'lbs' :
					$weight *= 2.20462;
					break;
				case 'oz' :
					$weight *= 35.274;
					break;
			}
		}

		return ( $weight < 0 ) ? 0 : $weight;
	}

}
