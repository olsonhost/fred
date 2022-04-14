<?php 

namespace Olsonhost\Ect;

// Perform common telco functions using Twilio

// Send a text
// Dial a number
// Process webhook

// These are low level functions that could be processed with Twilio, a dialogic card, or some other service or software

class Twilio
{

    public $author;

	protected $token, $sid;

	protected $ect; // This is the calling class containing ect event handlers

	public function __construct($ect = false)
	{

	// Get configuration info
	$this->token = 'xxxxxxxxxxxxxxxxxxxxxxx';
	$this->sid = 'xxxxxxxxxxxxxxxxxxxx';
	$this->ect = $ect;
	$this->author = 'Erik Olson';

	}

	public function webhook($uri = false) {

	// The webhook must invoke an event for ECT to handle

	if ($this->ect == false) {

		exit('TWILIO ERROR: ECT is undefined');

		}

	if ($uri == false) {
		
		// Invoke test event in calling class

		$this->ect->test();

		}


	}

	public function sendSMS($to, $from, $msg) {

	}

	public function dial($number, $callback) {

	}
 



}
