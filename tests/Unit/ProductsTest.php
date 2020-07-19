<?php

declare(strict_types=1);

namespace UMA\Tests\DoctrineDemo\Unit;

use PHPUnit\Framework\TestCase;
use UMA\DoctrineDemo\Domain\Product;

class ProductsTest extends TestCase
{
    public function testeInsertProductWithCycle(): void
    {
        $sut = new Product('Plano p');
        
        $newCycle = new ProductCycle(
            $sut,
            3,
            67.17,
            67.17
        );
        self::assertTrue($sut->getId(), $newCycle->getCycle());
    }
}
