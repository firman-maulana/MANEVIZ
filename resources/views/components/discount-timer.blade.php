<?php
// File: resources/views/components/discount-timer.blade.php
// Real-time discount countdown component

/**
 * Usage in Blade:
 * <x-discount-timer :product="$product" />
 *
 * Props:
 * - product: Product model instance with discount_end_date
 */
?>

<style>
/* Discount Timer Styles */
.discount-timer-container {
    margin-top: 12px;
    padding: 12px 16px;
    background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
    border: 2px solid #ffc107;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
}

.discount-timer-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

.discount-timer-display {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    z-index: 1;
}

.timer-icon {
    width: 24px;
    height: 24px;
    color: #856404;
    flex-shrink: 0;
    animation: tick 1s ease-in-out infinite;
}

@keyframes tick {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-5deg); }
    75% { transform: rotate(5deg); }
}

.timer-content {
    flex: 1;
}

.timer-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #856404;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.timer-countdown {
    display: flex;
    align-items: center;
    gap: 4px;
}

.time-block {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255, 255, 255, 0.8);
    padding: 6px 8px;
    border-radius: 6px;
    min-width: 45px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.time-value {
    font-size: 18px;
    font-weight: 700;
    color: #dc3545;
    line-height: 1;
    font-family: 'Courier New', monospace;
}

.time-unit {
    font-size: 9px;
    font-weight: 600;
    color: #856404;
    text-transform: uppercase;
    margin-top: 2px;
    letter-spacing: 0.3px;
}

.time-separator {
    font-size: 18px;
    font-weight: 700;
    color: #856404;
    margin: 0 2px;
}

/* Urgent state - less than 24 hours */
.discount-timer-container.urgent {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c2c7 100%);
    border-color: #dc3545;
    animation: pulse-urgent 2s ease-in-out infinite;
}

@keyframes pulse-urgent {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(220, 53, 69, 0);
    }
}

.discount-timer-container.urgent .timer-icon,
.discount-timer-container.urgent .timer-label,
.discount-timer-container.urgent .time-unit {
    color: #721c24;
}

.discount-timer-container.urgent .time-separator {
    color: #721c24;
    animation: blink 1s ease-in-out infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

/* Expired State */
.discount-expired-message {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background: #f8d7da;
    border: 1px solid #f5c2c7;
    border-radius: 8px;
    color: #721c24;
}

.discount-expired-message svg {
    width: 20px;
    height: 20px;
    color: #dc3545;
}

/* Responsive Design */
@media (max-width: 768px) {
    .discount-timer-container {
        padding: 10px 12px;
    }

    .timer-icon {
        width: 20px;
        height: 20px;
    }

    .timer-label {
        font-size: 11px;
    }

    .time-block {
        padding: 4px 6px;
        min-width: 40px;
    }

    .time-value {
        font-size: 16px;
    }

    .time-unit {
        font-size: 8px;
    }

    .time-separator {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .discount-timer-container {
        padding: 8px 10px;
    }

    .timer-countdown {
        gap: 2px;
    }

    .time-block {
        padding: 3px 4px;
        min-width: 35px;
    }

    .time-value {
        font-size: 14px;
    }

    .time-unit {
        font-size: 7px;
    }

    .time-separator {
        font-size: 14px;
        margin: 0 1px;
    }
}
</style>

@if($product->hasActiveDiscount() && $product->discount_end_date)
<div class="discount-timer-container"
     data-end-date="{{ $product->discount_end_date->toIso8601String() }}"
     data-product-id="{{ $product->id }}">

    <!-- Timer Display -->
    <div class="discount-timer-display">
        <svg class="timer-icon" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/>
        </svg>

        <div class="timer-content">
            <span class="timer-label">Discount ends in:</span>
            <div class="timer-countdown" id="countdown-{{ $product->id }}">
                <span class="time-block">
                    <span class="time-value" data-days>00</span>
                    <span class="time-unit">Days</span>
                </span>
                <span class="time-separator">:</span>
                <span class="time-block">
                    <span class="time-value" data-hours>00</span>
                    <span class="time-unit">Hours</span>
                </span>
                <span class="time-separator">:</span>
                <span class="time-block">
                    <span class="time-value" data-minutes>00</span>
                    <span class="time-unit">Mins</span>
                </span>
                <span class="time-separator">:</span>
                <span class="time-block">
                    <span class="time-value" data-seconds>00</span>
                    <span class="time-unit">Secs</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Expired Message (hidden by default) -->
    <div class="discount-expired-message" style="display: none;">
        <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <span>This discount has expired</span>
    </div>
</div>

<script>
(function() {
    'use strict';

    class DiscountTimer {
        constructor(container) {
            this.container = container;
            this.productId = container.dataset.productId;
            this.endDate = new Date(container.dataset.endDate);
            this.countdownElement = container.querySelector(`#countdown-${this.productId}`);
            this.expiredMessage = container.querySelector('.discount-expired-message');
            this.timerDisplay = container.querySelector('.discount-timer-display');

            // Get all time display elements
            this.daysEl = this.countdownElement.querySelector('[data-days]');
            this.hoursEl = this.countdownElement.querySelector('[data-hours]');
            this.minutesEl = this.countdownElement.querySelector('[data-minutes]');
            this.secondsEl = this.countdownElement.querySelector('[data-seconds]');

            this.intervalId = null;
            this.init();
        }

        init() {
            // Check if end date is valid
            if (isNaN(this.endDate.getTime())) {
                console.error('Invalid end date for product:', this.productId);
                this.showExpired();
                return;
            }

            // Initial update
            this.updateCountdown();

            // Update every second
            this.intervalId = setInterval(() => {
                this.updateCountdown();
            }, 1000);
        }

        updateCountdown() {
            const now = new Date();
            const timeLeft = this.endDate - now;

            // Check if expired
            if (timeLeft <= 0) {
                this.handleExpired();
                return;
            }

            // Calculate time units
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            // Update display
            this.daysEl.textContent = this.padZero(days);
            this.hoursEl.textContent = this.padZero(hours);
            this.minutesEl.textContent = this.padZero(minutes);
            this.secondsEl.textContent = this.padZero(seconds);

            // Add urgent class if less than 24 hours
            const totalHours = days * 24 + hours;
            if (totalHours < 24) {
                this.container.classList.add('urgent');
            } else {
                this.container.classList.remove('urgent');
            }
        }

        padZero(num) {
            return num.toString().padStart(2, '0');
        }

        handleExpired() {
            // Stop the timer
            if (this.intervalId) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }

            // Show expired message
            this.showExpired();

            // Reload page after 3 seconds to update prices
            setTimeout(() => {
                console.log('Discount expired, reloading page...');
                window.location.reload();
            }, 3000);
        }

        showExpired() {
            if (this.timerDisplay) {
                this.timerDisplay.style.display = 'none';
            }
            if (this.expiredMessage) {
                this.expiredMessage.style.display = 'flex';
            }
        }

        destroy() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
            }
        }
    }

    // Initialize all discount timers on page load
    function initTimers() {
        const timerContainers = document.querySelectorAll('.discount-timer-container');
        const timers = [];

        timerContainers.forEach(container => {
            timers.push(new DiscountTimer(container));
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            timers.forEach(timer => timer.destroy());
        });
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTimers);
    } else {
        initTimers();
    }
})();
</script>
@endif
