<?php
/**
 * ScandiPWA_Cache
 *
 * @category    ScandiPWA
 * @package     ScandiPWA_Cache
 * @author      Ilja Lapkovskis <ilja@scandiweb.com | info@scandiweb.com>
 * @copyright   Copyright (c) 2019 Scandiweb, Ltd (https://scandiweb.com)
 */

namespace ScandiPWA\Cache\Model;

interface CacheInterface
{
    
    /**
     * @param string $name
     * @param int    $id
     * @return CacheInterface
     */
    public function addIdentity(string $name, int $id);
    
    /**
     * @param array $identities
     * @return array
     */
    public function addIdentities(array $identities): array;
    
    /**
     * @return array
     */
    public function getIdentities(): array;
    
    /**
     * @return bool
     */
    public function identitiesExist(): bool;
}
