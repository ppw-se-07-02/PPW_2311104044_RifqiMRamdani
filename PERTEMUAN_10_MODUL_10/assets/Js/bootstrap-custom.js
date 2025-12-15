// assets/js/bootstrap-custom.js
// Custom Bootstrap components initialization

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== TOOLTIPS ====================
    
    // Initialize all Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover'
        });
    });
    
    // ==================== POPOVERS ====================
    
    // Initialize all Bootstrap popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            trigger: 'focus'
        });
    });
    
    // ==================== MODALS ====================
    
    // Initialize all Bootstrap modals
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        // Focus on first input when modal opens
        modal.addEventListener('shown.bs.modal', function() {
            const input = this.querySelector('input, textarea, select');
            if (input) input.focus();
        });
        
        // Reset form when modal closes
        modal.addEventListener('hidden.bs.modal', function() {
            const form = this.querySelector('form');
            if (form) {
                form.reset();
                form.classList.remove('was-validated');
            }
        });
    });
    
    // ==================== DROPDOWNS ====================
    
    // Handle dropdown auto-close
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('hide.bs.dropdown', function() {
            const searchInput = this.querySelector('.dropdown-search');
            if (searchInput) searchInput.value = '';
        });
    });
    
    // Custom dropdown search functionality
    const dropdownSearchInputs = document.querySelectorAll('.dropdown-search');
    dropdownSearchInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const dropdownMenu = this.closest('.dropdown-menu');
            
            if (!dropdownMenu) return;
            
            const items = dropdownMenu.querySelectorAll('.dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
    
    // ==================== TOASTS ====================
    
    // Auto-initialize toasts
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    const toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 5000
        });
    });
    
    // Auto-show toasts on page load
    toastList.forEach(toast => toast.show());
    
    // ==================== COLLAPSE ====================
    
    // Handle accordion/collapse
    const collapses = document.querySelectorAll('.collapse');
    collapses.forEach(collapse => {
        collapse.addEventListener('show.bs.collapse', function() {
            // Add active class to parent
            const parent = this.closest('.accordion-item');
            if (parent) {
                parent.classList.add('active');
            }
        });
        
        collapse.addEventListener('hide.bs.collapse', function() {
            // Remove active class from parent
            const parent = this.closest('.accordion-item');
            if (parent) {
                parent.classList.remove('active');
            }
        });
    });
    
    // ==================== CAROUSEL ====================
    
    // Auto-play carousel with pause on hover
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        // Pause on hover
        carousel.addEventListener('mouseenter', function() {
            const carouselInstance = bootstrap.Carousel.getInstance(this);
            if (carouselInstance) {
                carouselInstance.pause();
            }
        });
        
        carousel.addEventListener('mouseleave', function() {
            const carouselInstance = bootstrap.Carousel.getInstance(this);
            if (carouselInstance) {
                carouselInstance.cycle();
            }
        });
    });
    
    // ==================== NAVBAR ====================
    
    // Handle navbar collapse on click (for mobile)
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            const navbarCollapse = document.querySelector('.navbar-collapse.show');
            if (navbarCollapse) {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                bsCollapse.hide();
            }
        });
    });
    
    // ==================== FORMS ====================
    
    // Password visibility toggle
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                input.type = 'password';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    });
    
    // Character counter for textareas
    const textareas = document.querySelectorAll('textarea[data-maxlength]');
    textareas.forEach(textarea => {
        const maxLength = parseInt(textarea.getAttribute('data-maxlength'));
        const counterId = 'counter-' + Math.random().toString(36).substr(2, 9);
        
        // Create counter element
        const counter = document.createElement('div');
        counter.id = counterId;
        counter.className = 'form-text text-end small';
        counter.textContent = `0/${maxLength}`;
        
        textarea.parentNode.appendChild(counter);
        
        // Update counter on input
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/${maxLength}`;
            
            if (length > maxLength * 0.9) {
                counter.classList.add('text-warning');
            } else {
                counter.classList.remove('text-warning');
            }
            
            if (length > maxLength) {
                counter.classList.add('text-danger');
                this.value = this.value.substring(0, maxLength);
            } else {
                counter.classList.remove('text-danger');
            }
        });
    });
    
    // ==================== TABLE ENHANCEMENTS ====================
    
    // Row selection with shift key
    let lastSelectedRow = null;
    const selectableRows = document.querySelectorAll('tr[data-selectable]');
    
    selectableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') {
                return;
            }
            
            const isShiftPressed = e.shiftKey;
            const isCtrlPressed = e.ctrlKey || e.metaKey;
            
            if (isShiftPressed && lastSelectedRow) {
                // Select range of rows
                const rows = Array.from(this.parentNode.children);
                const startIndex = rows.indexOf(lastSelectedRow);
                const endIndex = rows.indexOf(this);
                const start = Math.min(startIndex, endIndex);
                const end = Math.max(startIndex, endIndex);
                
                for (let i = start; i <= end; i++) {
                    rows[i].classList.add('table-active');
                }
            } else if (isCtrlPressed) {
                // Toggle selection
                this.classList.toggle('table-active');
            } else {
                // Clear all and select this one
                selectableRows.forEach(r => r.classList.remove('table-active'));
                this.classList.add('table-active');
            }
            
            lastSelectedRow = this;
        });
    });
    
    // ==================== SIDEBAR TOGGLE ====================
    
    // Mobile sidebar toggle
    const sidebarToggle = document.querySelector('[data-bs-toggle="sidebar"]');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.querySelector('.sidebar.show');
        if (sidebar && !sidebar.contains(e.target) && !e.target.matches('[data-bs-toggle="sidebar"]')) {
            sidebar.classList.remove('show');
        }
    });
    
    // ==================== PROGRESS BARS ====================
    
    // Animate progress bars on scroll
    const progressBars = document.querySelectorAll('.progress-bar[data-animate]');
    
    if (progressBars.length > 0) {
        const animateProgressBars = function() {
            progressBars.forEach(bar => {
                const rect = bar.getBoundingClientRect();
                const isVisible = (rect.top <= window.innerHeight) && (rect.bottom >= 0);
                
                if (isVisible && !bar.classList.contains('animated')) {
                    const targetWidth = bar.getAttribute('aria-valuenow') + '%';
                    bar.style.width = '0%';
                    
                    setTimeout(() => {
                        bar.style.width = targetWidth;
                        bar.classList.add('animated');
                    }, 100);
                }
            });
        };
        
        // Initial check
        animateProgressBars();
        
        // Check on scroll
        window.addEventListener('scroll', animateProgressBars);
    }
    
    // ==================== LAZY LOADING ====================
    
    // Lazy load images
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.getAttribute('data-src');
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        lazyImages.forEach(img => {
            img.src = img.getAttribute('data-src');
            img.removeAttribute('data-src');
        });
    }
    
    // ==================== COPY TO CLIPBOARD ====================
    
    // Copy to clipboard buttons
    const copyButtons = document.querySelectorAll('[data-copy]');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetSelector = this.getAttribute('data-copy');
            const target = document.querySelector(targetSelector);
            
            if (target) {
                const text = target.textContent || target.value;
                
                navigator.clipboard.writeText(text).then(() => {
                    // Show success feedback
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check"></i> Copied!';
                    this.classList.add('btn-success');
                    
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('btn-success');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                    alert('Gagal menyalin teks');
                });
            }
        });
    });
    
    // ==================== PRINT FUNCTIONALITY ====================
    
    // Enhanced print functionality
    const printButtons = document.querySelectorAll('.btn-print');
    printButtons.forEach(button => {
        button.addEventListener('click', function() {
            const printSection = this.getAttribute('data-print') || 'body';
            const elements = document.querySelectorAll(printSection);
            
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print Document</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body { padding: 20px; }
                        .no-print { display: none !important; }
                        @media print {
                            @page { margin: 0; }
                            body { margin: 1.6cm; }
                        }
                    </style>
                </head>
                <body>
            `);
            
            elements.forEach(element => {
                printWindow.document.write(element.outerHTML);
            });
            
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        });
    });
    
    // ==================== BACK TO TOP ====================
    
    // Back to top button
    const backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // ==================== FORM WIZARD ====================
    
    // Multi-step form wizard
    const formWizards = document.querySelectorAll('.form-wizard');
    formWizards.forEach(wizard => {
        const steps = wizard.querySelectorAll('.wizard-step');
        const nextButtons = wizard.querySelectorAll('.wizard-next');
        const prevButtons = wizard.querySelectorAll('.wizard-prev');
        const progressBar = wizard.querySelector('.wizard-progress');
        
        let currentStep = 0;
        
        function updateWizard() {
            // Hide all steps
            steps.forEach(step => step.classList.remove('active'));
            
            // Show current step
            steps[currentStep].classList.add('active');
            
            // Update progress bar
            if (progressBar) {
                const progress = ((currentStep + 1) / steps.length) * 100;
                progressBar.style.width = `${progress}%`;
            }
            
            // Update buttons
            const prevBtn = wizard.querySelector('.wizard-prev');
            const nextBtn = wizard.querySelector('.wizard-next');
            
            if (prevBtn) {
                prevBtn.style.display = currentStep === 0 ? 'none' : '';
            }
            
            if (nextBtn) {
                nextBtn.textContent = currentStep === steps.length - 1 ? 'Submit' : 'Next';
            }
        }
        
        // Next button
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    updateWizard();
                }
            });
        });
        
        // Previous button
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    updateWizard();
                }
            });
        });
        
        // Initialize
        updateWizard();
    });
    
    // ==================== INITIALIZATION COMPLETE ====================
    
    console.log('Bootstrap components initialized successfully');
    
    // Dispatch custom event when initialization is complete
    document.dispatchEvent(new CustomEvent('bootstrapInitialized'));
    
});

// Export functions for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        // Export jika diperlukan
    };
}