@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white border rounded-lg mt-6">
        <div class="flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-circle-alert h-16 w-16 text-red-500">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>

            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">What to Do When Scammed</h2>
                <p class="text-gray-600 mb-6">Follow these steps to protect yourself and take appropriate actions:</p>
            </div>
        </div>

        <div class="space-y-4 md:space-y-0 gap-3 grid grid-cols-1 md:grid-cols-2">
            <div class="space-y-3">
                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">1. Stop All Communication</h3>
                    <p class="text-gray-600">Cease all communication with the scammer immediately. Do not provide any
                        further
                        personal or financial information.</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">2. Document Everything</h3>
                    <p class="text-gray-600">Keep records of all interactions, emails, messages, and any proof of payment.
                        This
                        will be essential for reporting the scam.</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">3. Report the Scam</h3>
                    <p class="text-gray-600">Report the scam to Jasafy admin immediately.</p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">4. Contact Your Bank</h3>
                    <p class="text-gray-600">If you have made a payment, contact your bank or credit card company
                        immediately to
                        stop any further transactions and to dispute the charges.</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">5. Update Security Measures</h3>
                    <p class="text-gray-600">Change passwords for all your online accounts, enable two-factor
                        authentication,
                        and monitor your accounts for any suspicious activity.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
