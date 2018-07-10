<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Express\RequestBuilder;

use Dhl\Express\Api\Data\ShipmentRequestInterface;
use Dhl\Express\Api\ShipmentRequestBuilderInterface;
use Dhl\Express\Model\Request\Insurance;
use Dhl\Express\Model\Request\Shipment\DangerousGoods\DryIce;
use Dhl\Express\Model\Request\Shipment\Package;
use Dhl\Express\Model\Request\Shipment\Recipient;
use Dhl\Express\Model\Request\Shipment\ShipmentDetails;
use Dhl\Express\Model\Request\Shipment\Shipper;
use Dhl\Express\Model\ShipmentRequest;

/**
 * Shipment Request Builder.
 *
 * @package  Dhl\Express\RequestBuilder
 * @author   Ronny Gertler <ronny.gertler@netresearch.de>
 * @license  https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://www.netresearch.de/
 */
class ShipmentRequestBuilder implements ShipmentRequestBuilderInterface
{
    /**
     * The collected data used to build the shipment request.
     *
     * @var array
     */
    private $data = [];

    /**
     * @param bool $unscheduledPickup
     * @return self
     */
    public function setIsUnscheduledPickup(bool $unscheduledPickup): ShipmentRequestBuilderInterface
    {
        $this->data['unscheduledPickup'] = $unscheduledPickup;
        return $this;
    }

    /**
     * @param string $termsOfTrade
     * @return self
     */
    public function setTermsOfTrade(string $termsOfTrade): ShipmentRequestBuilderInterface
    {
        $this->data['termsOfTrade'] = $termsOfTrade;
        return $this;
    }

    /**
     * @param string $contentType
     * @return self
     */
    public function setContentType(string $contentType): ShipmentRequestBuilderInterface
    {
        $this->data['contentType'] = $contentType;
        return $this;
    }

    /**
     * @param int $readyAtTimestamp
     * @return self
     */
    public function setReadyAtTimestamp(int $readyAtTimestamp): ShipmentRequestBuilderInterface
    {
        $this->data['readyAtTimestamp'] = $readyAtTimestamp;
        return $this;
    }

    /**
     * @param int $numberOfPieces
     * @return self
     */
    public function setNumberOfPieces(int $numberOfPieces): ShipmentRequestBuilderInterface
    {
        $this->data['numberOfPieces'] = $numberOfPieces;
        return $this;
    }

    /**
     * @param string $currencyCode
     * @return self
     */
    public function setCurrency(string $currencyCode): ShipmentRequestBuilderInterface
    {
        $this->data['currencyCode'] = $currencyCode;
        return $this;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): ShipmentRequestBuilderInterface
    {
        $this->data['description'] = $description;
        return $this;
    }

    /**
     * @param string $serviceType
     * @return self
     */
    public function setServiceType(string $serviceType): ShipmentRequestBuilderInterface
    {
        $this->data['serviceType'] = $serviceType;
        return $this;
    }

    /**
     * @param string $accountNumber
     * @return self
     */
    public function setPayerAccountNumber(string $accountNumber): ShipmentRequestBuilderInterface
    {
        $this->data['payerAccountNumber'] = $accountNumber;
        return $this;
    }

    /**
     * @param float $insuranceValue
     * @param string $insuranceCurrency
     * @return self
     */
    public function setInsurance(float $insuranceValue, string $insuranceCurrency): ShipmentRequestBuilderInterface
    {
        $this->data['insurance'] = [
            'value' => $insuranceValue,
            'currencyType' => $insuranceCurrency,
        ];
        return $this;
    }

    /**
     * @param string $countryCode
     * @param string $postalCode
     * @param string $city
     * @param array $streetLines
     * @param string $name
     * @param string $company
     * @param string $phone
     * @return self
     */
    public function setShipper(
        string $countryCode,
        string $postalCode,
        string $city,
        array $streetLines,
        string $name,
        string $company,
        string $phone
    ): ShipmentRequestBuilderInterface {
        $this->data['shipper'] = [
            'countryCode' => $countryCode,
            'postalCode' => $postalCode,
            'city' => $city,
            'streetLines' => $streetLines,
            'name' => $name,
            'company' => $company,
            'phone' => $phone
        ];

        return $this;
    }

    /**
     * @param string $countryCode
     * @param string $postalCode
     * @param string $city
     * @param array $streetLines
     * @param string $name
     * @param string $company
     * @param string $phone
     * @return self
     */
    public function setRecipient(
        string $countryCode,
        string $postalCode,
        string $city,
        array $streetLines,
        string $name,
        string $company,
        string $phone
    ): ShipmentRequestBuilderInterface {
        $this->data['recipient'] = [
            'countryCode' => $countryCode,
            'postalCode' => $postalCode,
            'city' => $city,
            'streetLines' => $streetLines,
            'name' => $name,
            'company' => $company,
            'phone' => $phone
        ];

        return $this;
    }

    /**
     * @param int $sequenceNumber
     * @param float $weight
     * @param string $weightUOM
     * @param float $length
     * @param float $width
     * @param float $height
     * @param string $dimensionsUOM
     * @param string $customerReferences
     * @return self
     */
    public function addPackage(
        int $sequenceNumber,
        float $weight,
        string $weightUOM,
        float $length,
        float $width,
        float $height,
        string $dimensionsUOM,
        string $customerReferences
    ): ShipmentRequestBuilderInterface {
        $weightDetails = $this->normalizeWeight($weight, strtoupper($weightUOM));
        $dimensionsDetails = $this->normalizeDimensions($length, $width, $height, strtoupper($dimensionsUOM));

        $this->data['packages'][] = [
            'sequenceNumber' => $sequenceNumber,
            'weight' => $weightDetails['weight'],
            'weightUOM' => $weightDetails['uom'],
            'length' => $dimensionsDetails['length'],
            'width' => $dimensionsDetails['width'],
            'height' => $dimensionsDetails['height'],
            'dimensionsUOM' => $dimensionsDetails['uom'],
            'customerReferences' => $customerReferences
        ];

        return $this;
    }

