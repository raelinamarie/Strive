<?php namespace Authority\Mailers;

use Mail;

/**
 * Class Mailer
 * @package Authority\Mailers
 */
abstract class Mailer {

    /**
     * @param $email
     * @param $subject
     * @param $view
     * @param array $data
     */
    public function sendTo($email, $subject, $view, $data = array())
	{
		Mail::queue($view, $data, function($message) use($email, $subject)
		{
			$message->to($email)
					->subject($subject);
		});
	}
}