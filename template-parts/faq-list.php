<?php
/**
 * FAQ List Template Part
 *
 * @package BuffaloCannabisNetwork
 */

$faqs = array(
    array(
        'question' => 'What\'s included in each membership tier?',
        'answer' => 'Each tier builds on the previous one. Student membership ($49/year) includes all networking events, educational workshops, career development resources, industry newsletter, and welcome swag bag. Professional ($250/year) adds priority event registration, member directory listing, exclusive market reports, and quarterly member meetups. Premier ($695/year) includes everything plus 2 company representatives, speaking opportunities, brand exposure features, and partnership opportunities.'
    ),
    array(
        'question' => 'Can I upgrade my membership tier?',
        'answer' => 'Yes! You can upgrade your membership at any time. Simply pay the difference between your current tier and the new tier, and we\'ll prorate it based on your remaining membership period. Contact us at steve@buffalocannabisnetwork.com to process your upgrade.'
    ),
    array(
        'question' => 'Do you offer refunds?',
        'answer' => 'We offer a 30-day money-back guarantee. If you\'re not satisfied with your membership within the first 30 days, contact us for a full refund. After 30 days, memberships are non-refundable, but you can choose not to renew at the end of your membership period.'
    ),
    array(
        'question' => 'How do I cancel my membership?',
        'answer' => 'BCN memberships are annual and will not auto-renew unless you choose to renew. Simply don\'t renew at the end of your membership period. If you need to cancel before your term ends, please email steve@buffalocannabisnetwork.com.'
    ),
    array(
        'question' => 'Are Student memberships only for enrolled students?',
        'answer' => 'Yes, Student membership is exclusively for currently enrolled students (college, university, or vocational programs). You\'ll need to provide proof of enrollment such as a student ID or enrollment verification letter when you join.'
    ),
    array(
        'question' => 'What types of events does BCN host?',
        'answer' => 'BCN hosts a variety of events including monthly networking mixers, educational workshops on licensing and compliance, industry speaker series, product showcases and brand expos, happy hours, and special events like our annual Dispensary Showcase. All members have access to these events.'
    ),
    array(
        'question' => 'Can businesses purchase multiple memberships?',
        'answer' => 'Absolutely! Professional membership includes 2 company representatives. Premier membership includes even more benefits for businesses. If you need additional representatives beyond what\'s included, contact us about our corporate membership packages.'
    ),
    array(
        'question' => 'How do I access member-only resources?',
        'answer' => 'Once you join, you\'ll receive login credentials to access our member portal where you can find industry reports, educational materials, the member directory, event calendar, and exclusive content.'
    ),
    array(
        'question' => 'Is BCN affiliated with any government agencies?',
        'answer' => 'No, BCN is an independent professional networking organization. We are not affiliated with the NYS Office of Cannabis Management or any government agency. We work to support our members in navigating the regulatory landscape.'
    ),
    array(
        'question' => 'What payment methods do you accept?',
        'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express, Discover) as well as PayPal. All payments are processed securely through our payment processor. Invoicing is available for businesses requiring NET-30 terms (Premier memberships only).'
    ),
);
?>

<div class="bcn-faq-list">
    <?php foreach ( $faqs as $faq ) : ?>
        <details class="bcn-faq-item">
            <summary>
                <?php echo esc_html( $faq['question'] ); ?>
            </summary>
            <p style="margin-top: var(--md-spacing-4); color: var(--md-sys-color-on-surface-variant); line-height: 1.75;">
                <?php echo esc_html( $faq['answer'] ); ?>
            </p>
        </details>
    <?php endforeach; ?>
</div>

