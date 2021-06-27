@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Titlebar -->
        <div class="single-page-header" data-background-image="{{ asset('images/blog/blog-04.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-page-header-inner">
                            <div class="left-side">
                                <div class="header-image">
                                    <a href="{{ route('company.show', [$task->employer_id, $task->company_slug]) }}">
                                        <img src="{{ asset('images/companies/' . $task->pic_url) }}" alt="Employer Pic">
                                    </a>
                                </div>
                                <div class="header-details">
                                    <h3>{{ ucFirst($task->name) }}</h3>
                                    <h5>About the Employer</h5>
                                    <ul>
                                        <li>
                                            <a href="{{ route('company.show', [$task->employer_id, $task->company_slug]) }}"><i
                                                    class="icon-material-outline-business"></i>
                                            {{ $task->company_name }}</a></li>
                                        <li>
                                            <div class="star-rating" data-rating="{{ $company_rating }}"></div>
                                        </li>
                                        <li>
                                            <img class="flag"
                                                 src="{{ asset('images/flags/' . strtolower($location->country_code) . '.svg') }}"
                                                 alt="Flag">
                                            {{ $location->country_name }}
                                        </li>

                                        @if($task->verified)
                                            <li>
                                                <div class="verified-badge-with-title">Verified</div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="right-side">
                                <div class="salary-box">
                                    <div class="salary-type">Project Budget</div>
                                    <div
                                        class="salary-amount">{{ $task->budget_min . ' € - ' . $task->budget_max . ' €' }}</div>
                                </div>
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

                    <!-- Description -->
                    <div class="single-page-section">
                        <h3 class="margin-bottom-25">Project Description</h3>
                        <p>{{ $task->description }}</p>
                    </div>

                    <!-- TODO: Task Atachments -->
                    <div class="single-page-section">
                        <h3>Attachments</h3>
                        <div class="attachments-container">
                            <a href="#" class="attachment-box ripple-effect"><span>Project Brief</span><i>PDF</i></a>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="single-page-section">
                        <h3>Skills Required</h3>
                        <div class="task-tags">
                            @forelse($skills as $skill)
                                <span>{{ $skill }}</span>
                            @empty
                                <p>No skill required to apply !</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <!-- TODO: Freelancers Bidding -->
                    <div class="boxed-list margin-bottom-60">
                        <div class="boxed-list-headline">
                            <h3><i class="icon-material-outline-group"></i> Freelancers Bidding</h3>
                        </div>
                        <ul class="boxed-list-ul">
                            <li>
                                <div class="bid">
                                    <!-- Avatar -->
                                    <div class="bids-avatar">
                                        <div class="freelancer-avatar">
                                            <div class="verified-badge"></div>
                                            <a href="single-freelancer-profile.html"><img
                                                    src="images/user-avatar-big-01.jpg" alt=""></a>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="bids-content">
                                        <!-- Name -->
                                        <div class="freelancer-name">
                                            <h4><a href="single-freelancer-profile.html">Tom Smith <img class="flag"
                                                                                                        src="images/flags/gb.svg"
                                                                                                        alt=""
                                                                                                        title="United Kingdom"
                                                                                                        data-tippy-placement="top"></a>
                                            </h4>
                                            <div class="star-rating" data-rating="4.9"></div>
                                        </div>
                                    </div>

                                    <!-- Bid -->
                                    <div class="bids-bid">
                                        <div class="bid-rate">
                                            <div class="rate">$4,400</div>
                                            <span>in 7 days</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-container">

                        @if($task->end_date > 1)
                        <div class="countdown green margin-bottom-35">{{ $task->end_date }} days left</div>
                            <div class="sidebar-widget">
                                <div class="bidding-widget">
                                    <div class="bidding-headline"><h3>Bid on this job!</h3></div>
                                    <div class="bidding-inner">

                                        <!-- Headline -->
                                        <span class="bidding-detail">Set your <strong>minimal rate</strong></span>

                                        <!-- Price Slider -->
                                        <div class="bidding-value">€<span id="biddingVal"></span></div>
                                        <input class="bidding-slider" type="text" value="" data-slider-handle="custom"
                                               data-slider-currency="€" data-slider-min="{{ $task->budget_min }}" data-slider-max="{{ $task->budget_max + 1000 }}"
                                               data-slider-value="auto" data-slider-step="50" data-slider-tooltip="hide"/>

                                        <!-- Headline -->
                                        <span
                                            class="bidding-detail margin-top-30">Set your <strong>delivery time</strong></span>

                                        <!-- Fields -->
                                        <div class="bidding-fields">
                                            <div class="bidding-field">
                                                <!-- Quantity Buttons -->
                                                <div class="qtyButtons">
                                                    <div class="qtyDec"></div>
                                                    <input type="text" name="qtyInput" value="1">
                                                    <div class="qtyInc"></div>
                                                </div>
                                            </div>
                                            <div class="bidding-field">
                                                <select class="selectpicker default">
                                                    <option selected>Days</option>
                                                    <option>Hours</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Button -->
                                        <button id="snackbar-place-bid"
                                                class="button ripple-effect move-on-hover full-width margin-top-30"><span>Place a Bid</span>
                                        </button>

                                    </div>
                                    <div class="bidding-signup">Don't have an account? <a href="#sign-in-dialog"
                                                                                          class="register-tab sign-in popup-with-zoom-anim">Sign
                                            Up</a></div>
                                </div>
                            </div>
                        @else
                            <div class="countdown red margin-bottom-35">This project has reached its due date.</div>
                        @endif


                        <!-- Sidebar Widget -->
                        <div class="sidebar-widget">
                            <h3>Bookmark or Share</h3>

                            <!-- Bookmark Button -->
                            <button class="bookmark-button margin-bottom-25">
                                <span class="bookmark-icon"></span>
                                <span class="bookmark-text">Bookmark</span>
                                <span class="bookmarked-text">Bookmarked</span>
                            </button>
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
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
    <script>

        // Snackbar for "place a bid" button
        $('#snackbar-place-bid').click(function () {
            Snackbar.show({
                text: 'Your bid has been placed!',
            });
        });

    </script>
@endsection
