// assets/js/script.js

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== UTILITY FUNCTIONS ====================
    
    /**
     * Show loading overlay
     */
    function showLoading() {
        let overlay = document.getElementById('loadingOverlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'loading-overlay';
            overlay.innerHTML = '<div class="spinner"></div>';
            document.body.appendChild(overlay);
        }
        overlay.style.display = 'flex';
    }
    
    /**
     * Hide loading overlay
     */
    function hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }
    
    /**
     * Show toast notification
     * @param {string} message - Message to display
     * @param {string} type - Type of toast (success, error, warning, info)
     */
    function showToast(message, type = 'info') {
        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast align-items-center text-bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        
        container.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 3000
        });
        
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    }
    
    /**
     * Confirm dialog
     * @param {string} message - Confirmation message
     * @param {function} onConfirm - Callback when confirmed
     * @param {function} onCancel - Callback when cancelled
     */
    function confirmDialog(message, onConfirm, onCancel = null) {
        const modalHtml = `
            <div class="modal fade" id="confirmModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="confirmBtn">Ya, Lanjutkan</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal
        const existingModal = document.getElementById('confirmModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
        
        document.getElementById('confirmBtn').addEventListener('click', function() {
            modal.hide();
            if (onConfirm) onConfirm();
        });
        
        document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
            if (onCancel) onCancel();
        });
    }
    
    /**
     * Format currency
     * @param {number} amount - Amount to format
     * @returns {string} Formatted currency
     */
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }
    
    /**
     * Format date
     * @param {string} dateString - Date string
     * @returns {string} Formatted date
     */
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }
    
    // ==================== FORM VALIDATION ====================
    
    /**
     * Initialize form validation
     */
    function initFormValidation() {
        const forms = document.querySelectorAll('.needs-validation');
        
        forms.forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    }
    
    /**
     * Validate image file
     * @param {File} file - File object
     * @param {number} maxSizeMB - Maximum size in MB
     * @returns {object} Validation result
     */
    function validateImageFile(file, maxSizeMB = 2) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        const maxSize = maxSizeMB * 1024 * 1024;
        
        if (!allowedTypes.includes(file.type)) {
            return {
                valid: false,
                message: 'Format file tidak didukung. Gunakan JPG, PNG, WEBP, atau GIF.'
            };
        }
        
        if (file.size > maxSize) {
            return {
                valid: false,
                message: `Ukuran file terlalu besar. Maksimal ${maxSizeMB}MB.`
            };
        }
        
        return { valid: true, message: 'File valid' };
    }
    
    // ==================== IMAGE PREVIEW ====================
    
    /**
     * Initialize image preview
     */
    function initImagePreview() {
        const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
        
        imageInputs.forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                // Validate file
                const validation = validateImageFile(file);
                if (!validation.valid) {
                    showToast(validation.message, 'error');
                    this.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewId = this.getAttribute('data-preview') || 'preview';
                    let preview = document.getElementById(previewId);
                    
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = previewId;
                        preview.className = 'img-preview mt-2';
                        preview.style.maxWidth = '200px';
                        preview.style.maxHeight = '200px';
                        preview.style.objectFit = 'cover';
                        
                        const container = this.closest('.form-group') || this.parentNode;
                        container.appendChild(preview);
                    }
                    
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }.bind(this);
                
                reader.readAsDataURL(file);
            });
        });
    }
    
    // ==================== TABLE FUNCTIONS ====================
    
    /**
     * Initialize table sorting
     */
    function initTableSorting() {
        const sortableHeaders = document.querySelectorAll('th[data-sort]');
        
        sortableHeaders.forEach(header => {
            header.style.cursor = 'pointer';
            
            header.addEventListener('click', function() {
                const table = this.closest('table');
                const columnIndex = Array.from(this.parentNode.children).indexOf(this);
                const sortOrder = this.getAttribute('data-sort-order') || 'asc';
                
                // Toggle sort order
                const newSortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
                this.setAttribute('data-sort-order', newSortOrder);
                
                // Sort table
                sortTable(table, columnIndex, newSortOrder);
                
                // Update sort indicator
                updateSortIndicator(this, newSortOrder);
            });
        });
    }
    
    /**
     * Sort table by column
     */
    function sortTable(table, columnIndex, order) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.children[columnIndex].textContent.trim();
            const bValue = b.children[columnIndex].textContent.trim();
            
            // Try to parse as number
            const aNum = parseFloat(aValue.replace(/[^\d.-]/g, ''));
            const bNum = parseFloat(bValue.replace(/[^\d.-]/g, ''));
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return order === 'asc' ? aNum - bNum : bNum - aNum;
            }
            
            // Otherwise sort as string
            return order === 'asc' 
                ? aValue.localeCompare(bValue)
                : bValue.localeCompare(aValue);
        });
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
    }
    
    /**
     * Update sort indicator
     */
    function updateSortIndicator(header, order) {
        // Remove existing indicators
        const existingIndicators = header.parentNode.querySelectorAll('.sort-indicator');
        existingIndicators.forEach(ind => ind.remove());
        
        // Add new indicator
        const indicator = document.createElement('span');
        indicator.className = 'sort-indicator ms-1';
        indicator.innerHTML = order === 'asc' ? '↑' : '↓';
        header.appendChild(indicator);
    }
    
    /**
     * Initialize table search
     */
    function initTableSearch() {
        const searchInputs = document.querySelectorAll('input[data-table-search]');
        
        searchInputs.forEach(input => {
            input.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const tableId = this.getAttribute('data-table-search');
                const table = document.getElementById(tableId);
                
                if (!table) return;
                
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    }
    
    // ==================== AJAX FUNCTIONS ====================
    
    /**
     * Make AJAX request
     */
    function ajaxRequest(url, method = 'GET', data = null) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            
            xhr.open(method, url);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            if (data && method !== 'GET') {
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            }
            
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        resolve(xhr.responseText);
                    }
                } else {
                    reject(new Error(`Request failed: ${xhr.statusText}`));
                }
            };
            
            xhr.onerror = function() {
                reject(new Error('Network error'));
            };
            
            xhr.send(data);
        });
    }
    
    // ==================== INITIALIZATION ====================
    
    /**
     * Initialize all features
     */
    function init() {
        console.log('Initializing application...');
        
        // Initialize form validation
        initFormValidation();
        
        // Initialize image preview
        initImagePreview();
        
        // Initialize table features
        initTableSorting();
        initTableSearch();
        
        // Add fade-in animation to cards
        document.querySelectorAll('.card').forEach(card => {
            card.classList.add('fade-in');
        });
        
        // Handle print buttons
        document.querySelectorAll('.btn-print').forEach(btn => {
            btn.addEventListener('click', function() {
                window.print();
            });
        });
        
        // Handle export buttons
        document.querySelectorAll('.btn-export').forEach(btn => {
            btn.addEventListener('click', function() {
                const format = this.getAttribute('data-format') || 'csv';
                const tableId = this.getAttribute('data-table');
                exportTable(tableId, format);
            });
        });
        
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
        
        console.log('Application initialized successfully');
    }
    
    // ==================== EXPORT FUNCTIONS ====================
    
    /**
     * Export table data
     */
    function exportTable(tableId, format = 'csv') {
        const table = document.getElementById(tableId);
        if (!table) {
            showToast('Tabel tidak ditemukan', 'error');
            return;
        }
        
        let data = [];
        const headers = [];
        
        // Get headers
        table.querySelectorAll('thead th').forEach(th => {
            headers.push(th.textContent.trim());
        });
        
        // Get rows
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            tr.querySelectorAll('td').forEach(td => {
                row.push(td.textContent.trim());
            });
            data.push(row);
        });
        
        if (format === 'csv') {
            exportToCSV(headers, data, 'data.csv');
        } else if (format === 'excel') {
            exportToExcel(headers, data, 'data.xlsx');
        } else if (format === 'pdf') {
            exportToPDF(headers, data, 'data.pdf');
        }
    }
    
    /**
     * Export to CSV
     */
    function exportToCSV(headers, data, filename) {
        let csvContent = headers.join(',') + '\n';
        data.forEach(row => {
            csvContent += row.map(cell => `"${cell}"`).join(',') + '\n';
        });
        
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        downloadFile(blob, filename);
    }
    
    /**
     * Export to Excel
     */
    function exportToExcel(headers, data, filename) {
        // This would require a library like SheetJS
        showToast('Export Excel membutuhkan library tambahan', 'warning');
    }
    
    /**
     * Export to PDF
     */
    function exportToPDF(headers, data, filename) {
        // This would require a library like jsPDF
        showToast('Export PDF membutuhkan library tambahan', 'warning');
    }
    
    /**
     * Download file
     */
    function downloadFile(blob, filename) {
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.href = url;
        link.download = filename;
        link.style.display = 'none';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }
    
    // ==================== EVENT LISTENERS ====================
    
    // Global click handler for confirm links
    document.addEventListener('click', function(e) {
        // Handle confirm links
        if (e.target.matches('a[data-confirm]')) {
            e.preventDefault();
            const message = e.target.getAttribute('data-confirm');
            const href = e.target.getAttribute('href');
            
            confirmDialog(message, function() {
                window.location.href = href;
            });
        }
        
        // Handle confirm buttons
        if (e.target.matches('button[data-confirm]')) {
            e.preventDefault();
            const message = e.target.getAttribute('data-confirm');
            const form = e.target.closest('form');
            
            confirmDialog(message, function() {
                if (form) form.submit();
            });
        }
    });
    
    // Handle form submissions
    document.addEventListener('submit', function(e) {
        const form = e.target;
        
        // Show loading for forms with data-loading attribute
        if (form.hasAttribute('data-loading')) {
            showLoading();
        }
        
        // Handle AJAX forms
        if (form.hasAttribute('data-ajax')) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const url = form.getAttribute('action') || window.location.href;
            const method = form.getAttribute('method') || 'POST';
            
            showLoading();
            
            fetch(url, {
                method: method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.success) {
                    showToast(data.message, 'success');
                    
                    // Redirect if specified
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                    
                    // Reset form if specified
                    if (form.hasAttribute('data-reset')) {
                        form.reset();
                    }
                } else {
                    showToast(data.message || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                hideLoading();
                showToast('Terjadi kesalahan jaringan', 'error');
                console.error('AJAX error:', error);
            });
        }
    });
    
    // Handle window errors
    window.addEventListener('error', function(e) {
        console.error('JavaScript Error:', e.error);
        showToast('Terjadi kesalahan dalam aplikasi', 'error');
    });
    
    // Handle offline/online status
    window.addEventListener('offline', function() {
        showToast('Anda sedang offline', 'warning');
    });
    
    window.addEventListener('online', function() {
        showToast('Koneksi internet telah pulih', 'success');
    });
    
    // ==================== INITIALIZE ====================
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    // ==================== GLOBAL FUNCTIONS ====================
    
    // Make functions available globally
    window.App = {
        showLoading,
        hideLoading,
        showToast,
        confirmDialog,
        formatCurrency,
        formatDate,
        ajaxRequest,
        validateImageFile
    };
    
});

// ==================== GLOBAL EVENT HANDLERS ====================

// Handle back button
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});

// Handle beforeunload
window.addEventListener('beforeunload', function(e) {
    // You can add cleanup or confirmation here
});

// ==================== POLYFILLS ====================

// String.includes polyfill for older browsers
if (!String.prototype.includes) {
    String.prototype.includes = function(search, start) {
        if (typeof start !== 'number') {
            start = 0;
        }
        
        if (start + search.length > this.length) {
            return false;
        } else {
            return this.indexOf(search, start) !== -1;
        }
    };
}

// Array.from polyfill for older browsers
if (!Array.from) {
    Array.from = (function() {
        const toStr = Object.prototype.toString;
        const isCallable = function(fn) {
            return typeof fn === 'function' || toStr.call(fn) === '[object Function]';
        };
        const toInteger = function(value) {
            const number = Number(value);
            if (isNaN(number)) return 0;
            if (number === 0 || !isFinite(number)) return number;
            return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
        };
        const maxSafeInteger = Math.pow(2, 53) - 1;
        const toLength = function(value) {
            const len = toInteger(value);
            return Math.min(Math.max(len, 0), maxSafeInteger);
        };
        
        return function(arrayLike, mapFn, thisArg) {
            const C = this;
            const items = Object(arrayLike);
            
            if (arrayLike == null) {
                throw new TypeError('Array.from requires an array-like object');
            }
            
            let mapFn = arguments.length > 1 ? arguments[1] : void undefined;
            let T;
            if (typeof mapFn !== 'undefined') {
                if (!isCallable(mapFn)) {
                    throw new TypeError('Array.from: when provided, the second argument must be a function');
                }
                
                if (arguments.length > 2) {
                    T = arguments[2];
                }
            }
            
            const len = toLength(items.length);
            const A = isCallable(C) ? Object(new C(len)) : new Array(len);
            
            let k = 0;
            while (k < len) {
                const kValue = items[k];
                if (mapFn) {
                    A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
                } else {
                    A[k] = kValue;
                }
                k++;
            }
            
            A.length = len;
            return A;
        };
    }());
}