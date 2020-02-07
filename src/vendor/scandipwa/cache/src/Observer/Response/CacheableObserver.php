<?php
/**
 * ScandiPWA_Cache
 *
 * @category    ScandiPWA
 * @package     ScandiPWA_Cache
 * @author      Ilja Lapkovskis <ilja@scandiweb.com | info@scandiweb.com>
 * @copyright   Copyright (c) 2019 Scandiweb, Ltd (https://scandiweb.com)
 */

namespace ScandiPWA\Cache\Observer\Response;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\ObserverInterface;
use ScandiPWA\Cache\Model\Cache;

abstract class CacheableObserver implements ObserverInterface
{
    /**
     * @var Cache
     */
    protected $cache;
    
    /**
     * @var Http
     */
    protected $request;
    
    /**
     * @var bool
     */
    protected $isGraphQl;
    
    /**
     * @var bool
     */
    protected $isCacheable;
    
    /**
     * CacheableObserver constructor.
     * @param Cache $cache
     */
    public function __construct(
        Cache $cache,
        Http $request
    ) {
        $this->cache = $cache;
        $this->request = $request;
        $this->isGraphQl = $this->request->getPathInfo() === '/graphql';
        $this->isCacheable = array_key_exists('hash', $this->request->getParams());
    }
}
