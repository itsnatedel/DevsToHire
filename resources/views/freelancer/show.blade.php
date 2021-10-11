@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
    <!-- Titlebar -->
        <div class="single-page-header freelancer-header" data-background-image="{{ asset('images/adobestock_229479916.png')}}">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-page-header-inner">
                            <div class="left-side">
                                <div class="header-image freelancer-avatar">
                                    @if(isset($freelancer->dir_url) && !is_null($freelancer->dir_url) && !is_null($freelancer->picUrl))
                                    <img
                                        src="{{ asset('images/user/' . $freelancer->dir_url . '/avatar/' . $freelancer->picUrl) }}"
                                        alt="Freelancer's pic">
                                    @else

                                        <img
                                            src="{{ asset('images/user/' . $freelancer->picUrl) }}"
                                            alt="Freelancer's pic">
                                    @endif
                                </div>
                                <div class="header-details">
                                    <h3>{{ ucfirst($freelancer->firstname) . ' ' . ucfirst($freelancer->lastname) }} <span data-tippy-placement="bottom" title="Specialization">{{ $freelancer->info->speciality }}</span></h3>
                                    <ul>
                                        @if(round($freelancer->info->stats->rating) > 0)
                                        <li data-tippy-placement="bottom" title="Rating">
                                            <div class="star-rating" data-rating="{{ round($freelancer->info->stats->rating) }}"></div>
                                        </li>
                                        @else
                                            <li><span class="company-not-rated">Hasn't been rated yet</span></li>
                                        @endif
                                        <li data-tippy-placement="bottom" title="Location"><img class="flag"
                                                 src="{{ asset('images/flags/' . strtolower($freelancer->info->country_code) . '.svg') }}" alt="Country Flag">
                                            {{ $freelancer->info->country_name }}
                                        </li>
                                        @if ($freelancer->verified)
                                            <li>
                                                <div class="verified-badge-with-title">Verified</div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- Breadcrumbs -->
                                <nav id="breadcrumbs" class="dark right-side">
                                    <ul>
                                        <li><a href="{{ route('homepage') }}">Home</a></li>
                                        <li><a href="{{ route('freelancer.index') }}">Freelancers</a></li>
                                        <li>{{ ucfirst($freelancer->firstname) . ' ' . ucfirst($freelancer->lastname) }}</li>
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
                    <!-- Page Content -->
                    <div class="single-page-section">
                        <h2 class="margin-bottom-25">About Me</h2>
                        <p>{{ $freelancer->description }}</p>
                    </div>
                    <!-- Boxed List -->
                    <div class="boxed-list margin-bottom-60">
                        <div class="boxed-list-headline">
                            <h3><i class="icon-material-outline-thumb-up"></i> Work History and Feedback</h3>
                        </div>
                        <ul class="boxed-list-ul">
                            <!-- Get comments & rating from jobs-->
                            @forelse($freelancer->jobs as $job)
                            <li>
                                <div class="boxed-list-item">
                                    <!-- Content -->
                                    <div class="item-content">
                                        <h4>{{ ucFirst($job->title) }}
                                            <span style="margin-top: 10px" data-tippy-placement="left" title="Employer">
                                                <mark class="color">Rated by</mark>
                                                <a href="{{ route('company.show', [ $job->company_id, Str::slug($job->name)]) }}">
                                                    {{ $job->name }}
                                                </a>
                                            </span>
                                        </h4>
                                        <div class="item-details" style="margin-top: 10px">
                                            <div class="star-rating" data-tippy-placement="left" title="Rating" data-rating="{{ $job->rating }}"></div>
                                            <div class="detail-item" title="Job Finished" data-tippy-placement="right"><i class="icon-material-outline-date-range"></i>
                                                {{ $job->done_at }}
                                            </div>
                                        </div>
                                        <div class="item-description">
                                            <p>{{ $job->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                                <div class="boxed-list-item" style="padding: 30px">
                                    <div class="item-content">
                                        <h4>No work history so far
                                            <span>This freelancer hasn't completed any job or task on this platform</span>
                                        </h4>
                                    </div>
                                </div>
                            @endforelse
                        </ul>
                    </div>
                    <!-- Boxed List / End -->
                </div>


                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-container">
                        <!-- Profile Overview -->
                        <div class="profile-overview">
                            <div class="overview-item"><strong>{{ $freelancer->hourly_rate }}€</strong><span>Hourly Rate</span></div>
                            <div class="overview-item"><strong>{{ $freelancer->info->stats->total }}</strong><span>Jobs Done</span></div>
                            <div class="overview-item"><strong>{{ $freelancer->info->joined_at . ' ago'}}</strong><span>Joined</span></div>
                        </div>

                        @if(Session::has('success'))
                            <div class="notification success closeable">
                                <p>{{ Session::get('success') }}</p>
                                <a class="close"></a>
                            </div>
                        @endif

                        <!-- Button -->
                        @auth
                            @if(Auth::id() !== $freelancer->user_id)
                                <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim margin-bottom-50">
                                    Make an Offer
                                    <i class="icon-material-outline-arrow-right-alt"></i>
                                </a>
                            @else
                                <a href="{{ route('dashboard.index') }}" class="apply-now-button margin-bottom-50">
                                    Go to my Dashboard
                                </a>
                            @endif

                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div>
                                        <mark class="color">{{ $error }}</mark>
                                    </div>
                                @endforeach
                            @endif
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="apply-now-button">Login to make an offer !</a>
                        @endguest
                        <!-- Freelancer Indicators -->
                        <div class="sidebar-widget">
                            <div class="freelancer-indicators">

                                <!-- Indicator -->
                                <div class="indicator" data-tippy-placement="bottom" title="Successful delivery of their work">
                                    <strong>{{ round($freelancer->info->stats->success) }}%</strong>
                                    <div class="indicator-bar" data-indicator-percentage="{{ round($freelancer->info->stats->success) }}"><span></span></div>
                                    <span>Job Success</span>
                                </div>

                                <!-- Indicator -->
                                <div class="indicator" data-tippy-placement="bottom" title="Recommended by their previous employers">
                                    <strong>{{ round($freelancer->info->stats->recommended) }}%</strong>
                                    <div class="indicator-bar" data-indicator-percentage="{{ round($freelancer->info->stats->recommended) }}"><span></span></div>
                                    <span>Recommendation</span>
                                </div>

                                <!-- Indicator -->
                                <div class="indicator" data-tippy-placement="bottom" title="Respect of deadlines">
                                    <strong>{{ round($freelancer->info->stats->on_time) }}%</strong>
                                    <div class="indicator-bar" data-indicator-percentage="{{ round($freelancer->info->stats->on_time) }}"><span></span></div>
                                    <span>On Time</span>
                                </div>

                                <!-- Indicator -->
                                <div class="indicator" data-tippy-placement="bottom" title="Stayed on agreed budget">
                                    <strong>{{ round($freelancer->info->stats->on_budget) }}%</strong>
                                    <div class="indicator-bar" data-indicator-percentage="{{ $freelancer->info->stats->on_budget }}"><span></span></div>
                                    <span>On Budget</span>
                                </div>
                            </div>
                        </div>

                        <!-- Widget -->
                        <div data-tippy-placement="left" title="Social accounts">
                        @include('layouts.sidebar.socialIcons')
                        </div>
                        <!-- Widget -->
                        <div class="sidebar-widget">
                            <h3>Skills</h3>
                            <div class="task-tags" data-tippy-placement="left" title="Competent with these technologies">
                                @forelse($freelancer->skills as $skill)
                                <span>{{ $skill }}</span>
                                @empty
                                    <p>This freelancer has yet to specify his skills set.</p>
                                @endforelse
                            </div>
                        </div>
                        @Auth
                        <!-- Widget -->
                        <div class="sidebar-widget">
                            <h3>Attachments</h3>
                            <div class="attachments-container">
                                <a href="{{ !is_null($freelancer->CV_url)
                                    ? route('freelancer.cv.download', [$freelancer->id, substr($freelancer->CV_url, 0, -4)])
                                    : '' }}"
                                   class="attachment-box ripple-effect"
                                    title="Download CV"
                                    data-tippy-placement="bottom">
                                    <span>Curriculum Vitae
                                        @if(is_null($freelancer->CV_url))
                                            - None submitted
                                        @endif
                                    </span>
                                    <i>PDF</i>
                                </a>
                            </div>
                        </div>
                        @endauth
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
                                        title="Copy Freelancer's profile to clipboard !" data-tippy-placement="top"><i
                                        class="icon-material-outline-file-copy"></i></button>
                            </div>
                            <!-- Share Buttons -->
                            <div class="share-buttons margin-top-25">
                                <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                                <div class="share-buttons-content">
                                    <span>Interesting? <strong>Share It!</strong></span>
                                    <ul class="share-buttons-icons">
                                        <li><a href="https://www.facebook.com/" data-button-color="#3b5998" title="Share on Facebook"
                                               data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                        <li><a href="https://twitter.com/" data-button-color="#1da1f2" title="Share on Twitter"
                                               data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                        <li><a href="https://www.linkedin.com/" data-button-color="#0077b5" title="Share on LinkedIn"
                                               data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Spacer -->
        <div class="margin-top-15"></div>
        <!-- Spacer / End-->
        @auth
            @include('layouts.popups.makeOffer')
        @endauth
    </div>
    <!-- Wrapper / End -->
@endsection