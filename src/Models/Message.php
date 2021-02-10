<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Message extends Eloquent
{
	
	/*
		Model that inherits eloquent methods
		conencted to mysql db
	*/
	protected $guarded=[];
	public $timestamps = false;

	/**
	 * The id of the message
	 *
	 * @var integer
	 */
	public $id;
	
	/**
	 * Name of the contactor
	 *
	 * @var string
	 */
	public $name;
	
	/**
	 * The content of the message
	 *
	 * @var string
	 */
	public $message;
	
	
}