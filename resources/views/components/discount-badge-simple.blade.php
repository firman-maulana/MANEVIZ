<?php
// File: resources/views/components/discount-badge-simple.blade.php
// Simplified discount badge with countdown timer only when < 24 hours remaining

/**
 * Usage in Blade:
 * <x-discount-badge-simple :product="$product" />
 *
 * Props:
 * - product: Product model instance with discount information
 */
?>

<style>
/* Simple Discount Badge Styles */
.simple-discount-badge {
    position: relative;
    z-index: 2;
}

.discount-label {
    display: inline-block;
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
    animation: pulse-badge 2s ease-in-out infinite;
}

@keyframes pulse-badge {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(255, 107, 107, 0.5);
    }
}

/* Urgent Warning - Shows when < 24 hours */
.discount-urgent-warning {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 4px;
    padding: 4px 6px;
    background: rgba(255, 243, 205, 0.95);
    border: 1px solid #ffc107;
    border-radius: 4px;
    font-size: 8px;
    font-weight: 600;
    color: #856404;
    animation: blink-warning 1.5s ease-in-out infinite;
}

@keyframes blink-warning {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.urgent-icon {
    width: 10px;
    height: 10px;
    color: #dc3545;
    flex-shrink: 0;
}

/* Mini Countdown Timer */
.mini-countdown {
    display: inline-flex;
    align-items: center;
    gap: 2px;
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: #dc3545;
}

.time-unit-mini {
    font-size: 7px;
    color: #856404;
    font-weight: 600;
}

/* Tablet Responsive */
@media (max-width: 992px) {
    .discount-label {
        padding: 3px 7px;
        font-size: 9px;
    }
    
    .discount-urgent-warning {
        padding: 3px 5px;
        font-size: 7px;
    }
    
    .urgent-icon {
        width: 9px;
        height: 9px;
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .discount-label {
        padding: 3px 6px;
        font-size: 9px;
    }
    
    .discount-urgent-warning {
        padding: 3px 5px;
        font-size: 7px;
    }
}

/* Small Mobile Responsive */
@media (max-width: 576px) {
    .discount-label {
        padding: 2px 5px;
        font-size: 8px;
    }
    
    .discount-urgent-warning {
        padding: 2px 4px;
        font-size: 6px;
    }
    
    .urgent-icon {
        width: 8px;
        height: 8px;
    }
}
</style>

@if($product->hasActiveDiscount())
<div class="simple-discount-badge" data-discount-badge data-product-id="{{ $product->id }}" data-end-date="{{ $product->discount_end_date ? $product->discount_end_date->toIso8601String() : '' }}">
    <!-- Discount Label -->
    <div class="discount-label">
        {{ $product->getDiscountLabel() }} OFF
    </div>
    
    <!-- Urgent Warning (Only shows when < 24 hours) -->
    @if($product->discount_end_date)
    <div class="discount-urgent-warning" style="display: none;" data-urgent-warning>
        <svg class="urgent-icon" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <span>Ends in <span class="mini-countdown" data-countdown></span></span>
    </div>
    @endif
</div>

<script>
(function() {
    'use strict';
    
    class SimpleDiscountBadge {
        constructor(container) {
            this.container = container;
            this.productId = container.dataset.productId;
            this.endDateStr = container.dataset.endDate;
            
            if (!this.endDateStr) return;
            
            this.endDate = new Date(this.endDateStr);
            this.warningElement = container.querySelector('[data-urgent-warning]');
            this.countdownElement = container.querySelector('[data-countdown]');
            
            if (isNaN(this.endDate.getTime())) {
                console.error('Invalid end date for product:', this.productId);
                return;
            }
            
            this.intervalId = null;
            this.init();
        }
        
        init() {
            this.checkAndUpdate();
            this.intervalId = setInterval(() => {
                this.checkAndUpdate();
            }, 1000);
        }
        
        checkAndUpdate() {
            const now = new Date();
            const timeLeft = this.endDate - now;
            
            // If expired
            if (timeLeft <= 0) {
                this.handleExpired();
                return;
            }
            
            // Calculate hours remaining
            const hoursLeft = timeLeft / (1000 * 60 * 60);
            
            // Only show warning if less than 24 hours
            if (hoursLeft < 24) {
                this.showWarning(timeLeft);
            } else {
                this.hideWarning();
            }
        }
        
        showWarning(timeLeft) {
            if (!this.warningElement || !this.countdownElement) return;
            
            // Calculate time units
            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            
            // Update countdown display
            this.countdownElement.innerHTML = `
                ${this.padZero(hours)}h ${this.padZero(minutes)}m
            `;
            
            // Show warning
            this.warningElement.style.display = 'flex';
        }
        
        hideWarning() {
            if (this.warningElement) {
                this.warningElement.style.display = 'none';
            }
        }
        
        handleExpired() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
            
            // Hide entire badge or reload page
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }
        
        padZero(num) {
            return num.toString().padStart(2, '0');
        }
        
        destroy() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
            }
        }
    }
    
    // Initialize all discount badges
    function initBadges() {
        const badges = document.querySelectorAll('[data-discount-badge]');
        const instances = [];
        
        badges.forEach(badge => {
            instances.push(new SimpleDiscountBadge(badge));
        });
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            instances.forEach(instance => instance.destroy());
        });
    }
    
    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBadges);
    } else {
        initBadges();
    }
})();
</script>
@endif