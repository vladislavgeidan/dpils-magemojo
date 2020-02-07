<?php
/**
 * @category  Scandiweb
 * @package   Scandiweb\LocaleResolverFix
 * @author    Ilja Lapkovskis <info@scandiweb.com / ilja@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Ltd (http://scandiweb.com)
 * @license   OSL-3.0
 */

namespace Scandiweb\LocaleResolverFix\Locale;


class Resolver extends \Magento\Framework\Locale\Resolver
{
    /**
     * {@inheritdoc}
     */
    public function getDefaultLocale()
    {
        if (!$this->defaultLocale) {
            try {
                $locale = $this->scopeConfig->getValue($this->getDefaultLocalePath(), $this->scopeType);
            } catch (\Zend_Db_Statement_Exception $e) {
                $locale = null;
            }
            if (!$locale) {
                $locale = self::DEFAULT_LOCALE;
            }
            $this->defaultLocale = $locale;
        }
        return $this->defaultLocale;
    }
}
