<?php
/**
 * ScandiPWA_Cache
 *
 * @category    ScandiPWA
 * @package     ScandiPWA_Cache
 * @author      Ilja Lapkovskis <ilja@scandiweb.com | info@scandiweb.com>
 * @copyright   Copyright (c) 2019 Scandiweb, Ltd (https://scandiweb.com)
 */

namespace ScandiPWA\Cache\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use ScandiPWA\PersistedQuery\Model\PurgeCache;

class FlushVarnishObserver implements ObserverInterface
{
    /**
     * @var PurgeCache
     */
    private $purgeCache;
    
    /**
     * FlushVarnishObserver constructor.
     * @param PurgeCache $purgeCache
     */
    public function __construct(PurgeCache $purgeCache)
    {
        $this->purgeCache = $purgeCache;
    }
    
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $entity = $observer->getEntity() ?? $observer->getDataByKey('object');
        $identities = $entity->getIdentities();
        $this->purgeCache->sendPurgeRequest(implode(',', $identities));
    }
}
