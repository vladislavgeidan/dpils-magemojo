<?php
/**
 * @category ScandiPWA
 * @package ScandiPWA\Customization
 * @author Alfreds Genkins <info@scandiweb.com>
 * @copyright Copyright (c) 2015 Scandiweb, Ltd (http://scandiweb.com)
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

namespace ScandiPWA\Customization\Block\Adminhtml\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Color
 * @package Scommerce\Gdpr\Block\Adminhtml\Config
 */
class Color extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(
        AbstractElement $element
    ) {
        $html = $element->getElementHtml();
        $value = $element->getData('value');

        $html .= sprintf('<script type="text/javascript">
            require(["jquery", "jquery/colorpicker/js/colorpicker"], function ($) {
                $(function() {
                    var $el = $("#%s");
                    $el.css("backgroundColor", "#%s");
 
                    // Attach the color picker
                    $el.ColorPicker({
                        color: "%s",
                        onChange: function (hsb, hex, rgb) {
                            $el.css("backgroundColor", "#" + hex).val(hex);
                        }
                    });
                });
            });
            </script>', $element->getHtmlId(), $value, $value);

        return $html;
    }
}
