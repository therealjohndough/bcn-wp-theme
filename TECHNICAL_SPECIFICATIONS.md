# BCN WordPress Theme - Technical Specifications

## WordPress Requirements

### Minimum Requirements
- **WordPress**: 6.0 or higher
- **PHP**: 8.0 or higher
- **MySQL**: 5.7 or higher / MariaDB 10.2 or higher
- **Memory Limit**: 256MB minimum, 512MB recommended
- **Upload Limit**: 64MB minimum

### Required Plugins
- **Advanced Custom Fields Pro**: 6.0+ (Required for all custom fields)
- **All in One SEO**: 4.8+ (SEO management)
- **Wordfence Security**: Latest version (Security)
- **WP Rocket**: Latest version (Performance optimization)

### Recommended Plugins
- **Gravity Forms**: Form creation and management
- **WP Mail SMTP**: Email delivery optimization
- **MonsterInsights**: Google Analytics integration
- **UpdraftPlus**: Backup management

## Custom Post Types & Taxonomies

### Post Types

#### bcn_event
```php
'labels' => [
    'name' => 'Events',
    'singular_name' => 'Event',
    'menu_name' => 'Events',
    'add_new' => 'Add New Event',
    'add_new_item' => 'Add New Event',
    'edit_item' => 'Edit Event',
    'new_item' => 'New Event',
    'view_item' => 'View Event',
    'search_items' => 'Search Events',
    'not_found' => 'No events found',
    'not_found_in_trash' => 'No events found in trash'
],
'public' => true,
'has_archive' => true,
'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
'menu_icon' => 'dashicons-calendar-alt'
```

#### bcn_news
```php
'labels' => [
    'name' => 'News',
    'singular_name' => 'News Article',
    'menu_name' => 'News',
    'add_new' => 'Add New Article',
    'add_new_item' => 'Add New Article',
    'edit_item' => 'Edit Article',
    'new_item' => 'New Article',
    'view_item' => 'View Article',
    'search_items' => 'Search Articles',
    'not_found' => 'No articles found',
    'not_found_in_trash' => 'No articles found in trash'
],
'public' => true,
'has_archive' => true,
'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
'menu_icon' => 'dashicons-media-text'
```

#### bcn_member
```php
'labels' => [
    'name' => 'Members',
    'singular_name' => 'Member',
    'menu_name' => 'Members',
    'add_new' => 'Add New Member',
    'add_new_item' => 'Add New Member',
    'edit_item' => 'Edit Member',
    'new_item' => 'New Member',
    'view_item' => 'View Member',
    'search_items' => 'Search Members',
    'not_found' => 'No members found',
    'not_found_in_trash' => 'No members found in trash'
],
'public' => true,
'has_archive' => true,
'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
'menu_icon' => 'dashicons-groups'
```

#### bcn_resource
```php
'labels' => [
    'name' => 'Resources',
    'singular_name' => 'Resource',
    'menu_name' => 'Resources',
    'add_new' => 'Add New Resource',
    'add_new_item' => 'Add New Resource',
    'edit_item' => 'Edit Resource',
    'new_item' => 'New Resource',
    'view_item' => 'View Resource',
    'search_items' => 'Search Resources',
    'not_found' => 'No resources found',
    'not_found_in_trash' => 'No resources found in trash'
],
'public' => true,
'has_archive' => true,
'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
'menu_icon' => 'dashicons-book-alt'
```

#### bcn_testimonial
```php
'labels' => [
    'name' => 'Testimonials',
    'singular_name' => 'Testimonial',
    'menu_name' => 'Testimonials',
    'add_new' => 'Add New Testimonial',
    'add_new_item' => 'Add New Testimonial',
    'edit_item' => 'Edit Testimonial',
    'new_item' => 'New Testimonial',
    'view_item' => 'View Testimonial',
    'search_items' => 'Search Testimonials',
    'not_found' => 'No testimonials found',
    'not_found_in_trash' => 'No testimonials found in trash'
],
'public' => true,
'has_archive' => true,
'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
'menu_icon' => 'dashicons-format-quote'
```

### Taxonomies

#### event_type
```php
'labels' => [
    'name' => 'Event Types',
    'singular_name' => 'Event Type',
    'menu_name' => 'Event Types',
    'all_items' => 'All Event Types',
    'edit_item' => 'Edit Event Type',
    'view_item' => 'View Event Type',
    'update_item' => 'Update Event Type',
    'add_new_item' => 'Add New Event Type',
    'new_item_name' => 'New Event Type Name',
    'search_items' => 'Search Event Types',
    'not_found' => 'No event types found'
],
'hierarchical' => true,
'public' => true,
'show_ui' => true,
'show_admin_column' => true,
'show_in_nav_menus' => true,
'show_tagcloud' => false
```

