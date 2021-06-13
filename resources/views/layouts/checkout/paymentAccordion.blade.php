<!-- Payment Methods Accordion -->
<div class="payment margin-top-30">
    <div class="payment-tab payment-tab-active">
        <div class="payment-tab-trigger">
            <input checked id="paypal" name="cardType" type="radio" value="paypal">
            <label for="paypal">PayPal</label>
            <img class="payment-logo paypal" src="https://i.imgur.com/ApBxkXU.png" alt="">
        </div>

        <div class="payment-tab-content">
            <p>You will be redirected to PayPal to complete payment.</p>
        </div>
    </div>

    <div class="payment-tab">
        <div class="payment-tab-trigger">
            <input type="radio" name="cardType" id="creditCart" value="creditCard">
            <label for="creditCart">Credit / Debit Card</label>
            <img class="payment-logo" src="https://i.imgur.com/IHEKLgm.png" alt="">
        </div>

        <div class="payment-tab-content">
            <div class="row payment-form-row">

                <div class="col-md-6">
                    <div class="card-label">
                        <input id="nameOnCard" name="nameOnCard" required type="text" placeholder="Cardholder Name">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-label">
                        <input id="cardNumber" name="cardNumber" placeholder="Credit Card Number" required type="text">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-label">
                        <input id="expiryDate" placeholder="Expiry Month" required type="text">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-label">
                        <label for="expiryDate">Expiry Year</label>
                        <input id="expirynDate" placeholder="Expiry Year" required type="text">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-label">
                        <input id="cvv" required type="text" placeholder="CVV">
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- Payment Methods Accordion / End -->
