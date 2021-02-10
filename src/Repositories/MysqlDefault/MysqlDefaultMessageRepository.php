<?php
declare(strict_types=1);

namespace App\Repositories\MysqlDefault;

use App\Repositories\MessageRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\Message;

use Psr\Container\ContainerInterface;

class MysqlDefaultMessageRepository  implements MessageRepositoryInterface
{
    
	private $message;
  
	public function __construct(ContainerInterface $container)
	{
		
      $capsule = $container->get('CapsuleOne');
      $capsule->setAsGlobal();
      $capsule->bootEloquent();
      $this->message = new Message;
        
	}	

	public function store($data)
  {       
        
       $this->message->create($data);
       return 'saved in Mysql Default database';

  }
}