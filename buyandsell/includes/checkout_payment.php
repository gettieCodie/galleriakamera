<div class="form-section" id="payment-section" style="display: none;">
    <h2>Payment Method</h2>
    
    <div class="payment-methods">
        <div class="payment-option">
            <input type="radio" id="cod" name="payment_method" value="cod">
            <label for="cod">Cash on Delivery</label>
        </div>
        
        <div class="payment-option">
            <input type="radio" id="ewallet" name="payment_method" value="ewallet">
            <label for="ewallet">E-Wallet</label>
        </div>
    </div>
    
    <!-- Cash on Delivery Content -->
    <div id="cod-content" class="payment-content" style="display: none;">
        <div class="terms-agreement">
            <input type="checkbox" id="agree-terms" name="agree_terms">
            <label for="agree-terms">I agree to the terms and conditions of the store</label>
        </div>
        <button type="button" id="confirm-cod" class="btn-primary" disabled>Confirm Delivery</button>
    </div>
    
    <!-- E-Wallet Content -->
    <div id="ewallet-content" class="payment-content" style="display: none;">
        <div class="ewallet-options">
            <div class="ewallet-option">
                <input type="radio" id="gcash" name="ewallet_provider" value="gcash">
                <label for="gcash">GCash</label>
            </div>
            <div class="ewallet-option">
                <input type="radio" id="paymaya" name="ewallet_provider" value="paymaya">
                <label for="paymaya">PayMaya</label>
            </div>
            <div class="ewallet-option">
                <input type="radio" id="maribank" name="ewallet_provider" value="maribank">
                <label for="maribank">Maribank</label>
            </div>
        </div>
        <button type="button" id="confirm-ewallet" class="btn-primary" disabled>Confirm Payment</button>
    </div>
</div>
