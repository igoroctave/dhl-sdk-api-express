<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\Express\Webservice\Soap\Type\ShipmentRequest\OnDemandDeliveryOptions;

use Dhl\Express\Webservice\Soap\ValueInterface;

/**
 * A LWN type code. Mandatory if the delivery option is SW.
 *
 * @api
 * @package  Dhl\Express\Api
 * @author   Rico Sonntag <rico.sonntag@netresearch.de>
 * @license  https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://www.netresearch.de/
 */
class LWNTypeCode implements ValueInterface
{
    private const NUMBER_OF_CHARS = 1;

    /**
     * Leave with neighbour.
     *
     * @var string
     */
    public const N = 'N';

    /**
     * Leave with concierge.
     *
     * @var string
     */
    public const C  = 'C';

    /**
     * The value.
     *
     * @var string
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $value The value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value = self::N)
    {
        if ((strlen($value) !== self::NUMBER_OF_CHARS)
            || !in_array($value, [self::N, self::Y])
        ) {
            throw new \InvalidArgumentException('Argument must be either "N" or "C"');
        }

        $this->value = $value;
    }

    /**
     * Returns the value as string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}