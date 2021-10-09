@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Dashboard Container -->
        <div class="dashboard-container">
        @include('layouts.dashboard.sidebar')
        <!-- Dashboard Content -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">

                    <!-- Dashboard Headline -->
                    <div class="dashboard-headline">
                        <h3>My Active Bids</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>My Active Bids</li>
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
                                    <h3><i class="icon-material-outline-gavel"></i> Bids List</h3>

                                </div>
                                <div class="content">
                                    @if(Session::has('success'))
                                        <div class="notification success closeable">
                                            <p>{{ Session::get('success') }}</p>
                                            <a class="close"></a>
                                        </div>
                                    @endif
                                    @if(Session::has('fail'))
                                        <div class="notification error closeable">
                                            <p>{{ Session::get('fail') }}</p>
                                            <a class="close"></a>
                                        </div>
                                    @endif
                                    <ul class="dashboard-box-list">
                                        @forelse($bids as $bid)
                                            <li>
                                                <!-- Job Listing -->
                                                <div class="job-listing width-adjustment">

                                                    <!-- Job Listing Details -->
                                                    <div class="job-listing-details">

                                                        <!-- Details -->
                                                        <div class="job-listing-description">
                                                            <h3 class="job-listing-title">
                                                                <a href="{{ route('task.show', [$bid->task_id, $bid->slug]) }}">
                                                                    {{ ucfirst($bid->name) }}
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Task Details -->
                                                <ul class="dashboard-task-info">
                                                    <li><strong>{{ $bid->minimal_rate }}€</strong><span>{{ $bid->type }} payment</span></li>
                                                    <li><strong>{{ $bid->delivery_time . ' ' . $bid->time_period }}</strong><span>Delivery Time</span></li>
                                                </ul>

                                                <!-- Buttons -->
                                                <div class="buttons-to-right always-visible">
                                                    <div style="display: inline-block">
                                                    <a href="#small-dialog" id="{{ $bid->id }}" class="popup-with-zoom-anim button dark ripple-effect ico"
                                                       title="Edit Bid" data-tippy-placement="bottom"
                                                       data-id="{{ $bid->id }}"
                                                       data-min-price="{{ $bid->budget_min }}"
                                                       data-max-price="{{ $bid->budget_max }}"
                                                       data-amount-days="{{ $bid->delivery_time }}"
                                                       data-time-period="{{ $bid->time_period }}"
                                                       data-rate="{{ $bid->minimal_rate }}"
                                                       onclick="changeValue(this)">
                                                        <i class="icon-feather-edit"></i>
                                                    </a>
                                                    </div>
                                                    <div style="display: inline-block; transform: translateY(-12px)">
                                                        <form action="{{ route('dashboard.bid.delete', [$bid->id]) }}" method="post">
                                                            @csrf
                                                            <button class="button red ripple-effect ico" title="Cancel Bid"
                                                                    data-tippy-placement="bottom"><i class="icon-feather-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <p style="padding: 30px">You currently have no active bid !</p>
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
    @include('layouts.popups.bidEdit')
    <script>
        function changeValue(element) {
            let bidId = element.getAttribute('data-id');
            let minPrice = element.getAttribute('data-min-price');
            let maxPrice = element.getAttribute('data-max-price');
            let amountDays = element.getAttribute('data-amount-days');
            let rate = element.getAttribute('data-rate');

            let id = document.getElementById('bidId');
            id.setAttribute('value', bidId)

            let price = document.getElementById('price');
            price.setAttribute('min', minPrice);
            price.setAttribute('max', maxPrice);
            price.setAttribute('placeholder', 'Desired rate (max ' + maxPrice + '€)');

            let biddingVal = document.getElementById('biddingVal');
            biddingVal.innerHTML = rate;

            let daysPicker = document.getElementById('amountDays');
            daysPicker.setAttribute('value', amountDays)
        }
    </script>
@endsection