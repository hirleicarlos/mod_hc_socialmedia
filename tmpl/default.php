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

use Joomla\CMS\Helper\ModuleHelper;

require ModuleHelper::getLayoutPath('mod_hc_socialmedia', "default_" . $params->get('layout_mode', 'default'));