# Examples and Recipes

## Display Member Logos by Level

Add this shortcode to any page to show Premier Member logos in a 5‑column grid:

```shortcode
[member_logo_grid level="premier-member" limit="-1" columns="5" featured="true"]
```

## Create a Member Submission Page

1. Create a page titled “Member Submissions” with the content:
```shortcode
[member_submission_form redirect="/thank-you/"]
```
2. For a given member, enable “Allow this member to submit stories or media” in the meta box on their profile.
3. Share this link with the member:
```
https://yoursite.com/member-submissions/?submission_key=THEIR-PRIVATE-KEY
```

## Filter the Members Archive by Level (URL)

Visit:
```
/members/?membership_level=premier-member
```

## Increase Content Width via Filter

```php
add_filter('bcn_content_width', function($width) {
    return 1400;
});
```

## Change Excerpt Length and More Text

```php
add_filter('excerpt_length', fn($len) => 50);
add_filter('excerpt_more', fn($more) => ' …');
```

## Add the Community Widget

- Go to Appearance → Widgets
- Drag “BCN Community Widget” into Sidebar, Footer, or Community area
- Set a custom title

## REST: Create a Member from External System

```bash
curl -X POST \
  -H "Content-Type: application/json" \
  -H "Authorization: Basic $(printf 'user:app-password' | base64)" \
  -d '{
    "title": "Acme Labs",
    "status": "publish",
    "content": "Member bio...",
    "meta": {
      "bcn_member_website": "https://acme.example",
      "bcn_member_email": "hello@acme.example"
    }
  }' \
  https://yoursite.com/wp-json/wp/v2/bcn_member
```
