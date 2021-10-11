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
                <div class="dashboard-content-inner">

                    <!-- Dashboard Headline -->
                    <div class="dashboard-headline">
                        <h3>Manage Tasks</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>Manage Tasks</li>
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
                                    <h3><i class="icon-material-outline-assignment"></i> My Tasks</h3>
                                </div>

                                <div class="content">
                                    @if(Session::has('success'))
                                        <div class="notification success closeable">
                                            <p>{{ Session::get('success') }}</p>
                                            <a class="close"></a>
                                        </div>
                                    @endif
                                    @if($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div>
                                                <mark>{{ $error }}</mark>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if(Session::has('fail'))
                                        <div>
                                            <p><b><mark>{{ Session::get('fail') }}</mark></b></p>
                                        </div>
                                    @endif
                                    <ul class="dashboard-box-list">
                                        @forelse($tasks as $task)
                                            <li>
                                                <!-- Job Listing -->
                                                <div class="job-listing width-adjustment">

                                                    <!-- Job Listing Details -->
                                                    <div class="job-listing-details">

                                                        <!-- Details -->
                                                        <div class="job-listing-description">
                                                            <h3 class="job-listing-title">
                                                                <a href="{{ route('task.show', [$task->id, $task->slug]) }}">
                                                                    {{ $task->name }}
                                                                </a>
                                                                @if($task->expiring)
                                                                    <span class="dashboard-status-button yellow">Expiring</span>
                                                                @elseif($task->hasExpired)
                                                                    <span class="dashboard-status-button red">Expired</span>
                                                                @endif
                                                            </h3>

                                                            <!-- Job Listing Footer -->
                                                            <div class="job-listing-footer">
                                                                <ul>
                                                                    <li title="Time left before expiring" data-tippy-placement="right"><i class="icon-material-outline-access-time"></i>
                                                                        {{ $task->due_date }} left
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Task Details -->
                                                <ul class="dashboard-task-info">
                                                    <li><strong>{{ $task->bids->amount_bidders }}</strong><span>Bids</span></li>
                                                    @if(!is_null($task->bids->average_bid))
                                                        <li><strong>{{ $task->bids->average_bid }} €</strong><span>Avg. Bid</span></li>
                                                    @endif
                                                    <li><strong>{{ $task->budget_min . '€ - ' . $task->budget_max . '€' }}</strong><span>{{ $task->type }} Rate</span></li>
                                                </ul>

                                                <!-- Buttons -->
                                                <div class="buttons-to-right always-visible">

                                                    @if(!is_null($task->bids->amount_bidders) && $task->bids->amount_bidders > 0)
                                                    <a href="{{ route('dashboard.bidders.manage', [$task->id, $task->slug]) }}" class="button ripple-effect"><i
                                                            class="icon-material-outline-supervisor-account"></i> Manage
                                                        Bidders <span class="button-info">{{ $task->bids->amount_bidders }}</span></a>
                                                    @else
                                                        <a href="#" class="button ripple-effect" style="cursor: not-allowed; pointer-events: none;"><i
                                                                    class="icon-material-outline-supervisor-account"></i> Manage
                                                            Bidders <span class="button-info">{{ $task->bids->amount_bidders }}</span></a>
                                                    @endif
                                                    <div style="display: inline-block; transform: translateY(-12px)">
                                                        <form action="{{ route('dashboard.task.delete', [$task->id]) }}" method="post">
                                                            @csrf
                                                            @if(Auth::user()->role_id === 2)
                                                                <input type="hidden" name="freelancer_id" value="{{ Auth::user()->freelancer_id }}">
                                                            @else
                                                                <input type="hidden" name="employer_id" value="{{ Auth::user()->company_id }}">
                                                            @endif
                                                            <button class="button gray ripple-effect ico" title="Delete Task"
                                                               data-tippy-placement="bottom">
                                                                <i class="icon-feather-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <p style="padding: 30px">You don't have any task opened !</p>
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
@endsection