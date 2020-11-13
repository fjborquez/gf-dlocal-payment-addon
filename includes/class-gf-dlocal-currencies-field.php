<?php
    class GF_Field_DLocalCurrencies extends GF_Field_Select {
        public $type = 'currencies';
        public $choices = array();
    
        public function get_choices( $value ) {
            $this->choices = array(
                array(
                    'text'       => esc_html__( 'Argentine Peso', 'gf-dlocal-payment-addon'),
                    'value'      => 'ARS',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Bolivian Boliviano', 'gf-dlocal-payment-addon'),
                    'value'      => 'BOB',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Brazilian Real', 'gf-dlocal-payment-addon'),
                    'value'      => 'BRL',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Central African CFA franc', 'gf-dlocal-payment-addon'),
                    'value'      => 'XAF',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Chilean Peso', 'gf-dlocal-payment-addon'),
                    'value'      => 'CLP',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Chinese Yuan', 'gf-dlocal-payment-addon'),
                    'value'      => 'CNY',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Colombian Peso', 'gf-dlocal-payment-addon'),
                    'value'      => 'COP',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Colón', 'gf-dlocal-payment-addon'),
                    'value'      => 'CRC',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Egyptian Pound', 'gf-dlocal-payment-addon'),
                    'value'      => 'EGP',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Indian Rupee', 'gf-dlocal-payment-addon'),
                    'value'      => 'INR',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Indonesian Rupiah', 'gf-dlocal-payment-addon'),
                    'value'      => 'IDR',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Mexican Peso', 'gf-dlocal-payment-addon'),
                    'value'      => 'MXN',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Moroccan Dirham', 'gf-dlocal-payment-addon'),
                    'value'      => 'MAD',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Nigerian Naira', 'gf-dlocal-payment-addon'),
                    'value'      => 'NGN',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Paraguayan Guaraní', 'gf-dlocal-payment-addon'),
                    'value'      => 'PYG',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Peruvian Sol', 'gf-dlocal-payment-addon'),
                    'value'      => 'PEN',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'South African Rand', 'gf-dlocal-payment-addon'),
                    'value'      => 'ZAR',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Turkish Lira', 'gf-dlocal-payment-addon'),
                    'value'      => 'TRY',
                    'isSelected' => false,
                ),
                array(
                    'text'       => esc_html__( 'Uruguayan Peso', 'gf-dlocal-payment-addon'),
                    'value'      => 'UYU',
                    'isSelected' => false,
                ),
            );
    
            return GFCommon::get_select_choices( $this, $value );
        }
    
        public function get_form_editor_field_title() {
            return esc_html__( 'Currencies', 'gf-dlocal-payment-addon');
        }
    }