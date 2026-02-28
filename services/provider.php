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
defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * Provedor de Serviços do módulo mod_hc_socialmedia.
 *
 * Responsável por registrar no container de injeção de dependência:
 * - O Dispatcher do módulo
 * - A fábrica de Helpers
 * - O provedor base do módulo
 *
 * Compatível com Joomla 4.x, 5.x e 6.x.
 *
 * @since 1.0.0
 */
return new class () implements ServiceProviderInterface
{
    /**
     * Registra os serviços do módulo no container de dependência.
     *
     * @param Container $container Container de injeção de dependências do Joomla.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function register(Container $container): void
    {
        /**
         * Registra a fábrica responsável por resolver o Dispatcher
         * do módulo (classe localizada em:
         * Joomla\Module\Socialmedia\Site\Dispatcher).
         */
        $container->registerServiceProvider(
            new ModuleDispatcherFactory('\\Joomla\\Module\\Socialmedia')
        );

        /**
         * Registra a fábrica de Helpers do módulo.
         * Helpers localizados em:
         * Joomla\Module\Socialmedia\Site\Helper
         */
        $container->registerServiceProvider(
            new HelperFactory('\\Joomla\\Module\\Socialmedia\\Site\\Helper')
        );

        /**
         * Registra o provedor base do módulo.
         */
        $container->registerServiceProvider(
            new Module()
        );
    }
};