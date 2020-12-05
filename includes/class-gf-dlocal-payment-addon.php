<?php
class GFDLocalPaymentAddon extends GFPaymentAddOn {
	protected $_version = "1.0.0";
	protected $_min_gravityforms_version = "1.8.12";
	protected $_slug = 'gf-dlocal-payment-addon';
	protected $_path = 'gf-dlocal-payment-addon/gf-dlocal-payment-addon.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms DLocal Add-On';
	protected $_short_title = 'DLocal Payment Addon';
	protected $_supports_callbacks = true;
	protected $_requires_credit_card = false;
	protected $is_payment_gateway = true;
    
	private static $_instance = null;
	private $sandboxUrl = 'https://sandbox.dlocal.com';
	private $apiUrl = 'https://api.dlocal.com';

	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}
	 
		return self::$_instance;
	}
	
	// TODO: Dividir en funciones más pequeñas
	public function feed_settings_fields() {
		$default_settings = parent::feed_settings_fields();
		$transaction_type = $this->get_field( 'transactionType', $default_settings );
		$choices = rgar($transaction_type, 'choices');
		unset($choices[2]);
		$transaction_type['choices'] = $choices;
		$default_settings = $this->replace_field( 'transactionType', $transaction_type, $default_settings );

		$dlocalPropertiesFields = array(
			array(
				'name'     => 'dlocalXLogin',
				'label'    => esc_html__( 'X-Login', 'gf-dlocal-payment-addon'),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => true,
				'tooltip'  => '<h6>' . esc_html__( 'X-Login', 'gf-dlocal-payment-addon') . '</h6>' . esc_html__( 'Get this value from your DLocal account.', 'gf-dlocal-payment-addon')
			),
			array(
				'name'     => 'dlocalXVersion',
				'label'    => esc_html__( 'X-Version', 'gf-dlocal-payment-addon'),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => true,
				'tooltip'  => '<h6>' . esc_html__( 'X-Version', 'gf-dlocal-payment-addon') . '</h6>' . esc_html__( 'Get this value from your DLocal account.', 'gf-dlocal-payment-addon')
			),
			array(
				'name'     => 'dlocalXTransKey',
				'label'    => esc_html__( 'X-Trans-Key', 'gf-dlocal-payment-addon'),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => true,
				'tooltip'  => '<h6>' . esc_html__( 'X-Trans-Key', 'gf-dlocal-payment-addon') . '</h6>' . esc_html__( 'Get this value from your DLocal account.', 'gf-dlocal-payment-addon')
			),
			array(
				'name'     => 'dlocalSecretKey',
				'label'    => esc_html__( 'Secret Key', 'gf-dlocal-payment-addon'),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => true,
				'tooltip'  => '<h6>' . esc_html__( 'Secret Key', 'gf-dlocal-payment-addon') . '</h6>' . esc_html__( 'Get this value from your DLocal account.', 'gf-dlocal-payment-addon')
			),
			array(
				'name'     => 'dlocalSandbox',
				'label'    => esc_html__( 'Sandbox', 'gf-dlocal-payment-addon'),
				'type'     => 'checkbox',
				'choices' => array(
					array(
						'label' => esc_html__( 'Active', 'gf-dlocal-payment-addon'),
						'name'  => 'dlocalSandbox-active'
					)
				),
				'required' => false,
				'tooltip'  => '<h6>' . esc_html__( 'Sandbox', 'gf-dlocal-payment-addon') . '</h6>' . esc_html__( 'Checked to activate DLocal sandbox mode.', 'gf-dlocal-payment-addon')
			),
			array(
				'name'     => 'dlocalNotificationUrl',
				'label'    => esc_html__( 'Notification URL', 'gf-dlocal-payment-addon'),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => false,
				'tooltip'  => '<h6>' . esc_html__( 'Notification URL', 'gf-dlocal-payment-addon') . '</h6>' . esc_html__( 'This is the URL to which DLocal will notify changes in a payment.', 'gf-dlocal-payment-addon')
			),
			array(
				'name'     => 'dlocalErrorPageUrl',
				'label'    => esc_html__( 'Error Page URL', 'gf-dlocal-payment-addon'),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => false,
				'tooltip'  => '<h6>' . esc_html__( 'Error Page URL', 'gf-dlocal-payment-addon') . '</h6>' . esc_html__( 'This is the page you will redirect to when a payment error occurs. A get parameter will be added with an error message.', 'gf-dlocal-payment-addon')
			),
		);

		$default_settings = $this->add_field_after( 'transactionType', $dlocalPropertiesFields, $default_settings );

		return $default_settings;
	}

	public function billing_info_fields() {
		$fields = parent::billing_info_fields();
		$fields[] = array( 'name' => 'dlocalCurrency', 'label' => esc_html__( 'Currency', 'gf-dlocal-payment-addon'), 'required' => true );
		$fields[] = array( 'name' => 'dlocalPaymentMethod', 'label' => esc_html__( 'Payment Method', 'gf-dlocal-payment-addon'), 'required' => true );
		$fields[] = array( 'name' => 'dlocalPaymentMethodFlow', 'label' => esc_html__( 'Payment Method Flow', 'gf-dlocal-payment-addon'), 'required' => true );
		$fields[] = array( 'name' => 'dlocalPayerName', 'label' => esc_html__( 'Payer Name', 'gf-dlocal-payment-addon'), 'required' => true );
		$fields[] = array( 'name' => 'dlocalPayerDocument', 'label' => esc_html__( 'Payer Document', 'gf-dlocal-payment-addon'), 'required' => true );

		return $fields;
	}

	public function redirect_url( $feed, $submission_data, $form, $entry ) {
		$meta = rgar($feed, 'meta');
		$dlocalSandboxActive = rgar($meta, 'dlocalSandbox-active');
		$dlocalErrorPageUrl = rgar($meta, 'dlocalErrorPageUrl');

		if ($dlocalSandboxActive == '1') {
			$url = $this->sandboxUrl . '/payments';
		} else {
			$url = $this->apiUrl . '/payments';
		}
		
		
		// TODO: Generador de OC
		$oc = date_format(new DateTime(),"YmdHis");

		$amount = rgar($submission_data, 'payment_amount');
		$currency = rgar($submission_data, 'dlocalCurrency');
		$country = rgar($submission_data, 'country');
		$payment_method_id = rgar($submission_data, 'dlocalPaymentMethod');
		$payment_method_flow = rgar($submission_data, 'dlocalPaymentMethodFlow');
		$payer_name = rgar($submission_data, 'dlocalPayerName');
		$payer_email = rgar($submission_data, 'email');
		$payer_document = rgar($submission_data, 'dlocalPayerDocument');
		$payer_addres_state = rgar($submission_data, 'state');
		$payer_addres_city = rgar($submission_data, 'city');
		$payer_addres_zip_code = rgar($submission_data, 'zip');
		$payer_addres_street = rgar($submission_data, 'address');
		$payer_addres_number = rgar($submission_data, 'address2');

		$body = '{
			"amount": "' . $amount .'",
			"currency": "' . $currency .'",
			"country": "' . $country . '",
			"payment_method_id" : "' . $payment_method_id . '",
			"payment_method_flow" : "' . $payment_method_flow . '",
			"payer":{
				"name" : "' . $payer_name . '",
				"email" : "' . $payer_email . '",
				"user_reference": "12345",
				"document": "' . $payer_document . '",
				"address": {
					"state"  : "' . $payer_addres_state . '",
					"city" : "' . $payer_addres_city  . '",
					"zip_code" : "' . $payer_addres_zip_code . '",
					"street" : "' . $payer_addres_street  . '",
					"number" : "' . $payer_addres_number . '"
				},
				"ip": "' . $this->get_the_user_ip() . '"
			},
			"order_id": ' . rgar($entry, 'id') . ',
			"notification_url": "' . rgar($meta, 'dlocalNotificationUrl') . '"
		}';


		$date = date('Y-m-d\TH:i:s.\0\0\0\Z');
		$xLogin = rgar($meta, 'dlocalXLogin');
		$secretKey = rgar($meta, 'dlocalSecretKey');
		$signature = hash_hmac("sha256", "$xLogin$date$body", $secretKey);

		$headers = [
			'X-Version' => rgar($meta, 'dlocalXVersion'),
			'X-Trans-Key' => rgar($meta, 'dlocalXTransKey'),
			'Authorization' => 'V2-HMAC-SHA256, Signature: ' . $signature,
			'Content-Type' => 'application/json',
			'X-Login' => $xLogin,
			'X-Date' => $date
		];

		$response = null;
		$args = [
			'body'        => $body,
			'timeout'     => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,
			'cookies'     => [],
		];
        
		$response = wp_remote_post($url, $args);
		
		if ($response instanceof WP_Error) {
			if ($dlocalErrorPageUrl) {
				return $dlocalErrorPageUrl . "/?errMes=0000 - Can't connect to DLocal service";
			}
		} else {
			$responseBody = json_decode($response['body']);
			if (isset($responseBody->code)) {
				if ($dlocalErrorPageUrl) {
					return $dlocalErrorPageUrl . "/?errMes=" . $responseBody->code . " - " . $responseBody->message;
				}
			} else {
				if (isset($responseBody->redirect_url)) {
					return $responseBody->redirect_url;
				}
				
			}
		}

		return $this->redirect_url;
	}

	public function callback() {
		$notification = json_decode(file_get_contents('php://input'), true);
		return array(
			'id' => rgar($notification, 'id'),
			'type' => $this->status_code_convert(rgar($notification, 'status')),
			'amount' => rgar($notification, 'amount'),
			'entry_id' => rgar($notification, 'order_id'),
			'payment_status' => rgar($notification, 'status'),
			'note' => rgar($notification, 'status_code') . ' - ' . rgar($notification, 'status_detail')
		);
	}

	public function status_code_convert($status_code) {
		$gf_status = "";

		switch ($status_code) {
			case "PENDING":
				$gf_status = "add_pending_payment";
				break;
			case "PAID":
				$gf_status = "complete_payment";
				break;
			case "REJECTED":
				$gf_status = "fail_payment";
				break;
			case "CANCELLED":
				$gf_status = "fail_payment";
				break;
			case "EXPIRED":
				$gf_status = "fail_payment";
				break;
			case "AUTHORIZED":
				$gf_status = "add_pending_payment";
				break;
		}

		return $gf_status;
	}

	public function get_the_user_ip() {
		$ip = '';

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}
}