<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Nyholm\Psr7;
use UMA\DoctrineDemo\Domain\Product;
use UMA\DoctrineDemo\Domain\ProductCycle;

class ListProducts
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke(Psr7\ServerRequest $request, Psr7\Response $response): Psr7\Response
    {
        /** @var Product[] $products */
        $finalReturn = new \stdClass();
        $finalReturn->shared = new \stdClass();
        $finalReturn->shared ->products = new \stdClass();

        $products = $this->em->getRepository(Product::class)->findAll();
        
        foreach ($products as $key => $prod) {

            $auxObj = new \stdClass();
            $namePosition = 'product_'.$prod->getId();
            $auxObj->$namePosition = new \stdClass();
            $auxObj->$namePosition->name = $prod->getName();
            $auxObj->$namePosition->id = $prod->getId();

            $auxObj->$namePosition->cycle = new \stdClass();
            
            $cycles = $this->em->getRepository(ProductCycle::class)->findBy(array('cycle' => $prod->getId()));
            
            foreach ($cycles as $key => $cycle) {
                $nameCycle = '';
                $month = $cycle->getMonths(); 
                switch ($month) {
                    case '1':
                        $nameCycle = 'monthly';
                    break;
                    case '3':
                        $nameCycle = 'quarterly';
                    break;
                    case '6':
                        $nameCycle = 'semiannually';
                    break;
                    case '12':
                        $nameCycle = 'annually';
                    break;
                    case '24':
                        $nameCycle = 'biennially';
                    break;
                    case '36':
                        $nameCycle = 'triennially';
                    break;
                }
                if($nameCycle !== '') {
                    $auxObj->$namePosition->cycle->$nameCycle = new \stdClass();
                    $auxObj->$namePosition->cycle->$nameCycle->months = $month;
                    $auxObj->$namePosition->cycle->$nameCycle->priceRenew = $cycle->getPriceRenew();
                    $auxObj->$namePosition->cycle->$nameCycle->priceOrder = $cycle->getPriceOrder();
                    $finalReturn->shared->products->$namePosition = $auxObj->$namePosition;
                }
            }
        }

        $body = Psr7\Stream::create(\json_encode($finalReturn));

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $body->getSize())
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withBody($body);
    }
}
