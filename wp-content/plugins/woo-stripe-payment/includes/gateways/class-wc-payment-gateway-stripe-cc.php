<?php
defined( 'ABSPATH' ) || exit();

/**
 *
 * @since 3.0.0
 * @package Stripe/Gateways
 * @author User
 *
 */
class WC_Payment_Gateway_Stripe_CC extends WC_Payment_Gateway_Stripe {

	use WC_Stripe_Payment_Intent_Trait;

	protected $payment_method_type = 'card';

	public function __construct() {
		$this->id                 = 'stripe_cc';
		$this->tab_title          = __( 'Credit Cards', 'woo-stripe-payment' );
		$this->template_name      = 'credit-card.php';
		$this->token_type         = 'Stripe_CC';
		$this->method_title       = __( 'Stripe Credit Cards', 'woo-stripe-payment' );
		$this->method_description = __( 'Credit card gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		parent::__construct();
	}

	public function get_icon() {
		$cards = $this->get_option( 'cards' );
		$icons = array();
		foreach ( $cards as $card ) {
			$icons[ $card ] = stripe_wc()->assets_url( "img/cards/{$card}.svg" );
		}

		return wc_stripe_get_template_html(
			'card-icons.php',
			apply_filters( 'wc_stripe_cc_icon_template_args', array(
				'cards'      => $cards,
				'icons'      => $icons,
				'assets_url' => stripe_wc()->assets_url()
			), $this )
		);
	}

	public function enqueue_checkout_scripts( $scripts ) {
		$scripts->enqueue_script(
			'credit-card',
			$scripts->assets_url( 'js/frontend/credit-card.js' ),
			array(
				$scripts->prefix . 'external',
				$scripts->prefix . 'wc-stripe',
			)
		);
		$scripts->localize_script( 'credit-card', $this->get_localized_params() );
	}

	public function get_localized_params() {
		$data = parent::get_localized_params();

		return array_merge(
			$data,
			array(
				'cardOptions'        => $this->get_card_form_options(),
				'customFieldOptions' => $this->get_card_custom_field_options(),
				'elementOptions'     => $this->get_element_options(),
				'custom_form'        => $this->is_custom_form_active(),
				'html'               => array( 'card_brand' => sprintf( '<img id="wc-stripe-card" src="%s" />', $this->get_custom_form()['cardBrand'] ) ),
				'cards'              => array(
					'visa'       => stripe_wc()->assets_url( 'img/cards/visa.svg' ),
					'amex'       => stripe_wc()->assets_url( 'img/cards/amex.svg' ),
					'mastercard' => stripe_wc()->assets_url( 'img/cards/mastercard.svg' ),
					'discover'   => stripe_wc()->assets_url( 'img/cards/discover.svg' ),
					'diners'     => stripe_wc()->assets_url( 'img/cards/diners.svg' ),
					'jcb'        => stripe_wc()->assets_url( 'img/cards/jcb.svg' ),
					'unionpay'   => stripe_wc()->assets_url( 'img/cards/china_union_pay.svg' ),
					'unknown'    => $this->get_custom_form()['cardBrand'],
				),
				'postal_regex'       => $this->get_postal_code_regex(),
			)
		);
	}

	/**
	 * @since 3.3.0
	 */
	private function get_card_form_options() {
		$options = array(
			'style' => $this->get_form_style()
		);

		return apply_filters( 'wc_stripe_cc_form_options', $options, $this );
	}

	/**
	 * @return mixed|void
	 * @since 3.3.0
	 */
	private function get_card_custom_field_options() {
		$style   = $this->get_form_style();
		$options = array();
		foreach ( [ 'cardNumber', 'cardExpiry', 'cardCvc' ] as $key ) {
			$options[ $key ] = array( 'style' => $style );
		}

		return apply_filters( 'wc_stripe_get_card_custom_field_options', $options, $this );
	}

	private function get_form_style() {
		if ( $this->is_custom_form_active() ) {
			$style = $this->get_custom_form()['elementStyles'];
		} else {
			$style = array(
				'base'    => array(
					'color'         => '#32325d',
					'fontFamily'    => '"Helvetica Neue", Helvetica, sans-serif',
					'fontSmoothing' => 'antialiased',
					'fontSize'      => '18px',
					'::placeholder' => array( 'color' => '#aab7c4' ),
					':focus'        => array(),
				),
				'invalid' => array(
					'color'     => '#fa755a',
					'iconColor' => '#fa755a',
				),
			);
		}

		return apply_filters( 'wc_stripe_cc_element_style', $style, $this );
	}

	private function get_custom_form() {
		return wc_stripe_get_custom_forms()[ $this->get_option( 'custom_form' ) ];
	}

	private function get_element_options() {
		return $this->get_custom_form()['elementOptions'];
	}

	/**
	 * Returns true if custom forms are enabled.
	 *
	 * @return bool
	 */
	public function is_custom_form_active() {
		return $this->get_option( 'form_type' ) === 'custom';
	}

	public function get_custom_form_template() {
		$form = $this->get_option( 'custom_form' );

		return wc_stripe_get_custom_forms()[ $form ]['template'];
	}

	/**
	 * Returns true if the postal code field is enabled.
	 *
	 * @return bool
	 */
	public function postal_enabled() {
		if ( is_checkout() ) {
			return $this->is_active( 'postal_enabled' );
		}
		if ( is_add_payment_method_page() ) {
			return true;
		}
	}

	/**
	 * Returns true if the cvv field is enabled.
	 *
	 * @return bool
	 */
	public function cvv_enabled() {
		return $this->is_active( 'cvv_enabled' );
	}

	public function get_postal_code_regex() {
		return array(
			'AT' => '^([0-9]{4})$',
			'BR' => '^([0-9]{5})([-])?([0-9]{3})$',
			'CH' => '^([0-9]{4})$',
			'DE' => '^([0]{1}[1-9]{1}|[1-9]{1}[0-9]{1})[0-9]{3}$',
			'ES' => '^([0-9]{5})$',
			'FR' => '^([0-9]{5})$',
			'IT' => '^([0-9]{5})$/i',
			'IE' => '([AC-FHKNPRTV-Y]\d{2}|D6W)[0-9AC-FHKNPRTV-Y]{4}',
			'JP' => '^([0-9]{3})([-])([0-9]{4})$',
			'PT' => '^([0-9]{4})([-])([0-9]{3})$',
			'US' => '^([0-9]{5})(-[0-9]{4})?$',
			'CA' => '^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])([\ ])?(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$',
			'PL' => '^([0-9]{2})([-])([0-9]{3})',
			'CZ' => '^([0-9]{3})(\s?)([0-9]{2})$',
			'SK' => '^([0-9]{3})(\s?)([0-9]{2})$',
			'NL' => '^([1-9][0-9]{3})(\s?)(?!SA|SD|SS)[A-Z]{2}$',
		);
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see WC_Payment_Gateway_Stripe::add_stripe_order_args()
	 */
	public function add_stripe_order_args( &$args, $order ) {
		// if the merchant is forcing 3D secure for all intents then add the required args.
		if ( $this->is_active( 'force_3d_secure' ) && is_checkout() && ! doing_action( 'woocommerce_scheduled_subscription_payment_' . $this->id ) ) {
			$args['payment_method_options']['card']['request_three_d_secure'] = 'any';
		}
	}

	public function has_enqueued_scripts( $scripts ) {
		return wp_script_is( $scripts->get_handle( 'credit-card' ) );
	}
}