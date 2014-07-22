<?php
use \Session;

/**
 * Class BaseController
 */
class BaseController extends Controller {

    /**
     *
     */
    public function __construct(){

    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    public function sessionCheck($user_id){
        if(Session::has('user_id')){
            if(Session::get('user_id') == $user_id){
                return true;
            }
            else{
                return false;
            }
        }else{
            return false;
        }
    }


}