    /**
     * @param string $unCode
     * @param float $weight
     * @return self
     */
    public function setDryIce(string $unCode, float $weight): ShipmentRequestBuilderInterface
    {
        $this->data['dryIce'] = [
            'unCode' => $unCode,
            'weight' => $weight,
        ];
        return $this;
    }

    /**
     * @return ShipmentRequestInterface
     */
    public function build(): ShipmentRequestInterface
    {
        // build shipment details
        $shipmentDetails = new ShipmentDetails(
            $this->data['unscheduledPickup'],
            $this->data['termsOfTrade'],
            $this->data['contentType'],
            $this->data['readyAtTimestamp'],
            $this->data['numberOfPieces'],
            $this->data['currencyCode'],
            $this->data['description'],
            $this->data['serviceType']
        );

        // build insurance
        $insurance = new Insurance(
            $this->data['insurance']['value'],
            $this->data['insurance']['currencyType']
        );

        // build shipper
        $shipper = new Shipper(
            $this->data['shipper']['countryCode'],
            $this->data['shipper']['postalCode'],
            $this->data['shipper']['city'],
            $this->data['shipper']['streetLines'],
            $this->data['shipper']['name'],
            $this->data['shipper']['company'],
            $this->data['shipper']['phone']
        );

        // build recipient
        $recipient = new Recipient(
            $this->data['recipient']['countryCode'],
            $this->data['recipient']['postalCode'],
            $this->data['recipient']['city'],
            $this->data['recipient']['streetLines'],
            $this->data['recipient']['name'],
            $this->data['recipient']['company'],
            $this->data['recipient']['phone']
        );

        // build packages
        $packages = [];
        foreach ($this->data['packages'] as $package) {
            $packages[] = new Package(
                $package['sequenceNumber'],
                $package['weight'],
                $package['weightUOM'],
                $package['length'],
                $package['width'],
                $package['height'],
                $package['dimensionsUOM'],
                $package['customerReferences']
            );
        }

        // build dry ice
        $dryIce = new DryIce(
            $this->data['dryIce']['unCode'],
            $this->data['dryIce']['weight']
        );

        //build request
        $request = new ShipmentRequest(
            $shipmentDetails,
            $this->data['payerAccountNumber'],
            $insurance,
            $shipper,
            $recipient,
            $packages,
            $dryIce
        );

        $this->data = [];

        return $request;
    }

    /**
     * Normalizes the weight and unit of measurement to the unit of measurement KG (kilograms) or LB (Pound)
     * supported by the DHL express webservice.
     *
     * @param float $weight The weight
     * @param string $uom The unit of measurement
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    private function normalizeWeight(float $weight, string $uom): array
    {
        if (($uom === Package::UOM_WEIGHT_KG) || ($uom === Package::UOM_WEIGHT_LB)) {
            return [
                'weight' => $weight,
                'uom' => $uom,
            ];
        }

        if ($uom === Package::UOM_WEIGHT_G) {
            return [
                'weight' => $weight / 1000,
                'uom' => Package::UOM_WEIGHT_KG,
            ];
        }

        if ($uom === Package::UOM_WEIGHT_OZ) {
            return [
                'weight' => $weight / 16,
                'uom' => Package::UOM_WEIGHT_LB,
            ];
        }

        throw new \InvalidArgumentException(
            'Invalid weight unit of measurement'
        );
    }

    /**
     * Normalizes the dimensions to the unit of measurement CM (centimeter) or IN (inch) supported by the
     * DHL express webservice.
     *
     * @param float $length The length of a package
     * @param float $width The width of a package
     * @param float $height The height of a package
     * @param string $uom The unit of measurement
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    private function normalizeDimensions(float $length, float $width, float $height, string $uom): array
    {
        if (($uom === Package::UOM_DIMENSION_CM) || ($uom === Package::UOM_DIMENSION_IN)) {
            return [
                'length' => $length,
                'width' => $width,
                'height' => $height,
                'uom' => $uom,
            ];
        }

        if ($uom === Package::UOM_DIMENSION_MM) {
            return [
                'length' => $length / 10,
                'width' => $width / 10,
                'height' => $height / 10,
                'uom' => Package::UOM_DIMENSION_CM,
            ];
        }

        if ($uom === Package::UOM_DIMENSION_M) {
            return [
                'length' => $length * 100,
                'width' => $width * 100,
                'height' => $height * 100,
                'uom' => Package::UOM_DIMENSION_CM,
            ];
        }

        if ($uom === Package::UOM_DIMENSION_FT) {
            return [
                'length' => $length * 12,
                'width' => $width * 12,
                'height' => $height * 12,
                'uom' => Package::UOM_DIMENSION_IN,
            ];
        }

        if ($uom === Package::UOM_DIMENSION_YD) {
            return [
                'length' => $length * 36,
                'width' => $width * 36,
                'height' => $height * 36,
                'uom' => Package::UOM_DIMENSION_IN,
            ];
        }

        throw new \InvalidArgumentException(
            'Invalid dimensions unit of measurement'
        );
    }
}
