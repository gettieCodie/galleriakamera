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
    
     // Replace this with your cart total
    const totalAmountVariable = 18000; // Example

    // --- Helper function: get selected payment method ---
    function getSelectedPaymentMethod() {
        const mainPayment = document.querySelector('input[name="payment_method"]:checked')?.value;
        if (mainPayment === 'cod') {
            return 'COD';
        } else if (mainPayment === 'ewallet') {
            const ewalletSelected = document.querySelector('input[name="ewallet_provider"]:checked')?.value;
            return ewalletSelected ? ewalletSelected.toUpperCase() : 'E-WALLET';
        }
        return 'COD'; // Default fallback
    }

    // --- Helper function: save order + shipping to backend ---
    function saveOrderAndShipping() {
        const data = {
            first_name: document.getElementById("first-name").value,
            last_name: document.getElementById("last-name").value,
            mobile_number: document.getElementById("mobile-number").value,
            alternate_number: document.getElementById("alternate-number").value || null,
            address_line_1: document.getElementById("address-line-1").value,
            address_line_2: document.getElementById("address-line-2").value || null,
            region: document.getElementById("region").value,
            city: document.getElementById("city").value,
            barangay: document.getElementById("barangay").value,
            postal_code: document.getElementById("postal-code").value,
            landmark: document.getElementById("landmark").value || null,
            email: document.getElementById("email").value,
            total_amount: totalAmountVariable,
            payment_method: getSelectedPaymentMethod()
        };

        console.log("Sending data to server:", data); // Debug log

        return fetch("../core/db_shippingadd.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        })
        .then(res => {
            console.log("Response status:", res.status); // Debug log
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(res => {
            console.log("Server response:", res); // Debug log
            if (res.status === "success") {
                console.log("Order & shipping details saved!");
                return true;
            } else {
                console.error("DB Error:", res.message);
                alert("Error saving order: " + res.message);
                return false;
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert("Network error: " + error.message);
            return false;
        });
    }

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
        if (agreeTermsCheckbox.checked) {
            // Disable button to prevent double-clicks
            confirmCodBtn.disabled = true;
            confirmCodBtn.textContent = 'Processing...';
            
            saveOrderAndShipping().then(success => {
                if (success) {
                    showSuccessNotification();
                } else {
                    // Re-enable button if failed
                    confirmCodBtn.disabled = false;
                    confirmCodBtn.textContent = 'Confirm Order';
                }
            });
        }
    });
    
    confirmEwalletBtn.addEventListener('click', function() {
         const ewalletSelected = document.querySelector('input[name="ewallet_provider"]:checked');
        if (ewalletSelected) {
            // Disable button to prevent double-clicks
            confirmEwalletBtn.disabled = true;
            confirmEwalletBtn.textContent = 'Processing...';
            
            saveOrderAndShipping().then(success => {
                if (success) {
                    showSuccessNotification();
                } else {
                    // Re-enable button if failed
                    confirmEwalletBtn.disabled = false;
                    confirmEwalletBtn.textContent = 'Confirm Order';
                }
            });
        } else {
            alert("Please select an E-Wallet provider.");
        }
    });
    
    // Success Notification Handler
    closeNotificationBtn.addEventListener('click', function() {
        successNotification.style.display = 'none';
        // In a real application, you would redirect to the order confirmation page
        window.location.href = '../marketplace.php';
    });
    
    // Function to show success notification
    function showSuccessNotification() {
        successNotification.style.display = 'flex';
        
        // In a real application, you would submit the form data to the server here
        // For now, we'll just log the form data
        // const formData = new FormData(customerDetailsForm);
        // const data = Object.fromEntries(formData);
        // console.log('Order Data:', data);
    }
    
    // Initialize form states
    billingAddressFields.style.display = 'block';
});