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
                        <h3>Manage Jobs</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>Manage Jobs</li>
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
                                    <h3><i class="icon-material-outline-business-center"></i> My Job Listings</h3>
                                </div>

                                <div class="content">
                                    <ul class="dashboard-box-list">
                                        @forelse($jobs as $job)
                                            <li>
                                                <!-- Job Listing -->
                                                <div class="job-listing">
                                                    <!-- Job Listing Details -->
                                                    <div class="job-listing-details">
                                                        <!-- Details -->
                                                        <div class="job-listing-description">
                                                            <h3 class="job-listing-title">
                                                                <a href="{{ route('job.show', [$job->id, $job->slug]) }}">{{ $job->title }}</a>
                                                            </h3>

                                                            <!-- Job Listing Footer -->
                                                            <div class="job-listing-footer">
                                                                <ul>
                                                                    <li title="Job Created" data-tippy-placement="right"><i class="icon-material-outline-date-range"></i>
                                                                        {{ $job->created_at }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="buttons-to-right always-visible">
                                                    @if(Auth::user()->role_id === 3)
                                                        <form action="{{ route('dashboard.candidates') }}" method="get">
                                                            <input type="hidden" name="jobId" value="{{ $job->id }}">
                                                            <button class="button ripple-effect">
                                                                Manage
                                                                Candidates <span class="button-info">{{ $job->candidates }}</span>
                                                            </button>
                                                        </form>

                                                        <div class="margin-top-15">

                                                    <!-- Make sure no candidates before deleting -->
                                                    <a href="#small-dialog" id="{{ $job->id }}" class="button red popup-with-zoom-anim deleteButtons">
                                                        Delete
                                                    </a>
                                                    @else
                                                        <form action="{{ route('cancel.job.apply') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="jobId" value="{{ $job->id }}">
                                                            <input type="hidden" name="freelancerId" value="{{ $job->freelancerId }}">
                                                            <button class="button ripple-effect">
                                                                Cancel Application
                                                            </button>
                                                        </form>
                                                    @endif
                                                        @if(Session::has('fail'))
                                                            <div>
                                                                <p><b><mark>{{ Session::get('fail') }}</mark></b></p>
                                                            </div>
                                                        @endif
                                                    </div>

                                            </li>
                                        @empty
                                            @if(Auth::user()->role_id === 3)
                                                <p class="padding-top-30 padding-left-30 padding-bottom-30" >You have no active job offer !</p>
                                            @else
                                                <p class="padding-top-30 padding-left-30 padding-bottom-30" >You have not applied to any job offer !</p>
                                            @endif
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
    <script>
        let deleteButtons = document.getElementsByClassName('deleteButtons');

        for(let btn of deleteButtons) {
            btn.addEventListener('click', () => {
                document.getElementById('jobId').setAttribute('value', btn.getAttribute('id'));
            });
        }
    </script>
    <!-- Wrapper / End -->
    @auth
        @include('layouts.popups.delete')
    @endauth
@endsection