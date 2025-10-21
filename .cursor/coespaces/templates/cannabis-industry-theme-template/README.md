# Cannabis Industry Theme Template

This is a specialized WordPress theme template designed for cannabis industry businesses.

## Features

- Cannabis-specific design elements
- Age verification system
- Compliance features
- Product catalog (if applicable)
- Dispensary locator
- Educational content
- Community features
- Event management
- Member directory

## Quick Start

1. **Copy this template to your client coespace:**
   ```bash
   cp -r .cursor/coespaces/templates/cannabis-industry-theme-template/* .cursor/coespaces/client-cannabis-{client-name}/
   ```

2. **Set up development environment:**
   ```bash
   cp .env.example .env
   docker compose up --build
   ```

3. **Configure cannabis-specific settings:**
   - Age verification
   - Compliance settings
   - Legal disclaimers

## Cannabis-Specific Features

### Age Verification
- Modal popup on site entry
- Cookie-based verification
- Multiple verification methods
- Compliance tracking

### Legal Compliance
- Required disclaimers
- Terms of service
- Privacy policy
- Cookie consent
- State-specific regulations

### Product Management
- Strain information
- THC/CBD content
- Effects and benefits
- Growing information
- Product reviews

### Educational Content
- Cannabis education
- Health benefits
- Usage guides
- Safety information
- Legal information

## Custom Post Types

### Strains
```php
register_post_type('cannabis_strain', array(
    'labels' => array(
        'name' => 'Cannabis Strains',
        'singular_name' => 'Strain'
    ),
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'taxonomies' => array('strain_type', 'effects', 'benefits')
));
```

### Dispensaries
```php
register_post_type('dispensary', array(
    'labels' => array(
        'name' => 'Dispensaries',
        'singular_name' => 'Dispensary'
    ),
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'taxonomies' => array('location', 'services')
));
```

### Events
```php
register_post_type('cannabis_event', array(
    'labels' => array(
        'name' => 'Cannabis Events',
        'singular_name' => 'Event'
    ),
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'taxonomies' => array('event_type', 'location')
));
```

## Custom Taxonomies

### Strain Types
- Indica
- Sativa
- Hybrid
- CBD-dominant

### Effects
- Relaxing
- Energizing
- Creative
- Focused
- Sleepy

### Benefits
- Pain Relief
- Anxiety Relief
- Sleep Aid
- Appetite Stimulant
- Anti-inflammatory

## Compliance Features

### Age Verification
```php
function cannabis_age_verification() {
    if (!isset($_COOKIE['age_verified'])) {
        // Show age verification modal
        add_action('wp_footer', 'show_age_verification_modal');
    }
}
```

### Legal Disclaimers
```php
function cannabis_legal_disclaimer() {
    echo '<div class="legal-disclaimer">';
    echo '<p>This website is for adults 21+ only. Cannabis products are not FDA approved.</p>';
    echo '</div>';
}
```

### State Compliance
```php
function get_state_compliance_settings($state) {
    $compliance = array(
        'CA' => array(
            'age_requirement' => 21,
            'disclaimer_required' => true,
            'testing_required' => true
        ),
        'CO' => array(
            'age_requirement' => 21,
            'disclaimer_required' => true,
            'testing_required' => true
        )
    );
    
    return $compliance[$state] ?? $compliance['CA'];
}
```

## Design Elements

### Color Scheme
- Green tones (cannabis-inspired)
- Natural earth tones
- Professional appearance
- Accessibility compliant

### Typography
- Clean, readable fonts
- Professional appearance
- Mobile-friendly
- Accessibility features

### Imagery
- Cannabis-related graphics
- Professional photography
- Compliance-friendly images
- High-quality visuals

## Educational Content

### Cannabis Education
- Strain information
- Growing guides
- Health benefits
- Safety information
- Legal updates

### Content Management
- Educational articles
- Video content
- Infographics
- Downloadable resources
- User-generated content

## Community Features

### Member Directory
- User profiles
- Skill sharing
- Networking
- Event participation
- Content contribution

### Forums
- Discussion boards
- Q&A sections
- Expert advice
- Community support
- Moderation tools

### Events
- Event listings
- Registration system
- Calendar integration
- RSVP functionality
- Event management

## SEO Optimization

### Cannabis SEO
- Strain-specific keywords
- Local SEO for dispensaries
- Educational content optimization
- Compliance-friendly SEO
- Industry-specific meta tags

### Content Strategy
- Educational blog posts
- Strain reviews
- Industry news
- Local events
- User-generated content

## Security

### Data Protection
- User privacy protection
- Secure data storage
- Compliance with regulations
- Regular security updates
- Malware protection

### Compliance
- HIPAA considerations
- State regulations
- Federal compliance
- Privacy laws
- Data retention policies

## Performance

### Optimization
- Fast loading times
- Mobile optimization
- Image optimization
- Caching strategies
- CDN integration

### Monitoring
- Site performance
- User engagement
- Content effectiveness
- Conversion tracking
- Error monitoring

## Testing

### Compliance Testing
- Age verification
- Legal disclaimers
- State regulations
- Accessibility
- Mobile responsiveness

### User Testing
- Usability testing
- A/B testing
- User feedback
- Performance testing
- Security testing

## Deployment

### Staging Environment
```bash
npm run deploy:staging
```

### Production Deployment
```bash
npm run deploy:production
```

### Compliance Checklist
- [ ] Age verification working
- [ ] Legal disclaimers in place
- [ ] Privacy policy updated
- [ ] Terms of service current
- [ ] State compliance verified

## Maintenance

### Regular Updates
- WordPress updates
- Plugin updates
- Theme updates
- Security patches
- Compliance updates

### Monitoring
- Site uptime
- Performance metrics
- Security alerts
- Compliance status
- User feedback

## Support

### Documentation
- Cannabis industry guidelines
- Compliance requirements
- Theme customization
- Troubleshooting guide
- Best practices

### Resources
- Industry associations
- Legal resources
- Compliance tools
- Design resources
- Development guides