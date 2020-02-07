<?php
/**
 * @category  ScandiPWA
 * @package   ScandiPWA\Router
 * @author    Ilja Lapkovskis <info@scandiweb.com / ilja@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Ltd (http://scandiweb.com)
 * @license   OSL-3.0
 */

namespace ScandiPWA\Router\Validator;

use Magento\Framework\App\RequestInterface;
use ScandiPWA\Router\ValidatorInterface;

/**
 * Class Cms
 * @deprecated 1.5.0 Implemented generic always pass
 * @package ScandiPWA\Router\Validator
 */
class Cart implements ValidatorInterface
{
    /**
     * @inheritdoc
     */
    public function validateRequest(RequestInterface $request): bool
    {
        return true;
    }
}
