<?php 

namespace Olsonhost\Ect;

// Return a fully initialized Ect Object which can
//	Execute a command (sendSMS, dial, etc)
//	Process a webhook
//	Check for scheduled or queued tasks

class Init
{

	public $tel;

	public function __construct()
	{

		// Assign our preferred telephony driver to $tel

		$this->tel = new Twilio($this);	
	}

	public function test() {

		// $tel->webhook(false) should callback this

		echo '*** TEST!!! ***';
	}

	public function whtest() {

		// Test $tel->webhook(), should callback to test()

		$this->tel->webhook();

	}

	public function sendSMS($to, $from, $message) {
		$this->tel->sendSMS($to, $from, $message);
	}

	public function dial($number, $callback) {
		$this->tel->dial($number, $callback);
	}

}