#### news_category
```php
'labels' => [
    'name' => 'News Categories',
    'singular_name' => 'News Category',
    'menu_name' => 'News Categories',
    'all_items' => 'All News Categories',
    'edit_item' => 'Edit News Category',
    'view_item' => 'View News Category',
    'update_item' => 'Update News Category',
    'add_new_item' => 'Add New News Category',
    'new_item_name' => 'New News Category Name',
    'search_items' => 'Search News Categories',
    'not_found' => 'No news categories found'
],
'hierarchical' => true,
'public' => true,
'show_ui' => true,
'show_admin_column' => true,
'show_in_nav_menus' => true,
'show_tagcloud' => false
```

#### bcn_membership_level
```php
'labels' => [
    'name' => 'Membership Levels',
    'singular_name' => 'Membership Level',
    'menu_name' => 'Membership Levels',
    'all_items' => 'All Membership Levels',
    'edit_item' => 'Edit Membership Level',
    'view_item' => 'View Membership Level',
    'update_item' => 'Update Membership Level',
    'add_new_item' => 'Add New Membership Level',
    'new_item_name' => 'New Membership Level Name',
    'search_items' => 'Search Membership Levels',
    'not_found' => 'No membership levels found'
],
'hierarchical' => true,
'public' => true,
'show_ui' => true,
'show_admin_column' => true,
'show_in_nav_menus' => true,
'show_tagcloud' => false
```

## ACF Field Groups

### Event Fields (bcn_event)
```php
[
    'key' => 'group_bcn_event',
    'title' => 'Event Details',
    'fields' => [
        [
            'key' => 'field_event_date',
            'label' => 'Event Date',
            'name' => 'event_date',
            'type' => 'date_picker',
            'required' => 1
        ],
        [
            'key' => 'field_event_time',
            'label' => 'Event Time',
            'name' => 'event_time',
            'type' => 'time_picker',
            'required' => 1
        ],
        [
            'key' => 'field_event_location',
            'label' => 'Event Location',
            'name' => 'event_location',
            'type' => 'text',
            'required' => 1
        ],
        [
            'key' => 'field_event_capacity',
            'label' => 'Event Capacity',
            'name' => 'event_capacity',
            'type' => 'number',
            'required' => 1
        ],
        [
            'key' => 'field_event_price',
            'label' => 'Event Price',
            'name' => 'event_price',
            'type' => 'number',
            'step' => 0.01,
            'required' => 1
        ],
        [
            'key' => 'field_event_type',
            'label' => 'Event Type',
            'name' => 'event_type',
            'type' => 'taxonomy',
            'taxonomy' => 'event_type',
            'required' => 1
        ],
        [
            'key' => 'field_event_image',
            'label' => 'Event Image',
            'name' => 'event_image',
            'type' => 'image',
            'return_format' => 'id'
        ],
        [
            'key' => 'field_event_registration',
            'label' => 'Registration URL',
            'name' => 'event_registration',
            'type' => 'url'
        ]
    ],
    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'bcn_event'
            ]
        ]
    ]
]
```

### Member Fields (bcn_member)
```php
[
    'key' => 'group_bcn_member',
    'title' => 'Member Details',
    'fields' => [
        [
            'key' => 'field_member_first_name',
            'label' => 'First Name',
            'name' => 'member_first_name',
            'type' => 'text',
            'required' => 1
        ],
        [
            'key' => 'field_member_last_name',
            'label' => 'Last Name',
            'name' => 'member_last_name',
            'type' => 'text',
            'required' => 1
        ],
        [
            'key' => 'field_member_email',
            'label' => 'Email Address',
            'name' => 'member_email',
            'type' => 'email',
            'required' => 1
        ],
        [
            'key' => 'field_member_phone',
            'label' => 'Phone Number',
            'name' => 'member_phone',
            'type' => 'text'
        ],
        [
            'key' => 'field_member_company',
            'label' => 'Company',
            'name' => 'member_company',
            'type' => 'text'
        ],
        [
            'key' => 'field_member_title',
            'label' => 'Job Title',
            'name' => 'member_title',
            'type' => 'text'
        ],
        [
            'key' => 'field_member_bio',
            'label' => 'Biography',
            'name' => 'member_bio',
            'type' => 'textarea'
        ],
        [
            'key' => 'field_member_photo',
            'label' => 'Profile Photo',
            'name' => 'member_photo',
            'type' => 'image',
            'return_format' => 'id'
        ],
        [
            'key' => 'field_member_membership_level',
            'label' => 'Membership Level',
            'name' => 'member_membership_level',
            'type' => 'taxonomy',
            'taxonomy' => 'bcn_membership_level',
            'required' => 1
        ],
        [
            'key' => 'field_member_can_submit_content',
            'label' => 'Can Submit Content',
            'name' => 'member_can_submit_content',
            'type' => 'true_false',
            'default_value' => 0
        ],
        [
            'key' => 'field_member_submission_key',
            'label' => 'Submission Key',
            'name' => 'member_submission_key',
            'type' => 'text',
            'readonly' => 1
        ]
    ],
    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'bcn_member'
            ]
        ]
    ]
]
```

