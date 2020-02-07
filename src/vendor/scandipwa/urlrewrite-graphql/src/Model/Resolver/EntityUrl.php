<?php
/**
 * @category  ScandiPWA
 * @package   ScandiPWA\UrlrewriteGraphQl
 * @author    Vladimirs Mihnovics <info@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Ltd (http://scandiweb.com)
 * @license   OSL-3.0
 */
declare(strict_types=1);

namespace ScandiPWA\UrlrewriteGraphQl\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewriteGraphQl\Model\Resolver\UrlRewrite\CustomUrlLocatorInterface;
use Magento\Catalog\Model\ProductRepository;

/**
 * UrlRewrite field resolver, used for GraphQL request processing.
 */
class EntityUrl implements ResolverInterface
{
    /**
     * @var UrlFinderInterface
     */
    private $urlFinder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CustomUrlLocatorInterface
     */
    private $customUrlLocator;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param UrlFinderInterface $urlFinder
     * @param StoreManagerInterface $storeManager
     * @param CustomUrlLocatorInterface $customUrlLocator
     * @param ProductRepository $productRepository
     */
    public function __construct(
        UrlFinderInterface $urlFinder,
        StoreManagerInterface $storeManager,
        CustomUrlLocatorInterface $customUrlLocator,
        ProductRepository $productRepository
    ) {
        $this->urlFinder = $urlFinder;
        $this->storeManager = $storeManager;
        $this->customUrlLocator = $customUrlLocator;
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['url']) || empty(trim($args['url']))) {
            throw new GraphQlInputException(__('"url" argument should be specified and not empty'));
        }

        $result = null;
        $url = $args['url'];
        if (substr($url, 0, 1) === '/' && $url !== '/') {
            $url = ltrim($url, '/');
        }
        $customUrl = $this->customUrlLocator->locateUrl($url);
        $url = $customUrl ?: $url;
        $urlRewrite = $this->findCanonicalUrl($url);

        if ($urlRewrite) {
            $id = $urlRewrite->getEntityId();
            $type = $this->sanitizeType($urlRewrite->getEntityType());
            $result = [
                'id' => $id,
                'canonical_url' => $urlRewrite->getTargetPath(),
                'type' => $type,
                'url_key' => ($type === 'PRODUCT') ? $this->getProductUrl($id) : null
            ];
        }
        return $result;
    }
    
    /**
     * Find url key of product by id
     *
     * @param $productId
     * @return String
     * @throws NoSuchEntityException
     */
    private function getProductUrl(String $productId) : string
    {
        $product = $this->productRepository->getById($productId);
        return $product->getUrlKey();
    }

    /**
     * Find the canonical url passing through all redirects if any
     *
     * @param string $requestPath
     * @return UrlRewrite|null
     */
    private function findCanonicalUrl(string $requestPath) : ?UrlRewrite
    {
        $urlRewrite = $this->findUrlFromRequestPath($requestPath);
        if ($urlRewrite && $urlRewrite->getRedirectType() > 0) {
            while ($urlRewrite && $urlRewrite->getRedirectType() > 0) {
                $urlRewrite = $this->findUrlFromRequestPath($urlRewrite->getTargetPath());
            }
        }
        if (!$urlRewrite) {
            $urlRewrite = $this->findUrlFromTargetPath($requestPath);
        }

        return $urlRewrite;
    }
    
    /**
     * Find a url from a request url on the current store
     *
     * @param string $requestPath
     * @return UrlRewrite|null
     * @throws NoSuchEntityException
     */
    private function findUrlFromRequestPath(string $requestPath) : ?UrlRewrite
    {
        return $this->urlFinder->findOneByData(
            [
                'request_path' => $requestPath,
                'store_id' => $this->storeManager->getStore()->getId()
            ]
        );
    }
    
    /**
     * Find a url from a target url on the current store
     *
     * @param string $targetPath
     * @return UrlRewrite|null
     * @throws NoSuchEntityException
     */
    private function findUrlFromTargetPath(string $targetPath) : ?UrlRewrite
    {
        return $this->urlFinder->findOneByData(
            [
                'target_path' => $targetPath,
                'store_id' => $this->storeManager->getStore()->getId()
            ]
        );
    }

    /**
     * Sanitize the type to fit schema specifications
     *
     * @param string $type
     * @return string
     */
    private function sanitizeType(string $type) : string
    {
        return strtoupper(str_replace('-', '_', $type));
    }
}
