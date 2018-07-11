<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\Express\Test\Unit\Model\Request\Shipment\DangerousGoods;

use Dhl\Express\Model\Request\Shipment\DangerousGoods\DryIce;
use PHPUnit\Framework\TestCase;

/**
 * @package Dhl\Express\Test\Unit
 * @author  Ronny Gertler <ronny.gertler@netresearch.de>
 * @license https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link    https://www.netresearch.de/
 */
class DryIceTest extends TestCase
{
    /**
     * @test
     */
    public function propertiesArePopulatedAndAccessible()
    {

        $dryIce = new DryIce(
            $unCode = 'UN1845',
            $weight = 20.53
        );

        $this->assertInstanceOf(DryIce::class, $dryIce);
        $this->assertSame(DryIce::CONTENT_ID, $dryIce->getContentId());
        $this->assertSame($unCode, $dryIce->getUnCode());
        $this->assertSame($weight, $dryIce->getWeight());
    }
}