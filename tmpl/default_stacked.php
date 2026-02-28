<?php
/**
 * @package     Joomla.Module
 * @subpackage  mod_hc_socialmedia
 *
 * @copyright   (C) 2026 Hirlei Carlos Pereira de Araújo
 * @license     GNU General Public License version 2 or later
 *
 * @since       1.0.0
 */


\defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$app = Factory::getApplication();
$wa  = $app->getDocument()->getWebAssetManager();

/**
 * CSS do layout stacked
 */
$wa->registerAndUseStyle(
        'mod_hc_socialmedia.stacked',
        'media/mod_hc_socialmedia/css/stacked.css'
);

// ---------------------------------------------------------
// Params
// ---------------------------------------------------------
$contentMode = (string) $params->get('content_mode', 'both');
$alignment   = (string) $params->get('alignment', 'start');
$gap         = (int)    $params->get('gap', 16);
$device      = (string) $params->get('device', 'all');
$iconSize    = (int)    $params->get('icon_size', 28);
$shape       = (string) $params->get('shape', 'rounded');
$shadow      = (int)    $params->get('shadow', 0);
$transition  = (string) $params->get('transition', 'smooth');
$customClass = trim((string) $params->get('custom_class', ''));

// ---------------------------------------------------------
// Items
// ---------------------------------------------------------
$items = $items ?? [];

if (!is_array($items) || empty($items)) {
    return;
}

// ---------------------------------------------------------
// Wrapper classes
// ---------------------------------------------------------
$classes = [
        'mod-hc-socialmedia',
        'mod-hc-socialmedia--stacked',
        'is-layout-stacked',
        'is-align-' . preg_replace('/[^a-z0-9_-]/i', '', $alignment),
        'is-device-' . preg_replace('/[^a-z0-9_-]/i', '', $device),
        'is-content-' . preg_replace('/[^a-z0-9_-]/i', '', $contentMode),
        'is-shape-' . preg_replace('/[^a-z0-9_-]/i', '', $shape),
        'is-shadow-' . ($shadow ? '1' : '0'),
        'is-transition-' . preg_replace('/[^a-z0-9_-]/i', '', $transition),
];

if ($customClass !== '') {
    $classes[] = $customClass;
}

$wrapperClass = implode(' ', $classes);
?>

<nav class="<?php echo htmlspecialchars($wrapperClass, ENT_QUOTES, 'UTF-8'); ?>"
     aria-label="Mídias sociais">

    <ul class="mod-hc-socialmedia__list"
        role="list"
        style="gap: <?php echo (int) $gap; ?>px;">

        <?php foreach ($items as $it): ?>
            <?php
            $name = trim((string) ($it['name'] ?? ''));
            $url  = trim((string) ($it['url'] ?? ''));

            if ($url === '') {
                continue;
            }

            $target = (string) ($it['target'] ?? '_blank');
            $rel    = trim((string) ($it['rel'] ?? ''));
            $aria   = trim((string) ($it['aria_label'] ?? '')) ?: ($name !== '' ? $name : 'Social');

            $iconType  = (string) ($it['icon_type'] ?? 'svg');
            $iconSvg   = (string) ($it['icon_svg'] ?? '');
            $iconMedia = (string) ($it['icon_media'] ?? '');
            $iconClass = trim((string) ($it['icon_class'] ?? ''));

            // 🔹 estilo individual
            $itemStyle = trim((string) ($it['style'] ?? ''));
            ?>

            <li class="mod-hc-socialmedia__item">

                <a class="mod-hc-socialmedia__link"
                   href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>"
                        <?php echo $target ? 'target="' . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
                        <?php echo $rel ? 'rel="' . htmlspecialchars($rel, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
                   aria-label="<?php echo htmlspecialchars($aria, ENT_QUOTES, 'UTF-8'); ?>"
                        <?php echo $itemStyle !== '' ? 'style="' . htmlspecialchars($itemStyle, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>

                    <?php if ($contentMode === 'icon' || $contentMode === 'both'): ?>
                        <span class="mod-hc-socialmedia__icon"
                              aria-hidden="true"
                              style="font-size: <?php echo (int) $iconSize; ?>px;">

                            <?php if ($iconType === 'class' && $iconClass !== ''): ?>
                                <i class="<?php echo htmlspecialchars($iconClass, ENT_QUOTES, 'UTF-8'); ?>"></i>

                            <?php elseif ($iconType === 'image' && $iconMedia !== ''): ?>
                                <img src="<?php echo htmlspecialchars($iconMedia, ENT_QUOTES, 'UTF-8'); ?>" alt="">

                            <?php else: ?>
                                <?php echo $iconSvg; ?>
                            <?php endif; ?>

                        </span>
                    <?php endif; ?>

                    <?php if (($contentMode === 'text' || $contentMode === 'both') && $name !== ''): ?>
                        <span class="mod-hc-socialmedia__label">
                            <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    <?php endif; ?>

                </a>

            </li>

        <?php endforeach; ?>

    </ul>
</nav>