
<!-- Modal Form -->
<div id="listingModal" class="listing-modal" style="display:none;">
  <div class="listing-modal-overlay"></div>
  <div class="listing-modal-content">
    <!-- Header -->
    <div class="listing-modal-header">
      <div class="listing-modal-title-section">
        <h2 class="listing-modal-title">Add Camera Listing</h2>
        <p class="listing-modal-subtitle">Upload a new camera to your inventory</p>
      </div>
      <button class="listing-modal-close" id="listingModalClose">&times;</button>
    </div>

    <!-- Message Container -->
    <div id="messageContainer" class="listing-message-container" style="display: none;"></div>

    <!-- Form -->
    <form id="cameraForm" enctype="multipart/form-data" class="listing-form">
      
      <!-- Camera Info Section -->
      <div class="listing-form-section">
        <h3 class="listing-section-title">Camera Information</h3>
        <div class="listing-form-grid-2">
          <div class="listing-form-group">
            <label for="brand" class="listing-label">Brand <span class="listing-required">*</span></label>
            <input type="text" id="brand" name="brand" class="listing-input" placeholder="e.g., Sony, Canon, Nikon" required>
          </div>

          <div class="listing-form-group">
            <label for="model" class="listing-label">Model <span class="listing-required">*</span></label>
            <input type="text" id="model" name="model" class="listing-input" placeholder="e.g., A7 III, EOS R5" required>
          </div>
        </div>

        <div class="listing-form-group">
          <label for="description" class="listing-label">Description <span class="listing-required">*</span></label>
          <textarea id="description" name="description" class="listing-textarea" placeholder="Describe the camera, condition, features, and any defects..." rows="4" required></textarea>
        </div>
      </div>

      <!-- Specifications Section -->
      <div class="listing-form-section">
        <h3 class="listing-section-title">Specifications</h3>
        <div class="listing-form-grid-2">
          <div class="listing-form-group">
            <label for="megapixels" class="listing-label">Megapixels <span class="listing-required">*</span></label>
            <input type="number" id="megapixels" name="megapixels" class="listing-input" placeholder="e.g., 24" min="1" required>
          </div>

          <div class="listing-form-group">
            <label for="sensor" class="listing-label">Sensor <span class="listing-required">*</span></label>
            <input type="text" id="sensor" name="sensor" class="listing-input" placeholder="e.g., Full-frame, APS-C" required>
          </div>
        </div>

        <div class="listing-form-group">
          <label for="condition" class="listing-label">Condition <span class="listing-required">*</span></label>
          <select id="condition" name="condition" class="listing-input listing-select" required>
            <option value="">Select condition...</option>
            <option value="New">New</option>
            <option value="Like New">Like New</option>
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Fair">Fair</option>
            <option value="Used">Used</option>
          </select>
        </div>
      </div>

      <!-- Pricing Section -->
      <div class="listing-form-section">
        <h3 class="listing-section-title">Pricing</h3>
        <div class="listing-form-grid-2">
          <div class="listing-form-group">
            <label for="original_price" class="listing-label">Original Price <span class="listing-required">*</span></label>
            <div class="listing-input-prefix">
              <span class="listing-currency">₱</span>
              <input type="number" id="original_price" name="original_price" class="listing-input" placeholder="0.00" min="0.01" step="0.01" required>
            </div>
          </div>

          <div class="listing-form-group">
            <label for="selling_price" class="listing-label">Selling Price <span class="listing-required">*</span></label>
            <div class="listing-input-prefix">
              <span class="listing-currency">₱</span>
              <input type="number" id="selling_price" name="selling_price" class="listing-input" placeholder="0.00" min="0.01" step="0.01" required>
            </div>
          </div>
        </div>
      </div>

      <!-- Images Section -->
      <div class="listing-form-section">
        <h3 class="listing-section-title">Product Images</h3>
        <div class="listing-form-group">
          <label for="images" class="listing-label">Upload Images <span class="listing-required">*</span></label>
          <p class="listing-helper-text">Maximum 6 images, JPG or PNG format, up to 2MB each</p>
          
          <div class="listing-file-upload">
            <input type="file" id="images" name="images[]" class="listing-file-input" accept=".jpg,.jpeg,.png" multiple required>
            <div class="listing-file-zone">
              <div class="listing-file-icon">
                <i class="fas fa-cloud-upload-alt"></i>
              </div>
              <p class="listing-file-text">
                <span class="listing-file-primary">Click to upload</span> or drag and drop
              </p>
              <p class="listing-file-hint">JPG, PNG up to 2MB (6 files max)</p>
            </div>
            <div class="listing-file-preview" id="filePreview"></div>
          </div>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="listing-form-actions">
        <button type="button" id="cancelBtn" class="listing-btn listing-btn-secondary">Cancel</button>
        <button type="submit" name="submit" class="listing-btn listing-btn-primary">
          <i class="fas fa-plus"></i>
          <span>Add Listing</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Styles -->
<style>
/* Modal Overlay */
.listing-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
}

