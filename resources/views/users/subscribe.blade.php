@extends('layouts.app')

@section('content')
<div class="flex items-center px-6 md:px-0">
    <div class="w-full max-w-md md:mx-auto">
        <div class="rounded shadow">
            <div class="font-medium text-lg text-teal-darker bg-teal p-3 rounded-t">
                Subscribe
            </div>
            <div class="bg-white p-3 rounded-b">
                @if (
                    auth()->user()->subscribedToPlanId('stripe-id')
                )
                    You are subscribed!
                @else
                    <style>
                        /**
                        * The CSS shown here will not be introduced in the Quickstart guide, but shows
                        * how you can use CSS to style your Element's container.
                        */
                        .StripeElement {
                            background-color: white;
                            height: 40px;
                            padding: 10px 12px;
                            border-radius: 4px;
                            border: 1px solid transparent;
                            box-shadow: 0 1px 3px 0 #e6ebf1;
                            -webkit-transition: box-shadow 150ms ease;
                            transition: box-shadow 150ms ease;
                        }

                        .StripeElement--focus {
                            box-shadow: 0 1px 3px 0 #cfd7df;
                        }

                        .StripeElement--invalid {
                            border-color: #fa755a;
                        }

                        .StripeElement--webkit-autofill {
                            background-color: #fefde5 !important;
                        }
                    </style>

                    <script src="https://js.stripe.com/v3/"></script>

                    <form method="POST" id="payment-form" action="{{ route('users.doSubscribe', 'token') }}">
                        {{ csrf_field() }}

                        <div class="form-row">
                            <label for="card-element">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                                
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <button>Submit Payment</button>

                        <script>
                            // Create a Stripe client.
                            var stripe = Stripe('{{ config("services.stripe.key") }}');

                            // Create an instance of Elements.
                            var elements = stripe.elements();

                            // Custom styling can be passed to options when creating an Element.
                            // (Note that this demo uses a wider set of styles than the guide below.)
                            var style = {
                                base: {
                                    color: '#32325d',
                                    lineHeight: '18px',
                                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                    fontSmoothing: 'antialiased',
                                    fontSize: '16px',
                                    '::placeholder': {
                                    color: '#aab7c4'
                                    }
                                },
                                invalid: {
                                    color: '#fa755a',
                                    iconColor: '#fa755a'
                                }
                            };

                            // Create an instance of the card Element.
                            var card = elements.create('card', {style: style});

                            // Add an instance of the card Element into the `card-element` <div>.
                            card.mount('#card-element');

                            // Handle real-time validation errors from the card Element.
                            card.addEventListener('change', function(event) {
                                var displayError = document.getElementById('card-errors');
                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }
                            });

                            // Handle form submission.
                            var form = document.getElementById('payment-form');
                            var readyToSubmit = false;

                            form.addEventListener('submit', function(event) {
                                if (readyToSubmit) {
                                    return true;
                                }

                                event.preventDefault();

                                stripe.createToken(card).then(function(result) {
                                    if (result.error) {
                                        // Inform the user if there was an error.
                                        var errorElement = document.getElementById('card-errors');
                                        errorElement.textContent = result.error.message;
                                    } else {
                                        // Send the token to your server.
                                        // stripeTokenHandler(result.token);
                                        // console.log(result.token);

                                        form.setAttribute(
                                            'action',
                                            form.getAttribute('action').replace('token', result.token.id)
                                        );

                                        readyToSubmit = true;
                                        form.submit();
                                    }
                                });
                            });
                        </script>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
