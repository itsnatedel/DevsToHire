@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Spacer -->
        <div class="margin-top-90"></div>
        <!-- Spacer / End-->

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="sidebar-container">
                        <form action="{{ route('job.search') }}" method="get">
                            <!-- Keywords -->
                            <div class="sidebar-widget" style="margin-top: 5px">
                                <h3>Title Search</h3>
                                <div class="keywords-container">
                                    <div class="keyword-input-container" title="Look for a specific job title"
                                         data-tippy-placement="bottom">
                                        <input type="text" name="title" placeholder="e.g. internet">
                                        <button type="submit" class="keyword-input-button ripple-effect">
                                            <i class="icon-material-outline-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('job.search') }}" method="get">
                            <input type="hidden" name="search" value="refined">
                            <!-- Location -->
                            <div class="sidebar-widget">
                                <h3>Location</h3>
                                <div class="bootstrap-select" style="margin-bottom: 15px">
                                    <select class="form-control selectpicker with-border" id="select-country"
                                            data-live-search="true" title="Search for a country" name="country">
                                        <option disabled>Countries</option>
                                        @foreach($countries as $country)
                                            <option data-tokens="{{ $country->name }}"
                                                    value="{{ $country->id }}">
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Category -->
                            <div class="sidebar-widget">
                                <h3>Category</h3>
                                <select class="form-control selectpicker with-border" data-live-search="true"
                                        name="category"
                                        title="Search a category">
                                    <option disabled>Categories</option>
                                    @foreach($categories as $category)
                                        <option data-tokens="{{ $category->name }}"
                                                value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Job Types -->
                            <div class="sidebar-widget">
                                <h3>Job Type</h3>

                                <div class="switches-list">
                                    <div class="switch-container">
                                        <label class="switch"><input type="checkbox" name="freelance"><span
                                                class="switch-button"></span>
                                            Freelance</label>
                                    </div>

                                    <div class="switch-container">
                                        <label class="switch"><input type="checkbox" name="full time"><span
                                                class="switch-button"></span>
                                            Full Time</label>
                                    </div>

                                    <div class="switch-container">
                                        <label class="switch"><input type="checkbox" name="part time"><span
                                                class="switch-button"></span>
                                            Part Time</label>
                                    </div>

                                    <div class="switch-container">
                                        <label class="switch"><input type="checkbox" name="internship"><span
                                                class="switch-button"></span>
                                            Internship</label>
                                    </div>
                                    <div class="switch-container">
                                        <label class="switch"><input type="checkbox" name="temporary"><span
                                                class="switch-button"></span>
                                            Temporary</label>
                                    </div>
                                </div>

                            </div>

                            <button class="button ripple-effect button-sliding-icon" type="submit" style="float:right;">
                                Search
                                <i class="icon-material-outline-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 content-left-offset">

                    <h3 class="page-title">Search Results</h3>

                    <div class="notify-box margin-top-15">
                        <a href="{{ route('job.index') }}" class="button gray ripple-effect button-sliding-icon" style="margin: -10px 0; padding: 5px; transform: translateY(3px)">
                            Reset Search
                            <i class="icon-material-outline-autorenew"></i>
                        </a>

                        <div class="sort-by">
                            <span>Sort by:</span>
                            <form action="{{ route('job.search') }}" method="get">
                                <select class="selectpicker hide-tick" name="sortBy" onchange="this.form.submit()">
                                    <option selected disabled>Method</option>
                                    <option value="newest">Newest</option>
                                    <option value="oldest">Oldest</option>
                                    <option value="random">Random</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="listings-container margin-top-35">
                    @if(sizeof($jobs) >= 1)
                        @foreach($jobs as $job)
                            <!-- Job Listing -->
                                <a href="{{ route('job.show', $job->id) }}" class="job-listing">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">
                                        <!-- Logo -->
                                        <div class="job-listing-company-logo">
                                            <img src="{{ asset('images/companies/' . $job->pic_url) }}"
                                                 alt="Employer Pic">
                                        </div>

                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h4 class="job-listing-company">
                                                {{ $job->name }}

                                                @if($job->verified)
                                                    <span class="verified-badge"
                                                          title="Verified Employer"
                                                          data-tippy-placement="top">
                                                    </span>
                                                @endif

                                            </h4>
                                            <h3 class="job-listing-title">{{ $job->title }}</h3>
                                            <p class="job-listing-text">
                                                {{ $job->description }}
                                            </p>
                                        </div>

                                        <!-- Bookmark -->
                                        <span class="bookmark-icon"></span>
                                    </div>

                                    <!-- Job Listing Footer -->
                                    <div class="job-listing-footer">
                                        <ul>
                                            <li>
                                                <i class="icon-material-outline-location-on"></i>
                                                {{ $job->country_name }}
                                            </li>
                                            <li>
                                                <i class="icon-material-outline-business-center"></i>
                                                {{ $job->type }}
                                            </li>
                                            <li title="Estimated Salary"
                                                data-tippy-placement="bottom">
                                                <i class="icon-material-outline-account-balance-wallet"></i>
                                                {{ $job->salary_low . '-' . $job->salary_high . '€' }}
                                            </li>
                                            <li>
                                                <i class="icon-material-outline-access-time"></i>
                                                {{ $job->created_at }} days ago
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                        @endforeach
                        <!-- Pagination -->
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Pagination -->
                                    <div class="pagination-container margin-top-30 margin-bottom-60">
                                        <nav class="pagination">
                                            {{ $jobs->links() }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!-- Pagination / End -->
                        @else
                            <div class="notification notice closeable">
                                <p>No match found for the specified search settings, <a href="{{ route('job.index') }}">click
                                        here to reset your filters</a></p>
                                <a class="close"></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="margin-bottom-25"></div>
    <!-- Wrapper / End -->
@endsection
