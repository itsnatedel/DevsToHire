<!-- Dashboard Sidebar
            ================================================== -->
<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
                <span class="trigger-title">Dashboard Navigation</span>
            </a>

            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">
                    <ul data-submenu-title="Start">
                        @if(Auth::check() && Auth::user()->role_id === 3)
                        <li><a href="{{ route('dashboard.index') }}"><i class="icon-material-outline-dashboard"></i>
                                Dashboard</a></li>
                        @endif
                        <li><a href="{{ route('dashboard.messages') }}"><i
                                    class="icon-material-outline-question-answer"></i> Messages <span
                                    class="nav-tag">2</span></a></li>
                        <li><a href="{{ route('dashboard.bookmarks') }}"><i
                                    class="icon-material-outline-star-border"></i> Bookmarks</a></li>
                        <li><a href="{{ route('dashboard.reviews') }}"><i
                                    class="icon-material-outline-rate-review"></i> Reviews</a></li>
                    </ul>

                    <ul data-submenu-title="Organize and Manage">
                        <li><a href="#"><i class="icon-material-outline-business-center"></i> Jobs</a>
                            <ul>
                                <li><a href="{{ route('dashboard.job.manage') }}">Manage Jobs <span
                                            class="nav-tag">3</span></a></li>
                                @if(Auth::check() && Auth::user()->role_id === 3)
                                <li><a href="{{ route('dashboard.candidates') }}">Manage Candidates</a></li>
                                @endif
                                <li><a href="{{ route('dashboard.job.create') }}">Post a Job</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="icon-material-outline-assignment"></i> Tasks</a>
                            <ul>
                                <li><a href="{{ route('dashboard.job.manage') }}">Manage Tasks <span
                                            class="nav-tag">2</span></a></li>
                                @if(Auth::check() && Auth::user()->role_id === 3)
                                <li><a href="{{ route('dashboard.bid.manage') }}">Manage Bidders</a></li>
                                @endif

                                <li><a href="{{ route('dashboard.bid.active') }}">My Active Bids <span
                                            class="nav-tag">4</span></a></li>
                                <li><a href="{{ route('dashboard.task.create') }}">Post a Task</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul data-submenu-title="Account">
                        <li class="active"><a href="{{ route('dashboard.settings') }}"><i
                                    class="icon-material-outline-settings"></i> Settings</a></li>
                    </ul>
                </div>
            </div>
            <!-- Navigation / End -->

        </div>
    </div>
</div>
<!-- Dashboard Sidebar / End -->

