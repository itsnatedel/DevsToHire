<!-- Edit Bid Popup
================================================== -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a href="#tab">Edit Bid</a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <!-- Bidding -->
                <div class="bidding-widget">
                    <!-- Headline -->
                    <span class="bidding-detail">Set your <strong>minimal payment rate in €</strong> (Previous : <b><span id="biddingVal"></span> €)</b></span>
                    <!-- Price Slider -->
                    <form action="{{ route('dashboard.bid.edit') }}" method="post">
                        @csrf
                        <input type="hidden" name="bidId" id="bidId">
                        <div class="bidding-value">
                            <input type="number" min="" max="" name="price" value="" id="price">
                        </div>
                        <!-- Headline -->
                        <span class="bidding-detail margin-top-30">Set your <strong>delivery time</strong> (Previous : <b><span id="oldDelivery"></span></b>)</span>
                        <!-- Fields -->
                        <div class="bidding-fields">
                            <div class="bidding-field">
                                <!-- Quantity Buttons -->
                                <div class="qtyButtons with-border">
                                    <div class="qtyDec"></div>
                                    <input type="text" id="amountDays" name="time" placeholder="2">
                                    <div class="qtyInc"></div>
                                </div>
                            </div>
                            <div class="bidding-field">
                                <select id="timePicker" name="period" class="selectpicker default with-border">
                                    <option value="days">Days</option>
                                    <option value="hours">Hours</option>
                                </select>
                            </div>
                            <div class="bidding-field">

                            </div>
                        </div>

                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save Changes
                            <i class="icon-material-outline-arrow-right-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Bid Popup / End -->