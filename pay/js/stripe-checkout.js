// Base URL for pay endpoints (set by page when loaded from payment-confirmation rewrite)
const payBase = (typeof PAY_BASE !== 'undefined' && PAY_BASE) ? PAY_BASE.replace(/\/$/, '') : '';

// Get Your Stripe Publishable API Key
let publishable_key = document.querySelector("#publishable_key").value;

// Set your Stripe publishable API key to an instance of Stripe Object
const stripe = Stripe(publishable_key);

// Define the card elements variable
let elements;

// Select a payment form element
const paymentForm = document.querySelector("#stripe-payment-form");

// Select a payment submit button
const submitButton = document.querySelector("#submit-button");

// Select a payment submit button text
const submitText = document.querySelector("#submit-text");

// Select a payment submit spinner
const spinner = document.querySelector("#spinner");

// Select a payment message response element
const messageContainer = document.querySelector("#stripe-payment-message");

// Select a payment processing element
const paymentProcessing = document.querySelector("#payment_processing");

// Select a payment reinitiate element
const payReinitiate = document.querySelector("#payment-reinitiate");

// Get a payment_intent_client_secret parameter from URL
const checkClientSecret = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
);

stripeProcessing(true);
// Check is payment_intent_client_secret parameter exist in the URL
if(!checkClientSecret){
    stripeProcessing(false);
    // Create a new instance of Stripe Elements UI library and attach the client secret to it
    initialize();
}

// Check the status of PaymentIntent creation
checkStatus();

// Attach a payment submit event handler to payment form
paymentForm.addEventListener("submit", handlePaymentSubmit);

// Fetch a payment intent and capture the client secret
let payment_intent_id;
async function initialize() {
    const { paymentIntentId, clientSecret } = await fetch((payBase ? payBase + '/' : '') + "create_payment_intent.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ request_type:'create_payment_intent' }),
    }).then((r) => r.json());
    
    const appearance = {
        theme: 'stripe',
        rules: {
            '.Label': {
                fontWeight: 'bold',
            }
        }
    };
    
    elements = stripe.elements({ clientSecret, appearance });
    
    const paymentElement = elements.create("payment");
    paymentElement.mount("#stripe-payment-element");
    
    payment_intent_id = paymentIntentId;
}

// Function to handle payment form submit
async function handlePaymentSubmit(e) {
    e.preventDefault();
    var termsEl = document.getElementById("terms_agree");
    if (termsEl && !termsEl.checked) {
        showMessage("Please accept the Terms and Conditions to proceed with payment.");
        return;
    }
    setLoading(true);
    
    let name = document.getElementById("fullname").value;
    let email = document.getElementById("email").value;
    let courseid = document.getElementById("courseid").value;
    let locid = document.getElementById("locid").value;
    let slotid = document.getElementById("slotid").value;
    let cityid = document.getElementById("cityid").value;
    let registerid = document.getElementById("registerid").value;
    let fullname = name+'_'+courseid+'_'+locid+'_'+slotid+'_'+cityid+'_'+registerid;
    
    const { customer_id } = await fetch((payBase ? payBase + '/' : '') + "create_customer.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ payment_intent_id: payment_intent_id, fullname: fullname, email: email }),
    }).then((r) => r.json());
    
    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: window.location.href+'?customer_id='+customer_id,
        },
    });
    
    // This point will only be reached if there is an immediate error when
    // confirming the payment. Otherwise, your customer will be redirected to
    // your `return_url`. For some payment methods like iDEAL, your customer will
    // be redirected to an intermediate site first to authorize the payment, then
    // redirected to the `return_url`.
    if (error.type === "card_error" || error.type === "validation_error") {
        showMessage(error.message);
        paymentReinitiate();
    } else {
        showMessage("An unexpected error occured.");
        paymentReinitiate();
    }
    setLoading(false);
}

// Fetch the PaymentIntent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );
    
    const customer_id = new URLSearchParams(window.location.search).get(
        "customer_id"
    );
    
    if (!clientSecret) {
        return;
    }
    
    // Show loading while we check status (user just returned from 3DS etc.)
    paymentForm.classList.add("hidden");
    paymentProcessing.classList.remove("hidden");
    if (submitButton) { submitButton.classList.add("hidden"); }
    if (payReinitiate) { payReinitiate.classList.add("hidden"); }
    
    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
    
    if (paymentIntent) {
        switch (paymentIntent.status) { 
            case "succeeded":
                // Post the transaction data to the server-side script
                // and redirect to the payment status page (keep showing "processing..." until redirect)
                fetch((payBase ? payBase + '/' : '') + "payment_insert.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ payment_intent: paymentIntent, customer_id: customer_id }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.transaction_id) {
                        var statusUrl = (payBase ? payBase.replace(/\/+$/, '') + '/' : '') + 'status.php?tid='+data.transaction_id;
                        window.location.href = statusUrl;
                    } else {
                        paymentProcessing.classList.add("hidden");
                        showMessage(data.error || "Something went wrong.");
                        paymentReinitiate();
                    }
                })
                .catch(function(err) {
                    paymentProcessing.classList.add("hidden");
                    showMessage("Something went wrong. Please try again.");
                    paymentReinitiate();
                });
                break;
            case "processing":
                // Keep showing payment_processing message
                showMessage("Your payment is still processing. We will confirm shortly.");
                paymentReinitiate();
                break;
            case "requires_payment_method":
                paymentProcessing.classList.add("hidden");
                showMessage("Your payment was not successful, please try again.");
                paymentReinitiate();
                break;
            default:
                paymentProcessing.classList.add("hidden");
                showMessage("Something went wrong.");
                paymentReinitiate();
                break;
        }
    } else {
        paymentProcessing.classList.add("hidden");
        showMessage("Something went wrong.");
        paymentReinitiate();
    }
}

// Display message
function showMessage(messageText) {
    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;
    
    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageContainer.textContent = "";
    }, 10000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        submitButton.disabled = true;
        spinner.classList.remove("hidden");
        submitText.textContent = "Processing...";
    } else {
        submitButton.disabled = false;
        spinner.classList.add("hidden");
        submitText.textContent = "Pay Now";
    }
}

// Show/Hide a spinner of processing on payment form
function stripeProcessing(isProcessing) {
    if (isProcessing) {
        paymentForm.classList.add("hidden");
        paymentProcessing.classList.remove("hidden");
    } else {
        paymentForm.classList.remove("hidden");
        paymentProcessing.classList.add("hidden");
    }
}

// Display the payment reinitiate button
function paymentReinitiate() {
    paymentProcessing.classList.add("hidden");
    payReinitiate.classList.remove("hidden");
    submitButton.classList.add("hidden");
}

// Reinitiate stripe payment
function reinitiateStripe() {
    window.location.href=window.location.href.split('?')[0];
}