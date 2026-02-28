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


namespace Joomla\Module\Socialmedia\Site\Helper;

defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use function defined;

/**
 * Classe auxiliar responsável por processar
 * e normalizar os dados dos itens de redes sociais.
 *
 * Esta classe concentra:
 * - Validação básica dos dados
 * - Normalização do subform
 * - Montagem da estrutura final consumida pelos layouts
 * - Geração opcional de variáveis CSS individuais
 *
 * @since 1.0.0
 */
class SocialmediaHelper
{
    /**
     * Retorna a lista de itens normalizados do módulo.
     *
     * Processa os dados vindos do subform (params->items),
     * valida campos obrigatórios e monta a estrutura final
     * utilizada pelos arquivos de layout.
     *
     * @param Registry $params Parâmetros do módulo.
     *
     * @return array<int, array<string, mixed>> Lista de itens processados.
     *
     * @since 1.0.0
     */
    public function getItems(Registry $params): array
    {
        $raw = $params->get('items', null);

        // Caso comum no subform: stdClass com items0/items1...
        if (is_object($raw)) {
            $raw = (array) $raw;
        }

        // Caso raro: JSON/string
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            $raw = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($raw)) {
            return [];
        }

        // Normaliza items0/items1... => lista numérica
        $raw = array_values($raw);

        $items = [];

        foreach ($raw as $it) {
            if (is_object($it)) {
                $it = (array) $it;
            }

            if (!is_array($it)) {
                continue;
            }

            // Ignora item desabilitado
            if (isset($it['enabled']) && (int) $it['enabled'] !== 1) {
                continue;
            }

            // URL é obrigatória
            $url = trim((string) ($it['url'] ?? ''));
            if ($url === '') {
                continue;
            }

            $name = trim((string) ($it['name'] ?? ''));

            // Target seguro
            $target = (string) ($it['target'] ?? '_blank');
            $target = in_array($target, ['_blank', '_self'], true) ? $target : '_blank';

            // Rel automático
            $nofollow = ((int) ($it['nofollow'] ?? 0) === 1);
            $rel = 'noopener noreferrer' . ($nofollow ? ' nofollow' : '');

            // Aria label
            $aria = trim((string) ($it['aria_label'] ?? ''));
            if ($aria === '') {
                $aria = $name !== '' ? $name : 'Social';
            }

            // Tipo de ícone validado
            $iconType = (string) ($it['icon_type'] ?? 'svg');
            if (!in_array($iconType, ['svg', 'image', 'class'], true)) {
                $iconType = 'svg';
            }

            $iconSvg   = (string) ($it['icon_svg'] ?? '');
            $iconMedia = (string) ($it['icon_media'] ?? '');
            $iconClass = trim((string) ($it['icon_class'] ?? ''));

            $items[] = [
                'name'       => $name,
                'url'        => $url,
                'icon_type'  => $iconType,
                'icon_svg'   => $iconSvg,
                'icon_media' => $iconMedia,
                'icon_class' => $iconClass,
                'target'     => $target,
                'rel'        => $rel,
                'aria_label' => $aria,
                'style'      => $this->buildItemStyleVars($it),
            ];
        }

        return $items;
    }

    /**
     * Gera variáveis CSS inline para personalização individual.
     *
     * As variáveis só são aplicadas quando:
     * - use_custom = 1
     * - E os valores estiverem preenchidos
     *
     * @param array<string, mixed> $it Dados do item.
     *
     * @return string String formatada para atributo style.
     *
     * @since 1.0.0
     */
    protected function buildItemStyleVars(array $it): string
    {
        if ((int) ($it['use_custom'] ?? 0) !== 1) {
            return '';
        }

        $vars = [];

        // Cores
        $this->addVarColor($vars, '--hc-bg',            $it['bg_color'] ?? '');
        $this->addVarColor($vars, '--hc-text',          $it['text_color'] ?? '');
        $this->addVarColor($vars, '--hc-border',        $it['border_color'] ?? '');
        $this->addVarColor($vars, '--hc-bg-hover',      $it['bg_hover'] ?? '');
        $this->addVarColor($vars, '--hc-text-hover',    $it['text_hover'] ?? '');
        $this->addVarColor($vars, '--hc-border-hover',  $it['border_hover'] ?? '');

        // Medidas
        $this->addVarPx($vars, '--hc-border-width', $it['border_width'] ?? null);
        $this->addVarPx($vars, '--hc-radius',       $it['radius'] ?? null);
        $this->addVarPx($vars, '--hc-py',           $it['padding_y'] ?? null);
        $this->addVarPx($vars, '--hc-px',           $it['padding_x'] ?? null);

        // Sombra
        if ((int) ($it['shadow'] ?? 0) === 1) {
            $vars[] = '--hc-shadow: 1';
        }

        // Transition
        $transition = (string) ($it['transition'] ?? '');
        if (in_array($transition, ['none', 'fast', 'smooth'], true)) {
            $vars[] = '--hc-transition: ' . $transition;
        }

        return $vars ? implode('; ', $vars) . ';' : '';
    }

    /**
     * Adiciona variável CSS de cor se válida.
     *
     * @param array<int, string> &$vars Lista de variáveis.
     * @param string $name Nome da variável CSS.
     * @param mixed  $value Valor informado.
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function addVarColor(array &$vars, string $name, mixed $value): void
    {
        $v = trim((string) $value);

        if ($v === '' || $v[0] !== '#') {
            return;
        }

        $vars[] = $name . ': ' . $v;
    }

    /**
     * Adiciona variável CSS em pixel se válida.
     *
     * @param array<int, string> &$vars Lista de variáveis.
     * @param string $name Nome da variável CSS.
     * @param mixed  $value Valor informado.
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function addVarPx(array &$vars, string $name, mixed $value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $n = (int) $value;

        if ($n <= 0) {
            return;
        }

        $vars[] = $name . ': ' . $n . 'px';
    }
}