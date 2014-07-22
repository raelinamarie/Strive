<?php namespace Strive\Admin\Controllers;

use Illuminate\Routing\Controller;
use \Restable;
use View;
use \Auth;

/**
 * Class BaseController
 */
class BaseController extends Controller {

    /**
     *
     */
    public function __construct() {

    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */

    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}