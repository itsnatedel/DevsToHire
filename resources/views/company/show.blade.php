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
                                <div class="header-image"><img
                                        src="{{ asset('images/companies/' . $company->pic_url) }}" alt="Company Pic">
                                </div>
                                <div class="header-details">
                                    <h3>{{ $company->name }}<span>{{ ucFirst($company->speciality) }}</span></h3>
                                    <ul>
                                        <li>
                                            <div class="star-rating" data-rating="4.9"></div>
                                        </li>
                                        <li><img class="flag" src="images/flags/de.svg" alt=""> Germany</li>

                                        @if($company->verified)
                                            <li>
                                                <div class="verified-badge-with-title">Verified</div>
                                            </li>
                                        @endif
                                    </ul>
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
                    <div class="boxed-list margin-bottom-60">
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
                                                        <li>
                                                            <i class="icon-material-outline-location-on"></i>
                                                            {{ $position->country_name }}
                                                        </li>
                                                        <li>
                                                            <i class="icon-material-outline-business-center"></i>
                                                            {{ $position->type }}
                                                        </li>
                                                        <li>
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
                                <p style="margin-top: 10px; padding: 10px">This employer currently doesn't have any opened position available.</p>
                            @endif
                        </div>


                    </div>
                    <!-- Boxed List / End -->
                    <!-- Boxed List -->
                    <div class="boxed-list margin-bottom-60">
                        <div class="boxed-list-headline">
                            <h3><i class="icon-material-outline-thumb-up"></i> Reviews</h3>
                        </div>
                        <ul class="boxed-list-ul">
                            <li>
                                <div class="boxed-list-item">
                                    <!-- Content -->
                                    <!-- TODO: Sort by latest... -->
                                    <div class="item-content">
                                        <h4>Doing things the right way <span>Anonymous Employee</span></h4>
                                        <div class="item-details margin-top-10">
                                            <div class="star-rating" data-rating="5.0"></div>
                                            <div class="detail-item"><i class="icon-material-outline-date-range"></i>
                                                August 2019
                                            </div>
                                        </div>
                                        <div class="item-description">
                                            <p>Great company and especially ideal for the career-minded individual. The
                                                company is large enough to offer a variety of jobs in all kinds of
                                                interesting locations. Even if you never change roles, your job changes
                                                and evolves as the company grows, keeping things fresh.</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="centered-button margin-top-35">
                            <a href="#small-dialog" class="popup-with-zoom-anim button button-sliding-icon">Leave a
                                Review <i class="icon-material-outline-arrow-right-alt"></i></a>
                        </div>
                    </div>
                    <!-- Boxed List / End -->
                </div>
                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-container">
                        <!-- Widget -->
                        <div class="sidebar-widget">
                            <h3>Social Profiles</h3>
                            @include('layouts.sidebar.socialIcons')
                        </div>

                        <!-- Sidebar Widget -->
                        <div class="sidebar-widget">
                            <h3>Bookmark or Share</h3>

                            <!-- Bookmark Button -->
                            <button class="bookmark-button margin-bottom-25">
                                <span class="bookmark-icon"></span>
                                <span class="bookmark-text">Bookmark</span>
                                <span class="bookmarked-text">Bookmarked</span>
                            </button>

                            <!-- Copy URL -->
                            <div class="copy-url">
                                <input id="copy-url" type="text" value="" class="with-border">
                                <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url"
                                        title="Copy to Clipboard" data-tippy-placement="top"><i
                                        class="icon-material-outline-file-copy"></i></button>
                            </div>
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
        // Snackbar for "place a bid" button
        $('#snackbar-place-bid').click(function () {
            Snackbar.show({
                text: 'Your bid has been placed!',
            });
        });

        // Snackbar for copy to clipboard button
        $('.copy-url-button').click(function () {
            Snackbar.show({
                text: 'Copied to clipboard!',
            });
        });
    </script>
@endsection
