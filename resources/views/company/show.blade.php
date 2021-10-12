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
                                <div class="header-image">
                                    <img src="{{ asset('images/companies/' . $company->pic_url) }}" alt="Company Pic">
                                </div>
                                <div class="header-details">
                                    <h3>{{ $company->name }}<span>{{ ucFirst($company->speciality) }}</span></h3>
                                    <ul>
                                        @if($company->rating !== 0)
                                        <li>
                                            <div class="star-rating" data-rating="{{ round($company->rating) }}"></div>
                                        </li>
                                        @else
                                            <li>
                                                <span class="company-not-rated">This company hasn't been rated yet</span>
                                            </li>
                                        @endif
                                        <li><img class="flag"
                                                 src="{{ asset('images/flags/' . strtolower($company->country_code) . '.svg') }}"
                                                 alt="Flag">{{ $company->country_name }}</li>

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
                                <nav id="breadcrumbs" class="dark">
                                    <ul>
                                        <li><a href="{{ route('homepage') }}">Home</a></li>
                                        <li><a href="{{ route('company.index') }}">Browse Companies</a></li>
                                        <li>{{ ucfirst($company->name) }}</li>
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
                        <h3 class="margin-bottom-25">About <b>{{ $company->name }}</b></h3>
                        <p>{{ $company->description }}</p>
                    </div>

                    <!-- Boxed List -->
                    <div class="boxed-list margin-bottom-30">
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
                                                        <li data-tippy-placement="bottom" title="Job Location">
                                                            <i class="icon-material-outline-location-on"></i>
                                                            {{ $position->country_name }}
                                                        </li>
                                                        <li data-tippy-placement="bottom" title="Job Type">
                                                            <i class="icon-material-outline-business-center"></i>
                                                            {{ $position->type }}
                                                        </li>
                                                        <li data-tippy-placement="bottom" title="Posted">
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
                                <p style="padding: 30px">This employer doesn't currently have any
                                    opened job offer.</p>
                            @endif
                        </div>
                    </div>
                    <!-- Boxed List / End -->
                    <!-- Boxed List -->
                    <div class="boxed-list margin-bottom-60">
                        <div class="boxed-list-headline">
                            <h3><i class="icon-material-outline-business-center"></i> Open Tasks</h3>
                        </div>
                        <div class="listings-container compact-list-layout">
                        @forelse($tasks as $task)
                            <!-- Job Listing -->
                                <a href="{{ route('task.show', [$task->task_id, Str::slug($task->name)]) }}"
                                   class="job-listing">
                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">
                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">{{ ucFirst($task->name) }}</h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li data-tippy-placement="bottom" title="Budget Allocated">
                                                        <i class="icon-line-awesome-money"></i>
                                                        {{ $task->budget_min . ' € - ' . $task->budget_max . ' €' }}
                                                    </li>
                                                    <li data-tippy-placement="bottom" title="Remuneration Type">
                                                        <i class="icon-material-outline-business-center"></i>
                                                        {{ $task->type }}
                                                    </li>
                                                    <li data-tippy-placement="bottom" title="Field">
                                                        <i class="icon-line-awesome-certificate"></i>
                                                        {{ $task->category_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p style="padding: 30px">This employer currently doesn't have any
                                    opened task.</p>
                            @endforelse
                        </div>
                    </div>
                    <!-- Boxed List / End -->
                </div>
                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-container">
                        <!-- Sidebar Widget -->
                        <div class="sidebar-widget">
                            @if(Session::has('fail'))
                                <div class="notification error closeable">
                                    <p>{{ Session::get('fail') }}</p>
                                    <a class="close"></a>
                                </div>
                            @endif
                            @if(Session::has('success'))
                                <div class="notification success closeable">
                                    <p>{{ Session::get('success') }}</p>
                                    <a class="close"></a>
                                </div>
                            @endif
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div>
                                        <p>{{ $error }}</p>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Bookmark Button -->
                            @include('layouts.sidebar.socialIcons')

                            <div class="boxed-list margin-top-10">

                                <div class="notify-box margin-top-15">
                                    <i class="icon-material-outline-thumb-up"></i> Reviews
                                    <div class="sort-by">
                                        <span>Sort by:</span>
                                        <form
                                            action="{{ route('company.ratings.search', [$company->id, Str::slug($company->name)]) }}"
                                            method="post">
                                            @csrf
                                            <select class="selectpicker hide-tick" name="sortBy" onchange="this.form.submit()">
                                                <optgroup label="Date">
                                                    <option value="newest">Newest</option>
                                                    <option value="oldest">Oldest</option>
                                                </optgroup>
                                                <optgroup label="Rating">
                                                    <option value="high-to-low">High to low</option>
                                                    <option value="low-to-high">Low to high</option>
                                                </optgroup>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                                <ul class="boxed-list-ul">
                                    @forelse($ratings as $rating)
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <div class="item-content">
                                                    <h4>{{ Str::limit($rating->reviewTitle, 70) }}
                                                        <span>{{ $rating->full_name }}</span></h4>
                                                    <div class="item-details margin-top-10">
                                                        <div class="star-rating"
                                                             data-rating="{{ $rating->note . '.0'}}"></div>
                                                        <div class="detail-item"><i
                                                                class="icon-material-outline-date-range"></i>
                                                            {{ $rating->rating_when }} days ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <span style="transform: translate(60px,10px)" class="company-not-rated">This employer hasn't been rated yet</span>
                                    @endforelse
                                </ul>
                                <div class="centered-button margin-top-35">
                                    @auth
                                        @if(Auth::user()->role_id === 3 && Auth::id() === $company->user_id)
                                            <a href="#" class="button">
                                                Cannot rate yourself !
                                            </a>
                                        @else
                                            <a href="#small-dialog" class="popup-with-zoom-anim button button-sliding-icon">
                                                Leave a Review <i class="icon-material-outline-arrow-right-alt"></i>
                                            </a>
                                        @endif

                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}" class="button button-sliding-icon">
                                            Login to leave a review
                                            <i class="icon-material-outline-arrow-right-alt"></i>
                                        </a>
                                    @endguest
                                </div>
                            </div>
                            <!-- Boxed List / End -->
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
    @auth
        @include('layouts.popups.reviewToCompany')
    @endauth
@endsection