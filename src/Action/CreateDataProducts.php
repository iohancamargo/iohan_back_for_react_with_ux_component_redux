<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Nyholm\Psr7;
use UMA\DoctrineDemo\Domain\Product;
use UMA\DoctrineDemo\Domain\ProductCycle;

class CreateDataProducts
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
        /* Remove todos os registros existentes */
        $productsCycle = $this->em->getRepository(ProductCycle::class);
        $recordProductsCycle = $productsCycle->findAll();

        if($recordProductsCycle){
            foreach ($recordProductsCycle as $key => $prodCycle) {
                $this->em->remove($prodCycle);
            }
        }
        $this->em->flush();
        $products = $this->em->getRepository(Product::class);
        $recordProducts = $products->findAll();

        if($recordProducts){
            foreach ($recordProducts as $key => $prod) {
                $this->em->remove($prod);
            }
        }
        $this->em->flush();

        /* Cadastra os produtos default vindos do exemplo */
        $newProduct = new Product(
            "Plano P"
        );
        $this->em->persist($newProduct);
        $this->em->flush();


        $newCycle = new ProductCycle(
            $newProduct,
            1,
            24.19,
            24.19
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            3,
            67.17,
            67.17
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            6,
            128.34,
            128.34
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            12,
            220.66,
            220.66
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            24,
            393.36,
            393.36
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            36,
            561.13,
            561.13
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        /* Plano bussiness */
        $newProduct = new Product(
            "Plano Business"
        );
        $this->em->persist($newProduct);
        $this->em->flush();

        
        $newCycle = new ProductCycle(
            $newProduct,
            1,
            44.99,
            44.99
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            3,
            131.97,
            131.97
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            6,
            257.94,
            257.94
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            12,
            503.88,
            503.88
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            24,
            983.76,
            983.76
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $newCycle = new ProductCycle(
            $newProduct,
            36,
            1439.64,
            1439.64
        );
        $this->em->persist($newCycle);
        $this->em->flush();

        $body= new \stdClass();
        $body->success = true;
        $body->message = "Registers created successfully";
        $body = Psr7\Stream::create(\json_encode($body));

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $body->getSize())
            ->withBody($body);
    }
}
