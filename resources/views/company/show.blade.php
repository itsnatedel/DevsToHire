@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Titlebar -->
        <div class="single-page-header" data-background-image="{{ asset('images/home-background.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-page-header-inner">
                            <div class="left-side">
                                <div class="header-image">
                                    <img src="{{ asset('images/companies/' . $company->pic_url) }}" alt="Company Pic">
                                </div>
                                <div class="header-details">
                                    <h3>{{ $company->name }}<span>{{ ucFirst($company->speciality) }}</span></h3>
                                    <ul>
                                        <li>
                                            <div class="star-rating" data-rating="{{ $company->rating }}"></div>
                                        </li>
                                        <li><img class="flag"
                                                 src="{{ asset('images/flags/' . strtolower($company->country_code) . '.svg') }}"
                                                 alt="Flag">{{ $company->country_name }}</li>

                                        @if($company->verified)
                                            <li>
                                                <div class="verified-badge-with-title">Verified</div>
                                            </li>
                                        @endif
                                    </ul>
                                    @include('layouts.sidebar.socialIcons')
                                </div>
                            </div>
                            <div class="right-side">
                                <!-- Breadcrumbs -->
                                <nav id="breadcrumbs" class="white">
                                    <ul>
                                        <li><a href="{{ route('homepage') }}">Home</a></li>
                                        <li><a href="{{ route('company.index') }}">Browse Companies</a></li>
                                        <li>{{ $company->name }}</li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Content -->
                <div class="col-xl-8 col-lg-8 content-right-offset">

                    <div class="single-page-section">
                        <h3 class="margin-bottom-25">About Company</h3>
                        <p>{{ $company->description }}</p>
                    </div>

                    <!-- Boxed List -->
                    <div class="boxed-list margin-bottom-30">
                        <div class="boxed-list-headline">
                            <h3><i class="icon-material-outline-business-center"></i> Open Positions</h3>
                        </div>
                        <div class="listings-container compact-list-layout">
                        @if(count($openedPositions) > 0)
                            @foreach($openedPositions as $position)
                                <!-- Job Listing -->
                                    <a href="{{ route('job.show', [$position->id, $position->slug]) }}"
                                       class="job-listing">
                                        <!-- Job Listing Details -->
                                        <div class="job-listing-details">
                                            <!-- Details -->
                                            <div class="job-listing-description">
                                                <h3 class="job-listing-title">{{ $position->title }}</h3>
                                                <!-- Job Listing Footer -->
                                                <div class="job-listing-footer">
                                                    <ul>
                                                        <li data-tippy-placement="bottom" title="Job Location">
                                                            <i class="icon-material-outline-location-on"></i>
                                                            {{ $position->country_name }}
                                                        </li>
                                                        <li data-tippy-placement="bottom" title="Job Type">
                                                            <i class="icon-material-outline-business-center"></i>
                                                            {{ $position->type }}
                                                        </li>
                                                        <li data-tippy-placement="bottom" title="Posted">
                                                            <i class="icon-material-outline-access-time"></i>
                                                            {{ $position->date_posted }} days ago
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <p style="margin-top: 10px; padding: 10px">This employer currently doesn't have any
                                    opened position available.</p>
                            @endif
                        </div>
                    </div>
                    <!-- Boxed List / End -->
                    <!-- Boxed List -->
                    <div class="boxed-list margin-bottom-60">
                        <div class="boxed-list-headline">
                            <h3><i class="icon-material-outline-business-center"></i> Open Tasks</h3>
                        </div>
                        <div class="listings-container compact-list-layout">
                        @forelse($tasks as $task)
                            <!-- Job Listing -->
                                <a href="{{ route('task.show', [$task->id, Str::slug($task->name)]) }}"
                                   class="job-listing">
                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">
                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">{{ ucFirst($task->name) }}</h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li data-tippy-placement="bottom" title="Budget Allocated">
                                                        <i class="icon-line-awesome-money"></i>
                                                        {{ $task->budget_min . ' € - ' . $task->budget_max . ' €' }}
                                                    </li>
                                                    <li data-tippy-placement="bottom" title="Remuneration Type">
                                                        <i class="icon-material-outline-business-center"></i>
                                                        {{ $task->type }}
                                                    </li>
                                                    <li data-tippy-placement="bottom" title="Field">
                                                        <i class="icon-line-awesome-certificate"></i>
                                                        {{ $task->category_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p style="margin-top: 10px; padding: 10px">This employer currently doesn't have any
                                    opened task available.</p>
                            @endforelse
                        </div>
                    </div>
                    <!-- Boxed List / End -->
                </div>
                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-container">
                        <!-- Sidebar Widget -->
                        <div class="sidebar-widget">
                            <!-- Bookmark Button -->
                            <button class="bookmark-button margin-bottom-15">
                                <span class="bookmark-icon"></span>
                                <span class="bookmark-text">Bookmark this company</span>
                                <span class="bookmarked-text">Bookmarked</span>
                            </button>

                            <div class="boxed-list margin-top-10">

                                <div class="notify-box margin-top-15">
                                    <i class="icon-material-outline-thumb-up"></i> Reviews
                                    <div class="sort-by">
                                        <span>Sort by:</span>
                                        <form
                                            action="{{ route('company.ratings.search', [$company->id, Str::slug($company->name)]) }}"
                                            method="post">
                                            @csrf
                                            <select class="selectpicker hide-tick" name="sortBy" onchange="this.form.submit()">
                                                <optgroup label="Date">
                                                    <option value="newest">Newest</option>
                                                    <option value="oldest">Oldest</option>
                                                </optgroup>
                                                <optgroup label="Rating">
                                                    <option value="high-to-low">High to low</option>
                                                    <option value="low-to-high">Low to high</option>
                                                </optgroup>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                                <ul class="boxed-list-ul">
                                    @forelse($ratings as $rating)
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <!-- TODO: Sort by latest... -->
                                                <div class="item-content">
                                                    <h4>{{ Str::limit($rating->comment, 70) }}
                                                        <span>{{ $rating->full_name }}</span></h4>
                                                    <div class="item-details margin-top-10">
                                                        <div class="star-rating"
                                                             data-rating="{{ $rating->note . '.0'}}"></div>
                                                        <div class="detail-item"><i
                                                                class="icon-material-outline-date-range"></i>
                                                            {{ $rating->rating_when }} days ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <p>This employer hasn't been rated yet.</p>
                                    @endforelse
                                </ul>
                                <div class="centered-button margin-top-35">
                                    <a href="#small-dialog" class="popup-with-zoom-anim button button-sliding-icon">Leave
                                        a
                                        Review <i class="icon-material-outline-arrow-right-alt"></i></a>
                                </div>
                            </div>
                            <!-- Boxed List / End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Spacer -->
        <div class="margin-top-15"></div>
        <!-- Spacer / End-->
    </div>
    <!-- Wrapper / End -->
    @include('layouts.popups.reviewToCompany')
    <script>
        // Snackbar for copy to clipboard button
        $('.copy-url-button').click(function () {
            Snackbar.show({
                text: 'Copied to clipboard!',
            });
        });
    </script>

    <!-- Google API & Maps -->
    <!-- Geting an API Key: https://developers.google.com/maps/documentation/javascript/get-api-key -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_MAPS_KEY') }}&libraries=places"></script>
    <script src="{{ asset('js/infobox.min.js') }}"></script>
    <script src="{{ asset('js/markerclusterer.js') }}"></script>
    <script src="{{ asset('js/maps.js') }}"></script>
@endsection
