document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const customerDetailsForm = document.getElementById('customer-details-form');
    const continueToPaymentBtn = document.getElementById('continue-to-payment');
    const customerDetailsSection = document.getElementById('customer-details-section');
    const customerDetailsCard = document.getElementById('customer-details-card');
    const editCustomerDetailsBtn = document.getElementById('edit-customer-details');
    const paymentSection = document.getElementById('payment-section');
    const sameAsDeliveryCheckbox = document.getElementById('same-as-delivery');
    const billingAddressFields = document.getElementById('billing-address-fields');
    
    // Payment method elements
    const codRadio = document.getElementById('cod');
    const ewalletRadio = document.getElementById('ewallet');
    const codContent = document.getElementById('cod-content');
    const ewalletContent = document.getElementById('ewallet-content');
    const agreeTermsCheckbox = document.getElementById('agree-terms');
    const confirmCodBtn = document.getElementById('confirm-cod');
    const confirmEwalletBtn = document.getElementById('confirm-ewallet');
    
    // Success notification
    const successNotification = document.getElementById('success-notification');
    const closeNotificationBtn = document.getElementById('close-notification');
    
    // Continue to Payment Button Handler
    continueToPaymentBtn.addEventListener('click', function() {
        if (customerDetailsForm.checkValidity()) {
            // Populate customer details card
            document.getElementById('card-customer-name').textContent = 
                document.getElementById('first-name').value + ' ' + 
                document.getElementById('last-name').value;
            document.getElementById('card-customer-mobile').textContent = 
                '+63 ' + document.getElementById('mobile-number').value;
            document.getElementById('card-customer-address').textContent = 
                document.getElementById('address-line-1').value + ', ' + 
                document.getElementById('city').value;
            document.getElementById('card-customer-email').textContent = 
                document.getElementById('email').value;
            
            // Hide form, show card and payment section
            customerDetailsSection.style.display = 'none';
            customerDetailsCard.style.display = 'block';
            paymentSection.style.display = 'block';
        } else {
            customerDetailsForm.reportValidity();
        }
    });
    
    // Edit Customer Details Button Handler
    editCustomerDetailsBtn.addEventListener('click', function() {
        customerDetailsCard.style.display = 'none';
        customerDetailsSection.style.display = 'block';
        paymentSection.style.display = 'none';
    });
    
    // Same as Delivery Address Checkbox Handler
    sameAsDeliveryCheckbox.addEventListener('change', function() {
        if (this.checked) {
            billingAddressFields.style.display = 'none';
            
            // Copy delivery address to billing address
            document.getElementById('billing-first-name').value = 
                document.getElementById('first-name').value;
            document.getElementById('billing-last-name').value = 
                document.getElementById('last-name').value;
            document.getElementById('billing-mobile-number').value = 
                document.getElementById('mobile-number').value;
            document.getElementById('billing-alternate-number').value = 
                document.getElementById('alternate-number').value;
            document.getElementById('business-address-line-1').value = 
                document.getElementById('address-line-1').value;
            document.getElementById('business-address-line-2').value = 
                document.getElementById('address-line-2').value;
            document.getElementById('business-region').value = 
                document.getElementById('region').value;
            document.getElementById('business-city').value = 
                document.getElementById('city').value;
            document.getElementById('business-barangay').value = 
                document.getElementById('barangay').value;
            document.getElementById('business-postal-code').value = 
                document.getElementById('postal-code').value;
            document.getElementById('business-landmark').value = 
                document.getElementById('landmark').value;
            document.getElementById('business-email').value = 
                document.getElementById('email').value;
        } else {
            billingAddressFields.style.display = 'block';
        }
    });
    
    // Payment Method Selection Handlers
    codRadio.addEventListener('change', function() {
        if (this.checked) {
            codContent.style.display = 'block';
            ewalletContent.style.display = 'none';
        }
    });
    
    ewalletRadio.addEventListener('change', function() {
        if (this.checked) {
            ewalletContent.style.display = 'block';
            codContent.style.display = 'none';
        }
    });
    
    // Terms Agreement Handler
    agreeTermsCheckbox.addEventListener('change', function() {
        confirmCodBtn.disabled = !this.checked;
    });
    
    // E-Wallet Provider Selection Handler
    document.querySelectorAll('input[name="ewallet_provider"]').forEach(radio => {
        radio.addEventListener('change', function() {
            confirmEwalletBtn.disabled = !document.querySelector('input[name="ewallet_provider"]:checked');
        });
    });
    
    // Confirm Order Handlers
    confirmCodBtn.addEventListener('click', function() {
        showSuccessNotification();
    });
    
    confirmEwalletBtn.addEventListener('click', function() {
        showSuccessNotification();
    });
    
    // Success Notification Handler
    closeNotificationBtn.addEventListener('click', function() {
        successNotification.style.display = 'none';
        // In a real application, you would redirect to the order confirmation page
        // window.location.href = 'order-confirmation.php';
    });
    
    // Function to show success notification
    function showSuccessNotification() {
        successNotification.style.display = 'flex';
        
        // In a real application, you would submit the form data to the server here
        // For now, we'll just log the form data
        const formData = new FormData(customerDetailsForm);
        const data = Object.fromEntries(formData);
        console.log('Order Data:', data);
    }
    
    // Initialize form states
    billingAddressFields.style.display = 'block';
});