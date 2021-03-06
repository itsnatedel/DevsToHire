<!-- Edit Review Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab1">

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Change Review</h3>
                    <span>Rate <a href="#">Herman Ewout</a> for the project <a href="#">WordPress Theme Installation</a> </span>
                </div>

                <!-- Form -->
                <form method="post" id="change-review-form">

                    <div class="feedback-yes-no">
                        <strong>Was this delivered on budget?</strong>
                        <div class="radio">
                            <input id="radio-rating-1" name="radio" type="radio" checked>
                            <label for="radio-rating-1"><span class="radio-label"></span> Yes</label>
                        </div>

                        <div class="radio">
                            <input id="radio-rating-2" name="radio" type="radio">
                            <label for="radio-rating-2"><span class="radio-label"></span> No</label>
                        </div>
                    </div>

                    <div class="feedback-yes-no">
                        <strong>Was this delivered on time?</strong>
                        <div class="radio">
                            <input id="radio-rating-3" name="radio2" type="radio" checked>
                            <label for="radio-rating-3"><span class="radio-label"></span> Yes</label>
                        </div>

                        <div class="radio">
                            <input id="radio-rating-4" name="radio2" type="radio">
                            <label for="radio-rating-4"><span class="radio-label"></span> No</label>
                        </div>
                    </div>

                    <div class="feedback-yes-no">
                        <strong>Your Rating</strong>
                        <div class="leave-rating">
                            <input type="radio" name="rating" id="rating-1" value="1" checked/>
                            <label for="rating-1" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-2" value="2"/>
                            <label for="rating-2" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-3" value="3"/>
                            <label for="rating-3" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-4" value="4"/>
                            <label for="rating-4" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-5" value="5"/>
                            <label for="rating-5" class="icon-material-outline-star"></label>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <textarea class="with-border" placeholder="Comment" name="message" id="message" cols="7" required>Excellent programmer - helped me fixing small issue.</textarea>
                </form>
                <!-- Button -->
                <button class="button full-width button-sliding-icon ripple-effect" type="submit"
                        form="change-review-form">Save Changes <i class="icon-material-outline-arrow-right-alt"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Review Popup / End -->
