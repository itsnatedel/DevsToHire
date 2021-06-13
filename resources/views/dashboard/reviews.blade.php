@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Dashboard Container -->
        <div class="dashboard-container">
        @include('layouts.dashboard.sidebar')
        <!-- Dashboard Content -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">

                    <!-- Dashboard Headline -->
                    <div class="dashboard-headline">
                        <h3>Reviews</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Dashboard</a></li>
                                <li>Reviews</li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Row -->
                    <div class="row">

                        <!-- Dashboard Box -->
                        <div class="col-xl-6">
                            <div class="dashboard-box margin-top-0">

                                <!-- Headline -->
                                <div class="headline">
                                    <h3><i class="icon-material-outline-business"></i> Rate Employers</h3>
                                </div>

                                <div class="content">
                                    <ul class="dashboard-box-list">
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <div class="item-content">
                                                    <h4>Simple Chrome Extension</h4>
                                                    <span class="company-not-rated margin-bottom-5">Not Rated</span>
                                                </div>
                                            </div>

                                            <a href="#small-dialog-2"
                                               class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i
                                                    class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                                        </li>
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <div class="item-content">
                                                    <h4>Adsense Expert</h4>
                                                    <span class="company-not-rated margin-bottom-5">Not Rated</span>
                                                </div>
                                            </div>

                                            <a href="#small-dialog-2"
                                               class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i
                                                    class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                                        </li>
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <div class="item-content">
                                                    <h4>Fix Python Selenium Code</h4>
                                                    <div class="item-details margin-top-10">
                                                        <div class="star-rating" data-rating="5.0"></div>
                                                        <div class="detail-item"><i
                                                                class="icon-material-outline-date-range"></i> May 2019
                                                        </div>
                                                    </div>
                                                    <div class="item-description">
                                                        <p>Great clarity in specification and communication. I got
                                                            payment really fast. Really recommend this employer for his
                                                            professionalism. I will work for him again with
                                                            pleasure.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#small-dialog-1"
                                               class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10"><i
                                                    class="icon-feather-edit"></i> Edit Review</a>
                                        </li>
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <div class="item-content">
                                                    <h4>PHP Core Website Fixes</h4>
                                                    <div class="item-details margin-top-10">
                                                        <div class="star-rating" data-rating="5.0"></div>
                                                        <div class="detail-item"><i
                                                                class="icon-material-outline-date-range"></i> May 2019
                                                        </div>
                                                    </div>
                                                    <div class="item-description">
                                                        <p>Great clarity in specification and communication. I got
                                                            payment really fast. Really recommend this employer for his
                                                            professionalism. I will work for him again with
                                                            pleasure.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#small-dialog-1"
                                               class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10"><i
                                                    class="icon-feather-edit"></i> Edit Review</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="clearfix"></div>
                            <div class="pagination-container margin-top-40 margin-bottom-0">
                                <nav class="pagination">
                                    <ul>
                                        <li><a href="#" class="ripple-effect current-page">1</a></li>
                                        <li><a href="#" class="ripple-effect">2</a></li>
                                        <li><a href="#" class="ripple-effect">3</a></li>
                                        <li class="pagination-arrow"><a href="#" class="ripple-effect"><i
                                                    class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Pagination / End -->

                        </div>

                        <!-- Dashboard Box -->
                        <div class="col-xl-6">
                            <div class="dashboard-box margin-top-0">

                                <!-- Headline -->
                                <div class="headline">
                                    <h3><i class="icon-material-outline-face"></i> Rate Freelancers</h3>
                                </div>

                                <div class="content">
                                    <ul class="dashboard-box-list">
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <div class="item-content">
                                                    <h4>Simple Chrome Extension</h4>
                                                    <span class="company-not-rated margin-bottom-5">Not Rated</span>
                                                </div>
                                            </div>

                                            <a href="#small-dialog-2"
                                               class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i
                                                    class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                                        </li>
                                        <li>
                                            <div class="boxed-list-item">
                                                <!-- Content -->
                                                <div class="item-content">
                                                    <h4>Help Fix Laravel PHP issue</h4>
                                                    <div class="item-details margin-top-10">
                                                        <div class="star-rating" data-rating="5.0"></div>
                                                        <div class="detail-item"><i
                                                                class="icon-material-outline-date-range"></i> August
                                                            2019
                                                        </div>
                                                    </div>
                                                    <div class="item-description">
                                                        <p>Excellent programmer - helped me fixing small issue.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#small-dialog-1"
                                               class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10"><i
                                                    class="icon-feather-edit"></i> Edit Review</a>
                                        </li>
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
    @include('layouts.popups.reviewEdit')

    @include('layouts.popups.reviewToFreelancer')

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
@endsection
