<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\Express\Webservice\Soap\Request\Value\ShipmentRequest;

use \Dhl\Express\Webservice\Soap\Request\Value\Address as ValueAddress;

/**
 * An buyer address.
 * 
 * @api
 * @package  Dhl\Express\Api
 * @author   Rico Sonntag <rico.sonntag@netresearch.de>
 * @license  https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://www.netresearch.de/
 */
class Address extends ValueAddress
{
    /**
     * Constructor.
     *
     * @param string $streetLines The street lines
     * @param string $city        The city
     * @param string $postalCode  The postal code
     * @param string $countryCode The country code
     */
    public function __construct(string $streetLines, string $city, string $postalCode, string $countryCode)
    {
        $this->setStreetLines($streetLines)
            ->setCity($city)
            ->setPostalCode($postalCode)
            ->setCountryCode($countryCode);
    }
}
