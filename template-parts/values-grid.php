<?php
/**
 * Values Grid Template Part
 *
 * @package BuffaloCannabisNetwork
 */

$values = array(
    array(
        'title' => 'Community-First',
        'description' => 'Local relationships are our foundation. We believe the strongest businesses grow from the strongest communities.',
        'color' => '#7CB342'
    ),
    array(
        'title' => 'Value-Driven',
        'description' => 'Every interaction provides tangible benefit. Your success is our success through practical workshops and direct connections.',
        'color' => '#4A90E2'
    ),
    array(
        'title' => 'Authenticity',
        'description' => 'Genuine relationships over transactional networking. No fluff, just results through transparent communication.',
        'color' => '#9C27B0'
    ),
    array(
        'title' => 'Collaboration Over Competition',
        'description' => 'The industry grows when we support each other. A rising tide lifts all boats through resource sharing.',
        'color' => '#7CB342'
    ),
    array(
        'title' => 'Knowledge Is Power',
        'description' => 'Informed decisions drive sustainable growth. Stay informed, stay ahead with educational workshops and regulatory updates.',
        'color' => '#4A90E2'
    ),
    array(
        'title' => 'Long-Term Vision',
        'description' => 'Building sustainable, lasting industry presence through strategic planning and community investment.',
        'color' => '#9C27B0'
    ),
);
?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--md-spacing-6);">
    <?php foreach ( $values as $value ) : ?>
        <div class="bcn-card-hover" style="background: var(--md-sys-color-surface); padding: var(--md-spacing-8); border-radius: var(--md-shape-corner-large); border-top: 4px solid <?php echo esc_attr( $value['color'] ); ?>;">
            <h3 style="margin-bottom: var(--md-spacing-4); color: var(--md-sys-color-on-surface);"><?php echo esc_html( $value['title'] ); ?></h3>
            <p style="color: var(--md-sys-color-on-surface-variant); line-height: 1.75; margin: 0;"><?php echo esc_html( $value['description'] ); ?></p>
        </div>
    <?php endforeach; ?>
</div>

