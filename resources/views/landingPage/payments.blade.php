@extends('landingPage.parent')
@section('contents')
<div class="ps-products-wrap pt-80 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div id="payment-message" style="display:none;" class="alert alert-info"></div>
                <form method="POST" id="payment-form">
                    <div id="payment-config" data-payment-url="{{ route('stripe.paymentIntel.create', $order->id) }}"></div>
                    @csrf
                    <div id="payment-element"></div>
                    <button id="submit" class="btn btn-primary">
                        <span id="button-text">Pay now</span>
                        <span class="spinner" id="spinner" style="display: none;">Processing....</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
    var csrfToken = "{{ csrf_token() }}";
</script>
<script>
    const stripe = Stripe("{{config('services.stripe.publishable_key')}}");
    let elements;

    initialize();
    checkStatus();

    document.getElementById("payment-form").addEventListener("submit", handleSubmit);

    let emailAddress = '';

    async function initialize() {
        const paymentUrl = document.getElementById('payment-config').getAttribute('data-payment-url');

        const { data, message } = await fetch(paymentUrl, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                "_token": csrfToken
            }),
        }).then(response => {
    if (!response.ok) {
        throw new Error("Network response was not ok");
    }
    return response.json();
}).then(data => {
    console.log("API Response:", data); // Check the actual response data
    return data;
}).catch(error => {
    console.error("Error fetching clientSecret:", error);
    throw error; // Rethrow the error to handle it in the caller function if necessary
});
console.log("API Response:", data); // Check the actual response data
console.log("Message:", message); // Check the message field (optional)

// Now, extract the clientSecret from the 'data' object
const { clientSecret } = data;

console.log("clientSecret:", clientSecret);

        elements = stripe.elements({ clientSecret });

        const paymentElementOptions = {
            // Customize the appearance of the payment form if needed
            // e.g., style, fonts, etc.
        };

        const paymentElement = elements.create("payment", paymentElementOptions);
        paymentElement.mount("#payment-element");
    }

    async function handleSubmit(e) {
        e.preventDefault();
        setLoading(true);

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: "{{ route('stripe.return', $order->id) }}",
                receipt_email: emailAddress,
            },
        });

        if (error) {
            console.error("Error confirming payment:", error);
            showMessage("An unexpected error occurred while processing your payment. Please try again later.");
        } else {
            showMessage("Payment succeeded!");
            // Optionally, you can redirect to a success page here
        }

        setLoading(false);
    }

    async function checkStatus() {
        const clientSecret = new URLSearchParams(window.location.search).get("payment_intent_client_secret");

        if (!clientSecret) {
            return;
        }

        const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

        switch (paymentIntent.status) {
            case "succeeded":
                showMessage("Payment succeeded!");
                break;
            case "processing":
                showMessage("Your payment is processing.");
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                break;
            default:
                showMessage("Something went wrong.");
                break;
        }
    }

    // ------- UI helpers -------

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");
        messageContainer.style.display = "block";
        messageContainer.textContent = messageText;

        setTimeout(function () {
            messageContainer.style.display = "none";
            messageContainer.textContent = "";
        }, 4000);
    }

    function setLoading(isLoading) {
        const submitButton = document.querySelector("#submit");
        const spinner = document.querySelector("#spinner");
        const buttonText = document.querySelector("#button-text");

        if (isLoading) {
            submitButton.disabled = true;
            spinner.style.display = "inline";
            buttonText.style.display = "none";
        } else {
            submitButton.disabled = false;
            spinner.style.display = "none";
            buttonText.style.display = "inline";
        }
    }
</script>
@endsection
