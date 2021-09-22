<!-- Apply for a job popup -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Apply Now</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Let <strong>{{ $job->name }}</strong> know you're interested in getting this job!</h3>
                </div>

                <!-- Form -->
                <form method="post" id="apply-now-form" action="{{ route('apply.job', $job->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-with-icon-left">
                        <input type="hidden" value="{{ Auth::user()->id }}" name="candidateId">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="text" class="input-text with-border" name="name" id="name" placeholder="First and Last Name"
                               @auth
                                       value="{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}"
                               @endauth
                               required/>
                    </div>

                    <div class="input-with-icon-left">
                        <i class="icon-material-baseline-mail-outline"></i>
                        <input type="text" class="input-text with-border" name="email" id="emailaddress" placeholder="Email Address"
                               @auth
                               value="{{ Auth::user()->email }}"
                               @endauth
                               required/>
                    </div>

                    <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                            form="apply-now-form">Apply Now <i class="icon-material-outline-arrow-right-alt"></i>
                    </button>

                </form>

                <!-- Button -->

            </div>

        </div>
    </div>
</div>
<!-- Apply for a job popup / End -->