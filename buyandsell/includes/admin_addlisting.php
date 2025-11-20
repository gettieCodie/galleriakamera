<!-- Add Listing Button -->
<button id="addListingBtn">Add New Camera Listing</button>

<!-- Modal Form -->
<div id="listingModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Add Camera Listing</h2>
    
    <!-- Success/Error Message Container -->
    <div id="messageContainer" style="display: none; padding: 10px; margin: 10px 0; border-radius: 4px;"></div>
    
    <form id="cameraForm" enctype="multipart/form-data">
      <label>Brand:</label>
      <input type="text" name="brand" required><br>

      <label>Model:</label>
      <input type="text" name="model" required><br>

      <label>Description:</label>
      <textarea name="description" required></textarea><br>

      <label>Megapixels:</label>
      <input type="number" name="megapixels" min="1" required><br>

      <label>Sensor:</label>
      <input type="text" name="sensor" required><br>

      <label>Condition:</label>
      <select name="condition" required>
        <option value="New">New</option>
        <option value="Used">Used</option>
      </select><br>

      <label>Original Price:</label>
      <input type="number" name="original_price" min="0.01" step="0.01" required><br>

      <label>Selling Price:</label>
      <input type="number" name="selling_price" min="0.01" step="0.01" required><br>

      <label>Upload Images (6 max, JPG/PNG, max 2MB each):</label>
      <input type="file" name="images[]" accept=".jpg,.jpeg,.png" multiple required><br><br>

      <button type="submit" name="submit">Add Listing</button>
      <button type="button" id="cancelBtn">Cancel</button>
    </form>
  </div>
</div>

<!-- Modal Styles -->
<style>
.modal {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;
  z-index: 1000;
}
.modal-content {
  background: #fff; padding: 20px; border-radius: 5px; width: 500px; 
  max-height: 90vh; overflow-y: auto; position: relative;
}
.close { 
  position: absolute; top: 10px; right: 15px; cursor: pointer; 
  font-size: 24px; font-weight: bold;
}
.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>

<!-- Modal JS with AJAX -->
<script>
const modal = document.getElementById('listingModal');
const btn = document.getElementById('addListingBtn');
const span = document.getElementsByClassName('close')[0];
const cancel = document.getElementById('cancelBtn');
const form = document.getElementById('cameraForm');
const messageContainer = document.getElementById('messageContainer');

// Show modal
btn.onclick = () => {
  modal.style.display = 'flex';
  resetForm();
};

// Hide modal
span.onclick = cancel.onclick = () => {
  modal.style.display = 'none';
  resetForm();
};

// Hide modal when clicking outside
window.onclick = (e) => { 
  if (e.target == modal) {
    modal.style.display = 'none';
    resetForm();
  }
};

// Form submission with AJAX
form.addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const submitButton = this.querySelector('button[type="submit"]');
  
  // Disable submit button and show loading state
  submitButton.disabled = true;
  submitButton.textContent = 'Adding...';
  hideMessage();

  fetch('core/upload_listings.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showMessage(data.message, 'success');
      form.reset();
      // Optional: Redirect or refresh listings after success
      setTimeout(() => {
        modal.style.display = 'none';
        resetForm();
        // You can add code here to refresh the listings display
      }, 2000);
    } else {
      showMessage(data.errors.join('<br>'), 'error');
    }
  })
  .catch(error => {
    showMessage('An error occurred while submitting the form.', 'error');
    console.error('Error:', error);
  })
  .finally(() => {
    submitButton.disabled = false;
    submitButton.textContent = 'Add Listing';
  });
});

// Helper functions
function showMessage(message, type) {
  messageContainer.innerHTML = message;
  messageContainer.className = type;
  messageContainer.style.display = 'block';
}

function hideMessage() {
  messageContainer.style.display = 'none';
}

function resetForm() {
  form.reset();
  hideMessage();
}
</script>