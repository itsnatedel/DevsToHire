@extends('layouts.app')
<!-- Wrapper -->
@section('content')
    <div id="wrapper">
        <!-- Intro Banner
        ================================================== -->
        <!-- add class "disable-gradient" to enable consistent background overlay -->
        <div class="intro-banner" data-background-image="{{ asset('images/home-background.jpg') }}">
            <div class="container">

                <!-- Intro Headline -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="banner-headline">
                            <h3>
                                <strong>Hire experts or be hired for any job, any time.</strong>
                                <br>
                                <span>Thousands of small businesses use <strong class="color">DevsToHire</strong> to turn their ideas into reality.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- Search Bar -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="intro-banner-search-form margin-top-95">

                            <!-- Search Field -->
                            <div class="intro-search-field with-autocomplete">
                                <label for="autocomplete-input" class="field-title ripple-effect">Where?</label>
                                <div class="input-with-icon">
                                    <input id="autocomplete-input" type="text" placeholder="Online Job">
                                    <i class="icon-material-outline-location-on"></i>
                                </div>
                            </div>

                            <!-- Search Field -->
                            <div class="intro-search-field">
                                <label for="intro-keywords" class="field-title ripple-effect">What job you want?</label>
                                <input id="intro-keywords" type="text" placeholder="Job Title or Keywords">
                            </div>

                            <!-- Button -->
                            <div class="intro-search-button">
                                <button class="button ripple-effect"
                                        onclick="window.location.href='{{ route('job.index') }}'">Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="row">
                    <div class="col-md-12">
                        <ul class="intro-stats margin-top-45 hide-under-992px">
                            <li>
                                <strong class="counter">{{ $jobs }}</strong>
                                <span>Jobs Posted</span>
                            </li>
                            <li>
                                <strong class="counter">{{ $tasks }}</strong>
                                <span>Tasks Posted</span>
                            </li>
                            <li>
                                <strong class="counter">{{ $freelancers }}</strong>
                                <span>Freelancers</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <!-- Content -->
        <!-- Category Boxes -->
        <div class="section margin-top-65">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">

                        <div class="section-headline centered margin-bottom-15">
                            <h3>Popular Job Categories</h3>
                        </div>
                        <!-- Category Boxes Container -->
                        <div class="categories-container">
                            @foreach($categories as $category)
                                <a href="{{ route('job.category', $category->id) }}" class="category-box">
                                    <div class="category-box-icon">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <div class="category-box-content">
                                        <h3>{{ $category->name }}</h3>
                                        <p>{{ $category->description }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Category Boxes / End -->

        <!-- Features Jobs -->
        <div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">

                        <!-- Section Headline -->
                        <div class="section-headline margin-top-0 margin-bottom-35">
                            <h3>Featured Jobs</h3>
                            <a href="{{ route('job.index') }}" class="headline-link">Browse All Jobs</a>
                        </div>

                        <!-- Jobs Container -->
                        <div class="listings-container compact-list-layout margin-top-35">
                        @foreach($featuredJobs as $fJob)
                            <!-- Job Listing -->
                                <a href="{{ route('job.show', [$fJob->id, $fJob->slug]) }}" class="job-listing with-apply-button">
                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">
                                        <!-- Logo -->
                                        <div class="job-listing-company-logo">
                                            <img src="{{ asset('images/companies/' . $fJob->pic) }}" alt="">
                                        </div>
                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">{{ $fJob->title }}</h3>
                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li><i class="icon-material-outline-business"></i>
                                                        {{ $fJob->company }}
                                                        <div class="verified-badge" title="Verified Employer"
                                                             data-tippy-placement="top">
                                                        </div>
                                                    </li>
                                                    <li><i class="icon-material-outline-location-on"></i>
                                                        {{ $fJob->country }}
                                                    </li>
                                                    <li><i class="icon-material-outline-business-center"></i>
                                                        {{ $fJob->type }}
                                                    </li>
                                                    <li><i class="icon-material-outline-access-time"></i>
                                                        {{ $fJob->date_posted }}
                                                        @if($fJob->date_posted == 1)
                                                            day
                                                        @else
                                                            days
                                                        @endif
                                                        ago
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Apply Button -->
                                        <span class="list-apply-button button-sliding-icon ripple-effect">
                                            More info
                                            <i class="icon-material-outline-keyboard-arrow-right"
                                               style="transform: translateY(2px)"></i>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <!-- Jobs Container / End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Featured Jobs / End -->

        <!-- Highest Rated Freelancers -->
        <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
            <div class="container">
                <div class="row">

                    <div class="col-xl-12">
                        <!-- Section Headline -->
                        <div class="section-headline margin-top-0 margin-bottom-25">
                            <h3>Highest Rated Freelancers</h3>
                            <a href="{{ route('freelancer.index') }}" class="headline-link">Browse All Freelancers</a>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="default-slick-carousel freelancers-container freelancers-grid-layout">
                            <!--Freelancer -->
                            @foreach($featuredFreelancers as $freelancer)
                                <div class="freelancer">
                                    <!-- Overview -->
                                    <div class="freelancer-overview">
                                        <div class="freelancer-overview-inner">
                                            <!-- Bookmark Icon -->
                                            <span class="bookmark-icon"></span>
                                            <!-- Avatar -->
                                            <div class="freelancer-avatar">
                                                <div class="verified-badge"
                                                     title="Verified Freelancer"
                                                     data-tippy-placement="right"></div>
                                                <a href="{{ route('freelancer.show', [$freelancer->id, Str::slug($freelancer->fullName)]) }}">
                                                    <img src="{{ asset('images/user/' . $freelancer->pic_url) }}"
                                                         alt=""></a>
                                            </div>
                                            <!-- Name -->
                                            <div class="freelancer-name">
                                                <h4>
                                                    <a href="{{ route('freelancer.show', [$freelancer->id, Str::slug($freelancer->fullName)]) }}">
                                                        {{ $freelancer->fullName }}
                                                        <img class="flag"
                                                             src="{{ asset('images/flags/' . strtolower($freelancer->country_code) . '.svg') }}"
                                                             alt=""
                                                             title="{{ $freelancer->country_name }}"
                                                             data-tippy-placement="top">
                                                    </a>
                                                </h4>
                                                <span>Lorem Tags</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Details -->
                                    <div class="freelancer-details">
                                        <div class="freelancer-details-list">
                                            <ul>
                                                <li>Location <strong><i class="icon-material-outline-location-on"></i>
                                                        {{ Str::limit($freelancer->country_name, 10, '.') }}</strong>
                                                </li>
                                                <li>Rate <strong>{{ $freelancer->hourly_rate }}€/h</strong></li>
                                                <li>Job Success <strong>{{ $freelancer->success_rate }}%</strong></li>
                                            </ul>
                                        </div>
                                        <a href="{{ route('freelancer.show', [$freelancer->id, $freelancer->fullName]) }}"
                                           class="button button-sliding-icon ripple-effect">
                                            View Profile
                                            <i class="icon-material-outline-arrow-right-alt"></i>
                                        </a>
                                    </div>
                                </div>
                        @endforeach
                        <!-- Freelancer / End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Highest Rated Freelancers / End-->
        <!-- Membership Plans -->
        <div class="section padding-top-60 padding-bottom-75">
            <div class="container">
                <div class="row">

                    <div class="col-xl-12">
                        <!-- Section Headline -->
                        <div class="section-headline centered margin-top-0 margin-bottom-35">
                            <h3>Membership Plans</h3>
                        </div>
                    </div>


                    <div class="col-xl-12">

                        <!-- Billing Cycle  -->
                        <div class="billing-cycle-radios margin-bottom-70">
                            <div class="radio billed-monthly-radio">
                                <input id="radio-5" name="radio-payment-type" type="radio" checked>
                                <label for="radio-5"><span class="radio-label"></span> Billed Monthly</label>
                            </div>

                            <div class="radio billed-yearly-radio">
                                <input id="radio-6" name="radio-payment-type" type="radio">
                                <label for="radio-6"><span class="radio-label"></span> Billed Yearly <span
                                        class="small-label">Save 10%</span></label>
                            </div>
                        </div>

                        <!-- Pricing Plans Container -->
                        <div class="pricing-plans-container">
                        @foreach($premiumPlans as $plan)
                            <!-- Plan -->
                                @if($plan->plan === 'Standard')
                                    <div class="pricing-plan recommended">
                                        <div class="recommended-badge">Recommended</div>
                                        @else
                                            <div class="pricing-plan">
                                                @endif
                                                <h3>{{ $plan->plan }} Plan</h3>
                                                <p class="margin-top-10">{{ $plan->description }}</p>
                                                <div class="pricing-plan-label billed-monthly-label">
                                                    <strong>{{ $plan->monthly_price }}€</strong>/ monthly
                                                </div>
                                                <div class="pricing-plan-label billed-yearly-label">
                                                    <strong>{{ $plan->yearly_price }}€</strong>/ yearly
                                                </div>
                                                <div class="pricing-plan-features">
                                                    <strong>Features of our {{ $plan->plan }} Plan</strong>
                                                    <ul>
                                                        <li>
                                                            {{ $plan->listing }}
                                                            @if ($plan->listing == 1 && $plan->listing !== 'Unlimited')
                                                                Listing
                                                            @else
                                                                Listings
                                                            @endif
                                                        </li>
                                                        <li>{{ $plan->visibility_days }} Days Visibility</li>
                                                        <li>{{ $plan->highlighted }}</li>
                                                    </ul>
                                                </div>
                                                <a href="{{ route('checkout.index') }}"
                                                   class="button full-width margin-top-20">
                                                    Buy Now
                                                </a>
                                            </div>
                                            @endforeach
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Membership Plans / End-->
        </div>
        <!-- Wrapper / End -->
@endsection
