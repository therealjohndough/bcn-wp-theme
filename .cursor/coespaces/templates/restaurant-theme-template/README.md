# Restaurant Theme Template

This is a specialized WordPress theme template designed for restaurants and food service businesses.

## Features

- Restaurant-specific design
- Menu management system
- Online ordering (if applicable)
- Reservation system
- Event management
- Gallery and reviews
- Location and hours
- Social media integration

## Quick Start

1. **Copy this template to your client coespace:**
   ```bash
   cp -r .cursor/coespaces/templates/restaurant-theme-template/* .cursor/coespaces/client-restaurant-{client-name}/
   ```

2. **Set up development environment:**
   ```bash
   cp .env.example .env
   docker compose up --build
   ```

3. **Configure restaurant settings:**
   - Menu items
   - Hours of operation
   - Contact information
   - Location details

## Restaurant-Specific Features

### Menu Management
- Digital menu display
- Category organization
- Price management
- Description and images
- Seasonal menu updates

### Online Ordering
- Menu item selection
- Customization options
- Cart functionality
- Checkout process
- Order tracking

### Reservation System
- Table booking
- Time slot management
- Party size selection
- Special requests
- Confirmation system

### Event Management
- Private events
- Catering services
- Special occasions
- Event packages
- Booking system

## Custom Post Types

### Menu Items
```php
register_post_type('menu_item', array(
    'labels' => array(
        'name' => 'Menu Items',
        'singular_name' => 'Menu Item'
    ),
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'taxonomies' => array('menu_category', 'dietary_info')
));
```

### Events
```php
register_post_type('restaurant_event', array(
    'labels' => array(
        'name' => 'Restaurant Events',
        'singular_name' => 'Event'
    ),
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'taxonomies' => array('event_type', 'event_category')
));
```

### Testimonials
```php
register_post_type('testimonial', array(
    'labels' => array(
        'name' => 'Testimonials',
        'singular_name' => 'Testimonial'
    ),
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'taxonomies' => array('rating')
));
```

## Custom Taxonomies

### Menu Categories
- Appetizers
- Main Courses
- Desserts
- Beverages
- Specials

### Dietary Information
- Vegetarian
- Vegan
- Gluten-Free
- Dairy-Free
- Nut-Free
- Spicy

### Event Types
- Private Dining
- Catering
- Special Events
- Wine Tastings
- Cooking Classes

## Menu Display

### Menu Layout
```php
function display_menu_section($category) {
    $menu_items = get_posts(array(
        'post_type' => 'menu_item',
        'tax_query' => array(
            array(
                'taxonomy' => 'menu_category',
                'field' => 'slug',
                'terms' => $category
            )
        )
    ));
    
    foreach ($menu_items as $item) {
        // Display menu item
    }
}
```

### Menu Filtering
```php
function filter_menu_by_dietary($dietary_requirements) {
    $args = array(
        'post_type' => 'menu_item',
        'tax_query' => array(
            array(
                'taxonomy' => 'dietary_info',
                'field' => 'slug',
                'terms' => $dietary_requirements
            )
        )
    );
    
    return get_posts($args);
}
```

## Online Ordering

### Cart Functionality
```php
function add_to_cart($menu_item_id, $quantity, $customizations) {
    $cart = WC()->cart;
    $cart->add_to_cart($menu_item_id, $quantity, 0, array(), $customizations);
}
```

### Order Management
```php
function process_restaurant_order($order_id) {
    $order = wc_get_order($order_id);
    
    // Send order to kitchen
    send_order_to_kitchen($order);
    
    // Send confirmation to customer
    send_order_confirmation($order);
}
```

## Reservation System

### Booking Form
```php
function restaurant_booking_form() {
    echo '<form class="reservation-form">';
    echo '<input type="date" name="reservation_date" required>';
    echo '<input type="time" name="reservation_time" required>';
    echo '<input type="number" name="party_size" min="1" max="20" required>';
    echo '<input type="text" name="special_requests" placeholder="Special requests">';
    echo '<button type="submit">Make Reservation</button>';
    echo '</form>';
}
```

### Availability Check
```php
function check_table_availability($date, $time, $party_size) {
    $existing_bookings = get_posts(array(
        'post_type' => 'reservation',
        'meta_query' => array(
            array(
                'key' => 'reservation_date',
                'value' => $date
            ),
            array(
                'key' => 'reservation_time',
                'value' => $time
            )
        )
    ));
    
    $total_booked = array_sum(wp_list_pluck($existing_bookings, 'party_size'));
    $available_capacity = get_restaurant_capacity() - $total_booked;
    
    return $available_capacity >= $party_size;
}
```

