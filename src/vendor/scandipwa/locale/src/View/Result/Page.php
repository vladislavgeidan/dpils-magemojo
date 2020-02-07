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

namespace ScandiPWA\Locale\View\Result;

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
use ScandiPWA\Router\View\Result\Page as OriginalPage;

class Page extends OriginalPage
{
    /**
     * @var Resolver
     */
    private $localeResolver;

    /**
     * Page constructor.
     * @param Resolver $localeResolver
     * @param Context $context
     * @param LayoutFactory $layoutFactory
     * @param ReaderPool $layoutReaderPool
     * @param InlineInterface $translateInline
     * @param BuilderFactory $layoutBuilderFactory
     * @param GeneratorPool $generatorPool
     * @param RendererFactory $pageConfigRendererFactory
     * @param Reader $pageLayoutReader
     * @param string $template,
     * @param bool $isIsolated
     * @param EntitySpecificHandlesList|null $entitySpecificHandlesList
     * @param null $action
     */
    public function __construct(
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
        parent::__construct(
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

        $this->localeResolver = $localeResolver;
    }

    protected function getThemeFolder($url)
    {
        return 'Magento_Theme/' . $url;
    }

    public function getStaticFile($url)
    {
        $asset = $this->assetRepo->createAsset(
            $this->getThemeFolder($url)
        );

        return $asset->getUrl();
    }

    public function getStaticBundleFile()
    {
        $filePath = sprintf(
            '%s.bundle.js',
            $this->localeResolver->getLocale()
        );

        return $this->getStaticFile($filePath);
    }
}
