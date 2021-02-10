<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

use App\Repositories\MessageRepositoryInterface;
use App\Repositories\MysqlDefault\MysqlDefaultMessageRepository;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as CapsuleTwo;



return function (ContainerBuilder $containerBuilder) {
    
    $containerBuilder->addDefinitions([
        MessageRepositoryInterface::class => \DI\autowire(MysqlDefaultMessageRepository::class),

        'CapsuleOne'=>function(ContainerInterface $c) {
            $dbSettings=$c->get('settings')['default'];

            $capsule = new Capsule;

            $capsule->addConnection([

               "driver" => $dbSettings['driver'],

               "host" => $dbSettings['host'],

               "database" => $dbSettings['dbname'],

               "username" => $dbSettings['user'],

               "password" => $dbSettings['password']

            ]);               

            return $capsule;
        },

        'CapsuleTwo'=>function(ContainerInterface $c) {
            $dbSettings=$c->get('settings')['mysql_two'];

            $capsule = new Capsule;

            $capsule->addConnection([

               "driver" => $dbSettings['driver'],

               "host" => $dbSettings['host'],

               "database" => $dbSettings['dbname'],

               "username" => $dbSettings['user'],

               "password" => $dbSettings['password']

            ]);               

            return $capsule;
        } 



        
    ]);
};
