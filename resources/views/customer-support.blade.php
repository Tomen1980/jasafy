@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white border rounded-lg mt-6">
        <div class="flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-circle-help h-16 w-16 text-orange-500">
                <circle cx="12" cy="12" r="10" />
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                <path d="M12 17h.01" />
            </svg>

            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600 mb-6">In case you need help regarding our services, here are some common questions
                    asked:</p>
            </div>
        </div>

        <div class="space-y-4 md:space-y-0 gap-3 grid grid-cols-1 md:grid-cols-2">
            <div class="space-y-3">
                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">1. What is Jasafy?</h3>
                    <p class="text-gray-600">Jasafy is a platform where skills meet opportunity. We connect customers with
                        skilled service providers across various categories, ensuring you can easily find the right
                        professional for your needs.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">2. How does Jasafy work?
                    </h3>
                    <p class="text-gray-600">Simply browse through our diverse categories of services, select the one you
                        need, and connect with a verified professional who can help you with your project.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">3. How do I create an account?
                    </h3>
                    <p class="text-gray-600">To create an account, click on the "Sign Up" button on the top right corner of
                        our homepage, and follow the prompts to enter your details.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">4. How do I edit my profile information?
                    </h3>
                    <p class="text-gray-600">Log in to your account, go to your profile page, and click on the "Edit
                        Profile" button. From there, you can update your personal information, profile picture, and other
                        details.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">5. What should I do if I forget my password?
                    </h3>
                    <p class="text-gray-600">Click on the "Forgot Password" link on the login page, enter your registered
                        email address, and follow the instructions to reset your password.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">6. How do I find a service provider?
                    </h3>
                    <p class="text-gray-600">Use our search bar to enter the service you need or browse through our
                        categories. Once you find a service provider, you can view their profile, read reviews, and contact
                        them directly to discuss your project.

                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">7. How do I book a service?
                    </h3>
                    <p class="text-gray-600">After finding the right service provider, click on the "Book Now" button on
                        their profile, choose the date and time that suits you, and follow the prompts to complete your
                        booking.
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">8. How do I find a service provider?
                    </h3>
                    <p class="text-gray-600">Use our search bar to enter the service you need or browse through our
                        categories. Once you find a service provider, you can view their profile, read reviews, and contact
                        them directly to discuss your project.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">9. Is my payment information secure?
                    </h3>
                    <p class="text-gray-600">Yes, we use industry-standard encryption and security measures to protect your
                        payment information.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">10. What is the refund policy?
                    </h3>
                    <p class="text-gray-600">Refund policies may vary depending on the service provider. Please review the
                        provider's cancellation and refund terms on their profile before booking.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">11. How can I contact customer support?
                    </h3>
                    <p class="text-gray-600">You can reach our customer support team by clicking on the "Contact Us" link at
                        the bottom of the page, filling out the contact form, or emailing us at support@jasafy.com.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">12. What should I do if I encounter a problem with
                        a service provider?
                    </h3>
                    <p class="text-gray-600">If you face any issues with a service provider, please contact our customer
                        support team immediately. We will assist you in resolving the matter as quickly as possible.
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">13. How can I leave feedback or a review for a
                        service provider?
                    </h3>
                    <p class="text-gray-600">After your service is completed, you will receive an email with a link to leave
                        feedback. Alternatively, you can log in to your account, go to "My Orders" and click on "Review" for
                        the respective service.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
