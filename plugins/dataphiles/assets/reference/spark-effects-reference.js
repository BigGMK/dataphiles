/**
 * SPARK EFFECTS REFERENCE CODE
 *
 * This file contains the spark effects code that was removed from the main widget
 * for performance optimization. To re-enable sparks:
 *
 * 1. Copy the JavaScript methods back into dynamic-text.js DynamicTextWidget class
 * 2. Copy the CSS from spark-effects-reference.css into dynamic-text.css
 * 3. Re-enable the PHP controls in class-dynamic-text-widget.php
 * 4. Add spark containers back to the render() method HTML output
 *
 * @package Dataphiles
 * @since 1.0.6
 */

// ============================================
// JAVASCRIPT - Add these methods to the DynamicTextWidget class
// ============================================

/**
 * Trigger sparks - call this in showEntry() after the RAF animation starts
 * Example:
 *   if (this.settings.sparksEnabled) {
 *     this.addTimeout(() => {
 *       this.triggerSparks();
 *     }, this.settings.impactEnterDuration * 0.3);
 *   }
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

// ============================================
// DOM ELEMENTS - Add these queries in the constructor
// ============================================
// this.sparksLeftEl = element.querySelector('.dataphiles-dynamic-text__sparks--left');
// this.sparksRightEl = element.querySelector('.dataphiles-dynamic-text__sparks--right');

// ============================================
// HTML STRUCTURE - Add these elements in render() around the impact element
// ============================================
/*
<div class="dataphiles-dynamic-text__impact-wrapper">
    <div class="dataphiles-dynamic-text__sparks dataphiles-dynamic-text__sparks--left"></div>
    <h2 class="dataphiles-dynamic-text__impact">...</h2>
    <div class="dataphiles-dynamic-text__sparks dataphiles-dynamic-text__sparks--right"></div>
</div>
*/