### Testimonial Fields (bcn_testimonial)
```php
[
    'key' => 'group_bcn_testimonial',
    'title' => 'Testimonial Details',
    'fields' => [
        [
            'key' => 'field_testimonial_type',
            'label' => 'Testimonial Type',
            'name' => 'testimonial_type',
            'type' => 'select',
            'choices' => [
                'written' => 'Written',
                'video' => 'Video',
                'photo' => 'Photo',
                'audio' => 'Audio'
            ],
            'default_value' => 'written',
            'required' => 1
        ],
        [
            'key' => 'field_testimonial_source',
            'label' => 'Testimonial Source',
            'name' => 'testimonial_source',
            'type' => 'select',
            'choices' => [
                'website' => 'Website Form',
                'email' => 'Email',
                'event' => 'Event',
                'social_media' => 'Social Media',
                'member_portal' => 'Member Portal'
            ],
            'default_value' => 'member_portal',
            'required' => 1
        ],
        [
            'key' => 'field_testimonial_rating',
            'label' => 'Rating (1-5 Stars)',
            'name' => 'testimonial_rating',
            'type' => 'number',
            'min' => 1,
            'max' => 5,
            'step' => 1,
            'default_value' => 5
        ],
        [
            'key' => 'field_testimonial_member_id',
            'label' => 'Associated Member',
            'name' => 'testimonial_member_id',
            'type' => 'post_object',
            'post_type' => ['bcn_member'],
            'return_format' => 'id'
        ],
        [
            'key' => 'field_testimonial_approval_status',
            'label' => 'Approval Status',
            'name' => 'testimonial_approval_status',
            'type' => 'select',
            'choices' => [
                'pending' => 'Pending Review',
                'approved' => 'Approved',
                'featured' => 'Approved & Featured',
                'rejected' => 'Rejected'
            ],
            'default_value' => 'pending',
            'required' => 1
        ],
        [
            'key' => 'field_testimonial_featured',
            'label' => 'Feature Testimonial',
            'name' => 'testimonial_featured',
            'type' => 'true_false',
            'default_value' => 0
        ],
        [
            'key' => 'field_testimonial_industry_focus',
            'label' => 'Industry Focus',
            'name' => 'testimonial_industry_focus',
            'type' => 'select',
            'choices' => [
                'cultivation' => 'Cultivation',
                'retail' => 'Retail',
                'advocacy' => 'Advocacy',
                'processing' => 'Processing',
                'ancillary' => 'Ancillary Services',
                'other' => 'Other'
            ],
            'multiple' => 1
        ]
    ],
    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'bcn_testimonial'
            ]
        ]
    ]
]
```

## Automation Systems

### Content Automation
```php
// Auto-publish scheduled content
add_action('wp_scheduled_publish', 'bcn_auto_publish_content');

// Email automation queue
add_action('init', 'bcn_process_email_queue');

// Daily reports generation
add_action('wp_scheduled_delete', 'bcn_generate_daily_reports');
```

### Member Automation
```php
// Member onboarding sequence
add_action('user_register', 'bcn_member_onboarding');

// Achievement checking
add_action('save_post', 'bcn_check_achievements');

// Points calculation
add_action('bcn_submission_approved', 'bcn_award_points');
```

### Event Automation
```php
// Event reminder emails
add_action('wp_scheduled_delete', 'bcn_send_event_reminders');

// Event capacity monitoring
add_action('wp_scheduled_delete', 'bcn_monitor_event_capacity');

// Post-event follow-up
add_action('wp_scheduled_delete', 'bcn_send_event_followup');
```

