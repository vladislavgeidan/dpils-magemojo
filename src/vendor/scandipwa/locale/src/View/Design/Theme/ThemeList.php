<?php
/**
 * ScandiPWA - Progressive Web App for Magento
 *
 * Copyright © Scandiweb, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * @license OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * @package scandipwa/locale
 * @link https://github.com/scandipwa/quote-graphql
 */

namespace ScandiPWA\Locale\View\Design\Theme;

use Magento\Framework\View\Design\Theme\ThemeList as MagentoThemeList;
use Magento\Framework\View\Design\Theme\ThemePackage;
use Magento\Framework\View\Design\ThemeInterface;

class ThemeList extends MagentoThemeList
{
    /**
     * Return default configuration data
     *
     * @param ThemePackage $themePackage
     * @return array
     */
    protected function _prepareConfigurationData($themePackage)
    {
        $themeConfig = $this->_getConfigModel($themePackage);
        $pathData = $this->_preparePathData($themePackage);
        $media = $themeConfig->getMedia();

        $parentPathPieces = $themeConfig->getParentTheme();
        if (is_array($parentPathPieces) && count($parentPathPieces) == 1) {
            $pathPieces = $pathData['theme_path_pieces'];
            array_pop($pathPieces);
            $parentPathPieces = array_merge($pathPieces, $parentPathPieces);
        }

        $themePath = implode(ThemeInterface::PATH_SEPARATOR, $pathData['theme_path_pieces']);
        $themeCode = implode(ThemeInterface::CODE_SEPARATOR, $pathData['theme_path_pieces']);
        $parentPath = $parentPathPieces ? implode(ThemeInterface::PATH_SEPARATOR, $parentPathPieces) : null;

        return [
            'parent_id' => null,
            'type' => $themeConfig->isPwa() ? 4 : ThemeInterface::TYPE_PHYSICAL,
            'area' => $themePackage->getArea(),
            'theme_path' => $themePath,
            'code' => $themeCode,
            'theme_title' => $themeConfig->getThemeTitle(),
            'preview_image' => $media['preview_image'] ? $media['preview_image'] : null,
            'parent_theme_path' => $parentPath
        ];
    }
}
