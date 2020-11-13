<?php
    class GF_Field_DLocalPaymentMethods extends GF_Field_Select {
        public $type = 'paymentmethods';
        public $choices = array();
    
        public function get_form_editor_field_title() {
            return esc_html__( 'DLocal Payment Methods', 'gf-dlocal-payment-addon');
        }
    
        public function get_choices( $value ) {
            $countries = ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'MX', 'PY', 'PE', 'UY'];
    
            $this->choices = array(
                array(
                    'text' => 'Pago Facil', 
                    'value' => 'PF', 
                    'countryCode' => 'AR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Rapi Pago', 
                    'value' => 'RP', 
                    'countryCode' => 'AR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Bank Transfer', 
                    'value' => 'IO', 
                    'countryCode' => 'AR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Bank Transfer', 
                    'value' => 'IO', 
                    'countryCode' => 'BO', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Itau', 
                    'value' => 'I', 
                    'countryCode' => 'BR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Banco do Brasil', 
                    'value' => 'BB', 
                    'countryCode' => 'BR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Bradesco', 
                    'value' => 'B', 
                    'countryCode' => 'BR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Caixa', 
                    'value' => 'CA', 
                    'countryCode' => 'BR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Santander', 
                    'value' => 'SB', 
                    'countryCode' => 'BR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Boleto', 
                    'value' => 'BL', 
                    'countryCode' => 'BR', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'WebPay', 
                    'value' => 'WP', 
                    'countryCode' => 'CL', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Servipag', 
                    'value' => 'SP', 
                    'countryCode' => 'CL', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Efecty', 
                    'value' => 'EY', 
                    'countryCode' => 'CO', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'PSE', 
                    'value' => 'PC', 
                    'countryCode' => 'CO', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Baloto', 
                    'value' => 'BU', 
                    'countryCode' => 'CO', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'PagoEfectivo', 
                    'value' => 'EF', 
                    'countryCode' => 'EC', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Oxxo', 
                    'value' => 'OX', 
                    'countryCode' => 'MX', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Bancomer', 
                    'value' => 'BV', 
                    'countryCode' => 'MX', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Santander', 
                    'value' => 'SM', 
                    'countryCode' => 'MX', 
                    'isSelected' => false 
                ),
                array(
                     'text' => 'Spei', 
                     'value' => 'SE', 
                     'countryCode' => 'MX', 
                     'isSelected' => false 
                ),
                array( 
                    'text' => 'Banorte', 
                    'value' => 'BQ', 
                    'countryCode' => 'MX', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Pago Express', 
                    'value' => 'PE',
                    'countryCode' => 'PY', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'InterBank', 
                    'value' => 'IB', 
                    'countryCode' => 'PE', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'BBVA',
                    'value' => 'BP', 
                    'countryCode' => 'PE', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'PagoEfectivo', 
                    'value' => 'EF', 
                    'countryCode' => 'PE', 
                    'isSelected' => false 
                ),
                array(
                    'text' => 'BCP', 
                    'value' => 'BC', 
                    'countryCode' => 'PE', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Red Pagos', 
                    'value' => 'RE', 
                    'countryCode' => 'UY', 
                    'isSelected' => false 
                ),
                array( 
                    'text' => 'Abitab', 
                    'value' => 'AI', 
                    'countryCode' => 'UY', 
                    'isSelected' => false 
                )
            );
    
            return GFCommon::get_select_choices( $this, $value );
        }
    
        // TODO: Metodos de pago segun país elegido
    }