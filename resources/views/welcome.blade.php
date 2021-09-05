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
                        <form action="{{ route('welcome.search') }}" method="get">
                            @csrf
                            <div class="intro-banner-search-form margin-top-95">
                                <!-- Search Field -->
                                <div class="intro-search-field with-autocomplete">
                                    <label for="autocomplete-input" class="field-title ripple-effect">Where ?</label>
                                    <div class="input-with-icon">
                                        <input id="autocomplete-input" name="searchCountry" type="text" placeholder="France">
                                        <i class="icon-material-outline-location-on"></i>
                                    </div>
                                </div>

                                <!-- Search Field -->
                                <div class="intro-search-field">
                                    <label for="select-jobCategories" class="field-title ripple-effect">Which field ?</label>
                                    <select id="select-jobCategories" name="category" class="selectpicker default"
                                            data-selected-text-format="count" data-size="7" title="Choose a field category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="intro-search-field">
                                    <label for="select-jobType" class="field-title ripple-effect">What kind ?</label>
                                    <select id="select-jobType" name="type" class="selectpicker default" title="Choose a job/task type">
                                        <optgroup label="Job">
                                            <option value="freelance">Freelance</option>
                                            <option value="full-time">Full Time</option>
                                            <option value="part-time">Part Time</option>
                                            <option value="internship">Internship</option>
                                        </optgroup>
                                        <optgroup label="Task">
                                            <option value="fixed">Fixed Price</option>
                                            <option value="hourly">Hourly Rate</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <!-- Button -->
                                <div class="intro-search-button">
                                    <button class="button ripple-effect"
                                            onclick="window.location.href='{{ route('job.index') }}'">Search
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if(Session::has('fail'))
                            <div class="alert alert-danger" style="margin-top: 10px">
                                <p style="font-weight: bold">{{ Session::get('fail') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stats -->
                <div class="row">
                    <div class="col-md-12">
                        <ul class="intro-stats margin-top-45 hide-under-992px">
                            <li>
                                <strong class="counter">{{ $countJobs }}</strong>
                                <span>Jobs Posted</span>
                            </li>
                            <li>
                                <strong class="counter">{{ $countTasks }}</strong>
                                <span>Tasks Posted</span>
                            </li>
                            <li>
                                <strong class="counter">{{ $countFreelancers }}</strong>
                                <span>Freelancers</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

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
                                        <div class="category-box-counter" data-tippy-placement="top" title="Amount of jobs"
                                             data-tippy-theme="light">{{ $category->jobCount }}
                                        </div>
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

        <!-- Featured Jobs -->
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
        <div class="section white padding-top-65 padding-bottom-70 full-width-carousel-fix">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Section Headline -->
                        <div class="section-headline margin-top-0 margin-bottom-25">
                            <h3>Featured Freelancers</h3>
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
                                            @Auth
                                                <span class="bookmark-icon"></span>
                                            @endauth
                                        <!-- Avatar -->
                                            <div class="freelancer-avatar">
                                                @if($freelancer->verified)
                                                    <div class="verified-badge"
                                                         title="Verified Freelancer"
                                                         data-tippy-placement="right">
                                                    </div>
                                                @endif
                                                <a href="{{ route('freelancer.show', [$freelancer->id, Str::slug($freelancer->fullName)]) }}">
                                                    <!-- If null -->
                                                    @if (is_null($freelancer->remember_token))
                                                        <img src="{{ asset('images/user/' . $freelancer->pic_url) }}"
                                                             alt="Freelancer Avatar">
                                                </a>
                                                @else
                                                    <img
                                                        src="{{ asset('images/user/' . $freelancer->remember_token . '/avatar/' . $freelancer->pic_url) }}"
                                                        alt="Freelancer Avatar">
                                                    </a>
                                                @endif
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
                                                <span title="Specialized in" data-tippy-theme="dark"
                                                      data-tippy-placement="bottom">{{ $freelancer->speciality }}</span>
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
                                                <li>Rate <strong>{{ $freelancer->hourly_rate }} €/h</strong></li>
                                                <li>Job Success <strong>{{ $freelancer->success_rate }}%</strong></li>
                                            </ul>
                                        </div>
                                        <a href="{{ route('freelancer.show', [$freelancer->id, Str::slug($freelancer->fullName)]) }}"
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

        <!-- Recent Tasks -->
        <div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Section Headline -->
                        <div class="section-headline margin-top-0 margin-bottom-35">
                            <h3>Recent Tasks</h3>
                            <a href="{{ route('task.index') }}" class="headline-link">Browse All Tasks</a>
                        </div>
                        <!-- Jobs Container -->
                        <div class="tasks-list-container compact-list margin-top-35">
                            <!-- Task -->
                            @foreach($tasks as $task)
                                <a href="{{ route('task.show', [$task->company_id, $task->id, Str::slug($task->name)]) }}"
                                   class="task-listing">
                                    <!-- Job Listing Details -->
                                    <div class="task-listing-details">
                                        <!-- Details -->
                                        <div class="task-listing-description">
                                            <h3 class="task-listing-title">{{ ucfirst($task->name) }}</h3>
                                            <ul class="task-icons">
                                                <li title="Employer located in" data-tippy-placement="left" data-tippy-theme="dark"><i
                                                        class="icon-material-outline-location-on"></i> {{ $task->country }}</li>
                                                <li data-tippy-placement="right" title="Uploaded" data-tippy-theme="dark">
                                                    <i class="icon-material-outline-access-time"></i>
                                                    @if($task->task_created_at > 1)
                                                        {{ $task->task_created_at }} days ago
                                                    @endif

                                                    @if($task->task_created_at === 1)
                                                        {{ $task->task_created_at }} day ago
                                                    @endif

                                                    @if($task->task_created_at < 1)
                                                        Today
                                                    @endif
                                                </li>
                                            </ul>
                                            <div class="task-tags margin-top-15" title="Desired skills" data-tippy-placement="left"
                                                 data-tippy-theme="dark">
                                                @foreach($task->skills as $skill)
                                                    <span>{{ $skill }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="task-listing-bid">
                                        <div class="task-listing-bid-inner">
                                            <div class="task-offers">
                                                <strong title="Allocated Budget" data-tippy-placement="top"
                                                        data-tippy-theme="black">{{ 'Up to ' . $task->budget_max . ' €' }}</strong>
                                                <span>{{ $task->type }} Price</span>
                                            </div>
                                            <span class="button button-sliding-icon ripple-effect">Bid Now <i
                                                    class="icon-material-outline-arrow-right-alt"></i></span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <!-- Jobs Container / End -->
                    </div>
                </div>
            </div>
        </div>
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
                                                                class="button full-width margin-top-50" value="{{ $loop->iteration }}">
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
        <!-- Membership Plans / End-->
    </div>
    <!-- Wrapper / End -->
@endsection
