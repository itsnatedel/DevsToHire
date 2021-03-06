<!-- Bid Acceptance Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a href="#tab1">Accept Offer</a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Accept Offer From David</h3>
                    <div class="bid-acceptance margin-top-15">
                        $3200
                    </div>
                </div>
                <form id="terms">
                    <div class="radio">
                        <input id="radio-1" name="radio" type="radio" required>
                        <label for="radio-1"><span class="radio-label"></span> I have read and agree to the <a
                                    href="{{ route('terms') }}">Terms and
                                Conditions</a></label>
                    </div>
                </form>
                <!-- Button -->
                <button class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit"
                        form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>

        </div>
    </div>
</div>
<!-- Bid Acceptance Popup / End -->