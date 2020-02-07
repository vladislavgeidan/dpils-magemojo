<?php
/**
 * ScandiPWA - Progressive Web App for Magento
 *
 * Copyright © Scandiweb, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * @license OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * @package scandipwa/customization
 * @link https://github.com/scandipwa/quote-graphql
 */

namespace ScandiPWA\Customization\View\Result;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\Translate\InlineInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\EntitySpecificHandlesList;
use Magento\Framework\View\Layout\BuilderFactory;
use Magento\Framework\View\Layout\GeneratorPool;
use Magento\Framework\View\Layout\ReaderPool;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\Page\Config\RendererFactory;
use Magento\Framework\View\Page\Layout\Reader;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use ScandiPWA\Locale\View\Result\Page as LocalePage;

/**
 * Class Page
 * @package ScandiPWA\Customization\View\Result
 */
class Page extends LocalePage
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Page constructor.
     * @param StoreManagerInterface $storeManager
     * @param Resolver $localeResolver
     * @param Context $context
     * @param LayoutFactory $layoutFactory
     * @param ReaderPool $layoutReaderPool
     * @param InlineInterface $translateInline
     * @param BuilderFactory $layoutBuilderFactory
     * @param GeneratorPool $generatorPool
     * @param RendererFactory $pageConfigRendererFactory
     * @param Reader $pageLayoutReader
     * @param string $template
     * @param bool $isIsolated
     * @param EntitySpecificHandlesList|null $entitySpecificHandlesList
     * @param null $action
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Resolver $localeResolver,
        Context $context,
        LayoutFactory $layoutFactory,
        ReaderPool $layoutReaderPool,
        InlineInterface $translateInline,
        BuilderFactory $layoutBuilderFactory,
        GeneratorPool $generatorPool,
        RendererFactory $pageConfigRendererFactory,
        Reader $pageLayoutReader,
        string $template,
        $isIsolated = false,
        EntitySpecificHandlesList $entitySpecificHandlesList = null,
        $action = null
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->storeManager = $storeManager;

        parent::__construct(
            $localeResolver,
            $context,
            $layoutFactory,
            $layoutReaderPool,
            $translateInline,
            $layoutBuilderFactory,
            $generatorPool,
            $pageConfigRendererFactory,
            $pageLayoutReader,
            $template,
            $isIsolated,
            $entitySpecificHandlesList,
            $action
        );
    }

    /**
     * Get config by section name
     * @param string $sectionName
     * @return array
     * @throws NoSuchEntityException
     */
    public function getThemeConfiguration(
        string $sectionName
    ) {
        return $this->scopeConfig->getValue(
            $sectionName,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }
}
