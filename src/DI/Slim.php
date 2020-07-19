<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\DI;

use Doctrine\ORM\EntityManager;
use Faker;
use Slim\App;
use Slim\Factory\AppFactory;
use UMA\DIC\Container;
use UMA\DIC\ServiceProvider;
use UMA\DoctrineDemo\Action\ListProducts;
use UMA\DoctrineDemo\Action\ListProductById;
use UMA\DoctrineDemo\Action\CreateDataProducts;

/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself.
 */
class Slim implements ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function provide(Container $c): void
    {
        $c->set(ListProducts::class, static function(Container $c): ListProducts {
            return new ListProducts(
                $c->get(EntityManager::class)
            );
        });

        $c->set(ListProductById::class, static function(Container $c): ListProductById {
            return new ListProductById(
                $c->get(EntityManager::class)
            );
        });

        $c->set(CreateDataProducts::class, static function(Container $c): CreateDataProducts {
            return new CreateDataProducts(
                $c->get(EntityManager::class)
            );
        });

        $c->set(App::class, static function (Container $c): App {
            /** @var array $settings */
            $settings = $c->get('settings');

            $app = AppFactory::create(null, $c);

            $app->addErrorMiddleware(
                $settings['slim']['displayErrorDetails'],
                $settings['slim']['logErrors'],
                $settings['slim']['logErrorDetails']
            );
            
            $app->get('/products', ListProducts::class);
            $app->get('/prices/{id}', ListProductById::class);
            $app->put('/create_data', CreateDataProducts::class);

            return $app;
        });
    }
}