## Database Schema

### Custom Tables
```sql
-- Member points and achievements
CREATE TABLE wp_bcn_member_points (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    points INT DEFAULT 0,
    achievement_id VARCHAR(50),
    earned_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES wp_posts(ID)
);

-- Email queue for automation
CREATE TABLE wp_bcn_email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    scheduled_date DATETIME NOT NULL,
    status ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Achievement definitions
CREATE TABLE wp_bcn_achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    achievement_key VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    points_required INT DEFAULT 0,
    category VARCHAR(50),
    badge_icon VARCHAR(255),
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## File Structure

### Theme Directory Structure
```
bcn-wp-theme/
├── admin-theme/
│   ├── admin-theme.php
│   ├── assets/
│   │   ├── css/
│   │   │   ├── admin-main.css
│   │   │   ├── admin-components.css
│   │   │   └── admin-responsive.css
│   │   ├── js/
│   │   │   ├── admin-main.js
│   │   │   ├── admin-forms.js
│   │   │   └── admin-dashboard.js
│   │   └── images/
│   │       ├── logo.svg
│   │       └── icons/
│   └── template-parts/
│       └── admin/
├── assets/
│   ├── css/
│   │   ├── design-system.css
│   │   ├── patterns.css
│   │   ├── member-portal.css
│   │   ├── member-dashboard.css
│   │   └── submission-admin.css
│   ├── js/
│   │   ├── main.js
│   │   ├── navigation.js
│   │   ├── member-dashboard.js
│   │   └── submission-admin.js
│   └── scripts/
│       └── install-and-build.sh
├── includes/
│   ├── acf-fields/
│   │   └── acf-field-groups.php
│   ├── automation/
│   │   └── automation.php
│   ├── custom-post-types/
│   │   ├── custom-post-types.php
│   │   └── events.php
│   ├── seo/
│   │   └── seo-optimization.php
│   ├── enhanced-testimonial-system.php
│   ├── blog-submission-system.php
│   ├── member-dashboard-system.php
│   ├── submission-workflows.php
│   ├── community-features.php
│   ├── customizer.php
│   ├── front-page-customizer.php
│   ├── internal-linking.php
│   ├── member-directory.php
│   ├── patterns.php
│   ├── post-types.php
│   ├── template-functions.php
│   └── template-tags.php
├── template-parts/
│   ├── admin/
│   │   └── dashboard.php
│   ├── events/
│   ├── front-page/
│   │   ├── blocks/
│   │   ├── events.php
│   │   ├── hero-new.php
│   │   └── hero.php
│   ├── members/
│   └── news/
├── bcn-wp-theme/
│   ├── admin-theme/
│   ├── front-page.php
│   ├── functions.php
│   ├── includes/
│   ├── page-contact.php
│   └── template-parts/
├── page-member-portal.php
├── functions.php
├── style.css
└── index.php
```

## Coding Standards

### PHP Standards
- Follow WordPress Coding Standards (WPCS)
- Use PSR-4 autoloading where applicable
- Implement proper error handling and logging
- Use WordPress hooks and filters appropriately
- Sanitize all user inputs
- Escape all outputs

### JavaScript Standards
- Use ES6+ features where supported
- Follow WordPress JavaScript coding standards
- Implement proper error handling
- Use jQuery for WordPress compatibility
- Minify production JavaScript files

### CSS Standards
- Use CSS custom properties (variables)
- Follow BEM methodology for class naming
- Implement mobile-first responsive design
- Use CSS Grid and Flexbox for layouts
- Optimize for performance and accessibility

### Security Best Practices
- Implement nonce verification on all forms
- Sanitize and validate all user inputs
- Use proper user capability checks
- Implement rate limiting where appropriate
- Regular security audits and updates

## Performance Optimization

### Frontend Optimization
- Minify CSS and JavaScript files
- Optimize images (WebP format with fallbacks)
- Implement lazy loading for images
- Use CSS and JavaScript concatenation
- Implement browser caching headers

### Backend Optimization
- Use WordPress object caching
- Optimize database queries
- Implement proper indexing
- Use WordPress transients for caching
- Regular database optimization

### CDN and Caching
- Implement CDN for static assets
- Use WordPress caching plugins
- Implement page caching
- Use browser caching effectively
- Optimize server response times

---

*This technical specification document serves as the complete reference for developers working on the BCN WordPress theme. All development should follow these specifications for consistency and maintainability.*
