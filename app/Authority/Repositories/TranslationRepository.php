<?php  namespace Authority\Repositories;

use Authority\Exceptions\GoogleTranslateException;
use Authority\Interfaces\TranslationsInterface;

class TranslationRepository implements TranslationsInterface{

    public function getTranslation($text){
        $api_key = 'AIzaSyD0GkPbrLY6n6ChJ0ZPdr4eUQqmFm4H48E';
        $source="en";
        $target="es";

        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $api_key . '&q=' . rawurlencode($text);
        $url .= '&target='.$target;
        $url .= '&source='.$source;

        $response = file_get_contents($url);
        $obj =json_decode($response,true); //true converts stdClass to associative array.
        if($obj != null)
        {
            if(isset($obj['error']))
            {
                throw new GoogleTranslateException($obj['error']['message']);
            }
            else
            {
                return $obj['data']['translations'][0]['translatedText'];
            }
        }
        else
            throw new GoogleTranslateException('unknown error');
    }
} 