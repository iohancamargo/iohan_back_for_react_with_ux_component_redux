<?php

declare(strict_types=1);

namespace UMA\Tests\DoctrineDemo\Functional;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

class EndToEndTest extends TestCase
{
    /**
     * @var App
     */
    private static $app;

    /**
     * @var SchemaTool
     */
    private static $tool;

    /**
     * @var ClassMetadata[]
     */
    private static $schema;

    public static function setUpBeforeClass()
    {
        self::$app = $GLOBALS['cnt']->get(App::class);

        /** @var EntityManager $em */
        $em = self::$app->getContainer()->get(EntityManager::class);

        self::$schema = $em->getMetadataFactory()->getAllMetadata();
        self::$tool = new SchemaTool($em);
    }

    protected function setUp()
    {
        self::$tool->dropSchema(self::$schema);
        self::$tool->createSchema(self::$schema);
    }

    public function testGettingAListOfProductsWithTheGetEndpoint(): ResponseInterface
    {
        $request = new ServerRequest('GET', '/products');
        $response = self::$app->handle($request);

        self::assertSame(200, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));

        return $response;
    }

    public function testSeveralApiCalls(): void
    {
        $products = json_decode((string) $this->testGettingAListOfProductsWithTheGetEndpoint()->getBody());
        self::assertCount(0, $products);

        $products = json_decode((string) $this->testGettingAListOfProductsWithTheGetEndpoint()->getBody());
        self::assertCount(3, $products);

        $products = json_decode((string) $this->testGettingAListOfProductsWithTheGetEndpoint()->getBody());
        self::assertCount(4, $products);
    }
}
