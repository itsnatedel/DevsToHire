@extends('layouts.app')
@section('content')
    <!-- Wrapper -->

    <div id="wrapper">
        <!-- Titlebar -->
        <div class="single-page-header" data-background-image="{{ asset('images/task/single-task.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-page-header-inner">
                            <div class="left-side">
                                <div class="header-image">
                                    @if(!is_null($task->employer_id))
                                        <a href="{{ route('company.show', [$task->employer_id, $task->company_slug]) }}">
                                            <img src="{{ asset('images/companies/' . $task->pic_url) }}"
                                                 alt="Employer Pic">
                                        </a>
                                    @else
                                        <a href="{{ route('freelancer.show', [$task->freelancer_id, $task->company_slug]) }}">
                                            <img src="{{ asset('images/user/' . $task->dir_url . '/avatar/' . $task->pic_url) }}"
                                                 alt="Employer Pic">
                                        </a>
                                    @endif
                                </div>
                                <div class="header-details">
                                    <h3>{{ ucFirst($task->name) }}</h3>
                                    <h5>About the Employer</h5>
                                    <ul>
                                        <li>
                                            @if(!is_null($task->employer_id))
                                                <a href="{{ route('company.show', [$task->employer_id, $task->company_slug]) }}"><i
                                                            class="icon-material-outline-business"></i>
                                                    {{ $task->company_name }}</a>
                                            @else
                                                <a href="{{ route('freelancer.show', [$task->freelancer_id, $task->company_slug]) }}"><i
                                                            class="icon-material-outline-business"></i>
                                                    {{ $task->company_name }}</a>
                                            @endif
                                        </li>
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
                                            class="salary-amount">{{ 'Up to ' . $task->budget_max . ' €' }}</div>
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

                    <!-- TODO: Task Attachments -->
                    <div class="single-page-section">
                        <h3>Attachments</h3>
                        <div class="attachments-container">

                            @if(!is_null($task->dir_url) && !is_null($task->file_url))
                                <a href="{{ route('task.brief.download', [
                                    $task->id, $task->file_url
                                ]) }}" class="attachment-box ripple-effect">
                                    <span>Project Brief</span>
                                    <i>PDF</i>
                                </a>
                            @else
                                <div class="attachment-box ripple-effect">
                                    <span>Project Brief - None uploaded</span>
                                </div>
                            @endif
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
                            @forelse($bids as $bid)
                            <li>
                                <div class="bid">
                                    <!-- Avatar -->
                                    <div class="bids-avatar">
                                        <div class="freelancer-avatar">
                                            <div class="verified-badge"></div>
                                            <a href="{{ route('freelancer.show', [$bid->bidder_id, Str::slug($bid->firstname . ' ' . $bid->lastname)]) }}">
                                                <img src="{{ asset('images/user/' . $bid->dir_url . '/avatar/' . $bid->pic_url) }}" alt="User avatar">
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="bids-content">
                                        <!-- Name -->
                                        <div class="freelancer-name">
                                            <h4>
                                                <a href="{{ route('freelancer.show', [$bid->bidder_id, Str::slug($bid->firstname . ' ' . $bid->lastname)]) }}">
                                                    {{ ucfirst($bid->firstname) . ' ' . ucfirst($bid->lastname) }}
                                                    <img class="flag"
                                                        src="{{ asset('images/flags/' . strtolower($bid->country_code) . '.svg') }}"
                                                        alt="Bidder's localization"
                                                        title="{{ $bid->country_name }}"
                                                        data-tippy-placement="top"
                                                    >
                                                </a>
                                            </h4>
                                            @if(!is_null($bid->rating))
                                                <div class="star-rating" data-rating="{{ round($bid->rating) }}"></div>
                                            @else
                                                <div><p>Not rated yet</p></div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bid -->
                                    <div class="bids-bid">
                                        <div class="bid-rate">
                                            <div class="rate">{{ $bid->minimal_rate }} €</div>
                                            <span>in {{ $bid->delivery_time . ' ' . $bid->time_period }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                                <p class="margin-top-15">No one has put a bid on this task so far, be the first !</p>
                            @endforelse
                        </ul>
                    </div>

                </div>
                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-container">
                        @if($task->end_date > 1)
                            <div class="countdown green margin-bottom-35">{{ $task->end_date }} days left</div>
                            @if(Session::has('fail'))
                                <div class="notification error closeable">
                                    <p>{{ Session::get('fail') }}</p>
                                    <a class="close"></a>
                                </div>
                            @endif
                            <div class="sidebar-widget">
                                <div class="bidding-widget">
                                    <div class="bidding-headline"><h3>Bid on this job!</h3></div>
                                    @if(Session::has('success'))
                                        <div class="notification success closeable">
                                            <p>{{ Session::get('success') }}</p>
                                            <a class="close"></a>
                                        </div>
                                    @endif
                                    <div class="bidding-inner">
                                        <form action="{{ route('bid.place', [$task->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="bidderId" value="{{ Auth::user()->freelancer_id ?? null }}">
                                            <input type="hidden" name="bidderRole" value="{{ Auth::user()->role_id ?? null }}">
                                            <input type="hidden" name="budgetMax" value="{{ $task->budget_max }}">
                                            <!-- Headline -->
                                            <span class="bidding-detail">Set your <strong>minimal rate</strong></span>

                                            <!-- Price Slider -->
                                            <div class="bidding-value">€<span id="biddingVal"></span></div>
                                            <input class="bidding-slider" type="text" name="rate" value=""
                                                   data-slider-handle="custom"
                                                   data-slider-currency="€" data-slider-min="{{ $task->budget_min }}"
                                                   data-slider-max="{{ $task->budget_max }}"
                                                   data-slider-value="auto" data-slider-step="1"
                                                   data-slider-tooltip="hide"/>

                                            <!-- Headline -->
                                            <span class="bidding-detail margin-top-30">
                                                Set your <strong>delivery time</strong>
                                            </span>

                                            <!-- Fields -->
                                            <div class="bidding-fields">
                                                <div class="bidding-field">
                                                    <!-- Quantity Buttons -->
                                                    <div class="qtyButtons">
                                                        <div class="qtyDec"></div>
                                                        <input type="text" name="timespan" value="1">
                                                        <div class="qtyInc"></div>
                                                    </div>
                                                </div>
                                                <div class="bidding-field">
                                                    <select class="selectpicker default" name="duration">
                                                        <option value="days" selected>Days</option>
                                                        <option value="hours">Hours</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @if($errors->any())
                                                @foreach ($errors->all() as $error)
                                                    <div>
                                                        <p>{{ $error }}</p>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <!-- Button -->
                                            <button type="submit" id="snackbar-place-bid"
                                                    class="button ripple-effect move-on-hover full-width margin-top-30">
                                                <span>Place a Bid</span>
                                            </button>
                                        </form>
                                    </div>
                                    @guest
                                        <div class="bidding-signup">Don't have an account?
                                            <a href="{{ route('register') }}" class="sign-in">Sign Up</a>
                                        </div>
                                    @endguest
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

@endsection