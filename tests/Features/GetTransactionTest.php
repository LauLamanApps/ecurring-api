<?php


namespace LauLamanApps\eCurring\Tests\Features;

use LauLamanApps\eCurring\Http\Endpoint\MapperInterface;
use LauLamanApps\eCurring\Http\Endpoint\Production;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetTransactionTest extends TestCase
{
    public function testGetTransaction()
    {
        $production = new Production();
        $id = Uuid::uuid4()->toString();

        $url = $production->map(MapperInterface::GET_TRANSACTION, [$id]);

        $this->assertEquals(Production::BASE_URL . '/transactions/' . $id, $url);
    }
}