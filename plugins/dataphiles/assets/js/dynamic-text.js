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
	// Debug logging helper
	const DEBUG = true;
	const log = (...args) => DEBUG && console.log('[DynamicText]', ...args);

	class DynamicTextWidget {
		constructor(element) {
			this.element = element;
			this.settings = JSON.parse(element.dataset.settings || '{}');
			this.currentIndex = 0;
			this.isPaused = false;
			this.timeoutIds = [];

			log('Constructor called');
			log('Settings:', this.settings);

			// Get DOM elements
			this.entryEl = element.querySelector('.dataphiles-dynamic-text__entry');
			this.impactEl = element.querySelector('.dataphiles-dynamic-text__impact');
			this.sublineEl = element.querySelector('.dataphiles-dynamic-text__subline');

			log('DOM Elements found:', {
				entry: !!this.entryEl,
				impact: !!this.impactEl,
				subline: !!this.sublineEl,
				entries: this.settings.entries?.length || 0
			});

			if (!this.impactEl || !this.sublineEl || !this.settings.entries || this.settings.entries.length === 0) {
				log('ERROR: Missing required elements or entries, aborting');
				return;
			}

			// Set CSS custom property for drop distance
			element.style.setProperty('--drop-distance', this.settings.dropDistance + 'px');
			log('Drop distance set:', this.settings.dropDistance + 'px');

			// Set data attribute for enter direction (used by CSS)
			element.dataset.enterDirection = this.settings.enterDirection || 'down';
			log('Enter direction:', element.dataset.enterDirection);

			// Initialize
			this.init();
		}

		init() {
			// Calculate and lock container height to prevent layout shifts
			this.lockContainerHeight();

			// Bind hover events if pause on hover is enabled
			if (this.settings.pauseOnHover) {
				this.element.addEventListener('mouseenter', () => this.pause());
				this.element.addEventListener('mouseleave', () => this.resume());
			}

			// Start the animation cycle
			this.startCycle();
		}

		/**
		 * Calculate the maximum height needed for all entries and lock the container
		 */
		lockContainerHeight() {
			// Store original styles
			const originalOpacity = this.impactEl.style.opacity;
			const originalTransform = this.impactEl.style.transform;
			const originalTransition = this.impactEl.style.transition;
			const originalSubOpacity = this.sublineEl.style.opacity;
			const originalSubTransform = this.sublineEl.style.transform;
			const originalSubTransition = this.sublineEl.style.transition;

			// Disable transitions and make elements visible for measurement
			this.impactEl.style.transition = 'none';
			this.sublineEl.style.transition = 'none';
			this.impactEl.style.opacity = '1';
			this.impactEl.style.transform = 'none';
			this.sublineEl.style.opacity = '1';
			this.sublineEl.style.transform = 'none';

			let maxHeight = 0;

			// Measure each entry
			this.settings.entries.forEach((entry) => {
				// Set content
				if (entry.contentType === 'image' && entry.imageUrl) {
					this.impactEl.innerHTML = '<img src="' + entry.imageUrl + '" alt="' + (entry.imageAlt || '') + '" />';
				} else {
					this.impactEl.textContent = entry.impact || '';
				}
				this.sublineEl.textContent = entry.subline;

				// Force reflow
				void this.entryEl.offsetHeight;

				// Measure
				const height = this.entryEl.offsetHeight;
				if (height > maxHeight) {
					maxHeight = height;
				}
			});

			// Set minimum height on container
			if (maxHeight > 0) {
				this.element.style.minHeight = maxHeight + 'px';
			}

			// Restore original styles
			this.impactEl.style.opacity = originalOpacity;
			this.impactEl.style.transform = originalTransform;
			this.impactEl.style.transition = originalTransition;
			this.sublineEl.style.opacity = originalSubOpacity;
			this.sublineEl.style.transform = originalSubTransform;
			this.sublineEl.style.transition = originalSubTransition;

			// Reset to first entry content
			const firstEntry = this.settings.entries[0];
			if (firstEntry.contentType === 'image' && firstEntry.imageUrl) {
				this.impactEl.innerHTML = '<img src="' + firstEntry.imageUrl + '" alt="' + (firstEntry.imageAlt || '') + '" />';
			} else {
				this.impactEl.textContent = firstEntry.impact || '';
			}
			this.sublineEl.textContent = firstEntry.subline;
		}

		startCycle() {
			log('startCycle() called');
			// Show the first entry
			this.showEntry();
		}

		showEntry() {
			const entry = this.settings.entries[this.currentIndex];
			const isImage = entry.contentType === 'image' && entry.imageUrl;

			log('showEntry() - Index:', this.currentIndex);
			log('Entry data:', entry);
			log('Is image/SVG:', isImage);

			// Update content based on type
			if (isImage) {
				this.impactEl.innerHTML = '<img src="' + entry.imageUrl + '" alt="' + (entry.imageAlt || '') + '" />';
				log('Set image content:', entry.imageUrl);
			} else {
				this.impactEl.textContent = entry.impact || '';
				log('Set text content:', entry.impact);
			}
			this.sublineEl.textContent = entry.subline;

			// Reset state - remove all animation classes
			this.impactEl.classList.remove('is-visible', 'is-exiting-down', 'is-exiting-up');
			this.sublineEl.classList.remove('is-visible', 'is-exiting-down', 'is-exiting-up');

			// Update enter direction data attribute
			const enterDir = this.settings.enterDirection || 'down';
			this.element.dataset.enterDirection = enterDir;

			// Set initial state based on content type
			const dropDist = this.settings.dropDistance || 50;
			const impactDuration = this.settings.impactEnterDuration;
			const sublineDuration = this.settings.sublineEnterDuration;

			// Disable transitions initially to set starting position without animation
			this.impactEl.style.transition = 'none';
			this.sublineEl.style.transition = 'none';

			if (isImage) {
				// Images/SVGs: fade only, no transform animation
				this.impactEl.style.transform = 'translateY(0)';
				log('Image mode: fade only, no transform');
			} else {
				// Text: use transform animation
				if (enterDir === 'down') {
					this.impactEl.style.transform = `translateY(-${dropDist}px)`;
					log('Text mode: drop down, initial transform:', `translateY(-${dropDist}px)`);
				} else {
					this.impactEl.style.transform = `translateY(${dropDist}px)`;
					log('Text mode: rise up, initial transform:', `translateY(${dropDist}px)`);
				}
			}
			this.impactEl.style.opacity = '0';
			this.sublineEl.style.opacity = '0';
			// Set initial subline position (always uses direction animation)
			if (enterDir === 'down') {
				this.sublineEl.style.transform = `translateY(-${dropDist}px)`;
			} else {
				this.sublineEl.style.transform = `translateY(${dropDist}px)`;
			}
			log('Initial state set - impact opacity: 0, transform:', this.impactEl.style.transform);
			log('Initial state set - subline opacity: 0, transform:', this.sublineEl.style.transform);

			// Force reflow to ensure initial position is painted
			void this.impactEl.offsetHeight;
			void this.sublineEl.offsetHeight;

			// Use double requestAnimationFrame for reliable paint timing
			requestAnimationFrame(() => {
				requestAnimationFrame(() => {
					// Enable transitions with full property definition
					this.impactEl.style.transition = `opacity ${impactDuration}ms ease-out, transform ${impactDuration}ms ease-out`;
					this.sublineEl.style.transition = `opacity ${sublineDuration}ms ease-out, transform ${sublineDuration}ms ease-out`;

					// Impact enters - animate to visible
					log('RAF callback - animating to visible');
					log('Transition set:', `opacity ${impactDuration}ms ease-out, transform ${impactDuration}ms ease-out`);
					this.impactEl.style.transform = 'translateY(0)';
					this.impactEl.style.opacity = '1';
					this.impactEl.classList.add('is-visible');
					log('Animation started - transform: translateY(0), opacity: 1');
				});
			});

			// Step 2: After delay, subline fades in
			this.addTimeout(() => {
				log('Subline entering');
				this.sublineEl.style.opacity = '1';
				this.sublineEl.style.transform = 'translateY(0)';
				this.sublineEl.classList.add('is-visible');
			}, this.settings.impactEnterDuration + this.settings.sublineDelay);

			// Step 3: After display duration, start exit animation
			// Use per-entry custom duration if set, otherwise use default
			const displayDuration = entry.displayDuration !== undefined
				? entry.displayDuration
				: this.settings.displayDuration;

			const totalEnterTime = this.settings.impactEnterDuration + this.settings.sublineDelay + this.settings.sublineEnterDuration;

			log('Timing - enter:', totalEnterTime, 'ms, display:', displayDuration, 'ms');

			this.addTimeout(() => {
				log('Display complete, starting exit');
				this.exitEntry();
			}, totalEnterTime + displayDuration);
		}

		exitEntry() {
			const entry = this.settings.entries[this.currentIndex];
			const isImage = entry.contentType === 'image' && entry.imageUrl;
			const dropDist = this.settings.dropDistance || 50;
			const impactExitDuration = this.settings.impactExitDuration;
			const sublineExitDuration = this.settings.sublineExitDuration;

			log('exitEntry() - Index:', this.currentIndex, 'isImage:', isImage);

			// Set exit transitions
			this.impactEl.style.transition = `opacity ${impactExitDuration}ms ease-out, transform ${impactExitDuration}ms ease-out`;
			this.sublineEl.style.transition = `opacity ${sublineExitDuration}ms ease-out, transform ${sublineExitDuration}ms ease-out`;

			// Determine exit direction and transform
			const exitDir = this.settings.exitDirection || 'down';
			const exitTransform = exitDir === 'up' ? `translateY(-${dropDist}px)` : `translateY(${dropDist}px)`;
			const exitClass = exitDir === 'up' ? 'is-exiting-up' : 'is-exiting-down';
			log('Exit direction:', exitDir, 'Exit transform:', exitTransform);

			// Images/SVGs: fade only exit
			if (isImage) {
				log('Image exit: fade only');
				this.impactEl.classList.remove('is-visible');
				this.impactEl.style.opacity = '0';
				// No transform change for images
			} else {
				log('Text exit: using transform animation');
				// Text: use transform exit animation
				this.impactEl.classList.remove('is-visible');
				this.impactEl.classList.add(exitClass);
				this.impactEl.style.opacity = '0';
				this.impactEl.style.transform = exitTransform;
			}

			// Subline always uses transform animation
			this.sublineEl.classList.remove('is-visible');
			this.sublineEl.classList.add(exitClass);
			this.sublineEl.style.opacity = '0';
			this.sublineEl.style.transform = exitTransform;

			// After exit animation completes, wait for delay then show next entry
			const maxExitDuration = Math.max(this.settings.impactExitDuration, this.settings.sublineExitDuration);

			this.addTimeout(() => {
				// Clean up exit classes
				this.impactEl.classList.remove('is-exiting-down', 'is-exiting-up');
				// Additional delay between entries
				this.addTimeout(() => {
					this.nextEntry();
				}, this.settings.delayBetweenEntries || 0);
			}, maxExitDuration);
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

			// Check current state and resume appropriately
			if (this.impactEl.classList.contains('is-visible') && this.sublineEl.classList.contains('is-visible')) {
				// Both visible - schedule exit
				const entry = this.settings.entries[this.currentIndex];
				const displayDuration = entry.displayDuration !== undefined
					? entry.displayDuration
					: this.settings.displayDuration;

				this.addTimeout(() => {
					this.exitEntry();
				}, displayDuration);
			} else if (this.impactEl.classList.contains('is-exiting-down') || this.impactEl.classList.contains('is-exiting-up')) {
				// Already exiting - move to next
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

	// Helper function to register Elementor widget handler
	function registerElementorHandler() {
		if (typeof window.elementorFrontend !== 'undefined' && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/dataphiles-dynamic-text.default', function($scope) {
				const widget = $scope[0].querySelector('.dataphiles-dynamic-text[data-settings]');
				if (widget && !widget.dataset.initialized) {
					widget.dataset.initialized = 'true';
					new DynamicTextWidget(widget);
				}
			});
			return true;
		}
		return false;
	}

	// Try to register immediately if Elementor is ready
	if (!registerElementorHandler()) {
		// Listen for Elementor init event
		window.addEventListener('elementor/frontend/init', function() {
			registerElementorHandler();
		});
	}

})();
