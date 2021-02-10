<?php

namespace App\Middlewares;

use \Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use \Psr\Http\Server\{RequestHandlerInterface, MiddlewareInterface};
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;
use DI\Definition\Helper\CreateDefinitionHelper;
use DI\Definition\Helper\AutowireDefinitionHelper;

use App\Repositories\MessageRepositoryInterface;
use App\Repositories\MysqlDefault\MysqlDefaultMessageRepository;

/*
    this Factory Middleware builds repository based on the incoming request
    params
*/

class RepositoryFactoryMiddleware implements MiddlewareInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function process(
        ServerRequestInterface $request, 
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
    
        //get class names of each datasource repository    
        $datasources = require __DIR__ . '/../../config/datasources.php';   
       
        $method = $request->getMethod();
                
    
        if($method=='GET') {
            return $handler->handle($request);            
        } 

        $json = $request
            ->getBody()
            ->getContents();
        $data = json_decode($json, true);      

    /*
        route switches repo to the one selected by client
    */           
        $source = $data['repo'] ?? 'default'; 

        $this->buildRepo($source, $datasources);

        return $handler->handle($request); 

    }

    /*
        Dynamically swap the implimentation of the repository interface
        and inject container instance. Done within DI container
     */   
    public function buildRepo($source, $datasources)
    {
        $newRepository = $datasources[$source];
             
        $currentRepository = MessageRepositoryInterface::class;
        $definitionHelper = new AutowireDefinitionHelper($newRepository);
        
        $this->container->set($currentRepository, $definitionHelper);
    }

}