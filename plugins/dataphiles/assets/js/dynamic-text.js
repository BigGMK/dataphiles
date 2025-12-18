/**
 * Dataphiles Dynamic Text Widget JavaScript
 *
 * Handles the cycling animation of impact text and sublines.
 *
 * @package Dataphiles
 * @since 1.0.3
 */

(function() {
	'use strict';

	/**
	 * DynamicTextWidget class
	 */
	class DynamicTextWidget {
		constructor(element) {
			this.element = element;
			this.settings = JSON.parse(element.dataset.settings || '{}');
			this.currentIndex = 0;
			this.isPaused = false;
			this.timeoutIds = [];

			// Get DOM elements
			this.impactEl = element.querySelector('.dataphiles-dynamic-text__impact');
			this.sublineEl = element.querySelector('.dataphiles-dynamic-text__subline');

			if (!this.impactEl || !this.sublineEl || !this.settings.entries || this.settings.entries.length === 0) {
				return;
			}

			// Set CSS custom property for drop distance
			element.style.setProperty('--drop-distance', this.settings.dropDistance + 'px');

			// Initialize
			this.init();
		}

		init() {
			// Bind hover events if pause on hover is enabled
			if (this.settings.pauseOnHover) {
				this.element.addEventListener('mouseenter', () => this.pause());
				this.element.addEventListener('mouseleave', () => this.resume());
			}

			// Start the animation cycle
			this.startCycle();
		}

		startCycle() {
			// Show the first entry
			this.showEntry();
		}

		showEntry() {
			const entry = this.settings.entries[this.currentIndex];

			// Update text content
			this.impactEl.textContent = entry.impact;
			this.sublineEl.textContent = entry.subline;

			// Reset state
			this.impactEl.classList.remove('is-visible', 'is-exiting');
			this.sublineEl.classList.remove('is-visible', 'is-exiting');

			// Set transition durations
			this.impactEl.style.transitionDuration = this.settings.impactEnterDuration + 'ms';

			// Trigger reflow to ensure animation starts fresh
			void this.impactEl.offsetHeight;

			// Step 1: Impact text drops in and fades in
			this.impactEl.classList.add('is-visible');

			// Step 2: After delay, subline fades in
			this.addTimeout(() => {
				this.sublineEl.style.transitionDuration = this.settings.sublineEnterDuration + 'ms';
				this.sublineEl.classList.add('is-visible');
			}, this.settings.impactEnterDuration + this.settings.sublineDelay);

			// Step 3: After display duration, start exit animation
			const totalEnterTime = this.settings.impactEnterDuration + this.settings.sublineDelay + this.settings.sublineEnterDuration;

			this.addTimeout(() => {
				this.exitEntry();
			}, totalEnterTime + this.settings.displayDuration);
		}

		exitEntry() {
			// Set exit transition duration
			this.impactEl.style.transitionDuration = this.settings.exitDuration + 'ms';
			this.sublineEl.style.transitionDuration = this.settings.exitDuration + 'ms';

			// Both elements exit together
			this.impactEl.classList.remove('is-visible');
			this.impactEl.classList.add('is-exiting');
			this.sublineEl.classList.remove('is-visible');
			this.sublineEl.classList.add('is-exiting');

			// After exit animation completes, show next entry
			this.addTimeout(() => {
				this.nextEntry();
			}, this.settings.exitDuration);
		}

		nextEntry() {
			// Move to next entry, loop back to start if at end
			this.currentIndex = (this.currentIndex + 1) % this.settings.entries.length;

			// Show the next entry
			this.showEntry();
		}

		addTimeout(callback, delay) {
			const id = setTimeout(() => {
				if (!this.isPaused) {
					callback();
				}
				// Remove this timeout from the list
				const index = this.timeoutIds.indexOf(id);
				if (index > -1) {
					this.timeoutIds.splice(index, 1);
				}
			}, delay);
			this.timeoutIds.push(id);
			return id;
		}

		clearAllTimeouts() {
			this.timeoutIds.forEach(id => clearTimeout(id));
			this.timeoutIds = [];
		}

		pause() {
			this.isPaused = true;
			this.element.classList.add('is-paused');
			this.clearAllTimeouts();
		}

		resume() {
			if (!this.isPaused) return;

			this.isPaused = false;
			this.element.classList.remove('is-paused');

			// Resume from current state - check if we need to exit or continue
			// For simplicity, we'll restart the current entry display
			const entry = this.settings.entries[this.currentIndex];

			// If text is visible, schedule the exit
			if (this.impactEl.classList.contains('is-visible') && this.sublineEl.classList.contains('is-visible')) {
				this.addTimeout(() => {
					this.exitEntry();
				}, this.settings.displayDuration);
			} else if (this.impactEl.classList.contains('is-exiting')) {
				// If already exiting, let it complete then show next
				this.addTimeout(() => {
					this.nextEntry();
				}, 100);
			} else {
				// Otherwise restart current entry
				this.showEntry();
			}
		}

		destroy() {
			this.clearAllTimeouts();
			if (this.settings.pauseOnHover) {
				this.element.removeEventListener('mouseenter', () => this.pause());
				this.element.removeEventListener('mouseleave', () => this.resume());
			}
		}
	}

	/**
	 * Initialize all widgets on the page
	 */
	function initWidgets() {
		const widgets = document.querySelectorAll('.dataphiles-dynamic-text[data-settings]');
		widgets.forEach(widget => {
			// Skip if already initialized
			if (widget.dataset.initialized) return;
			widget.dataset.initialized = 'true';
			new DynamicTextWidget(widget);
		});
	}

	// Initialize on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initWidgets);
	} else {
		initWidgets();
	}

	// Re-initialize when Elementor frontend loads (for live preview)
	if (typeof window.elementorFrontend !== 'undefined') {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/dataphiles-dynamic-text.default', function($scope) {
			const widget = $scope[0].querySelector('.dataphiles-dynamic-text[data-settings]');
			if (widget && !widget.dataset.initialized) {
				widget.dataset.initialized = 'true';
				new DynamicTextWidget(widget);
			}
		});
	}

	// Also listen for Elementor init
	window.addEventListener('elementor/frontend/init', function() {
		if (typeof window.elementorFrontend !== 'undefined') {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/dataphiles-dynamic-text.default', function($scope) {
				const widget = $scope[0].querySelector('.dataphiles-dynamic-text[data-settings]');
				if (widget && !widget.dataset.initialized) {
					widget.dataset.initialized = 'true';
					new DynamicTextWidget(widget);
				}
			});
		}
	});

})();
