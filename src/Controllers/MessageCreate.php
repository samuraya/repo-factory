<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\MessageController;
use Laminas\Diactoros\Response as Response;


final class MessageCreate extends MessageController
{

	public function action():Response
    {
       	return $this->respond(array(),'form.html');   
    }  


}
