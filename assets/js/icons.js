/**
 * Buffalo Cannabis Network - Icon System
 * Converts custom icon classes to Lucide SVG icons
 */

(function() {
    'use strict';

    // Icon name mappings (your preferred names → Lucide names)
    const iconMappings = {
        'pocket-knife': 'pocket-knife',
        'ferris-wheel': 'ferris-wheel',
        'lamp-ceiling': 'lamp-ceiling',
        'sparkle': 'sparkle',
        'snail': 'snail',
        'tickets': 'tickets',
        'calendar-fold': 'calendar-fold',
        'loader-pinwheel': 'loader-pinwheel',
        'mic-vocal': 'mic-vocal',
        'radio-tower': 'radio-tower',
        'pyramid': 'pyramid',
        'bus': 'bus',
        
        // Common icons
        'calendar': 'calendar',
        'clock': 'clock',
        'map-pin': 'map-pin',
        'users': 'users',
        'heart': 'heart',
        'star': 'star',
        'mail': 'mail',
        'phone': 'phone',
        'arrow-right': 'arrow-right',
        'external-link': 'external-link',
        'check': 'check',
        'x': 'x',
        'menu': 'menu',
        'search': 'search',
        'home': 'home',
        'info': 'info',
        'alert-circle': 'alert-circle',
        'chevron-right': 'chevron-right',
        'chevron-left': 'chevron-left',
        'chevron-down': 'chevron-down',
        'chevron-up': 'chevron-up',
        'plus': 'plus',
        'minus': 'minus',
        'edit': 'edit',
        'trash': 'trash',
        'download': 'download',
        'upload': 'upload',
        'share': 'share',
        'link': 'link',
        'image': 'image',
        'file': 'file',
        'folder': 'folder',
        'settings': 'settings',
        'eye': 'eye',
        'eye-off': 'eye-off',
        'facebook': 'facebook',
        'twitter': 'twitter',
        'instagram': 'instagram',
        'linkedin': 'linkedin',
        'youtube': 'youtube',
        'building': 'building',
        'building-2': 'building-2',
        'edit': 'edit-2',
        'pencil': 'pencil'
    };

    /**
     * Initialize icons
     * Converts <div class="icon-xxx"></div> to Lucide SVG
     */
    function initIcons() {
        // Check if Lucide is available
        if (typeof lucide === 'undefined') {
            console.warn('Lucide library not loaded. Icons will not render.');
            return;
        }

        // Find all elements with icon- classes
        const iconElements = document.querySelectorAll('[class*="icon-"]');
        
        iconElements.forEach(element => {
            // Extract icon name from class
            const classList = Array.from(element.classList);
            const iconClass = classList.find(cls => cls.startsWith('icon-') && cls !== 'icon-xs' && cls !== 'icon-sm' && cls !== 'icon-md' && cls !== 'icon-lg' && cls !== 'icon-xl' && cls !== 'icon-2xl');
            
            if (!iconClass) return;
            
            // Get icon name (remove 'icon-' prefix)
            const iconName = iconClass.replace('icon-', '');
            
            // Get Lucide icon name from mapping
            const lucideIconName = iconMappings[iconName] || iconName;
            
            // Skip if already has data-lucide or contains SVG
            if (element.hasAttribute('data-lucide') || element.querySelector('svg')) {
                return;
            }
            
            // Add data-lucide attribute
            element.setAttribute('data-lucide', lucideIconName);
            
            // Get stroke width from classes or default
            let strokeWidth = '1.5'; // Default optimal width
            if (element.classList.contains('icon-thin')) strokeWidth = '1';
            if (element.classList.contains('icon-regular')) strokeWidth = '1.5';
            if (element.classList.contains('icon-medium')) strokeWidth = '2';
            if (element.classList.contains('icon-bold')) strokeWidth = '2.5';
            if (element.classList.contains('icon-heavy')) strokeWidth = '3';
            
            element.setAttribute('stroke-width', strokeWidth);
        });

        // Create all icons using Lucide
        lucide.createIcons({
            attrs: {
                'stroke-width': 1.5 // Default stroke width
            }
        });
    }

    /**
     * Initialize on DOM ready
     */
    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    /**
     * Re-initialize icons when DOM changes (for dynamic content)
     */
    function observeIconChanges() {
        const observer = new MutationObserver(function(mutations) {
            let shouldReinitialize = false;
            
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Element node
                            const hasIconClass = node.classList && Array.from(node.classList).some(cls => cls.startsWith('icon-'));
                            const containsIconClass = node.querySelectorAll && node.querySelectorAll('[class*="icon-"]').length > 0;
                            
                            if (hasIconClass || containsIconClass) {
                                shouldReinitialize = true;
                            }
                        }
                    });
                }
            });
            
            if (shouldReinitialize) {
                initIcons();
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    /**
     * Initialize everything
     */
    ready(function() {
        initIcons();
        observeIconChanges();
        
        // Re-initialize on WordPress block editor updates
        if (window.wp && window.wp.data) {
            let previousContent = '';
            
            window.wp.data.subscribe(function() {
                const currentContent = document.body.innerHTML;
                if (currentContent !== previousContent) {
                    previousContent = currentContent;
                    setTimeout(initIcons, 100);
                }
            });
        }
    });

    // Export for manual re-initialization if needed
    window.bcnInitIcons = initIcons;

})();