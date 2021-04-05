<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'event_tickets_after_save_ticket', function( $post_id, $ticket ) {
    $product = wc_get_product( $ticket->ID );
    $product->set_catalog_visibility( 'visible' );
    $product->save();
}, 100, 2 );

// Hook in
add_filter( 'woocommerce_default_address_fields' , 'aveloles_override_default_address_fields' );

// gjanssens : Do not autofill field needed for shipping comute
function aveloles_override_default_address_fields( $address_fields ) {
    $address_fields['billing_postcode']['required'] = false;
    $address_fields['billing_city']['required'] = false;
    $address_fields['billing_country']['required'] = false;
    $address_fields['shipping_postcode']['required'] = false;
    $address_fields['shipping_city']['required'] = false;
    $address_fields['shipping_country']['required'] = false;

    return $address_fields;
}