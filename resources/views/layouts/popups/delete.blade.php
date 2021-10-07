<!-- Leave a Review Popup
    ================================================== -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a href="#tab">Deleting job offer</a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Are you sure you want to delete that offer ?</h3>
                    <!-- Form -->
                    <form method="post" action="{{ route('dashboard.job.delete') }}" id="leave-company-review-form">
                    @csrf
                    <!-- Leave Rating -->
                        <input type="hidden" name="companyId" value="{{ Auth::user()->company_id  }}">
                        <input type="hidden" id="jobId" name="jobId">
                        <button class="button red margin-top-35 full-width button-sliding-icon ripple-effect-dark"
                                type="submit">
                            Confirm deletion<i
                                    class="icon-material-outline-arrow-right-alt"></i>
                        </button>
                    </form>
                    <!-- Button -->
                    <button class="button dark margin-top-35 ripple-effect"
                            name="cancel"
                            id="cancelBtn">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let cancelButton = document.getElementById('cancelBtn');

    let clickEvent = new MouseEvent("click", {
        "view": window,
        "bubbles": true
    });

    cancelButton.addEventListener('click', () => {
        let closePopup = document.getElementsByClassName('mfp-close')[0];
        closePopup.dispatchEvent(clickEvent);
    })

</script>
<!-- Leave a Review Popup / End -->