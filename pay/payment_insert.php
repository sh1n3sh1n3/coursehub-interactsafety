<?php 
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/
@session_start();
@include('../include/conn.php');
require_once 'stripe_header.php';
// Include the database connection file 
require_once 'dbclass.php';

$payment = !empty($jsonObj->payment_intent)?$jsonObj->payment_intent:''; 
$customer_id = !empty($jsonObj->customer_id)?$jsonObj->customer_id:''; 
    
// Retrieve customer information from stripe
try {
    $customerData = \Stripe\Customer::retrieve($customer_id);  
}catch(Exception $e) { 
    $error = $e->getMessage(); 
}

if(empty($error)) {
    // If transaction was successful
    if(!empty($payment) && $payment->status == 'succeeded'){
        // Retrieve transaction details
        $transaction_id = $payment->id; 
        $amount = ($payment->amount/100); 
        $currency = $payment->currency; 
        $item_description = isset($payment->description) ? $payment->description : ''; 
        $payment_status = $payment->status; 
            
        $fullname = $email = ''; 
        $courseid = $locid = $slotid = $cityid = $registerid = '';
        if(!empty($customerData)){
            if(!empty($customerData->name)) {
                $fullname = $customerData->name;
                // Customer name is stored as "Name_courseid_locid_slotid_cityid_registerid" from create_customer
                $parts = explode('_', $customerData->name);
                if (count($parts) >= 6) {
                    $courseid   = $parts[1];
                    $locid      = $parts[2];
                    $slotid     = $parts[3];
                    $cityid     = $parts[4];
                    $registerid = $parts[5];
                }
            }
            if(!empty($customerData->email)) {
                $email = $customerData->email;
            }
        }

        $db = new DB;
        // Check if transaction data is already exists in DB with the same Transaction ID 
        $db->query("SELECT id FROM `stripe_payment` WHERE transaction_id=:transaction_id");
        $db->bind(":transaction_id", $transaction_id);
        $row = $db->result();
        if(empty($row)){
            // Insert transaction data into the `stripe_payment` database table
            $db->query("INSERT INTO `stripe_payment` (`fullname`, `email`, `item_description`, `currency`, `amount`, `transaction_id`,  `payment_status`) VALUES (:fullname, :email, :item_description, :currency, :amount, :transaction_id, :payment_status)");
            $db->bind(":fullname", $fullname);
            $db->bind(":email", $email);
            $db->bind(":item_description", $item_description);
            $db->bind(":currency", $currency);
            $db->bind(":amount", $amount);
            $db->bind(":transaction_id", $transaction_id);
            $db->bind(":payment_status", $payment_status);
            $db->execute();
        }
        $db->close();
        $output = [ 
            'transaction_id' => $transaction_id,
            'courseid' => $courseid,
            'locid' => $locid,
            'slotid' => $slotid,
            'cityid' => $cityid,
            'registerid' => $registerid
        ];
        echo json_encode($output); 
    }else{ 
        http_response_code(500); 
        echo json_encode(['error' => 'Transaction has been failed!']); 
    } 
}else{ 
    http_response_code(500);
    echo json_encode(['error' => $error]); 
} 
?>