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
			this.entryEl = element.querySelector('.dataphiles-dynamic-text__entry');
			this.impactEl = element.querySelector('.dataphiles-dynamic-text__impact');
			this.sublineEl = element.querySelector('.dataphiles-dynamic-text__subline');
			this.sparksLeftEl = element.querySelector('.dataphiles-dynamic-text__sparks--left');
			this.sparksRightEl = element.querySelector('.dataphiles-dynamic-text__sparks--right');

			if (!this.impactEl || !this.sublineEl || !this.settings.entries || this.settings.entries.length === 0) {
				return;
			}

			// Set CSS custom property for drop distance
			element.style.setProperty('--drop-distance', this.settings.dropDistance + 'px');

			// Set data attribute for enter direction (used by CSS)
			element.dataset.enterDirection = this.settings.enterDirection || 'down';

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
			const originalSubOpacity = this.sublineEl.style.opacity;
			const originalSubTransform = this.sublineEl.style.transform;

			// Temporarily make elements visible for measurement
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
			this.sublineEl.style.opacity = originalSubOpacity;
			this.sublineEl.style.transform = originalSubTransform;

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
			// Show the first entry
			this.showEntry();
		}

		showEntry() {
			const entry = this.settings.entries[this.currentIndex];

			// Update content based on type
			if (entry.contentType === 'image' && entry.imageUrl) {
				this.impactEl.innerHTML = '<img src="' + entry.imageUrl + '" alt="' + (entry.imageAlt || '') + '" />';
			} else {
				this.impactEl.textContent = entry.impact || '';
			}
			this.sublineEl.textContent = entry.subline;

			// Reset state - remove all animation classes
			this.impactEl.classList.remove('is-visible', 'is-exiting-down', 'is-exiting-up');
			this.sublineEl.classList.remove('is-visible', 'is-exiting-down', 'is-exiting-up');

			// Update enter direction data attribute
			this.element.dataset.enterDirection = this.settings.enterDirection || 'down';

			// Set transition durations for enter
			this.impactEl.style.transitionDuration = this.settings.impactEnterDuration + 'ms';
			this.sublineEl.style.transitionDuration = this.settings.sublineEnterDuration + 'ms';

			// Force reflow on parent to ensure CSS transforms are applied
			void this.entryEl.offsetHeight;

			// Use double requestAnimationFrame for reliable paint timing
			requestAnimationFrame(() => {
				requestAnimationFrame(() => {
					// Step 1: Impact text enters (drops in or rises up, depending on direction)
					this.impactEl.classList.add('is-visible');
				});
			});

			// Trigger sparks when impact text appears
			if (this.settings.sparksEnabled) {
				this.addTimeout(() => {
					this.triggerSparks();
				}, this.settings.impactEnterDuration * 0.3); // Sparks appear partway through animation
			}

			// Step 2: After delay, subline fades in
			this.addTimeout(() => {
				this.sublineEl.classList.add('is-visible');
			}, this.settings.impactEnterDuration + this.settings.sublineDelay);

			// Step 3: After display duration, start exit animation
			// Use per-entry custom duration if set, otherwise use default
			const displayDuration = entry.displayDuration !== undefined
				? entry.displayDuration
				: this.settings.displayDuration;

			const totalEnterTime = this.settings.impactEnterDuration + this.settings.sublineDelay + this.settings.sublineEnterDuration;

			this.addTimeout(() => {
				this.exitEntry();
			}, totalEnterTime + displayDuration);
		}

		/**
		 * Create and animate spark particles
		 */
		triggerSparks() {
			if (!this.sparksLeftEl || !this.sparksRightEl) return;

			const count = this.settings.sparksCount || 3;
			const color = this.settings.sparksColor || '#ff9500';
			const size = this.settings.sparksSize || 6;
			const showTrail = this.settings.sparksTrail;
			const duration = this.settings.sparksDuration || 1000;

			// Create sparks for left side
			for (let i = 0; i < count; i++) {
				this.createSpark(this.sparksLeftEl, color, size, showTrail, duration, 'left', i, count);
			}

			// Create sparks for right side
			for (let i = 0; i < count; i++) {
				this.createSpark(this.sparksRightEl, color, size, showTrail, duration, 'right', i, count);
			}
		}

		/**
		 * Create a single spark particle
		 */
		createSpark(container, color, size, showTrail, duration, side, index, total) {
			const spark = document.createElement('div');
			spark.className = 'dataphiles-dynamic-text__spark';
			if (showTrail) {
				spark.classList.add('dataphiles-dynamic-text__spark--trail');
			}

			// Random positioning within container - closer to the text
			const startX = side === 'left'
				? Math.random() * 15 + 3  // 3-18px from right edge
				: Math.random() * 15 + 3; // 3-18px from left edge

			// Stagger the start positions vertically around baseline
			const startY = (index / total) * 8 - 4;

			// Generate multiple random drift points for direction changes
			const drift1 = (Math.random() - 0.5) * 12;
			const drift2 = (Math.random() - 0.5) * 14;
			const drift3 = (Math.random() - 0.5) * 12;
			const drift4 = (Math.random() - 0.5) * 16;
			const drift5 = (Math.random() - 0.5) * 10;

			// Apply styles - soft glowing circle
			spark.style.cssText = `
				width: ${size}px;
				height: ${size}px;
				background: radial-gradient(circle, ${color} 0%, ${color}88 40%, transparent 70%);
				color: ${color};
				left: ${side === 'left' ? 'auto' : startX + 'px'};
				right: ${side === 'left' ? startX + 'px' : 'auto'};
				bottom: ${startY}px;
				box-shadow: 0 0 ${size * 0.5}px ${color}, 0 0 ${size}px ${color}66;
			`;

			container.appendChild(spark);

			// Stagger the animation start
			const delay = (index / total) * (duration * 0.15);

			setTimeout(() => {
				// Show trail after a brief moment
				if (showTrail) {
					setTimeout(() => {
						spark.classList.add('is-animating');
					}, 50);
					// Fade trail out before spark ends
					setTimeout(() => {
						spark.classList.remove('is-animating');
					}, duration * 0.6);
				}

				// Animate using Web Animations API - wandering floating rise
				const animation = spark.animate([
					{
						opacity: 0,
						transform: 'translateY(0) translateX(0) scale(0.3)'
					},
					{
						opacity: 0.9,
						transform: `translateY(-8px) translateX(${drift1}px) scale(1)`,
						offset: 0.1
					},
					{
						opacity: 1,
						transform: `translateY(-18px) translateX(${drift2}px) scale(1)`,
						offset: 0.25
					},
					{
						opacity: 1,
						transform: `translateY(-28px) translateX(${drift3}px) scale(0.95)`,
						offset: 0.4
					},
					{
						opacity: 0.8,
						transform: `translateY(-40px) translateX(${drift4}px) scale(0.85)`,
						offset: 0.6
					},
					{
						opacity: 0.4,
						transform: `translateY(-52px) translateX(${drift5}px) scale(0.65)`,
						offset: 0.8
					},
					{
						opacity: 0,
						transform: `translateY(-60px) translateX(${drift5 + (Math.random() - 0.5) * 8}px) scale(0.4)`
					}
				], {
					duration: duration,
					easing: 'cubic-bezier(0.4, 0, 0.2, 1)', // Smooth ease-out
					fill: 'forwards'
				});

				animation.onfinish = () => {
					spark.remove();
				};
			}, delay);
		}

		exitEntry() {
			// Set exit transition durations (separate for impact and subline)
			this.impactEl.style.transitionDuration = this.settings.impactExitDuration + 'ms';
			this.sublineEl.style.transitionDuration = this.settings.sublineExitDuration + 'ms';

			// Determine exit class based on exit direction
			const exitClass = this.settings.exitDirection === 'up' ? 'is-exiting-up' : 'is-exiting-down';

			// Both elements exit together
			this.impactEl.classList.remove('is-visible');
			this.impactEl.classList.add(exitClass);
			this.sublineEl.classList.remove('is-visible');
			this.sublineEl.classList.add(exitClass);

			// After exit animation completes, wait for delay then show next entry
			const maxExitDuration = Math.max(this.settings.impactExitDuration, this.settings.sublineExitDuration);

			this.addTimeout(() => {
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
