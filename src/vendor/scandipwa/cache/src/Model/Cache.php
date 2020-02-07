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

class Cache implements CacheInterface
{
    /**
     * @var array
     */
    private $identities = [];
    
    /**
     * @inheritDoc
     */
    public function addIdentity(string $name, int $id): self
    {
        $identity  = $name . '_' . $id;
        if (!in_array($identity, $this->identities)) {
            $this->identities[] = $identity;
        }
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function addIdentities(array $identities): array
    {
        $merged = array_merge($this->identities, $identities);
        return $this->identities = array_unique($merged);
    }
    
    /**
     * @inheritDoc
     */
    public function getIdentities(): array
    {
        return $this->identities;
    }
    
    /**
     * @inheritDoc
     */
    public function identitiesExist(): bool
    {
        return (bool)count($this->identities);
    }
}
