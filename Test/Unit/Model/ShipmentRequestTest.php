<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Express\Test\Unit\Model;

use Dhl\Express\Api\Data\ShipmentRequestInterface;
use Dhl\Express\Model\Request\Insurance;
use Dhl\Express\Model\Request\Shipment\DangerousGoods\DryIce;
use Dhl\Express\Model\Request\Shipment\Package;
use Dhl\Express\Model\Request\Shipment\Recipient;
use Dhl\Express\Model\Request\Shipment\ShipmentDetails;
use Dhl\Express\Model\Request\Shipment\Shipper;
use Dhl\Express\Model\ShipmentRequest;
use PHPUnit\Framework\TestCase;

/**
 * @package  Dhl\Express\Test\Unit
 * @author   Ronny Gertler <ronny.gertler@netresearch.de>
 * @license  https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://www.netresearch.de/
 */
class ShipmentRequestTest extends TestCase
{
    /**
     * @test
     */
    public function propertiesArePopulatedAndAccessible()
    {
        $shipmentDetails = new ShipmentDetails(
            $unscheduledPickup = true,
            $termsOfTrade = ShipmentDetails::PAYMENT_TYPE_CFR,
            $contentType = ShipmentDetails::CONTENT_TYPE_DOCUMENTS,
            $readyAtTimestamp = 238948923,
            $numberOfPieces = 12,
            $currencyCode = 'EUR',
            $description = 'A description',
            $serviceType = 'U'
        );

        $payerAccountNumber = 'XXXXXXXXX';

        $insurance = new Insurance(
            $value = 99.99,
            $currencyCode = 'EUR'
        );

        $shipper = new Shipper(
            $countryCode = 'DE',
            $postalCode = '12345',
            $city = 'Berlin',
            $streetLines = ['Sample street 5a', 'Sample street 5b'],
            $name = 'Max Mustermann',
            $company = 'Acme',
            $phone = '004922832432423'
        );

        $recipient = new Recipient(
            $countryCode = 'DE',
            $postalCode = '12345',
            $city = 'Berlin',
            $streetLines = ['Sample street 5a', 'Sample street 5b'],
            $name = 'Max Mustermann',
            $company = 'Acme',
            $phone = '004922832432423'
        );

        $package = new Package(
            $sequenceNumber = 1,
            $weight = 1.123,
            $weightUOM = Package::UOM_WEIGHT_KG,
            $length = 1.123,
            $width = 1.123,
            $height = 1.123,
            $dimensionUOM = Package::UOM_DIMENSION_CM,
            $customerReferences = 'TEST CZ-IT'
        );

        $packages = [$package, $package];

        $dryIce = new DryIce(
            $unCode = ' UN1845',
            $weight = 20.53
        );

        $shipmentRequest = new ShipmentRequest(
            $shipmentDetails,
            $payerAccountNumber,
            $insurance,
            $shipper,
            $recipient,
            $packages,
            $dryIce
        );

        self::assertInstanceOf(ShipmentRequestInterface::class, $shipmentRequest);
        self::assertSame($shipmentDetails, $shipmentRequest->getShipmentDetails());
        self::assertSame($payerAccountNumber, $shipmentRequest->getPayerAccountNumber());
        self::assertSame($insurance, $shipmentRequest->getInsurance());
        self::assertSame($shipper, $shipmentRequest->getShipper());
        self::assertSame($recipient, $shipmentRequest->getRecipient());
        self::assertSame($packages, $shipmentRequest->getPackages());
        self::assertSame($dryIce, $shipmentRequest->getDryIce());
    }
}
