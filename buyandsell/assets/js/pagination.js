// Pagination Configuration
const ITEMS_PER_PAGE = 12;
let currentPage = 1;
let totalPages = 1;
let filteredProducts = [];

// Initialize pagination
function initializePagination(products) {
    filteredProducts = products;
    totalPages = Math.ceil(products.length / ITEMS_PER_PAGE);
    currentPage = 1;
    updatePagination();
}

// Update pagination display
function updatePagination() {
    const paginationContainer = document.getElementById('pagination-container');
    const pageNumbers = document.getElementById('page-numbers');
    const itemsInfo = document.getElementById('items-info');
    const prevBtn = document.getElementById('prev-page');
    const nextBtn = document.getElementById('next-page');

    // Hide pagination if only one page or no products
    if (totalPages <= 1 || filteredProducts.length === 0) {
        paginationContainer.style.display = 'none';
        return;
    }

    paginationContainer.style.display = 'flex';

    // Update previous/next buttons
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages;

    // Generate page numbers
    pageNumbers.innerHTML = '';
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage < maxVisiblePages - 1) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    // Add first page and dots
    if (startPage > 1) {
        const firstPage = createPageButton(1);
        pageNumbers.appendChild(firstPage);

        if (startPage > 2) {
            const dots = document.createElement('span');
            dots.className = 'page-number dots';
            dots.textContent = '...';
            pageNumbers.appendChild(dots);
        }
    }

    // Add page numbers
    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = createPageButton(i);
        pageNumbers.appendChild(pageBtn);
    }

    // Add last page and dots
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const dots = document.createElement('span');
            dots.className = 'page-number dots';
            dots.textContent = '...';
            pageNumbers.appendChild(dots);
        }

        const lastPage = createPageButton(totalPages);
        pageNumbers.appendChild(lastPage);
    }

    // Update items info
    const startItem = (currentPage - 1) * ITEMS_PER_PAGE + 1;
    const endItem = Math.min(currentPage * ITEMS_PER_PAGE, filteredProducts.length);
    itemsInfo.textContent = `Showing ${startItem}-${endItem} of ${filteredProducts.length} products`;
}

// Create individual page button
function createPageButton(pageNum) {
    const btn = document.createElement('button');
    btn.className = 'page-number';
    btn.textContent = pageNum;

    if (pageNum === currentPage) {
        btn.classList.add('active');
    }

    btn.addEventListener('click', () => {
        currentPage = pageNum;
        displayPaginatedProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    return btn;
}

// Display products for current page
function displayPaginatedProducts() {
    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    const endIndex = startIndex + ITEMS_PER_PAGE;
    const pageProducts = filteredProducts.slice(startIndex, endIndex);
    
    displayProducts(pageProducts);
    updatePagination();
}

// Handle previous/next button clicks
document.addEventListener('DOMContentLoaded', () => {
    const prevBtn = document.getElementById('prev-page');
    const nextBtn = document.getElementById('next-page');

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                displayPaginatedProducts();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                displayPaginatedProducts();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }
});
