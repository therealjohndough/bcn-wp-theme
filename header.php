<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    
    <!-- Header / Navigation -->
    <header id="masthead" class="site-header" style="background: #000; padding: 0.75rem 2rem; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
        <div class="header-container" style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 60px;">
            
            <!-- Site Logo/Title -->
            <div class="site-branding" style="flex-shrink: 0;">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #FFFFFF; text-decoration: none; font-size: 1.25rem; font-weight: 700; font-family: 'Roboto Flex', sans-serif; line-height: 1; display: block;">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Primary Navigation -->
            <nav id="site-navigation" class="main-navigation" style="flex-grow: 1; display: flex; justify-content: flex-end;">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'primary-menu',
                    'fallback_cb'    => 'bcn_default_menu',
                ) );
                ?>
            </nav>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobile-menu-toggle" style="display: none; background: none; border: none; color: #fff; cursor: pointer; padding: 0.5rem; width: 40px; height: 40px; align-items: center; justify-content: center; flex-shrink: 0;" aria-label="Open menu" aria-expanded="false">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="mobile-overlay"></div>
    
    <!-- Mobile Menu Drawer -->
    <nav id="mobile-menu" class="mobile-menu-drawer">
        <div class="mobile-menu-header">
            <span style="color: var(--md-sys-color-primary); font-weight: 700; font-size: 1.25rem;">Menu</span>
            <button id="mobile-menu-close" class="mobile-menu-close" aria-label="Close menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_id'        => 'mobile-primary-menu',
            'container'      => false,
            'menu_class'     => 'mobile-primary-menu',
            'fallback_cb'    => 'bcn_default_menu',
        ) );
        ?>
    </nav>

    <style>
        /* Site Header */
        .site-header {
            font-family: 'Roboto Flex', sans-serif;
        }
        
        .header-container {
            min-height: 60px;
        }
        
        .site-branding img {
            max-height: 45px;
            width: auto;
        }
        
        /* Navigation Styles */
        .primary-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 1.5rem;
            align-items: center;
        }
        
        .primary-menu li {
            margin: 0;
            padding: 0;
        }
        
        .primary-menu a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s ease;
            font-family: 'Roboto Flex', sans-serif;
            white-space: nowrap;
            padding: 0.5rem 0;
            display: block;
        }
        
        .primary-menu a:hover {
            color: #7CB342;
        }
        
        .primary-menu .current-menu-item > a,
        .primary-menu .current_page_item > a {
            color: #7CB342;
            font-weight: 600;
        }
        
        /* Remove submenu styles if not needed */
        .primary-menu .sub-menu {
            display: none;
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .mobile-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        
        /* Mobile Menu Drawer - Material 3 */
        .mobile-menu-drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 85%;
            max-width: 320px;
            background: var(--md-sys-color-surface);
            z-index: 1000;
            transform: translateX(-100%);
            transition: transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--md-elevation-5);
            overflow-y: auto;
        }
        
        .mobile-menu-drawer.active {
            transform: translateX(0);
        }
        
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: var(--md-spacing-6) var(--md-spacing-4);
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
        }
        
        .mobile-menu-close {
            background: none;
            border: none;
            font-size: 24px;
            color: var(--md-sys-color-on-surface);
            cursor: pointer;
            padding: 8px;
            width: 40px;
            height: 40px;
            border-radius: var(--md-shape-corner-full);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 200ms;
        }
        
        .mobile-menu-close:hover {
            background: var(--md-sys-color-surface-variant);
        }
        
        .mobile-primary-menu {
            list-style: none;
            padding: var(--md-spacing-4) 0;
            margin: 0;
        }
        
        .mobile-primary-menu li {
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
        }
        
        .mobile-primary-menu li:last-child {
            border-bottom: none;
        }
        
        .mobile-primary-menu a {
            display: block;
            padding: var(--md-spacing-4);
            color: var(--md-sys-color-on-surface);
            text-decoration: none;
            font-family: 'Roboto Flex', sans-serif;
            font-size: 16px;
            font-weight: 500;
            transition: all 200ms;
            position: relative;
        }
        
        .mobile-primary-menu a:hover {
            background: var(--md-sys-color-surface-variant);
            color: var(--md-sys-color-primary);
            padding-left: var(--md-spacing-6);
        }
        
        .mobile-primary-menu .current-menu-item > a,
        .mobile-primary-menu .current_page_item > a {
            color: var(--md-sys-color-primary);
            background: var(--md-sys-color-primary-container);
            font-weight: 600;
        }
        
        /* Mobile Menu Styles */
        @media (max-width: 768px) {
            .main-navigation {
                display: none !important;
            }
            
            .mobile-menu-toggle {
                display: flex !important;
            }
            
            .site-branding a,
            .site-branding img {
                max-width: 180px;
            }
            
            .header-container {
                padding: 0 var(--md-spacing-4);
            }
            
            .site-header {
                padding: 0.5rem var(--md-spacing-4);
            }
            
            .header-container {
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
            }
        }
        
        @media (max-width: 480px) {
            .site-branding a,
            .site-branding img {
                max-width: 140px;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-menu-drawer,
            .mobile-overlay {
                display: none !important;
            }
        }
        
        .site-header {
            font-family: 'Roboto Flex', sans-serif;
        }
    </style>

    <script>
        // Mobile menu toggle - Material 3 Drawer
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('mobile-overlay');
            const closeBtn = document.getElementById('mobile-menu-close');
            
            function openMenu() {
                menu.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
                if (toggle) toggle.setAttribute('aria-expanded', 'true');
            }
            
            function closeMenu() {
                menu.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
            }
            
            if (toggle) {
                toggle.addEventListener('click', openMenu);
            }
            
            if (closeBtn) {
                closeBtn.addEventListener('click', closeMenu);
            }
            
            if (overlay) {
                overlay.addEventListener('click', closeMenu);
            }
            
            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && menu.classList.contains('active')) {
                    closeMenu();
                }
            });
        });
    </script>

