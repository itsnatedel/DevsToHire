<!-- Leave a Review Popup
    ================================================== -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a href="#tab">Leave a Review</a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>What is it like to work at {{ $company->name }}?</h3>
                    <!-- Form -->
                    <form method="post" action="{{ route('company.rate', $company->id) }}" id="leave-company-review-form">
                        @csrf
                        <!-- Leave Rating -->
                            <input type="hidden" name="freelancerId" value="{{ Auth::user()->freelancer_id ?? Auth::id()  }}">
                            <input type="hidden" name="roleId" value="{{ Auth::user()->role_id ?? null  }}">
                        <div class="clearfix"></div>
                        <div class="leave-rating-container">
                            <div class="leave-rating margin-bottom-5">
                                <input type="radio" name="rating" id="rating-1" value="5" required>
                                <label for="rating-1" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-2" value="4" required>
                                <label for="rating-2" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-3" value="3" required>
                                <label for="rating-3" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-4" value="2" required>
                                <label for="rating-4" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-5" value="1" required>
                                <label for="rating-5" class="icon-material-outline-star"></label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- Leave Rating / End-->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="input-with-icon-left" title="Leave blank to add review anonymously"
                                     data-tippy-placement="bottom">
                                    <i class="icon-material-outline-account-circle"></i>
                                    <input type="text" class="input-text with-border"
                                           name="name" id="name"
                                           value="{{ old('name') ?? Auth::user()->firstname . ' ' . Auth::user()->lastname }}"
                                           placeholder="First and Last Name"
                                    />
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="input-with-icon-left">
                                    <i class="icon-material-outline-rate-review"></i>
                                    <input type="text" class="input-text with-border" name="reviewTitle"
                                           id="reviewTitle"
                                           placeholder="Review Title"
                                           value="{{ old('reviewTitle') }}" required/>
                                </div>
                            </div>
                        </div>

                        <textarea class="with-border" placeholder="Review" name="comment" id="message" cols="7"
                                  required></textarea>
                    </form>
                    <!-- Button -->
                    <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                            form="leave-company-review-form">Leave a Review <i
                            class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Leave a Review Popup / End -->