<?php

return array(

    /** The default gateway name */
    'gateway' => 'PayPal_Pro',

    /** The default settings, applied to all gateways */
    'defaults' => array(
        'testMode' => true,
    ),

    /** Gateway specific parameters */
    'gateways' => array(
        'Stripe' => array(
            'ApiKey' => 'sk_test_HF9uEfIdbUq6NqQ06hvE3n5s'

        ),
        'PayPal_Pro' => array(
            'username' => '',
            'password' => '',
            'signature' => ''
        )
    ),

);
