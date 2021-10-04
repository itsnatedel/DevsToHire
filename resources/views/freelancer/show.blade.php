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
                                    @if(isset($freelancer->dir_url) && !is_null($freelancer->dir_url) && !is_null($freelancer->pic_url))
                                    <img
                                        src="{{ asset('images/user/' . $freelancer->dir_url . '/avatar/' . $freelancer->pic_url) }}"
                                        alt="Freelancer's pic">
                                    @else
                                        <img
                                            src="{{ asset('images/user/' . $freelancer->pic_url) }}"
                                            alt="Freelancer's pic">
                                    @endif
                                </div>
                                <div class="header-details">
                                    <h3>{{ ucfirst($freelancer->firstname) . ' ' . ucfirst($freelancer->lastname) }} <span>{{ $freelancer->info->speciality }}</span></h3>
                                    <ul>
                                        @if(round($freelancer->info->stats->rating) > 0)
                                        <li>
                                            <div class="star-rating" data-rating="{{ round($freelancer->info->stats->rating) }}"></div>
                                        </li>
                                        @else
                                            <li><mark>Hasn't been rated yet</mark></li>
                                        @endif
                                        <li><img class="flag"
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

                                <!-- TODO: social links for freelancers -->
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
                                            <span>
                                                <mark class="color">Rated by :</mark>
                                                <a href="{{ route('company.show', [ $job->company_id, Str::slug($job->name)]) }}">
                                                    {{ $job->name }}
                                                </a>
                                            </span>
                                        </h4>
                                        <div class="item-details margin-top-10">
                                            <div class="star-rating" data-rating="{{ $job->rating }}"></div>
                                            <div class="detail-item"><i class="icon-material-outline-date-range"></i>
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
                                <div class="boxed-list-item" style="margin-top: 20px">
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
                            <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim margin-bottom-50">
                                Make an Offer
                                <i class="icon-material-outline-arrow-right-alt"></i>
                            </a>

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
                        <div class="sidebar-widget">
                            <h3>Social Profiles</h3>
                            <div class="freelancer-socials margin-top-25">
                                <ul>
                                    <li><a href="#" title="Dribbble" data-tippy-placement="top"><i
                                                class="icon-brand-dribbble"></i></a></li>
                                    <li><a href="#" title="Twitter" data-tippy-placement="top"><i
                                                class="icon-brand-twitter"></i></a></li>
                                    <li><a href="#" title="Behance" data-tippy-placement="top"><i
                                                class="icon-brand-behance"></i></a></li>
                                    <li><a href="#" title="GitHub" data-tippy-placement="top"><i
                                                class="icon-brand-github"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Widget -->
                        <div class="sidebar-widget">
                            <h3>Skills</h3>
                            <div class="task-tags">
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
                                   class="attachment-box ripple-effect">
                                    <span>Curriculum Vitae
                                        @if(is_null($freelancer->CV_url))
                                            - None submitted
                                        @endif
                                    </span>
                                    <i>PDF</i>
                                </a>
                                <a href="#" class="attachment-box ripple-effect"><span>Contract</span><i>DOCX</i></a>
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
                                        title="Copy to Clipboard" data-tippy-placement="top"><i
                                        class="icon-material-outline-file-copy"></i></button>
                            </div>
                            <!-- Share Buttons -->
                            <div class="share-buttons margin-top-25">
                                <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                                <div class="share-buttons-content">
                                    <span>Interesting? <strong>Share It!</strong></span>
                                    <ul class="share-buttons-icons">
                                        <li><a href="#" data-button-color="#3b5998" title="Share on Facebook"
                                               data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                        <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter"
                                               data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                        <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus"
                                               data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a>
                                        </li>
                                        <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn"
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