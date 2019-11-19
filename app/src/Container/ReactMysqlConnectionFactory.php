<?php

declare(strict_types=1);

namespace App\Container;

use Psr\Container\ContainerInterface;
use React\MySQL\ConnectionInterface;
use React\MySQL\Factory;

class ReactMysqlConnectionFactory
{
    public function __invoke(ContainerInterface $container, string $dsn): ConnectionInterface
    {
        $factory = new Factory($container->get('reactphp.event_loop'));

        return $factory->createLazyConnection($dsn);
    }

    public static function createConnection(ContainerInterface $container, string $dsn): ConnectionInterface
    {
        $factory = new self;

        return $factory($container, $dsn);
    }
}
