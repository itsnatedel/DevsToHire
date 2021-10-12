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
                        <h3>Manage Candidates</h3>
                        <!-- Foreach jobs -> title -->
                        <span class="margin-top-7">Job Applications for your active job offers</span>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>Manage Candidates</li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Row -->
                    <div class="row">
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
                        @if(is_countable($jobs))
                            @forelse($jobs as $job)
                            <!-- Dashboard Box -->
                            <div class="col-xl-12 margin-bottom-40">
                                <div class="dashboard-box margin-top-0">
                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="icon-material-outline-supervisor-account"></i>
                                            {{ $job->nb_candidates }} Candidates for "<a href="{{ route('job.show', [$job->job_id, $job->slug]) }}">{{ $job->title }}</a>" offer.
                                        </h3>
                                    </div>
                                    <div class="content">
                                        <!-- For each jobs -->
                                        <ul class="dashboard-box-list">
                                            <!-- List candi -->
                                            @forelse($job->candidates as $candidate)
                                                <li>
                                                    <!-- Overview -->
                                                    <div class="freelancer-overview manage-candidates">
                                                        <div class="freelancer-overview-inner">
                                                            <!-- Avatar -->
                                                            <div class="freelancer-avatar">
                                                                @if($candidate->info->verified)
                                                                    <div class="verified-badge" title="Verified" data-tippy-placement="bottom"></div>
                                                                @endif
                                                                <a href="{{ route('freelancer.show', [$candidate->frId, Str::slug($candidate->info->firstname . ' ' . $candidate->info->lastname)]) }}">
                                                                    @if(!is_null($candidate->info->dir_url))
                                                                        <img src="{{ asset('images/user/' . $candidate->info->dir_url . '/avatar/' . $candidate->info->pic_url) }}" alt="Candidate Avatar">
                                                                    @else
                                                                        <img src="{{ asset('images/user/' . $candidate->info->pic_url) }}" alt="Candidate Avatar">
                                                                    @endif
                                                                </a>
                                                            </div>

                                                            <!-- Name -->
                                                            <div class="freelancer-name">
                                                                <h4>
                                                                    <a href="{{ route('freelancer.show', [$candidate->frId, Str::slug($candidate->info->firstname . ' ' . $candidate->info->lastname)]) }}">
                                                                        {{ ucfirst($candidate->info->firstname) . ' ' . ucfirst($candidate->info->lastname) }}
                                                                        <img class="flag"
                                                                          src="{{ asset('images/flags/' . strtolower($candidate->info->country_code) . '.svg') }}"
                                                                          alt="" title="{{ ucfirst($candidate->info->country_name) }}"
                                                                          data-tippy-placement="right">
                                                                    </a>
                                                                </h4>

                                                                <!-- Details -->
                                                                <span class="freelancer-detail-item">
                                                                    <a href="mailto:{{ $candidate->info->email }}">
                                                                        <i class="icon-feather-mail"></i>
                                                                        {{ $candidate->info->email }}
                                                                    </a>
                                                                </span>

                                                                <!-- Rating -->
                                                                <div class="freelancer-rating">
                                                                    @if(!is_null($candidate->info->rating) || $candidate->info->rating > 0)
                                                                    <div class="star-rating" data-rating="{{ $candidate->info->rating }}"></div>
                                                                    @else
                                                                        <span class="company-not-rated">Candidate hasn't been rated yet</span>
                                                                    @endif
                                                                </div>

                                                                <!-- Skills -->
                                                                    <div class="task-tags" data-tippy-placement="left"
                                                                    title="Skills">
                                                                        @if(!is_null($candidate->info->skills))
                                                                            @forelse($candidate->info->skills as $skill)
                                                                                <span>{{ $skill }}</span>
                                                                            @empty
                                                                                <p>No particular skill</p>
                                                                            @endforelse
                                                                        @else
                                                                            <p>No skills submitted.</p>
                                                                        @endif
                                                                    </div>


                                                                <!-- Buttons -->
                                                                <div
                                                                    class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
                                                                    @if (!is_null($candidate->info->CV_url))
                                                                    <a href="{{ route('dashboard.candidates.download.cv', [$candidate->user_id, $candidate->info->CV_url]) }}" class="button ripple-effect"><i
                                                                            class="icon-feather-file-text"></i> Download CV
                                                                    </a>
                                                                    @else
                                                                        <a href="#" style="pointer-events: none" class="button dark ripple-effect">
                                                                            <i class="icon-feather-file-text"></i> No CV submitted
                                                                        </a>
                                                                    @endif
                                                                        <a href="#small-dialog" id="{{ $candidate->user_id }}" class="deleteButtons popup-with-zoom-anim button gray ripple-effect ico"
                                                                           title="Remove Candidate" data-tippy-placement="top"><i
                                                                                    class="icon-feather-trash-2"></i>
                                                                        </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li>
                                                    <p style="padding: 15px">No candidate applied for this job.</p>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <p style="padding: 15px">You have currently no active job offer.</p>
                            @endforelse
                        @else
                            <!-- Dashboard Box -->
                                <div class="col-xl-12 margin-bottom-40">
                                    <div class="dashboard-box margin-top-0">
                                        <!-- Headline -->
                                        <div class="headline">
                                            <h3><i class="icon-material-outline-supervisor-account"></i>
                                                {{ $jobs->nb_candidates }} Candidates for "<a href="{{ route('job.show', [$jobs->job_id, $jobs->slug]) }}">{{ $jobs->title }}</a>" offer.
                                            </h3>
                                        </div>

                                        <div class="content">
                                            <!-- For each jobs -->
                                            <ul class="dashboard-box-list">
                                                <!-- List candi -->
                                                @forelse($jobs->candidates as $candidate)
                                                    <li>
                                                        <!-- Overview -->
                                                        <div class="freelancer-overview manage-candidates">
                                                            <div class="freelancer-overview-inner">
                                                                <!-- Avatar -->
                                                                <div class="freelancer-avatar">
                                                                    @if($candidate->info->verified)
                                                                        <div class="verified-badge" title="Verified" data-tippy-placement="bottom"></div>
                                                                    @endif
                                                                    <a href="{{ route('freelancer.show', [$candidate->user_id, Str::slug($candidate->info->firstname . ' ' . $candidate->info->lastname)]) }}">
                                                                        @if(!is_null($candidate->info->dir_url))
                                                                            <img src="{{ asset('images/user/' . $candidate->info->dir_url . '/avatar/' . $candidate->info->pic_url) }}" alt="Candidate Avatar">
                                                                        @else
                                                                            <img src="{{ asset('images/user/' . $candidate->info->pic_url) }}" alt="Candidate Avatar">
                                                                        @endif
                                                                    </a>
                                                                </div>

                                                                <!-- Name -->
                                                                <div class="freelancer-name">
                                                                    <h4>
                                                                        <a href="{{ route('freelancer.show', [$candidate->user_id, Str::slug($candidate->info->firstname . ' ' . $candidate->info->lastname)]) }}">
                                                                            {{ ucfirst($candidate->info->firstname) . ' ' . ucfirst($candidate->info->lastname) }}
                                                                            <img class="flag"
                                                                                 src="{{ asset('images/flags/' . strtolower($candidate->info->country_code) . '.svg') }}"
                                                                                 alt="" title="{{ ucfirst($candidate->info->country_name) }}"
                                                                                 data-tippy-placement="right">
                                                                        </a>
                                                                    </h4>

                                                                    <!-- Details -->
                                                                    <span class="freelancer-detail-item">
                                                                    <a href="mailto:{{ $candidate->info->email }}">
                                                                        <i class="icon-feather-mail"></i>
                                                                        {{ $candidate->info->email }}
                                                                    </a>
                                                                </span>

                                                                    <!-- Rating -->
                                                                    <div class="freelancer-rating">
                                                                        @if(!is_null($candidate->info->rating) || $candidate->info->rating > 0)
                                                                            <div class="star-rating" data-rating="{{ $candidate->info->rating }}"></div>
                                                                        @else
                                                                            <span class="company-not-rated">Candidate hasn't been rated yet</span>
                                                                        @endif
                                                                    </div>

                                                                    <!-- Skills -->
                                                                    <div class="task-tags" data-tippy-placement="left"
                                                                         title="Skills">
                                                                        @if(!is_null($candidate->info->skills))
                                                                            @forelse($candidate->info->skills as $skill)
                                                                                <span>{{ $skill }}</span>
                                                                            @empty
                                                                                <p>No particular skill</p>
                                                                            @endforelse
                                                                        @else
                                                                            <p>No skills submitted.</p>
                                                                        @endif
                                                                    </div>
                                                                    <!-- Buttons -->
                                                                    <div
                                                                            class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
                                                                        @if (!is_null($candidate->info->CV_url))
                                                                            <a href="{{ route('dashboard.candidates.download.cv', [$candidate->user_id, $candidate->info->CV_url ]) }}" class="button ripple-effect"><i
                                                                                        class="icon-feather-file-text"></i> Download CV
                                                                            </a>
                                                                        @else
                                                                            <a href="#" style="pointer-events: none" class="button dark ripple-effect">
                                                                                <i class="icon-feather-file-text"></i> No CV submitted
                                                                            </a>
                                                                        @endif

                                                                        <a href="#small-dialog" id="{{ $candidate->user_id }}"  class="deleteButtons popup-with-zoom-anim button gray ripple-effect ico"
                                                                           title="Remove Candidate" data-tippy-placement="top"><i
                                                                                    class="icon-feather-trash-2"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <li>
                                                        <p style="padding: 15px">No candidate applied for this job.</p>
                                                    </li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        @endif
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
    @auth
        @include('layouts.popups.candidateDelete')
    @endauth
    <script>
        let deleteButtons = document.getElementsByClassName('deleteButtons');
        for(let btn of deleteButtons) {
            btn.addEventListener('click', () => {
                document.getElementById('candidateId').setAttribute('value', btn.getAttribute('id'));
            });
        }
    </script>
@endsection