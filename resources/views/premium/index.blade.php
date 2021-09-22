@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Titlebar
        ================================================== -->
        <div id="titlebar" class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Pricing Plans</h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li>Pricing Plans</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Content
        ================================================== -->
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Section Headline -->
                    <div class="section-headline centered margin-top-0 margin-bottom-35">
                        <h3>Membership Plans</h3>
                    </div>
                    <div class="col-xl-12">
                        <!-- Billing Cycle  -->
                        <form action="{{ route('checkout.index') }}" method="get">
                            <div class="billing-cycle-radios margin-bottom-70">
                                <div class="radio billed-monthly-radio">
                                    <input id="radio-5" name="payment_type" value="monthly" type="radio" checked>
                                    <label for="radio-5"><span class="radio-label"></span> Billed Monthly</label>
                                </div>

                                <div class="radio billed-yearly-radio">
                                    <input id="radio-6" name="payment_type" value="yearly" type="radio">
                                    <label for="radio-6"><span class="radio-label"></span> Billed Yearly <span
                                                class="small-label">Save 10%</span></label>
                                </div>
                            </div>
                            <!-- Pricing Plans Container -->
                            <div class="pricing-plans-container">
                            @foreach($premiumPlans as $plan)
                                <!-- Plan -->
                                @if($plan->title === 'Standard')
                                    <div class="pricing-plan recommended">
                                        <div class="recommended-badge">Recommended</div>
                                @else
                                    <div class="pricing-plan">
                                @endif
                                <h3>{{ $plan->title }} Plan</h3>
                                <p class="margin-top-10">{{ $plan->description }}</p>
                                <div class="pricing-plan-label billed-monthly-label">
                                    <strong>{{ $plan->monthly_price }}€</strong>/ monthly
                                </div>
                                <div class="pricing-plan-label billed-yearly-label">
                                    <strong>{{ $plan->yearly_price }}€</strong>/ yearly
                                </div>
                                <div class="pricing-plan-features">
                                    <strong>Features of our {{ $plan->title }} Plan</strong>
                                    <ul class="list-2" style="margin-left: 25px">
                                        <li>
                                            {{ $plan->listing }}
                                            @if ($plan->listing == 1 && $plan->listing !== 'Unlimited')
                                                Listing
                                            @else
                                                Listings
                                            @endif
                                        </li>
                                        <li>{{ $plan->visibility_days }} Days Visibility</li>
                                        @if(!$loop->first)
                                            <li>{{ $plan->highlighted }}</li>
                                        @endif
                                    </ul>
                                </div>
                                @if($loop->first)
                                    <button type="submit" name="plan_id"
                                            class="button full-width margin-top-50"
                                            value="{{ $loop->iteration }}">
                                        Buy Now
                                    </button>
                                @else
                                    <button type="submit" name="plan_id"
                                            value="{{ $loop->iteration }}"
                                            class="button full-width margin-top-20">
                                        Buy Now
                                    </button>
                                @endif
                                </div>
                            @endforeach
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="margin-top-80"></div>
    <!-- Wrapper / End -->
@endsection