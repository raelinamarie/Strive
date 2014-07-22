<?php
use Authority\Interfaces\TranslationsInterface;
use Authority\Exceptions\GoogleTranslateException;
class TranslationsController extends BaseController{

    public function __construct(TranslationsInterface $translation){
        $this->trans = $translation;
	}
	
	public function index(){
        return Restable::single($this->trans->getTranslation(Input::get('text')))->render();
	}
}

    