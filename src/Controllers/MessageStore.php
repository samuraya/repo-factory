<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\MessageController;
use Zend\Diactoros\Response as Response;
use Rakit\Validation\Validator;




final class MessageStore extends MessageController
{
	public function action():Response
    {
        
        $container = $this->request->getAttribute('container');
        
        $json = $this->request
            ->getBody()
            ->getContents();
        $data = json_decode($json, true); 

        $validator = new Validator;    	

        $validation = $validator->validate($data, [
            'name'                  => 'required|alpha',
            'phone'                 => 'required|numeric',
            'message'               => 'required'
            
        ]);

        $errors = $validation->errors();

        $messages = $errors->firstOfAll(':message', false);

        if(count($messages)>0) {
            return $this->respondJson($messages,500);
        }
                
        $data = [
            'name'=>$data['name'],
            'phone'=>$data['phone'],
            'message'=>$data['message']
        ];
        $result = $this->messageRepository->store($data);

        return $this->respondJson(['result'=>$result],200);        
        
    	
    }
}