<?php

namespace ScandiPWA\MenuOrganizer\Model\Item\Source;

use ScandiPWA\MenuOrganizer\Model\Source\AbstractSource;
/**
 * @category ScandiPWA
 * @package ScandiPWA\MenuOrganizer\Model\Item\Source
 * @author Dmitrijs Sitovs <info@scandiweb.com / dmitrijssh@scandiweb.com / dsitovs@gmail.com>
 * @copyright Copyright (c) 2015 Scandiweb, Ltd (http://scandiweb.com)
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *
 * Class Opentypes
 */
class Opentypes extends AbstractSource
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->helper->getOpenTypes();

        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }

        return $options;
    }
}
