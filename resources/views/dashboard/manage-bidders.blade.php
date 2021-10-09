@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Dashboard Container -->
        <div class="dashboard-container">
            @include('layouts.dashboard.sidebar')
            <!-- Dashboard Content
            ================================================== -->
                <div class="dashboard-content-container" data-simplebar>
                    <div class="dashboard-content-inner" >

                        <!-- Dashboard Headline -->
                        <div class="dashboard-headline">
                            <h3>Manage Bidders</h3>
                            <span class="margin-top-7">Bids for <a href="{{ route('task.show', [$task->id, $task->slug]) }}">{{ $task->name }}</a></span>

                            <!-- Breadcrumbs -->
                            <nav id="breadcrumbs" class="dark">
                                <ul>
                                    <li><a href="{{ route('homepage') }}">Home</a></li>
                                    <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                    <li>Manage Bidders</li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Row -->
                        <div class="row">

                            <!-- Dashboard Box -->
                            <div class="col-xl-12">
                                <div class="dashboard-box margin-top-0">

                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="icon-material-outline-supervisor-account"></i> {{ $countBidders }} Bidders</h3>
                                        <div class="sort-by">
                                            <form action="{{ route('dashboard.bidders.manage', [$task->id, $task->slug]) }}" method="get">
                                                <select name="sortBy" class="selectpicker hide-tick" onchange="this.form.submit()">
                                                    <option disabled @if(is_null(app('request')->sortBy)) selected @endif>Sort Bidders By</option>
                                                    <option value="priceHiLo" @if(!is_null(app('request')->sortBy) && app('request')->sortBy === 'priceHiLo') selected @endif>Price : High to Low</option>
                                                    <option value="priceLoHi" @if(!is_null(app('request')->sortBy) && app('request')->sortBy === 'priceLoHi') selected @endif>Price : Low to High</option>
                                                    <option value="bidderAZ" @if(!is_null(app('request')->sortBy) && app('request')->sortBy === 'bidderAZ') selected @endif>Bidder : A to Z</option>
                                                    <option value="bidderZA" @if(!is_null(app('request')->sortBy) && app('request')->sortBy === 'bidderZA') selected @endif>Bidder : Z to A</option>
                                                    <option value="newest" @if(!is_null(app('request')->sortBy) && app('request')->sortBy === 'newest') selected @endif>Newest Bids</option>
                                                    <option value="oldest" @if(!is_null(app('request')->sortBy) && app('request')->sortBy === 'oldest') selected @endif>Oldest Bids</option>
                                                    <option value="reset" @if(!is_null(app('request')->sortBy) && app('request')->sortBy === 'reset') selected @endif>Reset Order</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="content">
                                        <ul class="dashboard-box-list">
                                            @forelse($bidders as $bidder)
                                            <li>
                                                <!-- Overview -->
                                                <div class="freelancer-overview manage-candidates">
                                                    <div class="freelancer-overview-inner">
                                                        <!-- Avatar -->
                                                        <div class="freelancer-avatar">
                                                            @if($bidder->verified)
                                                                <div class="verified-badge"></div>
                                                            @endif
                                                            @if(!is_null($bidder->dir_url))
                                                                <a href="{{ route('freelancer.show', [$bidder->bidder_id, Str::slug($bidder->firstname . ' ' . $bidder->lastname)]) }}">
                                                                    <img src="{{ asset('images/user/' . $bidder->dir_url . '/avatar/' . $bidder->pic_url) }}" alt="Bidder picture">
                                                                </a>
                                                            @else
                                                                <a href="{{ route('freelancer.show', [$bidder->bidder_id, Str::slug($bidder->firstname . ' ' . $bidder->lastname)]) }}">
                                                                    <img src="{{ asset('images/user/' . $bidder->pic_url) }}" alt="Bidder picture">
                                                                </a>
                                                            @endif
                                                        </div>

                                                        <!-- Name -->
                                                        <div class="freelancer-name">
                                                            <h4>
                                                                <a href="{{ route('freelancer.show', [$bidder->bidder_id, Str::slug($bidder->firstname . ' ' . $bidder->lastname)]) }}">
                                                                    {{ ucfirst($bidder->firstname) . ' ' . ucfirst($bidder->lastname) }}
                                                                    <img class="flag"
                                                                         src="{{ asset('images/flags/' . strtolower($bidder->country_code) . '.svg') }}"
                                                                         alt="Bidder location" title="{{ $bidder->country_name }}"
                                                                         data-tippy-placement="top">
                                                                </a>
                                                            </h4>

                                                            <!-- Details -->
                                                            <span class="freelancer-detail-item"><a href="mailto:{{ $bidder->email }}">
                                                                    <i class="icon-feather-mail"></i>
                                                                    {{ $bidder->email }}
                                                                </a></span>

                                                            <!-- Rating -->
                                                            <div class="freelancer-rating">
                                                                @if(!is_null($bidder->rating) && round($bidder->rating) > 0)
                                                                    <div class="star-rating" data-rating="{{ round($bidder->rating) }}"></div>
                                                                @else
                                                                    <p><mark>Hasn't been rated yet</mark></p>
                                                                @endif
                                                            </div>

                                                            <!-- Bid Details -->
                                                            <ul class="dashboard-task-info bid-info">
                                                                <li><strong>{{ $bidder->minimal_rate }} €</strong><span>{{ $bidder->type }} Price</span></li>
                                                                <li><strong>{{ $bidder->delivery_time . ' ' . $bidder->time_period }}</strong><span>Delivery Time</span></li>
                                                            </ul>

                                                            <!-- Buttons -->
                                                            <div class="buttons-to-right always-visible margin-top-25 margin-bottom-0">
                                                                <!-- Payment intent -->
                                                                <a href="#small-dialog-1"  class="popup-with-zoom-anim button ripple-effect"><i class="icon-material-outline-check"></i> Accept Offer</a>
                                                                <a href="#small-dialog-2" class="popup-with-zoom-anim button dark ripple-effect"><i class="icon-feather-mail"></i> Send Message</a>
                                                                <a href="#" class="button gray ripple-effect ico" title="Remove Bid" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @empty
                                                <p style="padding: 30px">No bids found for this task !</p>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row / End -->
                        @include('layouts.dashboard.footer')
                    </div>
                </div>
            <!-- Dashboard Content / End -->
        </div>
        <!-- Dashboard Container / End -->
    </div>
    <!-- Wrapper / End -->
    @include('layouts.popups.bidAccept')

    @include('layouts.popups.sendDM')
@endsection