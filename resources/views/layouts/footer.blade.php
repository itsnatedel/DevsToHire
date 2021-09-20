<!-- Footer
        ================================================== -->
<div id="footer">

    <!-- Footer Top Section -->
    <div class="footer-top-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Footer Rows Container -->
                    <div class="footer-rows-container">

                        <!-- Left Side -->
                        <div class="footer-rows-left">
                            <div class="footer-row">
                                <div class="footer-row-inner footer-logo">
                                    <img src="{{ asset('images/logo2.png') }}" alt="Logo">
                                </div>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="footer-rows-right">

                            <!-- Social Icons -->
                            <div class="footer-row">
                                <div class="footer-row-inner">
                                    <ul class="footer-social-links">
                                        <li>
                                            <a href="https://www.facebook.com/" title="Facebook" target="_blank" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" title="Twitter" target="_blank" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/" title="Instagram" target="_blank" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-instagram"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" title="LinkedIn" target="_blank" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-linkedin-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <!-- Language Switcher -->
                            <div class="footer-row">
                                <div class="footer-row-inner">
                                    <select class="selectpicker language-switcher"
                                            data-selected-text-format="count"
                                            data-size="5">
                                        <option selected>English</option>
                                        <option>Français</option>
                                        <option>Español</option>
                                        <option>Deutsch</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Footer Rows Container / End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top Section / End -->

    <!-- Footer Middle Section -->
    <div class="footer-middle-section">
        <div class="container">
            <div class="row">

                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>For Candidates</h3>
                        <ul>
                            <li><a href="{{ route('job.index') }}"><span>Browse Jobs</span></a></li>
                            <li><a href="{{ route('task.index') }}"><span>Browse Tasks</span></a></li>
                            <li><a href="{{ route('dashboard.bookmarks') }}"><span>My Bookmarks</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>For Employers</h3>
                        <ul>
                            <li><a href="{{ route('dashboard.candidates') }}"><span>Browse Candidates</span></a></li>
                            <li><a href="{{ route('dashboard.job.create') }}"><span>Post a Job</span></a></li>
                            <li><a href="{{ route('dashboard.task.create') }}"><span>Post a Task</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>Helpful Links</h3>
                        <ul>
                            <li><a href="{{ route('premium.index') }}"><span>Plans & Pricing</span></a></li>
                            <li><a href="{{ route('contact') }}"><span>Contact</span></a></li>
                            <li><a href="{{ route('terms') }}"><span>Terms of Use</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>Account</h3>
                        <ul>
                            @guest
                                <li><a href="{{ route('login') }}"><span>Log In</span></a></li>
                                <li><a href="{{ route('register') }}"><span>Register</span></a></li>
                            @endguest
                            @auth
                                <li><a href="{{ route('dashboard.index') }}"><span>My Account</span></a></li>
                            @endauth
                        </ul>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
                    <p>Weekly breaking news, analysis and cutting edge advices on job searching.</p>
                    <form action="#" method="get" class="newsletter">
                        <input type="text" name="fname" placeholder="Enter your email address">
                        <button type="submit"><i class="icon-feather-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Middle Section / End -->

    <!-- Footer Copyrights -->
    <div class="footer-bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    © 2021 <strong>DevsToHire</strong>. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Copyrights / End -->
</div>
<!-- Footer / End -->