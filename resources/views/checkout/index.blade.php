@extends('layouts.app')
@section('content')
    <!-- Wrapper -->

    <div id="wrapper">
        <!-- Titlebar  -->
        <div id="titlebar" class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Checkout</h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('premium.index') }}">Pricing Plans</a></li>
                                <li>Checkout</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <!-- Container -->
        <div class="container">
            <div class="row">

                <div class="col-xl-8 col-lg-8 content-right-offset">
                    <!-- Headline -->
                    <h3 id="title">Billing Cycle</h3>
                    <!-- Billing Cycle Radios  -->
                    <div class="billing-cycle margin-top-25">
                        <!-- Radio -->
                        <div class="radio">
                            <input id="radio-type" name="radio-payment-type" value="{{ app('request')->payment_type }}" type="radio"
                                   checked>
                            <label for="radio-type">
                                <span class="radio-label"></span>
                                Billed {{ ucfirst(app('request')->payment_type) . ' - ' . $planDetails->title . ' Plan'}}
                                <span class="billing-cycle-details">
                                    @if(app('request')->payment_type === 'monthly')
                                        <span class="regular-price-tag">{{ $planDetails->monthly_price }}€ / month</span>
                                    @elseif(app('request')->payment_type === 'yearly')
                                        <span class="regular-price-tag">{{ $planDetails->yearly_price }}€ / year</span>
                                    @endif
						</span>
                            </label>
                        </div>
                    </div>
                    <!-- Headline -->
                    <h3 class="margin-top-50">Payment Method</h3>
                    <form action="{{ route('checkout.store') }}" id="payment-form" method="post">
                    @csrf
                        @if(app('request')->payment_type === 'monthly')
                            <input type="hidden" name="plan" id="plan" value="{{ $planDetails->monthly_identifier }}">
                            <input type="hidden" name="subType" id="subType" value="monthly">
                        @elseif(app('request')->payment_type === 'yearly')
                            <input type="hidden" name="plan" id="plan" value="{{ $planDetails->yearly_identifier }}">
                            <input type="hidden" name="subType" id="subType" value="yearly">
                        @endif

                    <!-- Payment Methods Accordion -->
                        <div class="payment margin-top-30">
                            <div class="payment-tab payment-tab-active">
                                <div class="payment-tab-trigger">
                                    <input checked id="paypal" name="cardType" type="radio" value="paypal">
                                    <label for="paypal">PayPal</label>
                                    <img class="payment-logo paypal" src="https://imgur.com/ApBxkXU.png" alt="">
                                </div>

                                <div class="payment-tab-content">
                                    <p>You will be redirected to PayPal to complete payment.</p>
                                </div>
                            </div>

                            <div class="payment-tab">
                                <div class="payment-tab-trigger">
                                    <input type="radio" name="cardType" id="creditCart" value="creditCard">
                                    <label for="creditCart">Credit / Debit Card</label>
                                    <img class="payment-logo" src="https://i.imgur.com/IHEKLgm.png" alt="">
                                </div>

                                <div class="payment-tab-content">
                                    <input type="hidden" name="name" id="card-holder-name"
                                           value="{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}">
                                    <div id="card-element" style="height: 60px; margin-top: 50px"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Checkbox -->
                        <div class="checkbox margin-top-30">
                            <input type="checkbox" id="two-step" name="two-step">
                            <label for="two-step"><span class="checkbox-icon"></span> I agree to the <a href="{{ route('terms') }}">Terms and
                                    Conditions</a> and the <a href="{{ route('renewal') }}">Automatic Renewal Terms</a></label>
                        </div>

                        <!-- Payment Methods Accordion / End -->
                        <br>
                        <button type="submit" formtarget="payment-form"
                                class="button big ripple-effect margin-top-40 margin-bottom-65"
                                id="card-button" data-secret="{{ $intent->client_secret }}">Proceed Payment
                        </button>
                    </form>
                </div>
                <div class="col-xl-4 col-lg-4 margin-top-0 margin-bottom-60">

                    <!-- Summary -->
                    <div class="boxed-widget summary margin-top-0">
                        <div class="boxed-widget-headline">
                            <h3>Summary</h3>
                        </div>
                        <div class="boxed-widget-inner">
                            <ul>
                                <li>Standard Plan
                                    @if(app('request')->payment_type === 'monthly')
                                        <span id="span-price">{{ $planDetails->monthly_price }}€ / month</span>
                                    @elseif(app('request')->payment_type === 'yearly')
                                        <span id="span-price">{{ $planDetails->yearly_price }}€ / year</span>
                                    @endif
                                </li>
                                <li>VAT (20%) <span>Included</span></li>
                                @if(app('request')->payment_type === 'monthly')
                                    <li class="total-costs">Final Price <span>{{ $planDetails->monthly_price }}€</span></li>
                                @elseif(app('request')->payment_type === 'yearly')
                                    <li class="total-costs">Final Price <span>{{ $planDetails->yearly_price }}€</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- Summary / End -->

                </div>

            </div>
        </div>
        <!-- Container / End -->
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('cashier.key') }}')

        const elements = stripe.elements()
        const cardElement = elements.create('card')

        cardElement.mount('#card-element')

        const form = document.getElementById('payment-form')
        const cardBtn = document.getElementById('card-button')
        const cardHolderName = document.getElementById('card-holder-name')

        form.addEventListener('submit', async (e) => {
            e.preventDefault()

            cardBtn.disabled = true
            const {setupIntent, error} = await stripe.confirmCardSetup(
                cardBtn.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            )

            if (error) {
                cardBtn.disable = false
            } else {
                let token = document.createElement('input')

                token.setAttribute('type', 'hidden')
                token.setAttribute('name', 'token')
                token.setAttribute('value', setupIntent.payment_method)

                form.appendChild(token)

                form.submit();
            }
        });
    </script>
    <!-- Wrapper / End -->
@endsection