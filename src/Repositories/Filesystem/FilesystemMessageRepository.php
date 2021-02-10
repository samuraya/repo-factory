<?php
declare(strict_types=1);

namespace App\Repositories\Filesystem;

use App\Repositories\MessageRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\Message;

use Psr\Container\ContainerInterface;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;

class FilesystemMessageRepository  implements MessageRepositoryInterface
{
    
	private $filesystem;
  private $path;
  
	public function __construct(ContainerInterface $container)
	{
		
      $this->path = $container->get('settings')['filesystem']['path'];
      $adapter = new LocalFilesystemAdapter($this->path);
      $this->filesystem = new Filesystem($adapter);
        
	}	

	public function store($content)
  {       
        
    $this->filesystem->write(
      $content['name'],json_encode($content)
    );
    return 'saved in Filesystem';

  }
}