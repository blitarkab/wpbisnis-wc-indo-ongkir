<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPBisnis_WC_Indo_Checkout_Init {

	private static $instance;

	public static function get_instance() {
		return null === self::$instance ? ( self::$instance = new self ) : self::$instance;
	}

	public function __construct() {
		$this->fields_prepared = false;
		$this->address_fields = array();
		$this->billing_fields = array();
		$this->shipping_fields = array();
		$this->additional_fields = array();
		$this->address_mode = 'indo-ongkir-select';
		if ( 'autocomplete' == get_option( 'wpbisnis_wc_indo_ongkir_address' ) ) {
			$this->address_mode = 'indo-ongkir-autocomplete';
		}
		$this->fields_default();
		$this->fields_setup();
		$this->fields_text();
		if ( function_exists( 'WC' ) ) {
			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 );
			add_action( 'woocommerce_settings_tabs_indo_checkout', array( $this, 'settings_tab' ) );
			add_action( 'woocommerce_update_options_indo_checkout', array( $this, 'update_settings' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_checkout_address_fields', array( $this, 'admin_address_fields' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_checkout_billing_fields', array( $this, 'admin_billing_fields' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_checkout_shipping_fields', array( $this, 'admin_shipping_fields' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_checkout_additional_fields', array( $this, 'admin_additional_fields' ) );
			if ( $this->is_active() ) {
				add_action( 'woocommerce_checkout_billing', array( $this, 'add_style' ) );
				add_filter( 'woocommerce_billing_fields', array( $this, 'billing_fields' ), 100 );
				add_filter( 'woocommerce_shipping_fields', array( $this, 'shipping_fields' ), 100 );
				add_filter( 'woocommerce_checkout_fields', array( $this, 'checkout_fields' ), 100 );
				add_filter( 'woocommerce_get_country_locale', array( $this, 'country_locale' ) );
				add_action( 'customize_register', array( $this, 'customize_register' ), 20 );
			}
		} 
	}

	private function fields_default(){

		$this->address_fields_default = array(
			'address_1' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => 'textarea',
			),
			'address_2' => array(
				'show' => 'no',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'country' => array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
		);
		if ( 'indo-ongkir-autocomplete' != $this->address_mode ) {
			$this->address_fields_default['state'] = array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			);
			$this->address_fields_default['indo_ongkir_kota'] = array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			);
			$this->address_fields_default['indo_ongkir_kecamatan'] = array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			);
		}
		else {
			$this->address_fields_default['city'] = array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			);
		}
		$this->address_fields_default['postcode'] = array(
			'show' => 'yes',
			'required' => 'no',
			'label' => '',
			'placeholder' => '',
			'type' => '',
		);

		$this->billing_fields_default = array(
			'billing_first_name' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_last_name' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_company' => array(
				'show' => 'no',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_address' => array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_phone' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_email' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
		);

		$this->shipping_fields_default = array(
			'shipping_first_name' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_last_name' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_company' => array(
				'show' => 'no',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_address' => array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
		);

		$this->additional_fields_default = array(
			'order_comments' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
		);

	}

	private function fields_setup(){

		$this->address_fields_setup = array(
			'address_1' => array(
				'show' => false,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => true,
				'type_choices' => array( 'text' => 'text', 'textarea' => 'textarea' ),
			),
			'address_2' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'country' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => false,
				'type' => false,
			),
		);
		if ( 'indo-ongkir-autocomplete' != $this->address_mode ) {
			$this->address_fields_setup['state'] = array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			);
			$this->address_fields_setup['indo_ongkir_kota'] = array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			);
			$this->address_fields_setup['indo_ongkir_kecamatan'] = array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			);
		}
		else {
			$this->address_fields_setup['city'] = array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => false,
				'type' => false,
			);
		}
		$this->address_fields_setup['postcode'] = array(
			'show' => true,
			'required' => true,
			'label' => true,
			'placeholder' => true,
			'type' => false,
		);

		$this->billing_fields_setup = array(
			'billing_first_name' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_last_name' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_company' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_address' => array(
				'show' => false,
				'required' => false,
				'label' => false,
				'placeholder' => false,
				'type' => false,
			),
			'billing_phone' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_email' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
		);

		$this->shipping_fields_setup = array(
			'shipping_first_name' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_last_name' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_company' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_address' => array(
				'show' => false,
				'required' => false,
				'label' => false,
				'placeholder' => false,
				'type' => false,
			),
		);

		$this->additional_fields_setup = array(
			'order_comments' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
		);

	}

	private function fields_text(){

		$this->address_fields_text = array(
			'address_1' => array(
				'label' => __( 'Alamat Lengkap', 'wpbisnis-wc-indo-ongkir' ),
				// 'placeholder' => ' ',
				'placeholder' => __( 'Nama jalan dan nomor rumah', 'wpbisnis-wc-indo-ongkir' ),
			),
			'address_2' => array(
				'label' => '',
				// 'placeholder' => ' ',
				'placeholder' => __( 'tambahan detail alamat (opsional)', 'wpbisnis-wc-indo-ongkir' ),
			),
			'country' => array(
				'label' => __( 'Negara', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'state' => array(
				'label' => __( 'Provinsi', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Pilih Provinsi...', 'wpbisnis-wc-indo-ongkir' ),
			),
			'city' => array(
				'label' => __( 'Kecamatan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Pilih Kecamatan...', 'wpbisnis-wc-indo-ongkir' ),
			),
			'indo_ongkir_kota' => array(
				'label' => __( 'Kota / Kabupaten', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Pilih Kota / Kabupaten...', 'wpbisnis-wc-indo-ongkir' ),
			),
			'indo_ongkir_kecamatan' => array(
				'label' => __( 'Kecamatan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Pilih Kecamatan...', 'wpbisnis-wc-indo-ongkir' ),
			),
			'postcode' => array(
				'label' => __( 'Kode Pos', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
		);

		$this->billing_fields_text = array(
			'billing_first_name' => array(
				'label' => __( 'Nama Depan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_last_name' => array(
				'label' => __( 'Nama Belakang', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_company' => array(
				'label' => __( 'Nama Perusahaan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_address' => array(
				'label' => '',
				'placeholder' => '',
			),
			'billing_phone' => array(
				'label' => __( 'No HP / Whatsapp', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_email' => array(
				'label' => __( 'Email', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
		);

		$this->shipping_fields_text = array(
			'shipping_first_name' => array(
				'label' => __( 'Nama Depan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'shipping_last_name' => array(
				'label' => __( 'Nama Belakang', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'shipping_company' => array(
				'label' => __( 'Nama Perusahaan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'shipping_address' => array(
				'label' => '',
				'placeholder' => '',
			),
		);

		$this->additional_fields_text = array(
			'order_comments' => array(
				'label' => __( 'Catatan Tambahan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Catatan dari Anda untuk order ini.', 'wpbisnis-wc-indo-ongkir' ),
			),
		);

	}

	private function fields_prepare() {
		if ( $this->fields_prepared ) {
			return;
		}

		$this->billing_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_billing' ), $this->billing_fields_default );

		$priority = 0;
		foreach ( $this->billing_fields as $billing_field_id => $billing_field ) {
			$priority += 10;
			$this->billing_fields[ $billing_field_id ]['priority'] = $priority;
		}

		$this->shipping_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_shipping' ), $this->shipping_fields_default );

		$priority = 0;
		foreach ( $this->shipping_fields as $shipping_field_id => $shipping_field ) {
			$priority += 10;
			$this->shipping_fields[ $shipping_field_id ]['priority'] = $priority;
		}

		if ( $this->billing_fields['billing_address']['priority'] > $this->shipping_fields['shipping_address']['priority'] ) {
			$priority = $this->billing_fields['billing_address']['priority'] - $this->shipping_fields['shipping_address']['priority'];
			foreach ( $this->shipping_fields as $shipping_field_id => $shipping_field ) {
				$priority += 10;
				$this->shipping_fields[ $shipping_field_id ]['priority'] = $priority;
			}
		}
		elseif ( $this->shipping_fields['shipping_address']['priority'] > $this->billing_fields['billing_address']['priority'] ) {
			$priority = $this->shipping_fields['shipping_address']['priority'] - $this->billing_fields['billing_address']['priority'];
			foreach ( $this->billing_fields as $billing_field_id => $billing_field ) {
				$priority += 10;
				$this->billing_fields[ $billing_field_id ]['priority'] = $priority;
			}
		}

		if ( 'indo-ongkir-autocomplete' != $this->address_mode ) {
			$this->address_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_address' ), $this->address_fields_default );
		}
		else {
			$this->address_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_address2' ), $this->address_fields_default );
		}

		$priority = $this->billing_fields['billing_address']['priority'];
		foreach ( $this->address_fields as $address_field_id => $address_field ) {
			$this->address_fields[ $address_field_id ]['priority'] = $priority;
			$priority += 1;
		}
		if ( 'indo-ongkir-autocomplete' != $this->address_mode ) {
			$this->address_fields[ 'city' ] = $this->address_fields[ 'indo_ongkir_kecamatan' ];
		}

		$this->additional_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_additional' ), $this->additional_fields_default );

		$priority = 0;
		foreach ( $this->additional_fields as $additional_field_id => $additional_field ) {
			$priority += 10;
			$this->additional_fields[ $additional_field_id ]['priority'] = $priority;
		}

		$this->fields_prepared = true;
	}

	public function is_active() {

		if ( version_compare( WC_VERSION, '3.0.0', '<' ) )
			return false;

		if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
			$license_status = get_option( 'wpbisnis_wc_indo_ongkir_license_status' );
			if ( ! ( isset( $license_status->license ) && $license_status->license == 'valid' ) )
				return false;
		}
		else {
			$license_status = get_option( get_template().'_license_key_status' );
			if ( $license_status != 'valid' )
				return false;
		}

		$status = get_option( 'wpbisnis_wc_indo_checkout_status' );
		if ( 'no' == $status )
			return false;

		return true;
	}

	public function is_active_module() {

		$status = get_option( 'wpbisnis_wc_indo_checkout_status' );
		if ( 'no' == $status )
			return false;

		return true;
	}

	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['indo_checkout'] = __( 'Indo Checkout', 'wpbisnis-wc-indo-ongkir' );
		return $settings_tabs;
	}

	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}

	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
		if ( isset( $_POST['indo_checkout_address'] ) ) {
			$address_fields = $_POST['indo_checkout_address'];
			foreach ( $address_fields as $field_id => $field ) {
				foreach ( $field as $field_key => $field_value) {
					$address_fields[$field_id][$field_key] = sanitize_text_field( $field_value );
				}
			}
			// var_dump( $address_fields );
			if ( 'indo-ongkir-autocomplete' != $this->address_mode ) {
				update_option( 'wpbisnis_wc_indo_checkout_address', $address_fields, 'yes' );
			}
			else {
				update_option( 'wpbisnis_wc_indo_checkout_address2', $address_fields, 'yes' );
			}
		}
		if ( isset( $_POST['indo_checkout_billing'] ) ) {
			$billing_fields = $_POST['indo_checkout_billing'];
			foreach ( $billing_fields as $field_id => $field ) {
				foreach ( $field as $field_key => $field_value) {
					$billing_fields[$field_id][$field_key] = sanitize_text_field( $field_value );
				}
			}
			// var_dump( $billing_fields );
			update_option( 'wpbisnis_wc_indo_checkout_billing', $billing_fields, 'yes' );
		}
		if ( isset( $_POST['indo_checkout_shipping'] ) ) {
			$shipping_fields = $_POST['indo_checkout_shipping'];
			foreach ( $shipping_fields as $field_id => $field ) {
				foreach ( $field as $field_key => $field_value) {
					$shipping_fields[$field_id][$field_key] = sanitize_text_field( $field_value );
				}
			}
			// var_dump( $shipping_fields );
			update_option( 'wpbisnis_wc_indo_checkout_shipping', $shipping_fields, 'yes' );
		}
		if ( isset( $_POST['indo_checkout_additional'] ) ) {
			$additional_fields = $_POST['indo_checkout_additional'];
			foreach ( $additional_fields as $field_id => $field ) {
				foreach ( $field as $field_key => $field_value) {
					$additional_fields[$field_id][$field_key] = sanitize_text_field( $field_value );
				}
			}
			// var_dump( $additional_fields );
			update_option( 'wpbisnis_wc_indo_checkout_additional', $additional_fields, 'yes' );
		}
	}

	public function get_settings() {

		if ( 'indo-ongkir-autocomplete' != $this->address_mode ) {
			$this->address_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_address' ), $this->address_fields_default );
		}
		else {
			$this->address_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_address2' ), $this->address_fields_default );
		}

		$this->billing_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_billing' ), $this->billing_fields_default );

		$this->shipping_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_shipping' ), $this->shipping_fields_default );

		$this->additional_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_additional' ), $this->additional_fields_default );

		$settings = array();
		$settings[] = array(
				'name'     => __( 'Indo Checkout', 'wpbisnis-wc-indo-ongkir' ),
				'type'     => 'title',
				'desc'     => '<p>'.__( 'Berikut ini beberapa settings yang dapat Anda gunakan untuk mengatur tampilan halaman Checkout.', 'wpbisnis-wc-indo-ongkir' ).'</p>',
				'id'       => 'wpbisnis_wc_indo_checkout_section_title',
			);
		$settings[] = array(
				'title'    => __( 'Status', 'wpbisnis-wc-indo-ongkir' ),
				'desc'     => __( 'Aktifkan modul Indo Checkout', 'wpbisnis-wc-indo-ongkir' ).'<span class="description"><br/>'.__( 'Silahkan non aktifkan modul Indo Checkout jika Anda ingin menggunakan plugin lain untuk custom checkout fields di WooCommerce.', 'wpbisnis-wc-indo-ongkir' ).'</span>',
				'id'       => 'wpbisnis_wc_indo_checkout_status',
				'default'  => 'yes',
				'type'     => 'checkbox',
				'autoload' => true,
			);
		if ( $this->is_active_module() ) {
			$settings[] = array(
					'type'     => 'wpbisnis_wc_indo_checkout_address_fields',
				);
			$settings[] = array(
					'type'     => 'wpbisnis_wc_indo_checkout_billing_fields',
				);
			$settings[] = array(
					'type'     => 'wpbisnis_wc_indo_checkout_shipping_fields',
				);
			$settings[] = array(
					'type'     => 'wpbisnis_wc_indo_checkout_additional_fields',
				);
		}
		$settings[] = array(
				'type' => 'sectionend',
				'id' => 'wpbisnis_wc_indo_checkout_section_end'
			);

		return apply_filters( 'wc_settings_tab_indo_checkout_settings', $settings );
	}

	public function admin_address_fields() {
		$this->admin_fields( array( 
			'fields' => $this->address_fields,
			'fields_setup' => $this->address_fields_setup,
			'fields_text' => $this->address_fields_text,
			'fields_title' => __( 'Address Fields', 'wpbisnis-wc-indo-ongkir' ),
			'fields_post' => 'indo_checkout_address',
		));
	}

	public function admin_billing_fields() {
		$this->admin_fields( array( 
			'fields' => $this->billing_fields,
			'fields_setup' => $this->billing_fields_setup,
			'fields_text' => $this->billing_fields_text,
			'fields_title' => __( 'Billing Fields', 'wpbisnis-wc-indo-ongkir' ),
			'fields_post' => 'indo_checkout_billing',
		));
	}

	public function admin_shipping_fields() {
		$this->admin_fields( array( 
			'fields' => $this->shipping_fields,
			'fields_setup' => $this->shipping_fields_setup,
			'fields_text' => $this->shipping_fields_text,
			'fields_title' => __( 'Shipping Fields', 'wpbisnis-wc-indo-ongkir' ),
			'fields_post' => 'indo_checkout_shipping',
			'notes' => '<p><span class="description">'.sprintf( esc_html__( 'Jika ingin menyembunyikan bagian Shipping Fields saat Checkout, silahkan ke menu %s, di opsi Shipping destination pilih "Force shipping to the customer billing address".', 'wpbisnis-wc-indo-ongkir' ), '<a href="'.esc_url( admin_url('admin.php?page=wc-settings&tab=shipping&section=options') ).'">WooCommerce - Settings - Shipping - Shipping Options</a>' ).'</span></p>',
		));
	}

	public function admin_additional_fields() {
		$this->admin_fields( array( 
			'fields' => $this->additional_fields,
			'fields_setup' => $this->additional_fields_setup,
			'fields_text' => $this->additional_fields_text,
			'fields_title' => __( 'Additional Fields', 'wpbisnis-wc-indo-ongkir' ),
			'fields_post' => 'indo_checkout_additional',
		));
	}

	public function add_style() {

		$this->fields_prepare();

		$style = '';

		$additional_fields_show = false;
		foreach ( $this->additional_fields as $additional_field_id => $additional_field ) {
			if ( 'no' != $additional_field['show'] ) {
				$additional_fields_show = true;
			}
		}

		if ( ! $additional_fields_show ) {
			$style .= '.woocommerce-additional-fields { display: none !important; }';
		}

		if ( $style ) {
			echo '<style>'.$style.'</style>'."\n";
		}
	}

	public function billing_fields( $fields ) {

		$this->fields_prepare();

		foreach ( $this->billing_fields as $billing_field_id => $billing_field ) {
			if ( isset( $fields[$billing_field_id] ) ) {
				if ( 'no' == $billing_field['show'] ) {
					unset( $fields[$billing_field_id] );
				}
				else {
					if ( 'yes' == $billing_field['required'] ) {
						$fields[$billing_field_id]['required'] = true;
					}
					elseif ( 'no' == $billing_field['required'] ) {
						$fields[$billing_field_id]['required'] = false;
					}
					if ( $billing_field['label'] ) {
						$fields[$billing_field_id]['label'] = $billing_field['label'];
					}
					else {
						if ( $this->billing_fields_text[$billing_field_id]['label'] ) {
							$fields[$billing_field_id]['label'] = $this->billing_fields_text[$billing_field_id]['label'];
						}
					}
					if ( $billing_field['placeholder'] ) {
						$fields[$billing_field_id]['placeholder'] = $billing_field['placeholder'];
					}
					else {
						if ( $this->billing_fields_text[$billing_field_id]['placeholder'] ) {
							$fields[$billing_field_id]['placeholder'] = $this->billing_fields_text[$billing_field_id]['placeholder'];
						}
					}
					if ( $billing_field['type'] ) {
						$fields[$billing_field_id]['type'] = $billing_field['type'];
					}
				}
			}
		}
		if ( 'no' == $this->billing_fields['billing_last_name']['show'] ) {
			$fields['billing_first_name']['class'] = array('form-row-wide');
		}

		return $fields;
	}

	public function shipping_fields( $fields ) {

		$this->fields_prepare();

		foreach ( $this->shipping_fields as $shipping_field_id => $shipping_field ) {
			if ( isset( $fields[$shipping_field_id] ) ) {
				if ( 'no' == $shipping_field['show'] ) {
					unset( $fields[$shipping_field_id] );
				}
				else {
					if ( 'yes' == $shipping_field['required'] ) {
						$fields[$shipping_field_id]['required'] = true;
					}
					elseif ( 'no' == $shipping_field['required'] ) {
						$fields[$shipping_field_id]['required'] = false;
					}
					if ( $shipping_field['label'] ) {
						$fields[$shipping_field_id]['label'] = $shipping_field['label'];
					}
					else {
						if ( $this->shipping_fields_text[$shipping_field_id]['label'] ) {
							$fields[$shipping_field_id]['label'] = $this->shipping_fields_text[$shipping_field_id]['label'];
						}
					}
					if ( $shipping_field['placeholder'] ) {
						$fields[$shipping_field_id]['placeholder'] = $shipping_field['placeholder'];
					}
					else {
						if ( $this->shipping_fields_text[$shipping_field_id]['placeholder'] ) {
							$fields[$shipping_field_id]['placeholder'] = $this->shipping_fields_text[$shipping_field_id]['placeholder'];
						}
					}
					if ( $shipping_field['type'] ) {
						$fields[$shipping_field_id]['type'] = $shipping_field['type'];
					}
				}
			}
		}
		if ( 'no' == $this->shipping_fields['shipping_last_name']['show'] ) {
			$fields['shipping_first_name']['class'] = array('form-row-wide');
		}

		return $fields;
	}

	public function checkout_fields( $fields ) {

		$this->fields_prepare();

		foreach ( $this->billing_fields as $billing_field_id => $billing_field ) {
			if ( isset( $fields['billing'][$billing_field_id] ) ) {
				if ( 'no' == $billing_field['show'] ) {
					unset( $fields['billing'][$billing_field_id] );
				}
				else {
					if ( isset( $billing_field['priority'] ) && $billing_field['priority'] ) {
						$fields['billing'][$billing_field_id]['priority'] = $billing_field['priority'];
					}
					if ( isset( $billing_field['type'] ) && $billing_field['type'] ) {
						$fields['billing'][$billing_field_id]['type'] = $billing_field['type'];
					}
				}
			}
		}

		foreach ( $this->shipping_fields as $shipping_field_id => $shipping_field ) {
			if ( isset( $fields['shipping'][$shipping_field_id] ) ) {
				if ( 'no' == $shipping_field['show'] ) {
					unset( $fields['shipping'][$shipping_field_id] );
				}
				else {
					if ( isset( $shipping_field['priority'] ) && $shipping_field['priority'] ) {
						$fields['shipping'][$shipping_field_id]['priority'] = $shipping_field['priority'];
					}
					if ( isset( $shipping_field['type'] ) && $shipping_field['type'] ) {
						$fields['shipping'][$shipping_field_id]['type'] = $shipping_field['type'];
					}
				}
			}
		}

		foreach ( $this->additional_fields as $additional_field_id => $additional_field ) {
			if ( isset( $fields['order'][$additional_field_id] ) ) {
				if ( 'no' == $additional_field['show'] ) {
					unset( $fields['order'][$additional_field_id] );
				}
				else {
					if ( 'yes' == $additional_field['required'] ) {
						$fields['order'][$additional_field_id]['required'] = true;
					}
					elseif ( 'no' == $additional_field['required'] ) {
						$fields['order'][$additional_field_id]['required'] = false;
					}
					if ( $additional_field['label'] ) {
						$fields['order'][$additional_field_id]['label'] = $additional_field['label'];
					}
					else {
						if ( $this->additional_fields_text[$additional_field_id]['label'] ) {
							$fields['order'][$additional_field_id]['label'] = $this->additional_fields_text[$additional_field_id]['label'];
						}
					}
					if ( $additional_field['placeholder'] ) {
						$fields['order'][$additional_field_id]['placeholder'] = $additional_field['placeholder'];
					}
					else {
						if ( $this->additional_fields_text[$additional_field_id]['placeholder'] ) {
							$fields['order'][$additional_field_id]['placeholder'] = $this->additional_fields_text[$additional_field_id]['placeholder'];
						}
					}
					if ( isset( $additional_field['priority'] ) && $additional_field['priority'] ) {
						$fields['order'][$additional_field_id]['priority'] = $additional_field['priority'];
					}
					if ( isset( $additional_field['type'] ) && $additional_field['type'] ) {
						$fields['order'][$additional_field_id]['type'] = $additional_field['type'];
					}
				}
			}
		}

		foreach ( $this->address_fields as $address_field_id => $address_field ) {
			if ( isset( $fields['billing']['billing_'.$address_field_id] ) ) {
				if ( 'no' == $address_field['show'] ) {
					unset( $fields['billing']['billing_'.$address_field_id] );
				}
				else {
					if ( isset( $address_field['priority'] ) && $address_field['priority'] ) {
						$fields['billing']['billing_'.$address_field_id]['priority'] = $address_field['priority'];
					}
					if ( isset( $address_field['type'] ) && $address_field['type'] ) {
						$fields['billing']['billing_'.$address_field_id]['type'] = $address_field['type'];
					}
				}
			}
			if ( isset( $fields['shipping']['shipping_'.$address_field_id] ) ) {
				if ( 'no' == $address_field['show'] ) {
					unset( $fields['shipping']['shipping_'.$address_field_id] );
				}
				else {
					if ( isset( $address_field['priority'] ) && $address_field['priority'] ) {
						$fields['shipping']['shipping_'.$address_field_id]['priority'] = $address_field['priority'];
					}
					if ( isset( $address_field['type'] ) && $address_field['type'] ) {
						$fields['shipping']['shipping_'.$address_field_id]['type'] = $address_field['type'];
					}
				}
			}
		}

		return $fields;
	}

	public function country_locale( $locale ) {

		$this->fields_prepare();

		foreach ( $this->address_fields as $address_field_id => $address_field ) {
			$address_field = $this->address_fields[$address_field_id];
			if ( 'no' == $address_field['show'] ) {
				$locale['ID'][$address_field_id]['hidden'] = true;
			}
			else {
				if ( 'yes' == $address_field['required'] ) {
					$locale['ID'][$address_field_id]['required'] = true;
				}
				elseif ( 'no' == $address_field['required'] ) {
					$locale['ID'][$address_field_id]['required'] = false;
				}
				if ( $address_field['label'] ) {
					$locale['ID'][$address_field_id]['label'] = $address_field['label'];
				}
				else {
					if ( $this->address_fields_text[$address_field_id]['label'] ) {
						$locale['ID'][$address_field_id]['label'] = $this->address_fields_text[$address_field_id]['label'];
					}
				}
				if ( $address_field['placeholder'] ) {
					$locale['ID'][$address_field_id]['placeholder'] = $address_field['placeholder'];
				}
				else {
					if ( $this->address_fields_text[$address_field_id]['placeholder'] ) {
						$locale['ID'][$address_field_id]['placeholder'] = $this->address_fields_text[$address_field_id]['placeholder'];
					}
				}
				if ( $address_field['type'] ) {
					$locale['ID'][$address_field_id]['type'] = $address_field['type'];
				}
				if ( isset( $address_field['priority'] ) && $address_field['priority'] ) {
					$locale['ID'][$address_field_id]['priority'] = $address_field['priority'];
				}
			}
		}

		return $locale;
	}

	public function customize_register( $wp_customize ) {
		$fields = array(
			'company',
			'address_2',
			'phone',
		);
		foreach ( $fields as $field ) {
			$wp_customize->remove_control( 'woocommerce_checkout_' . $field . '_field' );
		}
	}

	private function parse_args( $args, $defaults ) {
		if ( empty( $defaults ) ) {
			return $args;
		}
		if ( empty( $args ) ) {
			return $defaults;
		}
		foreach ( $args as $field_key => $field_value ) {
			if ( isset( $defaults[$field_key] ) ) {
				$args[$field_key] = wp_parse_args( $args[$field_key], $defaults[$field_key] );
			}
			else {
				unset( $args[$field_key] );
			}
		}
		foreach ( $defaults as $field_key => $field_value ) {
			if ( !isset( $args[$field_key] ) ) {
				$args[$field_key] = $defaults[$field_key];
			}
		}
		return $args;		
	}

	private function admin_fields( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		$intro = isset( $args['intro'] ) ? $args['intro'] : '';
		$notes = isset( $args['notes'] ) ? $args['notes'] : '';
		$fields = $args['fields'];
		$fields_setup = $args['fields_setup'];
		$fields_title = $args['fields_title'];
		$fields_post = $args['fields_post'];
		$fields_text = $args['fields_text'];
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<style>
					.indo-checkout-fields-id { background-color: #f5f5f5; padding: 6px; font-weight: bold; } 
					.indo-checkout-fields { background-color: #f5f5f5; padding: 6px; } 
					.indo-checkout-select { border: 0; box-shadow: none; }
					.indo-checkout-radio { padding: 6px 6px 0 6px; }
					table.wc_input_table tr.current td .indo-checkout-fields-id { background-color: #fefbcc }
					table.wc_input_table tr.current td .indo-checkout-fields { background-color: #fefbcc }
				</style>
				<?php echo esc_html( $fields_title ); ?>
			</th>
			<td class="forminp">
				<?php if ( $intro ) { echo wp_kses_post( $intro ); } ?>
				<table class="widefat wc_input_table sortable" cellspacing="0">
				<!-- <table class="widefat wc_input_table" cellspacing="0"> -->
					<thead>
						<tr>
							<th class="sort">&nbsp;</th>
							<th><?php _e( 'ID', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Show', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Required', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Label', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Placeholder', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Type', 'wpbisnis-wc-indo-ongkir' ); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ( $fields as $field_id => $field ) : ?>
						<tr>
							<td class="sort"></td>
							<td>
								<div class="indo-checkout-fields-id">
									<?php echo $field_id; ?>
									<?php $this->field_hidden( array(
										'name' => $fields_post.'['.$field_id.'][id]',
										'value' => $field_id,
									) ); ?>
								</div>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['show'] ) : ?>
									<?php $this->field_select( array(
										'name' => $fields_post.'['.$field_id.'][show]',
										'value' => $field['show'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										<?php echo $field['show'] ? $field['show'] : '&nbsp;'; ?>
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['required'] ) : ?>
									<?php $this->field_select( array(
										'name' => $fields_post.'['.$field_id.'][required]',
										'value' => $field['required'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										<?php echo $field['required'] ? $field['required'] : '&nbsp;'; ?>
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['label'] ) : ?>
									<?php $this->field_input( array(
										'name' => $fields_post.'['.$field_id.'][label]',
										'value' => $field['label'],
										'placeholder' => $fields_text[$field_id]['label'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										&nbsp;
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['placeholder'] ) : ?>
									<?php $this->field_input( array(
										'name' => $fields_post.'['.$field_id.'][placeholder]',
										'value' => $field['placeholder'],
										'placeholder' => $fields_text[$field_id]['placeholder'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										&nbsp;
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['type'] ) : ?>
									<?php $this->field_select( array(
										'name' => $fields_post.'['.$field_id.'][type]',
										'value' => $field['type'],
										'choices' => $fields_setup[$field_id]['type_choices'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										<?php echo $field['type'] ? $field['type'] : '&nbsp;'; ?>
									</div>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php if ( $notes ) { echo wp_kses_post( $notes ); } ?>
			</td>
		</tr>
		<?php
	}

	private function field_hidden( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		echo '<input type="hidden" name="'.$args['name'].'" value="'.$args['value'].'">';
	}

	private function field_input( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		if ( true === $args['placeholder'] ) {
			$args['placeholder'] = '';
		}
		echo '<input type="text" name="'.$args['name'].'" placeholder="'.$args['placeholder'].'" value="'.$args['value'].'" class="indo-checkout-text">';
	}

	private function field_select( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		if ( !isset( $args['choices'] ) || ( isset( $args['choices'] ) && empty( $args['choices'] ) ) ) {
			$args['choices'] = array( 'yes' => 'yes', 'no' => 'no' );
		}
		echo '<select name="'.$args['name'].'" class="indo-checkout-select">';
		foreach ( $args['choices'] as $value => $choice ) {
			if ( $value == $args['value'] ) {
				echo '<option value="'.$value.'" selected="selected">'.$choice.'</option>';
			}
			else {
				echo '<option value="'.$value.'">'.$choice.'</option>';
			}
		}
		echo '</select>';
	}

	private function field_radio( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		if ( !isset( $args['choices'] ) || ( isset( $args['choices'] ) && empty( $args['choices'] ) ) ) {
			$args['choices'] = array( 'yes' => 'yes', 'no' => 'no' );
		}
		foreach ( $args['choices'] as $value => $choice ) {
			echo '<span class="indo-checkout-radio">';
			if ( $value == $args['value'] ) {
				echo '<input type="radio" name="'.$args['name'].'" value="'.$value.'" checked="checked">'.$choice.' ';
			}
			else {
				echo '<input type="radio" name="'.$args['name'].'" value="'.$value.'">'.$choice.' ';
			}
			echo '</span>';
		}
	}

}
if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
	add_action( 'plugins_loaded' , array( 'WPBisnis_WC_Indo_Checkout_Init' , 'get_instance' ), 0 );
}
else {
	WPBisnis_WC_Indo_Checkout_Init::get_instance();
}
