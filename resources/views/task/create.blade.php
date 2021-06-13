@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Dashboard Container -->
        <div class="dashboard-container">

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
                                    <li><a href="dashboard.html"><i class="icon-material-outline-dashboard"></i>
                                            Dashboard</a></li>
                                    <li><a href="dashboard-messages.html"><i
                                                class="icon-material-outline-question-answer"></i> Messages <span
                                                class="nav-tag">2</span></a></li>
                                    <li><a href="dashboard-bookmarks.html"><i
                                                class="icon-material-outline-star-border"></i>
                                            Bookmarks</a></li>
                                    <li><a href="dashboard-reviews.html"><i
                                                class="icon-material-outline-rate-review"></i>
                                            Reviews</a></li>
                                </ul>

                                <ul data-submenu-title="Organize and Manage">
                                    <li><a href="#"><i class="icon-material-outline-business-center"></i> Jobs</a>
                                        <ul>
                                            <li><a href="dashboard-manage-jobs.html">Manage Jobs <span
                                                        class="nav-tag">3</span></a></li>
                                            <li><a href="dashboard-manage-candidates.html">Manage Candidates</a></li>
                                            <li><a href="dashboard-post-a-job.html">Post a Job</a></li>
                                        </ul>
                                    </li>
                                    <li class="active-submenu"><a href="#"><i
                                                class="icon-material-outline-assignment"></i>
                                            Tasks</a>
                                        <ul>
                                            <li><a href="dashboard-manage-tasks.html">Manage Tasks <span
                                                        class="nav-tag">2</span></a></li>
                                            <li><a href="dashboard-manage-bidders.html">Manage Bidders</a></li>
                                            <li><a href="dashboard-my-active-bids.html">My Active Bids <span
                                                        class="nav-tag">4</span></a></li>
                                            <li><a href="dashboard-post-a-task.html">Post a Task</a></li>
                                        </ul>
                                    </li>
                                </ul>

                                <ul data-submenu-title="Account">
                                    <li><a href="dashboard-settings.html"><i class="icon-material-outline-settings"></i>
                                            Settings</a></li>
                                    <li><a href="index-logged-out.html"><i
                                                class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                                </ul>

                            </div>
                        </div>
                        <!-- Navigation / End -->

                    </div>
                </div>
            </div>
            <!-- Dashboard Sidebar / End -->


            <!-- Dashboard Content
            ================================================== -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">

                    <!-- Dashboard Headline -->
                    <div class="dashboard-headline">
                        <h3>Post a Task</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Dashboard</a></li>
                                <li>Post a Task</li>
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
                                    <h3><i class="icon-feather-folder-plus"></i> Task Submission Form</h3>
                                </div>

                                <div class="content with-padding padding-bottom-10">
                                    <div class="row">

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Project Name</h5>
                                                <input type="text" class="with-border"
                                                       placeholder="e.g. build me a website">
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Category</h5>
                                                <select class="selectpicker with-border" data-size="7"
                                                        title="Select Category">
                                                    <option>Admin Support</option>
                                                    <option>Customer Service</option>
                                                    <option>Data Analytics</option>
                                                    <option>Design & Creative</option>
                                                    <option>Legal</option>
                                                    <option>Software Developing</option>
                                                    <option>IT & Networking</option>
                                                    <option>Writing</option>
                                                    <option>Translation</option>
                                                    <option>Sales & Marketing</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Location <i class="help-icon" data-tippy-placement="right"
                                                                title="Leave blank if it's an online job"></i></h5>
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container">
                                                        <input id="autocomplete-input" class="with-border" type="text"
                                                               placeholder="Anywhere">
                                                    </div>
                                                    <i class="icon-material-outline-location-on"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>What is your estimated budget?</h5>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="input-with-icon">
                                                            <input class="with-border" type="text"
                                                                   placeholder="Minimum">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="input-with-icon">
                                                            <input class="with-border" type="text"
                                                                   placeholder="Maximum">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="feedback-yes-no margin-top-0">
                                                    <div class="radio">
                                                        <input id="radio-1" name="radio" type="radio" checked>
                                                        <label for="radio-1"><span class="radio-label"></span> Fixed
                                                            Price
                                                            Project</label>
                                                    </div>

                                                    <div class="radio">
                                                        <input id="radio-2" name="radio" type="radio">
                                                        <label for="radio-2"><span class="radio-label"></span> Hourly
                                                            Project</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>What skills are required? <i class="help-icon"
                                                                                 data-tippy-placement="right"
                                                                                 title="Up to 5 skills that best describe your project"></i>
                                                </h5>
                                                <div class="keywords-container">
                                                    <div class="keyword-input-container">
                                                        <input type="text" class="keyword-input with-border"
                                                               placeholder="Add Skills"/>
                                                        <button class="keyword-input-button ripple-effect"><i
                                                                class="icon-material-outline-add"></i></button>
                                                    </div>
                                                    <div class="keywords-list"><!-- keywords go here --></div>
                                                    <div class="clearfix"></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Describe Your Project</h5>
                                                <textarea cols="30" rows="5" class="with-border"></textarea>
                                                <div class="uploadButton margin-top-30">
                                                    <input class="uploadButton-input" type="file"
                                                           accept="image/*, application/pdf" id="upload" multiple/>
                                                    <label class="uploadButton-button ripple-effect" for="upload">Upload
                                                        Files</label>
                                                    <span class="uploadButton-file-name">Images or documents that might be helpful in describing your project</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <a href="#" class="button ripple-effect big margin-top-30"><i class="icon-feather-plus"></i>
                                Post a Task</a>
                        </div>

                    </div>
                    <!-- Row / End -->

                    <!-- Footer -->
                    <div class="dashboard-footer-spacer"></div>
                    <div class="small-footer margin-top-15">
                        <div class="small-footer-copyrights">
                            © 2019 <strong>Hireo</strong>. All Rights Reserved.
                        </div>
                        <ul class="footer-social-links">
                            <li>
                                <a href="#" title="Facebook" data-tippy-placement="top">
                                    <i class="icon-brand-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Twitter" data-tippy-placement="top">
                                    <i class="icon-brand-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Google Plus" data-tippy-placement="top">
                                    <i class="icon-brand-google-plus-g"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="LinkedIn" data-tippy-placement="top">
                                    <i class="icon-brand-linkedin-in"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Footer / End -->

                </div>
            </div>
            <!-- Dashboard Content / End -->

        </div>
        <!-- Dashboard Container / End -->

    </div>
    <!-- Wrapper / End -->


    <!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
    <script src="js/chart.min.js"></script>
    <script>
        Chart.defaults.global.defaultFontFamily = "Nunito";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';

        var ctx = document.getElementById('chart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line',

            // The data for our dataset
            data: {
                labels: ["January", "February", "March", "April", "May", "June"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: 'rgba(42,65,232,0.08)',
                    borderColor: '#2a41e8',
                    borderWidth: "3",
                    data: [196, 132, 215, 362, 210, 252],
                    pointRadius: 5,
                    pointHoverRadius: 5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },
            // Configuration options
            options: {
                layout: {
                    padding: 10,
                },
                legend: {display: false},
                title: {display: false},
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            borderDash: [6, 10],
                            color: "#d8d8d8",
                            lineWidth: 1,
                        },
                    }],
                    xAxes: [{
                        scaleLabel: {display: false},
                        gridLines: {display: false},
                    }],
                },
                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },
        });
    </script>
    <!-- Google Autocomplete -->
    <script>
        function initAutocomplete() {
            var options = {
                types: ['(cities)'],
                // componentRestrictions: {country: "us"}
            };

            var input = document.getElementById('autocomplete-input');
            var autocomplete = new google.maps.places.Autocomplete(input, options);

            if ($('.submit-field')[0]) {
                setTimeout(function () {
                    $(".pac-container").prependTo("#autocomplete-container");
                }, 300);
            }
        }
    </script>
@endsection
