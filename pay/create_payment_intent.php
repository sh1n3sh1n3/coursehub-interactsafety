<?php 
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/
require_once 'stripe_header.php';

// Define the product item price and convert it to cents (Stripe uses smallest currency unit)
$product_price = (int) round((float) AMOUNT * 100);

if ($product_price < 1) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid amount. Please return to the course page and try again.']);
    exit;
}

try { 
    // Create PaymentIntent with amount, currency and description
    $paymentIntent = \Stripe\PaymentIntent::create([ 
        'amount' => $product_price,
        'currency' => CURRENCY, 
        'description' => DESCRIPTION, 
        'payment_method_types' => [ 
            'card' 
        ] 
    ]); 
    
    $output = [ 
        'paymentIntentId' => $paymentIntent->id, 
        'clientSecret' => $paymentIntent->client_secret 
    ]; 
    
    echo json_encode($output); 
} catch (\Throwable $e) {
    http_response_code(500); 
    echo json_encode(['error' => $e->getMessage()]); 
} 
?>