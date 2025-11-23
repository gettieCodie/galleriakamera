// User Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();
});

function initializeDashboard() {
    // Initialize modal functionality
    initializeSellItemModal();
    
    // Initialize tab functionality
    initializeStatusTabs();
    
    // Load mock data for demonstration
    loadMockData();
}

// Modal functionality
function initializeSellItemModal() {
    const modal = document.getElementById('sellItemModal');
    const sellBtn = document.getElementById('sellItemBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelSellBtn');
    const form = document.getElementById('sellItemForm');

    // Open modal
    sellBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    // Close modal
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitSellItemForm();
    });
}

// Status tabs functionality
function initializeStatusTabs() {
    const tabs = document.querySelectorAll('.status-tab');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Filter items based on status
            const status = this.getAttribute('data-status');
            filterSellingItems(status);
        });
    });
}

// Mock data for demonstration
function loadMockData() {
    // Mock KPI data
    document.getElementById('total-listed').textContent = '3';
    document.getElementById('pending-review').textContent = '1';
    document.getElementById('total-purchases').textContent = '2';
    document.getElementById('wishlist-count').textContent = '4';

    // Mock selling items
    loadMockSellingItems();
    
    // Mock purchases
    loadMockPurchases();
    
    // Mock wishlist
    loadMockWishlist();
    
    // Mock reviews
    loadMockReviews();
}

function loadMockSellingItems() {
    const container = document.getElementById('selling-items-list');
    
    // Mock data - replace with actual API call later
    const mockItems = [
        {
            id: 1,
            image: 'assets/images/camera1.jpg',
            title: 'Sony A7 III',
            specs: '24MP • Full Frame',
            price: '₱45,000',
            status: 'pending',
            statusText: 'Under Review'
        },
        {
            id: 2,
            image: 'assets/images/camera2.jpg',
            title: 'Canon EOS R5',
            specs: '45MP • Full Frame',
            price: '₱120,000',
            status: 'approved',
            statusText: 'Listed'
        },
        {
            id: 3,
            image: 'assets/images/camera3.jpg',
            title: 'Nikon Z6',
            specs: '24MP • Full Frame',
            price: '₱65,000',
            status: 'sold',
            statusText: 'Sold'
        }
    ];

    if (mockItems.length > 0) {
        container.innerHTML = mockItems.map(item => `
            <div class="item-card" data-status="${item.status}">
                <img src="${item.image}" alt="${item.title}" class="item-image" onerror="this.src='assets/images/empty-box.png'">
                <div class="item-details">
                    <h4 class="item-title">${item.title}</h4>
                    <p class="item-specs">${item.specs}</p>
                    <p class="item-price">${item.price}</p>
                </div>
                <span class="item-status status-${item.status}">${item.statusText}</span>
            </div>
        `).join('');
    }
}

function loadMockPurchases() {
    const container = document.getElementById('purchases-list');
    // Similar structure to selling items
}

function loadMockWishlist() {
    const container = document.getElementById('wishlist-items');
    // Similar structure to marketplace product cards
}

function loadMockReviews() {
    const container = document.getElementById('reviews-list');
    // Mock reviews data
}

// Filter selling items by status
function filterSellingItems(status) {
    const items = document.querySelectorAll('.item-card');
    
    items.forEach(item => {
        if (status === 'all' || item.getAttribute('data-status') === status) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Form submission handler
function submitSellItemForm() {
    const form = document.getElementById('sellItemForm');
    const formData = new FormData(form);
    
    // Here you would send to backend
    console.log('Form data:', Object.fromEntries(formData));
    
    // Show success message
    alert('Your camera has been submitted for review!');
    
    // Close modal and reset form
    document.getElementById('sellItemModal').style.display = 'none';
    form.reset();
    
    // In real implementation, refresh the selling items list
    // loadSellingItems();
}