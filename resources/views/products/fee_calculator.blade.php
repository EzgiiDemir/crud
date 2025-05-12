@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <!-- Navigation Tabs -->
        <div class="flex mb-6 text-black">
            <button id="step1Nav" class="w-1/5 py-2 text-center bg-gray-200 rounded-l-lg hover:bg-gray-300 focus:outline-none" onclick="goToStep(1)">Step 1</button>
            <button id="step2Nav" class="w-1/5 py-2 text-center bg-gray-200 hover:bg-gray-300 focus:outline-none" onclick="goToStep(2)">Step 2</button>
            <button id="step3Nav" class="w-1/5 py-2 text-center bg-gray-200 hover:bg-gray-300 focus:outline-none" onclick="goToStep(3)">Step 3</button>
            <button id="step4Nav" class="w-1/5 py-2 text-center bg-gray-200 hover:bg-gray-300 focus:outline-none" onclick="goToStep(4)">Step 4</button>
            <button id="step5Nav" class="w-1/5 py-2 text-center bg-gray-200 rounded-r-lg hover:bg-gray-300 focus:outline-none" onclick="goToStep(5)">Result</button>
        </div>

        <!-- Step 1: User Profile -->
        <div id="step1" class="hidden bg-white shadow-md rounded-lg p-6 mb-6 text-black">
            <h2 class="text-2xl font-semibold mb-4">Step 1: User Profile</h2>
            <div class="space-y-4">
                <label class="block">
                    <span>Age Group</span>
                    <select id="ageGroup" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="18-25">18-25</option>
                        <option value="26-35">26-35</option>
                        <option value="36-45">36-45</option>
                    </select>
                </label>
                <label class="block">
                    <span>Gender</span>
                    <select id="gender" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </label>
                <label class="block">
                    <span>Country of Residence</span>
                    <input type="text" id="country" class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                </label>
                <label class="block">
                    <span>Budget (₺)</span>
                    <input type="number" id="budget" class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                </label>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="goToStep(2)">Next Step</button>
        </div>

        <!-- Step 2: Product Preference -->
        <div id="step2" class="hidden bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">Step 2: Product Preference</h2>
            <div class="space-y-4">
                <label class="block">
                    <span>Product Type</span>
                    <select id="productType" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="tech">Technology</option>
                        <option value="food">Food</option>
                        <option value="fashion">Fashion</option>
                    </select>
                </label>
                <label class="block">
                    <span>Usage Frequency</span>
                    <select id="usageFrequency" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </label>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="goToStep(3)">Next Step</button>
        </div>

        <!-- Step 3: Investment Attitude -->
        <div id="step3" class="hidden bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">Step 3: Investment Attitude</h2>
            <div class="space-y-4">
                <label class="block">
                    <span>Risk Level</span>
                    <select id="riskLevel" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </label>
                <label class="block">
                    <span>Expected Return</span>
                    <select id="expectedReturn" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="monthly">Monthly Gain</option>
                        <option value="usefulness">Usefulness</option>
                    </select>
                </label>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="goToStep(4)">Next Step</button>
        </div>

        <!-- Step 4: Lifestyle & Value -->
        <div id="step4" class="hidden bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">Step 4: Lifestyle & Value</h2>
            <div class="space-y-4">
                <label class="block">
                    <span>Eco-Friendly Products?</span>
                    <select id="ecoFriendly" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </label>
                <label class="block">
                    <span>Price Sensitivity</span>
                    <select id="priceSensitivity" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </label>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="goToStep(5)">Next Step</button>
        </div>

        <!-- Step 5: Result and Summary -->
        <div id="step5" class="hidden bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">Step 5: Summary and Result</h2>
            <div id="resultSummary" class="space-y-4">
                <h3 class="font-semibold text-lg">Your Answers:</h3>
                <div id="answersSummary"></div>

                <h3 class="font-semibold text-lg mt-6">Recommended Products:</h3>
                <div id="recommendedProducts"></div>

                <button class="bg-green-600 text-white px-4 py-2 rounded mt-4" onclick="addToCart()">Proceed to Product</button>
                <button class="bg-gray-500 text-white px-4 py-2 rounded mt-4" onclick="resetForm()">Try Again</button>
            </div>
        </div>
    </div>
<style>
    p, h1, h2, h3, h4{
        color: black; !important;
    }
</style>
    <script>
        // Navigation function to switch between steps
        function goToStep(step) {
            // Hide all steps
            for (let i = 1; i <= 5; i++) {
                document.getElementById('step' + i).classList.add('hidden');
                document.getElementById('step' + i + 'Nav').classList.remove('bg-green-500');
                document.getElementById('step' + i + 'Nav').classList.add('bg-gray-200');
            }
            // Show the selected step
            document.getElementById('step' + step).classList.remove('hidden');
            document.getElementById('step' + step + 'Nav').classList.add('bg-green-500');
            document.getElementById('step' + step + 'Nav').classList.remove('bg-gray-200');
        }

        // Collect data from all steps and show summary
        function submitTest() {
            const payload = {
                ageGroup: document.getElementById('ageGroup').value,
                gender: document.getElementById('gender').value,
                country: document.getElementById('country').value,
                budget: document.getElementById('budget').value,
                productType: document.getElementById('productType').value,
                usageFrequency: document.getElementById('usageFrequency').value,
                riskLevel: document.getElementById('riskLevel').value,
                expectedReturn: document.getElementById('expectedReturn').value,
                ecoFriendly: document.getElementById('ecoFriendly').value,
                priceSensitivity: document.getElementById('priceSensitivity').value,
            };

            axios.post('/api/recommend-products', payload)
                .then(res => {
                    const resultSummary = document.getElementById('answersSummary');
                    resultSummary.innerHTML = `
                        <p>Age Group: ${payload.ageGroup}</p>
                        <p>Gender: ${payload.gender}</p>
                        <p>Country: ${payload.country}</p>
                        <p>Budget: ${payload.budget}</p>
                        <p>Product Type: ${payload.productType}</p>
                        <p>Usage Frequency: ${payload.usageFrequency}</p>
                        <p>Risk Level: ${payload.riskLevel}</p>
                        <p>Expected Return: ${payload.expectedReturn}</p>
                        <p>Eco-Friendly: ${payload.ecoFriendly}</p>
                        <p>Price Sensitivity: ${payload.priceSensitivity}</p>
                    `;

                    const recommendedProducts = document.getElementById('recommendedProducts');
                    let productsHtml = '';
                    res.data.products.forEach(product => {
                        productsHtml += `
                            <div class="mb-4">
                                <h4 class="text-xl font-semibold">${product.name}</h4>
                                <p>Price: ${product.price} ${product.currency}</p>
                                <p>${product.description}</p>
                            </div>
                        `;
                    });
                    recommendedProducts.innerHTML = productsHtml;
                })
                .catch(err => {
                    console.error(err);
                });
        }

        // Mock function for adding to cart
        function addToCart() {
            alert("Added to Cart!");
        }

        // Reset form
        function resetForm() {
            location.reload();
        }

        // Initialize first step
        goToStep(1);
    </script>
@endsection
