<?php
/*
Plugin Name: Gravity Forms DLocal Payment Addon
Plugin URI: https://github.com/fjborquez/gf-dlocal-payment-addon
Description: Integrates DLocal Payment with Gravity Forms.
Version: 1.0
Author: Francisco Bórquez
Author URI: https://www.linkedin.com/in/francisco-b%C3%B3rquez-hern%C3%A1ndez/
Domain Path: /languages
Text Domain: gf-dlocal-payment-addon

*/

define( 'GF_DLOCAL_PAYMENT_ADDON_VERSION', '1.0' );

add_action( 'gform_loaded', array( 'GF_DLocal_Payment_Addon_Bootstrap', 'load' ), 5 );

add_filter( 'gform_countries', function ( $countries ) {
    $new_countries = array();
 
    foreach ( $countries as $country ) {
        $code                   = GF_Fields::get( 'address' )->get_country_code( $country );
        $new_countries[ $code ] = $country;
    }
 
    return $new_countries;
} );

class GF_DLocal_Payment_Addon_Bootstrap {

    public static function load() {

        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }
        load_plugin_textdomain('gf-dlocal-payment-addon', false, 'gf-dlocal-payment-addon/languages');
        GFForms::include_payment_addon_framework();
        
        require_once( 'includes/class-gf-dlocal-payment-addon.php' );
        require_once( 'includes/class-gf-dlocal-currencies-field.php' );
        require_once( 'includes/class-gf-dlocal-payment-method-field.php' );

        GF_Fields::register( new GF_Field_DLocalCurrencies() );
        GF_Fields::register( new GF_Field_DLocalPaymentMethods() );
        GFAddOn::register( 'GFDLocalPaymentAddon' );
    }

}