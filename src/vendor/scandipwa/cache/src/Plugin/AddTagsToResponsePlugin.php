<?php
/**
 * ScandiPWA_Cache
 *
 * @category    ScandiPWA
 * @package     ScandiPWA_Cache
 * @author      Ilja Lapkovskis <ilja@scandiweb.com | info@scandiweb.com>
 * @copyright   Copyright (c) 2019 Scandiweb, Ltd (https://scandiweb.com)
 */

namespace Scandipwa\Cache\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\HttpInterface;
use Magento\Framework\Interception\InterceptorInterface;
use ScandiPWA\Cache\Model\CacheInterface;

class AddTagsToResponsePlugin
{
    /**
     * @var CacheInterface
     */
    private $cache;
    
    /**
     * Cache constructor.
     * @param CacheInterface $cache
     */
    public function __construct(
        CacheInterface $cache
    ) {
        $this->cache = $cache;
    }
    
    /**
     * Add tag headers to the response
     * @param InterceptorInterface $interceptor
     * @param HttpInterface        $response
     * @param RequestInterface     $request
     * @return HttpInterface
     */
    public function afterDispatch(InterceptorInterface $interceptor, HttpInterface $response, RequestInterface $request)
    {
        if (!array_key_exists('hash', $request->getParams())) {
            return $response;
        }
        
        if ($this->cache->identitiesExist()) {
            $tagHeaderString = implode(',', $this->cache->getIdentities());
            $response->setHeader('X-Magento-Tags', $tagHeaderString);
        }
        
        return $response;
    }
}
