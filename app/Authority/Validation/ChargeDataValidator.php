<?php  namespace Authority\Validation;

class ChargeDataValidator extends Validator{

    static $cardData = [
        'card_number' => 'required|digit|creditCard',
        'amount' => 'required|max:12|numeric',
        'expiry_year' => 'required|max:2050|min:2014|numeric',
        'cvv' => 'required|numeric',
        'product' => 'required'
    ];

    static $chargeData = [
        'email' => 'required|email',
        'card_number' => 'required|digit|creditCard',
        'expiry_month' => 'required|max:12|min:1|numeric',
        'expiry_year' => 'required|max:99|min:14|numeric',
        'cvc' => 'required'
    ];
    static $validCard = [
        'card_number' => 'required|digit|creditCard',
        'amount' => 'required|max:12|numeric',
        'expiry_year' => 'required|max:2050|min:2014|numeric',
        'cvv' => 'required|numeric',
        'product' => 'required'
    ];

    static $postCharge = [
        'product' => 'required|numeric|exists:products,id',
        'token' => 'required'
    ];
} 