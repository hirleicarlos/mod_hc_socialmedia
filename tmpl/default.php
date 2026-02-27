<?php
\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

require ModuleHelper::getLayoutPath('mod_hc_socialmedia', "default_" . $params->get('layout_mode', 'default'));