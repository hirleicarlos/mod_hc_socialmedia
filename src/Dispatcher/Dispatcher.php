<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_hc_socialmedia
 *
 * @copyright   (C) 2026 Hirlei Carlos Pereira de Araújo
 * @license     GNU General Public License version 2 or later
 *
 * @since 1.0.0
 */

namespace Joomla\Module\Socialmedia\Site\Dispatcher;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

use function defined;

// phpcs:disable PSR1.Files.SideEffects
defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Dispatcher do módulo mod_hc_socialmedia.
 *
 * Esta classe é responsável por:
 * - Obter os dados padrão do módulo
 * - Acionar o Helper responsável pelo processamento
 * - Disponibilizar os itens tratados para os layouts (tmpl)
 *
 * Observação:
 * Não contém regras de negócio.
 * A transformação de dados é responsabilidade da camada Helper.
 *
 * @since 1.0.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    /**
     * Prepara os dados que serão enviados ao layout.
     *
     * Fluxo:
     * 1. Obtém os dados base via AbstractModuleDispatcher
     * 2. Resolve o Helper através da HelperFactory
     * 3. Processa os itens do módulo
     * 4. Injeta os itens no array de dados do layout
     *
     * Estrutura adicionada:
     * $data['items'] => array de itens normalizados
     *
     * @return array<string, mixed> Dados completos para o layout.
     *
     * @since 1.0.0
     */
    protected function getLayoutData(): array
    {
        // Obtém dados base do módulo
        $data = parent::getLayoutData();

        // Resolve o helper do módulo
        $helper = $this->getHelperFactory()->getHelper('SocialmediaHelper');

        // Processa e injeta os itens
        $data['items'] = $helper->getItems($data['params']);

        return $data;
    }
}