@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Payment Plan</h2>

            <!-- Step 1: Payment Information -->
            <div id="payment-info" class="space-y-4">
                <h3 class="text-xl font-semibold">Payment Information</h3>

                <label class="block">
                    <span class="text-gray-700">Cardholder Name</span>
                    <input type="text" id="cardholder-name" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="Enter your name" />
                </label>

                <label class="block">
                    <span class="text-gray-700">Card Number</span>
                    <input type="text" id="card-number" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="Enter your card number" />
                </label>

                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label class="block">
                            <span class="text-gray-700">Expiration Date</span>
                            <input type="month" id="expiration-date" class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                        </label>
                    </div>

                    <div class="w-1/2">
                        <label class="block">
                            <span class="text-gray-700">CVV</span>
                            <input type="text" id="cvv" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="Enter CVV" />
                        </label>
                    </div>
                </div>

                <label class="block">
                    <span class="text-gray-700">Billing Address</span>
                    <input type="text" id="billing-address" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="Enter your billing address" />
                </label>

                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="goToStep2()">Next Step</button>
            </div>

            <!-- Step 2: Payment Plan -->
            <div id="payment-plan" class="space-y-4 hidden mt-6">
                <h3 class="text-xl font-semibold">Choose Your Payment Plan</h3>

                <label class="block">
                    <span class="text-gray-700">Select Payment Plan</span>
                    <select id="payment-plan-select" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="one-time">One-time Payment</option>
                        <option value="installments">Installments (3 months)</option>
                        <option value="installments-six">Installments (6 months)</option>
                        <option value="installments-twelve">Installments (12 months)</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-gray-700">Discount Code (Optional)</span>
                    <input type="text" id="discount-code" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="Enter discount code" />
                </label>

                <div class="mt-4">
                    <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="submitPayment()">Submit Payment</button>
                </div>
            </div>

            <!-- Result Summary -->
            <div id="payment-summary" class="hidden mt-8">
                <h3 class="text-xl font-semibold">Payment Summary</h3>

                <div id="summary-content" class="mt-4">
                    <!-- Payment summary details will go here -->
                </div>

                <button class="bg-gray-500 text-white px-4 py-2 rounded mt-4" onclick="goBackToStep1()">Back</button>
            </div>
        </div>
    </div>

    <script>
        function goToStep2() {
            // Check if payment info is valid
            const cardholderName = document.getElementById('cardholder-name').value;
            const cardNumber = document.getElementById('card-number').value;
            const expirationDate = document.getElementById('expiration-date').value;
            const cvv = document.getElementById('cvv').value;
            const billingAddress = document.getElementById('billing-address').value;

            if (!cardholderName || !cardNumber || !expirationDate || !cvv || !billingAddress) {
                alert('Please fill in all payment information fields.');
                return;
            }

            document.getElementById('payment-info').style.display = 'none';
            document.getElementById('payment-plan').classList.remove('hidden');
        }

        function submitPayment() {
            const paymentPlan = document.getElementById('payment-plan-select').value;
            const discountCode = document.getElementById('discount-code').value;

            // Create the summary content
            const summaryContent = `
                <p><strong>Payment Plan:</strong> ${paymentPlan}</p>
                <p><strong>Discount Code:</strong> ${discountCode ? discountCode : 'No discount applied'}</p>
            `;

            // Display payment summary and hide other steps
            document.getElementById('payment-summary').classList.remove('hidden');
            document.getElementById('summary-content').innerHTML = summaryContent;

            // Hide the payment plan step
            document.getElementById('payment-plan').style.display = 'none';
        }

        function goBackToStep1() {
            document.getElementById('payment-info').style.display = 'block';
            document.getElementById('payment-plan').style.display = 'none';
            document.getElementById('payment-summary').classList.add('hidden');
        }
    </script>
@endsection
