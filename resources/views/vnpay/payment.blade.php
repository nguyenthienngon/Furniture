@extends('frontend.layouts.master')

@section('title', 'Artisan || Online Payment')

@section('main-content')
    <style>
        .payment-container {
            max-width: 800px;
            /* Increase width for a wider container */
            width: 100%;
            /* Ensure it takes up 100% of the container width, up to 800px */
            margin: 20px auto;
            padding: 30px;
            /* Adjust padding to give space while making it more compact vertically */
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            height: auto;
            /* Adjust height to auto for a shorter vertical space */
        }

        .payment-title {
            text-align: center;
            font-size: 1.8em;
            /* Reduced font size for a more compact title */
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            /* Reduced margin bottom */
        }

        .bank-options {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
            /* Reduced bottom margin */
        }

        .bank-options h4 {
            width: 100%;
            font-size: 1.2em;
            /* Reduced font size for bank selection */
            color: #555;
            margin-bottom: 10px;
            /* Reduced bottom margin */
        }

        .bank-options label {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin: 10px;
            /* Reduced margin for a more compact layout */
            flex: 1 0 160px;
            /* Increased flex size to create more space between options */
            justify-content: center;
        }

        .bank-options label input {
            margin-right: 10px;
            transform: scale(1.5);
            /* Increase size of the radio buttons */
        }

        .bank-options img {
            width: 70px;
            /* Adjusted image size */
            height: 70px;
            border-radius: 4px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
        }

        .payment-details {
            margin-top: 20px;
            /* Reduced margin-top for a more compact look */
            padding-top: 10px;
            /* Reduced padding-top */
            border-top: 1px solid #ddd;
        }

        .payment-details h4 {
            font-size: 1.2em;
            /* Reduced font size for card detail section */
            color: #333;
            margin-bottom: 15px;
            /* Reduced margin-bottom */
        }

        .payment-details input[type="text"] {
            width: 100%;
            padding: 12px;
            /* Reduced padding for more compact input fields */
            margin-top: 8px;
            /* Reduced margin */
            margin-bottom: 15px;
            /* Reduced bottom margin */
            border: 1px solid #ccc;
            border-radius: 8px;
            /* Maintain larger border radius for smooth look */
            box-sizing: border-box;
            font-size: 1.1em;
            /* Slightly reduced font size for inputs */
        }

        .pay-button {
            width: 100%;
            padding: 14px;
            /* Adjusted padding for a more compact button */
            background-color: #4CAF50;
            color: white;
            font-size: 1.1em;
            /* Reduced button font size */
            font-weight: bold;
            border: none;
            border-radius: 8px;
            /* Keep the rounded corners for the button */
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .pay-button:hover {
            background-color: #45a049;
        }

        .error-label {
            border-color: red;
        }

        .error-message {
            color: red;
            font-size: 1em;
            /* Slightly increased error message font size */
        }
    </style>

    <!-- VNPay Payment Simulation -->
    <section class="vn-pay-section section">
        <div class="container">
            <div class="payment-container">
                <div class="payment-title">VNPay Payment Simulation</div>

                <form class="form" method="POST" action="{{ route('cart.order') }}">
                    @csrf
                    <input type="hidden" name="order_number" value="{{ $order_data['order_number'] }}">
                    <input type="hidden" name="user_id" value="{{ $order_data['user_id'] }}">
                    <input type="hidden" name="shipping" value="{{ $order_data['shipping_id'] }}">
                    <input type="hidden" name="sub_total" value="{{ $order_data['sub_total'] }}">
                    <input type="hidden" name="quantity" value="{{ $order_data['quantity'] }}">
                    <input type="hidden" name="total_amount" value="{{ $order_data['total_amount'] }}">
                    <input type="hidden" name="status" value="{{ $order_data['status'] }}">
                    <input type="hidden" name="payment_method" value="cod">
                    <input type="hidden" name="country" value="{{ $order_data['country'] ?? 'Vietnam' }}">
                    <input type="hidden" name="first_name" value="{{ $order_data['first_name'] }}">
                    <input type="hidden" name="last_name" value="{{ $order_data['last_name'] }}">
                    <input type="hidden" name="address1" value="{{ $order_data['address1'] }}">
                    <input type="hidden" name="email" value="{{ $order_data['email'] }}">
                    <input type="hidden" name="address2" value="{{ $order_data['address2'] ?? '' }}">
                    <input type="hidden" name="phone" value="{{ $order_data['phone'] }}">
                    <input type="hidden" name="post_code" value="{{ $order_data['post_code'] ?? '' }}">

                    <div class="bank-options">
                        <h4>Select Domestic Bank</h4>
                        <label>
                            <input type="radio" name="bank_code" value="VCB" required>
                            <img src="{{ asset('images/download.jpg') }}" alt="Vietcombank"> Vietcombank
                        </label>
                        <label>
                            <input type="radio" name="bank_code" value="ACB">
                            <img src="{{ asset('images/download1.jpg') }}" alt="ACB"> ACB
                        </label>
                        <label>
                            <input type="radio" name="bank_code" value="TCB">
                            <img src="{{ asset('images/download2_1.jpg') }}" alt="Techcombank"> Techcombank
                        </label>
                        <label>
                            <input type="radio" name="bank_code" value="BIDV">
                            <img src="{{ asset('images/download3 (1).jpg') }}" alt="BIDV"> BIDV
                        </label>
                    </div>

                    <div class="bank-options">
                        <h4>Select International Bank</h4>
                        <label>
                            <input type="radio" name="bank_code" value="INT_PAYPAL">
                            <img src="{{ asset('images/pp.jpg') }}" alt="PayPal"> PayPal
                        </label>
                        <label>
                            <input type="radio" name="bank_code" value="INT_VISA">
                            <img src="{{ asset('images/visa.jpg') }}" alt="Visa/MasterCard"> Visa/MasterCard
                        </label>
                        <label>
                            <input type="radio" name="bank_code" value="INT_JCB">
                            <img src="{{ asset('images/jcb.jpg') }}" alt="JCB"> JCB
                        </label>
                    </div>

                    <div class="payment-details" id="paymentDetails">
                        <h4>Enter Card Details</h4>
                        <label for="card_number">Card Number:</label>
                        <input type="text" id="card_number" name="card_number" required><br><br>
                        <span id="card_number_error" class="error-message"></span><br>

                        <label for="card_expiry">Expiry Date (MM/YY):</label>
                        <input type="text" id="card_expiry" name="card_expiry" required><br><br>
                        <span id="card_expiry_error" class="error-message"></span><br>

                        <label for="card_cvc">CVC:</label>
                        <input type="text" id="card_cvc" name="card_cvc" required><br><br>
                        <span id="card_cvc_error" class="error-message"></span><br>
                    </div>

                    <button type="submit" class="pay-button">Proceed to Payment</button>

                </form>
            </div>
        </div>
    </section>
    <!-- End VNPay Payment Simulation -->

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.form');
        const cardNumberInput = document.getElementById('card_number');
        const expiryInput = document.getElementById('card_expiry');
        const cvcInput = document.getElementById('card_cvc');

        const cardNumberError = document.getElementById('card_number_error');
        const expiryError = document.getElementById('card_expiry_error');
        const cvcError = document.getElementById('card_cvc_error');

        const checkCardNumber = (value) => {
            if (!/^\d{16}$/.test(value)) {
                cardNumberError.textContent = "Số thẻ phải gồm đúng 16 chữ số.";
                cardNumberInput.classList.add('error-label');
                return false;
            }
            cardNumberError.textContent = "";
            cardNumberInput.classList.remove('error-label');
            return true;
        };

        const checkExpiry = (value) => {
            if (!/^\d{4}$/.test(value)) {
                expiryError.textContent = "Ngày hết hạn phải có đúng 4 chữ số (MM/YY).";
                expiryInput.classList.add('error-label');
                return false;
            }
            expiryError.textContent = "";
            expiryInput.classList.remove('error-label');
            return true;
        };

        const checkCvc = (value) => {
            if (!/^\d{3}$/.test(value)) {
                cvcError.textContent = "CVC phải gồm đúng 3 chữ số.";
                cvcInput.classList.add('error-label');
                return false;
            }
            cvcError.textContent = "";
            cvcInput.classList.remove('error-label');
            return true;
        };

        form.addEventListener('submit', function(event) {
            const isCardNumberValid = checkCardNumber(cardNumberInput.value);
            const isExpiryValid = checkExpiry(expiryInput.value);
            const isCvcValid = checkCvc(cvcInput.value);

            if (!(isCardNumberValid && isExpiryValid && isCvcValid)) {
                event.preventDefault(); // Prevent form submission if any field is invalid
            }
        });
    });
</script>
