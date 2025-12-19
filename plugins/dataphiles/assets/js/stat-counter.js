/**
 * Dataphiles Stat Counter Animation
 *
 * Animates stat numbers when they enter the viewport (first time only).
 * Supports formats like "10M+", "2000", "18+", etc.
 *
 * @package Dataphiles
 */

(function() {
	'use strict';

	/**
	 * Parse a stat value to extract numeric value, prefix, and suffix
	 * Examples: "10M+" -> { value: 10, prefix: "", suffix: "M+" }
	 *           "2000" -> { value: 2000, prefix: "", suffix: "" }
	 *           "18+" -> { value: 18, prefix: "", suffix: "+" }
	 */
	function parseStatValue(text) {
		const match = text.match(/^([^\d]*)(\d+(?:\.\d+)?)(.*)$/);
		if (!match) return null;

		return {
			prefix: match[1] || '',
			value: parseFloat(match[2]),
			suffix: match[3] || ''
		};
	}

	/**
	 * Easing function (ease-out cubic)
	 */
	function easeOutCubic(t) {
		return 1 - Math.pow(1 - t, 3);
	}

	/**
	 * Animate a number from 0 to target value
	 */
	function animateValue(element, parsed, duration) {
		const startTime = performance.now();
		const targetValue = parsed.value;
		const isInteger = Number.isInteger(targetValue);

		function update(currentTime) {
			const elapsed = currentTime - startTime;
			const progress = Math.min(elapsed / duration, 1);
			const easedProgress = easeOutCubic(progress);

			let currentValue = targetValue * easedProgress;

			if (isInteger) {
				currentValue = Math.round(currentValue);
			} else {
				currentValue = Math.round(currentValue * 10) / 10;
			}

			element.textContent = parsed.prefix + currentValue + parsed.suffix;

			if (progress < 1) {
				requestAnimationFrame(update);
			}
		}

		requestAnimationFrame(update);
	}

	/**
	 * Initialize stat counter for an element
	 */
	function initStatCounter(heading) {
		// Get the text content (handle nested spans)
		const textContent = heading.textContent.trim();
		const parsed = parseStatValue(textContent);

		if (!parsed) return;

		// Store original for reference
		heading.dataset.statTarget = textContent;

		// Set initial value to 0
		heading.textContent = parsed.prefix + '0' + parsed.suffix;

		// Create observer
		const observer = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					// Animate to target value
					animateValue(heading, parsed, 1500);
					// Stop observing (first time only)
					observer.disconnect();
				}
			});
		}, {
			threshold: 0.5
		});

		observer.observe(heading);
	}

	/**
	 * Initialize all stat counters
	 */
	function init() {
		const headings = document.querySelectorAll('.dataphiles-stats .elementor-heading-title');
		headings.forEach(heading => {
			// Skip if already initialized
			if (heading.dataset.statInitialized) return;
			heading.dataset.statInitialized = 'true';
			initStatCounter(heading);
		});
	}

	// Initialize on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

	// Re-initialize for Elementor editor
	if (typeof window.elementorFrontend !== 'undefined' && window.elementorFrontend.hooks) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/global', init);
	}
})();
