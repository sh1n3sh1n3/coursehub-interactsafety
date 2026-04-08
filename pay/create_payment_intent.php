<?php 
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/
// Always return JSON and ensure something is sent
header('Content-Type: application/json; charset=utf-8');

$create_payment_intent_sent = false;
function sendJson($data) {
    global $create_payment_intent_sent;
    $create_payment_intent_sent = true;
    echo json_encode($data);
    exit;
}
// If script dies before sending (e.g. fatal in config/conn), send a generic error
register_shutdown_function(function() {
    global $create_payment_intent_sent;
    if (!$create_payment_intent_sent && !connection_aborted()) {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
        }
        echo json_encode(['error' => 'Server error. Check that the pay page was opened first and that PHP error log has no fatal errors.']);
    }
});

try {
    // Check Stripe SDK exists before requiring
    $vendorAutoload = __DIR__ . '/vendor/autoload.php';
    if (!is_file($vendorAutoload)) {
        http_response_code(500);
        sendJson(['error' => 'Stripe SDK not installed. Run composer install in the pay folder.']);
    }

    require_once __DIR__ . '/config.php';
    require_once $vendorAutoload;

    if (!defined('STRIPE_SECRET_API_KEY') || !defined('AMOUNT')) {
        http_response_code(500);
        sendJson(['error' => 'Payment configuration missing. Ensure you opened the pay page first so the session is set.']);
    }

    \Stripe\Stripe::setApiKey(STRIPE_SECRET_API_KEY);

    // Amount in cents (Stripe uses smallest currency unit)
    $product_price = (int) round((float) AMOUNT * 100);

    if ($product_price < 1) {
        http_response_code(400);
        sendJson(['error' => 'Invalid amount. Please return to the course page and try again.']);
    }

    $courseid_sess = isset($_SESSION['courseid']) ? (int) $_SESSION['courseid'] : 0;
    $slotid_sess = isset($_SESSION['pay_slotid']) ? (int) $_SESSION['pay_slotid'] : 0;
    if ($courseid_sess > 0 && $slotid_sess > 0 && isset($conn) && $conn instanceof mysqli) {
        $slotTypeRes = $conn->query('SELECT type FROM course_slots WHERE id=' . $slotid_sess . ' AND courseid=' . $courseid_sess);
        if ($slotTypeRes && $slotTypeRes->num_rows > 0) {
            $slotRow = $slotTypeRes->fetch_assoc();
            if (($slotRow['type'] ?? '') === 'public') {
                if (public_booking_is_closed_for_slot($conn, $slotid_sess)) {
                    http_response_code(409);
                    sendJson(['error' => public_booking_closed_user_message()]);
                }
                $rem = get_public_seats_remaining($conn, $courseid_sess, $slotid_sess);
                if ($rem !== null && $rem < 1) {
                    http_response_code(409);
                    sendJson(['error' => format_course_capacity_block_message($rem)]);
                }
            }
        }
    }

    $currency = defined('CURRENCY') ? CURRENCY : 'AUD';
    $description = defined('DESCRIPTION') ? DESCRIPTION : 'Course payment';

    $paymentIntent = \Stripe\PaymentIntent::create([ 
        'amount' => $product_price,
        'currency' => $currency, 
        'description' => $description, 
        'payment_method_types' => [ 'card' ] 
    ]); 
    
    sendJson([ 
        'paymentIntentId' => $paymentIntent->id, 
        'clientSecret' => $paymentIntent->client_secret 
    ]); 

} catch (\Throwable $e) {
    http_response_code(500); 
    sendJson(['error' => $e->getMessage()]); 
}