.listing-modal-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
}

/* Modal Content */
.listing-modal-content {
  position: relative;
  background: white;
  border-radius: 16px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  width: 95%;
  max-width: 700px;
  max-height: 90vh;
  overflow-y: auto;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Modal Header */
.listing-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 32px 32px 24px;
  border-bottom: 1px solid #e5e7eb;
  background: linear-gradient(135deg, #f5f6f7 0%, #f0f2f5 100%);
}

.listing-modal-title-section {
  flex: 1;
}

.listing-modal-title {
  font-size: 28px;
  font-weight: 700;
  color: #111;
  margin: 0 0 8px;
}

.listing-modal-subtitle {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
}

.listing-modal-close {
  background: none;
  border: none;
  font-size: 32px;
  color: #999;
  cursor: pointer;
  padding: 0;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  transition: all 0.2s ease;
}

.listing-modal-close:hover {
  color: #111;
  background: #f0f2f5;
}

/* Message Container */
.listing-message-container {
  margin: 20px 32px 0;
  padding: 14px 16px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 500;
  animation: slideDown 0.3s ease;
}

.listing-message-container.success {
  background: #ecfdf5;
  color: #047857;
  border: 1px solid #d1fae5;
}

.listing-message-container.error {
  background: #fef2f2;
  color: #dc2626;
  border: 1px solid #fecaca;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Form */
.listing-form {
  padding: 32px;
}

/* Form Sections */
.listing-form-section {
  margin-bottom: 32px;
}

.listing-form-section:last-of-type {
  margin-bottom: 8px;
}

.listing-section-title {
  font-size: 16px;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 20px;
  padding-bottom: 12px;
  border-bottom: 2px solid #e5e7eb;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Form Grid */
.listing-form-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

@media (max-width: 600px) {
  .listing-form-grid-2 {
    grid-template-columns: 1fr;
  }
}

/* Form Group */
.listing-form-group {
  margin-bottom: 0;
}

.listing-label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 8px;
}

.listing-required {
  color: #ef4444;
}

.listing-helper-text {
  font-size: 13px;
  color: #6b7280;
  margin: 0 0 12px;
}

/* Inputs */
.listing-input,
.listing-textarea {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid #dde1e6;
  border-radius: 10px;
  font-size: 14px;
  font-family: inherit;
  color: #1f2937;
  transition: all 0.2s ease;
  background: #fff;
}

.listing-input::placeholder,
.listing-textarea::placeholder {
  color: #9ca3af;
}

.listing-input:focus,
.listing-textarea:focus {
  outline: none;
  border-color: #111;
  box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.1);
  background: #fff;
}

.listing-textarea {
  resize: vertical;
  min-height: 100px;
}

.listing-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%231f2937' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  padding-right: 40px;
  cursor: pointer;
}

/* Input with Prefix */
.listing-input-prefix {
  position: relative;
  display: flex;
  align-items: center;
}

.listing-currency {
  position: absolute;
  left: 16px;
  font-weight: 600;
  color: #6b7280;
  font-size: 14px;
  pointer-events: none;
}

.listing-input-prefix .listing-input {
  padding-left: 32px;
}

/* File Upload */
.listing-file-upload {
  position: relative;
}

.listing-file-input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
  z-index: 10;
}

.listing-file-zone {
  border: 2px dashed #dde1e6;
  border-radius: 12px;
  padding: 32px 20px;
  text-align: center;
  background: #fafbfc;
  transition: all 0.2s ease;
}

.listing-file-upload:hover .listing-file-zone,
.listing-file-upload.dragover .listing-file-zone {
  border-color: #111;
  background: #f5f6f7;
}

.listing-file-icon {
  font-size: 40px;
  color: #9ca3af;
  margin-bottom: 12px;
  display: block;
}

.listing-file-text {
  margin: 0 0 4px;
  font-size: 15px;
  color: #1f2937;
}

.listing-file-primary {
  font-weight: 600;
  color: #111;
}

.listing-file-hint {
  font-size: 13px;
  color: #6b7280;
  margin: 0;
}

.listing-file-preview {
  margin-top: 16px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
  gap: 12px;
}

.listing-preview-item {
  position: relative;
  border-radius: 8px;
  overflow: hidden;
  background: #f3f4f6;
  aspect-ratio: 1;
}

.listing-preview-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.listing-preview-remove {
  position: absolute;
  top: 4px;
  right: 4px;
  width: 24px;
  height: 24px;
  background: rgba(0, 0, 0, 0.6);
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  font-size: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s ease;
}

.listing-preview-remove:hover {
  background: rgba(0, 0, 0, 0.8);
}

/* Form Actions */
.listing-form-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding-top: 24px;
  border-top: 1px solid #e5e7eb;
  margin-top: 32px;
}

