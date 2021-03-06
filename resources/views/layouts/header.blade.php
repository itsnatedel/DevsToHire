<!-- Header Container
        ================================================== -->
<header id="header-container" class="fullwidth">
    <!-- Header -->
    <div id="header">
        <div class="container">

            <!-- Left Side Content -->
            <div class="left-side">

                <!-- Logo -->
                <div id="logo">
                    <a href="{{ route('homepage') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                </div>

                <!-- Main Navigation -->
                <nav id="navigation">
                    <ul id="responsive">
                        <li><a href="#">Find Work</a>
                            <ul class="dropdown-nav">
                                <li>
                                    <a href="{{ route('job.index') }}">Browse Jobs</a>
                                </li>
                                <li>
                                    <a href="{{ route('task.index') }}">Browse Tasks</a>
                                </li>
                                <li>
                                    <a href="{{ route('company.index') }}">Browse Companies</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Auth check for employer status -->
                        @if (Auth::check() && Auth::user()->role_id === 3)
                            <li><a href="#">For Employers</a>
                                <ul class="dropdown-nav">
                                    <li><a href="{{ route('freelancer.index') }}">Find a Freelancer</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.show', [Auth::user()->company_id ?? 1, Str::slug(Auth::user()->firstname . ' ' . Auth::user()->lastname)]) }}">Your Company Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.job.create') }}">Post a Job</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.task.create') }}">Post a Task</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    <!-- Auth::check() -->

                        @if(Auth::check())
                            <li><a href="#">Dashboard</a>
                                <ul class="dropdown-nav">
                                    <li><a href="{{ route('dashboard.index') }}">Overview</a></li>
                                    <li><a href="{{ route('dashboard.messages') }}">My messages</a></li>
                                    <li><a href="{{ route('dashboard.bookmarks') }}">My bookmarks</a></li>
                                    <li><a href="{{ route('dashboard.reviews') }}">My reviews</a></li>
                                    <li><a href="{{ route('dashboard.job.manage') }}">Jobs</a>
                                        <ul class="dropdown-nav">
                                            <li><a href="{{ route('dashboard.job.manage') }}">Manage Jobs</a></li>
                                            <!-- If user === employer-->
                                            @if(Auth::user()->role_id === 3)
                                                <li><a href="{{ route('dashboard.candidates') }}">Manage Candidates</a>
                                                </li>
                                                <li><a href="{{ route('dashboard.job.create') }}">Post a Job</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('dashboard.task.manage') }}">Tasks</a>
                                        <ul class="dropdown-nav">
                                            <li><a href="{{ route('dashboard.task.manage') }}">Manage Tasks</a></li>
                                            <!-- If user === freelancer -->
                                            @if(Auth::check() && Auth::user()->role_id === 2)
                                                <li><a href="{{ route('dashboard.bid.active') }}">My Active Bids</a></li>
                                            @endif

                                            @if(Auth::check())
                                                <li><a href="{{ route('dashboard.task.create') }}">Post a Task</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('dashboard.settings') }}">Settings</a></li>
                                </ul>
                            </li>
                        @endif
                        <li style="transform: translateY(2px)"><a href="{{ route('premium.index') }}">Pricing</a></li>
                        <li style="transform: translateY(2px)"><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->
            </div>
            <!-- Left Side Content / End -->
            <!-- Right Side Content / End -->
            <div class="right-side">
            @if(Auth::check())
                <!-- User Menu -->
                    <div class="header-widget">
                        <!-- Messages -->
                        <div class="header-notifications user-menu">
                            <div class="header-notifications-trigger">
                                <a href="#">
                                    <div id="user-avatar" class="user-avatar status-online">
                                        @if(!is_null(Auth::user()->dir_url))
                                        <img
                                            src="{{ asset('images/user/' . Auth::user()->dir_url . '/avatar/' . Auth::user()->pic_url) }}"
                                            alt="Profile Pic">
                                        @else

                                            <img
                                                src="{{ asset('images/user/' . Auth::user()->pic_url) }}"
                                                alt="Profile Pic">
                                        @endif
                                    </div>
                                </a>
                            </div>
                            <!-- Dropdown -->
                            <div class="header-notifications-dropdown">
                                <!-- User Status -->
                                <div class="user-status">
                                    <!-- User Name / Avatar -->
                                    <div class="user-details">
                                        <div id="dropdown-user-avatar" class="user-avatar status-online">
                                            @if(!is_null(Auth::user()->dir_url))
                                                <img
                                                    src="{{ asset('images/user/' . Auth::user()->dir_url . '/avatar/' . Auth::user()->pic_url) }}"
                                                    alt="Profile Pic">
                                            @else
                                                <img
                                                    src="{{ asset('images/user/' . Auth::user()->pic_url) }}"
                                                    alt="Profile Pic">
                                            @endif
                                        </div>
                                        <div class="user-name">
                                            {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
                                            <span>{{ Auth::user()->role_id === 2 ? 'Freelancer' : 'Employer' }}</span>
                                        </div>
                                    </div>

                                    <!-- User Status Switcher -->
                                    <div class="status-switch" id="snackbar-user-status">
                                        <label id="set-status-online" class="user-online current-status">Online</label>
                                        <label id="set-status-offline" class="user-invisible">Invisible</label>
                                        <!-- Status Indicator -->
                                        <span id="status-indicator" class="status-indicator online" aria-hidden="true"></span>
                                    </div>
                                </div>


                                <ul class="user-menu-small-nav">
                                    @if(Auth::user()->role_id === 2)
                                    <li>
                                        @if(!is_null(Auth::user()->freelancer_id))
                                        <a href="{{ route('freelancer.show', [Auth::user()->freelancer_id, Str::slug(Auth::user()->firstname . ' ' . Auth::user()->lastname)]) }}">
                                            <i class="icon-material-outline-person-pin"></i>
                                            My Profile
                                        </a>
                                            @endif
                                    </li>
                                    @elseif(Auth::user()->role_id === 3)
                                        <li>
                                            <a href="{{ route('company.show', [Auth::user()->company_id ?? 1, Str::slug(Auth::user()->firstname . ' ' . Auth::user()->lastname)]) }}">
                                                <i class="icon-material-outline-dashboard"></i>
                                                My Company Profile
                                            </a>
                                        </li>
                                    @endif
                                    <li><a href="{{ route('dashboard.index') }}"><i class="icon-material-outline-dashboard"></i>
                                            Dashboard</a>
                                    </li>
                                    <li><a href="{{ route('dashboard.settings') }}"><i
                                                class="icon-material-outline-settings"></i>
                                            Settings</a></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <i class="icon-material-outline-power-settings-new"></i>
                                            <button type="submit">Logout</button>
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <!-- User Menu / End -->
                @else
                    <div class="header-widget">
                        <a href="{{ route('login') }}" class="log-in-button"><i
                                class="icon-feather-log-in"></i> <span>Log In / Register</span></a>
                    </div>
            @endif
            <!-- Mobile Navigation Button -->
                <span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

            </div>
            <!-- Right Side Content / End -->

        </div>
    </div>
    <!-- Header / End -->
</header>
<div class="clearfix"></div>
<!-- Header Container / End -->