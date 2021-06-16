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
                        <li><a href="#">For Employers</a>
                            <ul class="dropdown-nav">
                                <li><a href="{{ route('freelancer.index') }}">Find a Freelancer</a>
                                </li>
                                <li>
                                    <a href="{{ route('company.show', 4) }}">Your Company Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.job.create') }}">Post a Job</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.task.create') }}">Post a Task</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Auth::check() -->
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
                                        <li><a href="{{ route('dashboard.candidates') }}">Manage Candidates</a>
                                        </li>
                                        <li><a href="{{ route('dashboard.job.create') }}">Post a Job</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('dashboard.task.manage') }}">Tasks</a>
                                    <ul class="dropdown-nav">
                                        <li><a href="{{ route('dashboard.task.manage') }}">Manage Tasks</a></li>
                                        <!-- If user === employer -->
                                        <li><a href="{{ route('dashboard.bid.manage') }}">Manage Bidders</a></li>
                                        <!-- If user === freelancer -->
                                        <li><a href="{{ route('dashboard.bid.active') }}">My Active Bids</a></li>
                                        <li><a href="{{ route('dashboard.task.create') }}">Post a Task</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('dashboard.settings') }}">Settings</a></li>
                            </ul>
                        </li>

                        <li><a href="#">Pages</a>
                            <ul class="dropdown-nav">
                                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                <li><a href="{{ route('premium.index') }}">Pricing Plans</a></li>
                                <li><a href="{{ route('checkout.index') }}">Checkout Page</a></li>
                                <li><a href="{{ route('invoice.show', 4) }}">Invoice Template</a></li>
                                <li><a href="pages-user-interface-elements.html">User Interface Elements</a>
                                </li>
                                <li><a href="pages-icons-cheatsheet.html">Icons Cheatsheet</a></li>
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                                <li><a href="{{ route('error-404') }}">404 Page</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </li>

                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->

            </div>
            <!-- Left Side Content / End -->


            <!-- Right Side Content / End -->
            <div class="right-side">
                @if(Auth::check())
                    <!--  User Notifications -->
                    <div class="header-widget hide-on-mobile">

                        <!-- Notifications -->
                        <div class="header-notifications">

                            <!-- Trigger -->
                            <div class="header-notifications-trigger">
                                <a href="#"><i class="icon-feather-bell"></i><span>4</span></a>
                            </div>

                            <!-- Dropdown -->
                            <div class="header-notifications-dropdown">

                                <div class="header-notifications-headline">
                                    <h4>Notifications</h4>
                                    <button class="mark-as-read ripple-effect-dark" title="Mark all as read"
                                            data-tippy-placement="left">
                                        <i class="icon-feather-check-square"></i>
                                    </button>
                                </div>

                                <div class="header-notifications-content">
                                    <div class="header-notifications-scroll" data-simplebar>
                                        <ul>
                                            <!-- Notification -->
                                            <li class="notifications-not-read">
                                                <a href="dashboard-manage-candidates.html">
                                                    <span class="notification-icon"><i
                                                            class="icon-material-outline-group"></i></span>
                                                    <span class="notification-text">
													<strong>Michael Shannah</strong> applied for a job <span
                                                            class="color">Full Stack Software Engineer</span>
												</span>
                                                </a>
                                            </li>

                                            <!-- Notification -->
                                            <li>
                                                <a href="dashboard-manage-bidders.html">
                                                    <span class="notification-icon"><i
                                                            class=" icon-material-outline-gavel"></i></span>
                                                    <span class="notification-text">
													<strong>Gilbert Allanis</strong> placed a bid on your <span
                                                            class="color">iOS App Development</span> project
												</span>
                                                </a>
                                            </li>

                                            <!-- Notification -->
                                            <li>
                                                <a href="dashboard-manage-jobs.html">
                                                    <span class="notification-icon"><i
                                                            class="icon-material-outline-autorenew"></i></span>
                                                    <span class="notification-text">
													Your job listing <span class="color">Full Stack PHP Developer</span> is expiring.
												</span>
                                                </a>
                                            </li>

                                            <!-- Notification -->
                                            <li>
                                                <a href="dashboard-manage-candidates.html">
                                                    <span class="notification-icon"><i
                                                            class="icon-material-outline-group"></i></span>
                                                    <span class="notification-text">
													<strong>Sindy Forrest</strong> applied for a job <span
                                                            class="color">Full Stack Software Engineer</span>
												</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Messages -->
                        <div class="header-notifications">
                            <div class="header-notifications-trigger">
                                <a href="#"><i class="icon-feather-mail"></i><span>3</span></a>
                            </div>

                            <!-- Dropdown -->
                            <div class="header-notifications-dropdown">

                                <div class="header-notifications-headline">
                                    <h4>Messages</h4>
                                    <button class="mark-as-read ripple-effect-dark" title="Mark all as read"
                                            data-tippy-placement="left">
                                        <i class="icon-feather-check-square"></i>
                                    </button>
                                </div>

                                <div class="header-notifications-content">
                                    <div class="header-notifications-scroll" data-simplebar>
                                        <ul>
                                            <!-- Notification -->
                                            <li class="notifications-not-read">
                                                <a href="dashboard-messages.html">
                                                    <span class="notification-avatar status-online"><img
                                                            src="images/user-avatar-small-03.jpg" alt=""></span>
                                                    <div class="notification-text">
                                                        <strong>David Peterson</strong>
                                                        <p class="notification-msg-text">Thanks for reaching
                                                            out.
                                                            I'm
                                                            quite busy right now on many...</p>
                                                        <span class="color">4 hours ago</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <!-- Notification -->
                                            <li class="notifications-not-read">
                                                <a href="dashboard-messages.html">
                                                    <span class="notification-avatar status-offline"><img
                                                            src="images/user-avatar-small-02.jpg" alt=""></span>
                                                    <div class="notification-text">
                                                        <strong>Sindy Forest</strong>
                                                        <p class="notification-msg-text">Hi Tom! Hate to break
                                                            it to
                                                            you, but I'm actually on vacation until...</p>
                                                        <span class="color">Yesterday</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <!-- Notification -->
                                            <li class="notifications-not-read">
                                                <a href="dashboard-messages.html">
                                                    <span class="notification-avatar status-online"><img
                                                            src="images/user-avatar-placeholder.png" alt=""></span>
                                                    <div class="notification-text">
                                                        <strong>Marcin Kowalski</strong>
                                                        <p class="notification-msg-text">I received payment.
                                                            Thanks
                                                            for
                                                            cooperation!</p>
                                                        <span class="color">Yesterday</span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <a href="dashboard-messages.html"
                                   class="header-notifications-button ripple-effect button-sliding-icon">View
                                    All
                                    Messages<i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>

                    </div>
                    <!--  User Notifications / End -->

                    <!-- User Menu -->
                    <div class="header-widget">

                        <!-- Messages -->
                        <div class="header-notifications user-menu">
                            <div class="header-notifications-trigger">
                                <a href="#">
                                    <div class="user-avatar status-online"><img
                                            src="images/user-avatar-small-01.jpg"
                                            alt=""></div>
                                </a>
                            </div>

                            <!-- Dropdown -->
                            <div class="header-notifications-dropdown">

                                <!-- User Status -->
                                <div class="user-status">

                                    <!-- User Name / Avatar -->
                                    <div class="user-details">
                                        <div class="user-avatar status-online"><img
                                                src="images/user-avatar-small-01.jpg" alt=""></div>
                                        <div class="user-name">
                                            Tom Smith <span>Freelancer</span>
                                        </div>
                                    </div>

                                    <!-- User Status Switcher -->
                                    <div class="status-switch" id="snackbar-user-status">
                                        <label class="user-online current-status">Online</label>
                                        <label class="user-invisible">Invisible</label>
                                        <!-- Status Indicator -->
                                        <span class="status-indicator" aria-hidden="true"></span>
                                    </div>
                                </div>

                                <ul class="user-menu-small-nav">
                                    <li><a href="dashboard.html"><i class="icon-material-outline-dashboard"></i>
                                            Dashboard</a></li>
                                    <li><a href="dashboard-settings.html"><i
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
