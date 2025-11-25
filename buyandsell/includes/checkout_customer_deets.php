<div class="form-section" id="customer-details-section">
    <h2>Customer Details</h2>
    
    <form id="customer-details-form">
        <div class="form-group">
            <label for="first-name">First Name *</label>
            <input type="text" id="first-name" name="first_name" required>
        </div>
        
        <div class="form-group">
            <label for="last-name">Last Name *</label>
            <input type="text" id="last-name" name="last_name" required>
        </div>
        
        <div class="form-group">
            <label for="mobile-number">Mobile Number *</label>
            <div class="phone-input">
                <span class="country-code">+63</span>
                <input type="tel" id="mobile-number" name="mobile_number" pattern="[9]\d{9}" placeholder="9XXXXXXXXX" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="alternate-number">Alternate Number (Optional)</label>
            <div class="phone-input">
                <span class="country-code">+63</span>
                <input type="tel" id="alternate-number" name="alternate_number" pattern="[9]\d{9}" placeholder="XXXXXXXXXX">
            </div>
        </div>
        
        <h3>Delivery Address</h3>
        
        <div class="form-group">
            <label for="address-line-1">Address Line 1 *</label>
            <input type="text" id="address-line-1" name="address_line_1" required>
        </div>
        
        <div class="form-group">
            <label for="address-line-2">Address Line 2 (Optional)</label>
            <input type="text" id="address-line-2" name="address_line_2">
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="region">Region *</label>
                <input type="text" id="region" name="region" placeholder="Enter your region" required>
            </div>
            
            <div class="form-group">
                <label for="city">City/Municipality *</label>
                <input type="text" id="city" name="city" placeholder="Enter your city or municipality" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="barangay">Barangay *</label>
                <input type="text" id="barangay" name="barangay" 
                    placeholder="Enter your barangay name" required>
            </div>
            
            <div class="form-group">
                <label for="postal-code">Postal Code *</label>
                <input type="text" id="postal-code" name="postal_code" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="landmark">Landmark (Optional)</label>
            <input type="text" id="landmark" name="landmark">
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <h3>Billing Address</h3>
        
        <div class="form-group checkbox-group">
            <input type="checkbox" id="same-as-delivery" name="same_as_delivery">
            <label for="same-as-delivery">Same as delivery address</label>
        </div>
        
        <div id="billing-address-fields">
            <div class="form-group">
                <label for="billing-first-name">First Name *</label>
                <input type="text" id="billing-first-name" name="billing_first_name">
            </div>
            
            <div class="form-group">
                <label for="billing-last-name">Last Name *</label>
                <input type="text" id="billing-last-name" name="billing_last_name">
            </div>
            
            <div class="form-group">
                <label for="billing-mobile-number">Mobile Number *</label>
                <div class="phone-input">
                    <span class="country-code">+63</span>
                    <input type="tel" id="billing-mobile-number" name="billing_mobile_number" pattern="[9]\d{9}" placeholder="9XXXXXXXXX">
                </div>
            </div>
            
            <div class="form-group">
                <label for="billing-alternate-number">Alternate Number (Optional)</label>
                <div class="phone-input">
                    <span class="country-code">+63</span>
                    <input type="tel" id="billing-alternate-number" name="billing_alternate_number" pattern="[9]\d{9}" placeholder="XXXXXXXXXX">
                </div>
            </div>
            
            <div class="form-group">
                <label for="tax-id">Tax ID No. (TIN) (Optional)</label>
                <input type="text" id="tax-id" name="tax_id">
            </div>
            
            <div class="form-group">
                <label for="business-name">Registered Business Name (Optional)</label>
                <input type="text" id="business-name" name="business_name">
            </div>
            
            <div class="form-group">
                <label for="business-style">Business name/style (Optional)</label>
                <input type="text" id="business-style" name="business_style">
            </div>
            
            <div class="form-group">
                <label for="business-address-line-1">Registered Business Address Line 1 *</label>
                <input type="text" id="business-address-line-1" name="business_address_line_1">
            </div>
            
            <div class="form-group">
                <label for="business-address-line-2">Registered Business Address Line 2 (Optional)</label>
                <input type="text" id="business-address-line-2" name="business_address_line_2">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="business-region">Region *</label>
                    <select id="business-region" name="business_region">
                        <option value="">Select Region</option>
                        <!-- Regions will be populated dynamically -->
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="business-city">City *</label>
                    <select id="business-city" name="business_city">
                        <option value="">Select City</option>
                        <!-- Cities will be populated based on region selection -->
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="business-barangay">Barangay *</label>
                    <input type="text" id="business-barangay" name="business_barangay" 
                        placeholder="Enter your barangay name" required>
                </div>
                
                <div class="form-group">
                    <label for="business-postal-code">Postal Code *</label>
                    <input type="text" id="business-postal-code" name="business_postal_code">
                </div>
            </div>
            
            <div class="form-group">
                <label for="business-landmark">Landmark (Optional)</label>
                <input type="text" id="business-landmark" name="business_landmark">
            </div>
            
            <div class="form-group">
                <label for="business-email">Email *</label>
                <input type="email" id="business-email" name="business_email">
            </div>
        </div>
        
        <button type="button" id="continue-to-payment" class="btn-primary">Continue to Payment</button>
    </form>
</div>

<!-- Customer Details Card (Hidden initially) -->
<div id="customer-details-card" class="customer-details-card" style="display: none;">
    <div class="card-header">
        <h3>Customer Details</h3>
        <button type="button" id="edit-customer-details" class="btn-edit">Edit</button>
    </div>
    <div class="card-content">
        <p><strong>Name:</strong> <span id="card-customer-name"></span></p>
        <p><strong>Mobile:</strong> <span id="card-customer-mobile"></span></p>
        <p><strong>Address:</strong> <span id="card-customer-address"></span></p>
        <p><strong>Email:</strong> <span id="card-customer-email"></span></p>
    </div>
</div>