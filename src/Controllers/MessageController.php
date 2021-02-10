<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\MessageRepositoryInterface;

use Laminas\Diactoros\Response as Response;
use Laminas\Diactoros\Response\JsonResponse;

use Laminas\Diactoros\Response\RedirectResponse as Redirect;
use Laminas\Diactoros\ServerRequest as Request;
use Narrowspark\HttpEmitter\SapiEmitter;
use App\Controllers\BaseController;
use Slim\Views\PhpRenderer;

abstract class MessageController extends BaseController
{

	protected $messageRepository;
	protected $request;
	protected $response;
	public function __construct(
		Response $response,
		MessageRepositoryInterface $messageRepository
	)
	{
		$this->messageRepository = $messageRepository;
		$this->response = $response;
        
	}

	public function __invoke(Request $request)
	{	
        $this->request = $request;
        
        try {
            return $this->action();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            throw new \Exception($this->request, $e->getMessage());
        } 
	}


    abstract protected function action():Response;

     protected function respond($payload, $template): Response
    {
      
       $renderer = new PhpRenderer(__DIR__.'/../../templates');
       $renderer->setLayout('layout.html');
       return $renderer->render($this->response, $template,['orders'=>$payload]);
       
    }


    protected function respondJson($payload, $status)
    {

        $response = new JsonResponse(
            $payload, 
            $status,
            ['Content-Type' => ['application/hal+xml']]

        );
        return $response;

    }

    protected function respondRedirect($uri)
    {
        $response = new Redirect($uri);
        return $response;
    }




}