/* Buttons */
.listing-btn {
  padding: 12px 28px;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.listing-btn-primary {
  background: #111;
  color: white;
}

.listing-btn-primary:hover:not(:disabled) {
  background: #374151;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

.listing-btn-primary:disabled {
  background: #9ca3af;
  cursor: not-allowed;
  opacity: 0.7;
}

.listing-btn-secondary {
  background: #f3f4f6;
  color: #1f2937;
  border: 1px solid #dde1e6;
}

.listing-btn-secondary:hover {
  background: #e5e7eb;
  border-color: #bcc1ca;
}

/* Scrollbar Styling */
.listing-modal-content::-webkit-scrollbar {
  width: 8px;
}

.listing-modal-content::-webkit-scrollbar-track {
  background: transparent;
}

.listing-modal-content::-webkit-scrollbar-thumb {
  background: #dde1e6;
  border-radius: 4px;
}

.listing-modal-content::-webkit-scrollbar-thumb:hover {
  background: #bcc1ca;
}

/* Responsive */
@media (max-width: 500px) {
  .listing-modal-content {
    width: 90%;
  }

  .listing-modal-header {
    padding: 24px 20px 16px;
  }

  .listing-form {
    padding: 20px;
  }

  .listing-section-title {
    font-size: 14px;
  }

  .listing-form-section {
    margin-bottom: 24px;
  }

  .listing-modal-title {
    font-size: 24px;
  }
}
</style>

<!-- Modal JS with AJAX -->
<script>
// Admin Dashboard Modal Functionality
function initializeListingModal() {
    const modal = document.getElementById('listingModal');
    const closeBtn = document.getElementById('listingModalClose');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('cameraForm');
    const messageContainer = document.getElementById('messageContainer');
    const fileInput = document.getElementById('images');
    const filePreview = document.getElementById('filePreview');
    const fileZone = document.querySelector('.listing-file-zone');

    // Close modal - X button
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            closeModal();
        });
    }

    // Close modal - Cancel button
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            closeModal();
        });
    }

    // Close modal when clicking overlay
    const overlay = document.querySelector('.listing-modal-overlay');
    if (overlay) {
        overlay.addEventListener('click', function() {
            closeModal();
        });
    }

    // File upload handling
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
        
        // Drag and drop
        const fileUpload = document.querySelector('.listing-file-upload');
        if (fileUpload) {
            fileUpload.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUpload.classList.add('dragover');
            });
            fileUpload.addEventListener('dragleave', () => {
                fileUpload.classList.remove('dragover');
            });
            fileUpload.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUpload.classList.remove('dragover');
                fileInput.files = e.dataTransfer.files;
                handleFileSelect();
            });
        }
    }

    // Form submission with AJAX
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const submitText = submitButton.innerHTML;
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Adding...</span>';
            hideMessage();

            // Determine the correct path based on where the script is running from
            const uploadPath = document.location.pathname.includes('/admin/') 
                ? '../core/upload_listings.php' 
                : 'core/upload_listings.php';
            
            fetch(uploadPath, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showMessage(data.message, 'success');
                    form.reset();
                    filePreview.innerHTML = '';
                    // Reload the page to show the new listing
                    setTimeout(() => {
                        modal.style.display = 'none';
                        resetForm();
                        location.reload(); // Reload to show new listing
                    }, 1500);
                } else {
                    showMessage(data.errors ? data.errors.join('<br>') : 'An error occurred', 'error');
                }
            })
            .catch(error => {
                showMessage('An error occurred while submitting the form.', 'error');
                console.error('Error:', error);
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = submitText;
            });
        });
    }

    // File selection handler
    function handleFileSelect() {
        const files = fileInput.files;
        filePreview.innerHTML = '';
        
        if (files.length === 0) return;
        
        // Validate file count
        if (files.length > 6) {
            showMessage('Maximum 6 images allowed', 'error');
            fileInput.value = '';
            return;
        }

        // Create previews
        Array.from(files).forEach((file, index) => {
            // Validate file type
            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                showMessage('Only JPG and PNG files are allowed', 'error');
                fileInput.value = '';
                filePreview.innerHTML = '';
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showMessage('Each image must be less than 2MB', 'error');
                fileInput.value = '';
                filePreview.innerHTML = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                const previewItem = document.createElement('div');
                previewItem.className = 'listing-preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="listing-preview-remove" onclick="removePreview(this)">×</button>
                `;
                filePreview.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    // Helper functions
    function showMessage(message, type) {
        if (messageContainer) {
            messageContainer.innerHTML = message;
            messageContainer.className = `listing-message-container ${type}`;
            messageContainer.style.display = 'block';
        }
    }

    function hideMessage() {
        if (messageContainer) {
            messageContainer.style.display = 'none';
        }
    }

    function resetForm() {
        if (form) {
            form.reset();
            hideMessage();
            filePreview.innerHTML = '';
        }
    }

    function closeModal() {
        modal.style.display = 'none';
        resetForm();
    }

    // Make closeModal globally available
    window.closeListingModal = closeModal;
}

// Remove preview image
window.removePreview = function(button) {
    button.parentElement.remove();
    document.getElementById('images').value = '';
};

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeListingModal();
});
</script>