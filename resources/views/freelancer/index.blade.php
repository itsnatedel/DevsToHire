@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <!-- TODO: Fix pagination number hover being blanks -->
    <div id="wrapper">
        <!-- Page Content -->
        <div class="full-page-container">
            <div class="full-page-sidebar">
                <div class="full-page-sidebar-inner" data-simplebar>
                    <form action="{{ route('freelancer.search') }}" method="get">
                        @csrf
                    <div class="sidebar-container">
                        <!-- Location -->
                        <div class="sidebar-widget">
                            <h3>Location</h3>
                            <div class="bootstrap-select">
                                <select class="form-control selectpicker with-border" id="select-country"
                                        data-live-search="true" title="Search by country" name="country"
                                        aria-expanded="false">
                                    <option disabled>Countries</option>
                                    @foreach($countries as $country)
                                        <option data-tokens="{{ $country->country_name }}"
                                                {{ !is_null($form) && $form->country === $country->country_name ? 'selected' : '' }}
                                                value="{{ $country->country_name }}">
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- Category -->
                        <div class="sidebar-widget">
                            <h3>Specialization Field</h3>
                            <select class="form-control selectpicker with-border" data-live-search="true"
                                    name="specialization"
                                    title="Search by specialization">
                                <option disabled>Specializations</option>
                                @foreach($categories as $category)
                                    <option data-tokens="{{ $category->name }}" {{ !is_null($form) && $form->specialization === $category->name ? 'selected' : ''}}
                                            value="{{ $category->name }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Skill -->
                        <div class="sidebar-widget">
                            <h3>Skill</h3>
                            <div class="keywords-container">
                                <div class="keyword-input-container">
                                    <input type="text" class="keyword-input" placeholder="e.g. Wordpress" name="skill" value="{{ $form->skill ?? '' }}"/>
                                    <button class="keyword-input-button ripple-effect">
                                        <i class="icon-material-outline-add"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Hourly Rate -->
                        <div class="sidebar-widget">
                            <h3 style="margin-bottom: 35px">Hourly Rate</h3>
                            <!-- Range Slider -->
                            <input class="range-slider" name="hourlyRates" type="text" value="" data-slider-currency="€"
                                   data-slider-min="{{ $hourlyRateLimits->min_rate }}"
                                   data-slider-max="{{ $hourlyRateLimits->max_rate }}" data-slider-step="5"
                                   data-slider-value="[{{ $form->hourlyRates ?? $hourlyRateLimits->min_rate . ',' . $hourlyRateLimits->max_rate }}]"
                            />
                        </div>

                        <div class="clearfix"></div>
                        <div class="sidebar-widget">
                            <h3>Rating</h3>

                            <!-- Range Slider -->
                            <div class="slider slider-horizontal" title="Rating of at least " data-tippy-placement="bottom">
                                <input class="range-slider-single" name="rated" type="text" data-slider-min="0"
                                       data-slider-max="5" data-slider-step="0.5"
                                       data-slider-value="{{ $form->rated ?? 3 }}" data-value="0" value="">
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Container / End -->
                    <!-- Search Button / End-->
                    <div class="sidebar-search-button-container">
                        <button class="col-xl-8 button ripple-effect button-sliding-icon" type="submit" style="float: right">Search
                            <i class="icon-material-outline-search"></i>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- Full Page Sidebar / End -->

            <!-- Full Page Content -->
            <div class="full-page-content-container" data-simplebar>
                <div class="full-page-content-inner">

                    <h3 class="page-title">Search Results - {{ $freelancers->total() }} profiles found.</h3>
                    @if(count($freelancers) > 0)
                    <div class="notify-box margin-top-15">
                        <!-- TODO: Hide Reset search if route !== search -> to other reset searches el. too -->
                        @if(!is_null($form) || !is_null($sortOption))
                        <a href="{{ route('freelancer.index') }}" class="button gray ripple-effect button-sliding-icon"
                           style="margin: -10px 0; padding: 5px; transform: translateY(3px)">
                            Reset Search Filters
                            <i class="icon-material-outline-autorenew"></i>
                        </a>
                        @endif
                        <div class="sort-by">
                            <span>Sort by:</span>
                            <form action="{{ route('freelancer.search') }}" method="get">
                                @csrf
                                <select class="selectpicker hide-tick" name="sortOption" onchange="this.form.submit()">
                                    <option @if(is_null($sortOption)) selected @endif disabled>Method</option>
                                    <option value="ratingHiLo" @if($sortOption === 'ratingHiLo') selected @endif>Rating - High to Low
                                    </option>
                                    <option value="ratingLoHi" @if($sortOption === 'ratingLoHi') selected @endif>Rating - Low to High
                                    </option>
                                    <option value="hrHiLo" @if($sortOption === 'hrHiLo') selected @endif>Hourly Rate - High to Low</option>
                                    <option value="hrLoHi" @if($sortOption === 'hrLoHi') selected @endif>Hourly Rate - Low to High</option>
                                    <option value="random" @if($sortOption === 'random') selected @endif>Randomize</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Freelancers List Container -->
                    <div class="freelancers-container freelancers-grid-layout margin-top-35">
                        <!--Freelancer -->
                        @forelse($freelancers as $freelancer)
                            <div class="freelancer">
                                <!-- Overview -->
                                <div class="freelancer-overview">
                                    <div class="freelancer-overview-inner">
                                        <!-- Bookmark Icon -->
                                        @Auth <span class="bookmark-icon"></span> @endauth
                                        <!-- Avatar -->
                                        <div class="freelancer-avatar">
                                            @if($freelancer->verified)
                                                <div class="verified-badge" title="Verified freelancer" data-tippy-placement="right"></div>
                                            @endif
                                            <a href={{ route('freelancer.show', [$freelancer->id, Str::slug($freelancer->full_name)]) }}><img
                                                    src="{{ asset('images/user/' . $freelancer->pic_url) }}" alt="Profile Pic"></a>
                                        </div>
                                        <!-- Name -->
                                        <div class="freelancer-name">
                                            <h4>
                                                <a href={{ route('freelancer.show', [$freelancer->id, Str::slug($freelancer->full_name)]) }}>
                                                    {{ $freelancer->full_name }}
                                                    <img class="flag"
                                                         src="{{ asset('images/flags/' . strtolower($freelancer->country_code) . '.svg') }}"
                                                         alt="Country"
                                                         title="{{ $freelancer->country_name }}"
                                                         data-tippy-placement="right">
                                                </a>
                                            </h4>
                                            <span title="Specialized in"
                                                  data-tippy-placement="left">{{ $freelancer->specialization }}</span>
                                        </div>

                                        <!-- Rating -->
                                        <div class="freelancer-rating">
                                            <div class="star-rating" data-rating="{{ round($freelancer->rating) }}" title="Rating"
                                                 data-tippy-placement="bottom"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="freelancer-details">
                                    <div class="freelancer-details-list col-xl-12 offset-xl-1">
                                        <ul>
                                            <li>Recommended
                                                <strong>
                                                    <i class="icon-material-outline-thumb-up"></i>
                                                    {{ round($freelancer->recommended * 100) }}%
                                                </strong>
                                            </li>
                                            <li>Rate
                                                <strong>
                                                    <i class="icon-line-awesome-money"></i>
                                                    {{ $freelancer->hourly_rate }}€/hr
                                                </strong>
                                            </li>
                                            <li>Job Success
                                                <strong>
                                                    <i class="icon-feather-check-square"></i>
                                                    {{ round($freelancer->success_rate * 100) }}%
                                                </strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('freelancer.show', [$freelancer->id, Str::slug($freelancer->full_name)]) }}"
                                       class="button button-sliding-icon ripple-effect">View Profile <i
                                            class="icon-material-outline-arrow-right-alt"></i></a>
                                </div>
                            </div>
                    @empty

                    @endforelse
                    <!-- Freelancer / End -->
                    </div>
                    <!-- Freelancers Container / End -->

                    <!-- Pagination -->
                    <!-- TODO: Fix pagination design. create CSS class to unify all paginations ? -->
                    <div class="clearfix"></div>
                    <div class="pagination-container margin-top-20 margin-bottom-20">
                        <nav class="pagination">
                            {{ $freelancers->withQueryString()->links() }}
                        </nav>
                    </div>
                    <div class="clearfix"></div>
                    @else
                        <div class="margin-top-20"></div>
                        <div class="notification warning closeable">
                            <p color="blue">No freelancer found by your search criterias. Please broaden your search or <a href="{{ route('freelancer.index') }}">click here to reset the search filters.</a></p>
                        </div>
                    @endif
                    <!-- Pagination / End -->
                    @include('layouts.freelancers.footer')
                </div>
            </div>
            <!-- Full Page Content / End -->
        </div>
    </div>

@endsection