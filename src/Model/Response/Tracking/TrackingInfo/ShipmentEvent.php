<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Express\Model\Response\Tracking\TrackingInfo;

use Dhl\Express\Api\Data\Response\Tracking\TrackingInfo\ShipmentEventInterface;

/**
 * Shipping event class.
 *
 * @author   Ronny Gertler <ronny.gertler@netresearch.de>
 * @link     https://www.netresearch.de/
 */
class ShipmentEvent implements ShipmentEventInterface
{
    /**
     * Event date
     *
     * @var string
     */
    private $date;

    /**
     * Event time
     *
     * @var string
     */
    private $time;

    /**
     * Event location description
     *
     * @var string
     */
    private $locationDescription;

    /**
     * Event description
     *
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $code;

    /**
     * ShipmentEvent constructor.
     *
     * @param string $date
     * @param string $time
     * @param string $locationDescription
     * @param string $description
     * @param string $code
     */
    public function __construct($date, $time, $locationDescription, $description, $code)
    {
        $this->date = $date;
        $this->time = $time;
        $this->locationDescription = $locationDescription;
        $this->description = $description;
        $this->code = $code;
    }

    public function getDate()
    {
        return (string) $this->date;
    }

    public function getTime()
    {
        return (string) $this->time;
    }

    public function getLocationDescription()
    {
        return (string) $this->locationDescription;
    }

    public function getDescription()
    {
        return (string) $this->description;
    }

    public function getCode()
    {
        return (string) $this->code;
    }
}
