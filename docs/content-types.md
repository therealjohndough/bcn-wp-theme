# Content Types, Taxonomies, and Meta

## Post Types

### bcn_event
- **Public**: true; **REST**: true; **Archive**: `/events/`
- **Supports**: title, editor, thumbnail, excerpt, comments
- **Rewrite**: slug `events`
- **Use cases**: upcoming events, recaps, workshops

### bcn_member
- **Public**: true; **REST**: true; **Archive**: `/members/`
- **Supports**: title, editor, thumbnail, excerpt, revisions
- **Rewrite**: slug `members`
- **Use cases**: member directory profiles

## Taxonomies

### event_category (for `bcn_event`)
- **Hierarchical**: true; **REST**: true; **Rewrite**: `event-category`
- **Admin UI**: yes; admin column enabled

### bcn_membership_level (for `bcn_member`)
- **Hierarchical**: false; **REST**: true; **Rewrite**: `membership`
- **Default seeded terms**: `premier-member`, `pro-member`, `community-partner`

## Registered Meta

### For `bcn_member` posts
- **bcn_member_website** (string, single, REST): Member website URL
- **bcn_member_email** (string, single, REST): Contact email
- **bcn_member_phone** (string, single, REST): Contact phone
- **bcn_member_address** (string, single, REST): Address
- **bcn_member_featured** (boolean, single, REST): Highlight in featured placements (default false)
- **bcn_member_can_submit_content** (boolean, single, REST): Allow secure submissions (default false)
- **bcn_member_submission_key** (string, single, private): Private key for submission link

### For standard `post` (member submissions)
- **bcn_member_submission_member_id** (integer, single, REST): Linked member ID
- **bcn_member_submission_type** (string, single, REST): `blog` or `photo`
- **bcn_member_submission_contact_name** (string, single, private)
- **bcn_member_submission_contact_email** (string, single, private)

## Query Parameters (Archive Enhancements)

On the `bcn_member` archive:
- `membership_level` (string): filter by `bcn_membership_level` slug
- `featured_only` (1/true): only featured members

Example:
```
/members/?membership_level=premier-member&featured_only=1
```