## Gallery and Reviews

### Photo Gallery
```php
function display_restaurant_gallery() {
    $gallery_images = get_field('restaurant_gallery');
    
    if ($gallery_images) {
        echo '<div class="restaurant-gallery">';
        foreach ($gallery_images as $image) {
            echo '<img src="' . $image['sizes']['medium'] . '" alt="' . $image['alt'] . '">';
        }
        echo '</div>';
    }
}
```

### Review System
```php
function display_restaurant_reviews() {
    $reviews = get_posts(array(
        'post_type' => 'testimonial',
        'posts_per_page' => 10
    ));
    
    foreach ($reviews as $review) {
        $rating = get_field('rating', $review->ID);
        echo '<div class="review">';
        echo '<h4>' . $review->post_title . '</h4>';
        echo '<div class="rating">' . display_stars($rating) . '</div>';
        echo '<p>' . $review->post_content . '</p>';
        echo '</div>';
    }
}
```

## Location and Hours

### Hours Display
```php
function display_restaurant_hours() {
    $hours = get_field('restaurant_hours');
    
    if ($hours) {
        echo '<div class="restaurant-hours">';
        echo '<h3>Hours of Operation</h3>';
        foreach ($hours as $day_hours) {
            echo '<div class="day-hours">';
            echo '<span class="day">' . $day_hours['day'] . '</span>';
            echo '<span class="hours">' . $day_hours['hours'] . '</span>';
            echo '</div>';
        }
        echo '</div>';
    }
}
```

### Location Map
```php
function display_restaurant_location() {
    $location = get_field('restaurant_location');
    
    if ($location) {
        echo '<div class="restaurant-location">';
        echo '<h3>Find Us</h3>';
        echo '<p>' . $location['address'] . '</p>';
        echo '<p>Phone: ' . $location['phone'] . '</p>';
        echo '<div class="map">' . $location['map'] . '</div>';
        echo '</div>';
    }
}
```

## Social Media Integration

### Social Feeds
```php
function display_social_feed() {
    // Instagram feed
    $instagram_posts = get_instagram_posts();
    
    // Facebook posts
    $facebook_posts = get_facebook_posts();
    
    // Twitter feed
    $twitter_posts = get_twitter_posts();
    
    // Display combined feed
    display_social_posts(array_merge($instagram_posts, $facebook_posts, $twitter_posts));
}
```

### Social Sharing
```php
function add_social_sharing() {
    echo '<div class="social-sharing">';
    echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '" target="_blank">Share on Facebook</a>';
    echo '<a href="https://twitter.com/intent/tweet?url=' . get_permalink() . '" target="_blank">Share on Twitter</a>';
    echo '<a href="https://www.instagram.com/" target="_blank">Share on Instagram</a>';
    echo '</div>';
}
```

## SEO Optimization

### Local SEO
- Google My Business integration
- Local keywords
- Location-based content
- Reviews and ratings
- Schema markup

### Content Strategy
- Menu optimization
- Event promotion
- Customer stories
- Food photography
- Local partnerships

## Performance

### Optimization
- Image optimization
- Fast loading times
- Mobile optimization
- Caching strategies
- CDN integration

### Monitoring
- Site performance
- User engagement
- Conversion tracking
- Mobile usage
- Search rankings

## Testing

### Functionality Testing
- Menu display
- Reservation system
- Online ordering
- Contact forms
- Mobile responsiveness

### User Experience
- Navigation testing
- Form usability
- Mobile experience
- Loading times
- Accessibility

## Deployment

### Staging Environment
```bash
npm run deploy:staging
```

### Production Deployment
```bash
npm run deploy:production
```

### Restaurant Checklist
- [ ] Menu items added
- [ ] Hours of operation set
- [ ] Contact information updated
- [ ] Location details verified
- [ ] Social media connected

## Maintenance

### Regular Updates
- Menu updates
- Event management
- Review monitoring
- Social media updates
- Performance optimization

### Monitoring
- Site uptime
- Performance metrics
- User engagement
- Conversion rates
- Customer feedback

## Support

### Documentation
- Restaurant management guide
- Menu setup instructions
- Reservation system guide
- SEO best practices
- Troubleshooting guide

### Resources
- Restaurant industry resources
- Design inspiration
- Marketing tools
- Analytics tools
- Customer support