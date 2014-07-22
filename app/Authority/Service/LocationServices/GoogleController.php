<?php namespace Authority\Service\LocationServices;
use Authority\Exceptions\NoSearchResultsException;
use \Job;
use \Location;

/**
 * Class GoogleController
 * @package Authority\Service\LocationServices
 */
class GoogleController {
    /**
     * @param Location $location
     */
    public function __construct(Location $location){
        $this->location = $location;
    }

    /**
     * @param $id
     */
    public function addressSearch($job_id){
        $job = Job::find($job_id);
        $latlng = $this->get_lat_long($job->address1, $job->city, $job->state);
        $job->lat = $latlng['lat'];
        $job->lng = $latlng['lng'];
        $job->fill(['lat' => $latlng['lat'],'lng' =>$latlng['lng']])->save();
        $this->addToIndexTable(array('job_id' => $job->id,'lat' => $latlng['lat'],'lng' =>$latlng['lng']));
    }

    /**
     * @param $address
     * @param $city
     * @param $state
     * @return mixed
     */
    public function get_lat_long($address, $city, $state){
        $fullAddress = $address." ".$city." ".$state;
        $urlAddress = str_replace(" ", "+",$fullAddress);
        $url = "http://maps.google.com/maps/api/geocode/json?address=";
        $url = $url.$urlAddress;
        $url = $url."&sensor=false&region=US";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        $result['lat'] = $response_a->results[0]->geometry->location->lat;
        $result['lng'] = $response_a->results[0]->geometry->location->lng;
        return $result;
    }
    public function get_lat_long_zip($zip){
        $url = "http://maps.google.com/maps/api/geocode/json?address=".$zip."&sensor=false&region=US";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        $result['lat'] = $response_a->results[0]->geometry->location->lat;
        $result['lng'] = $response_a->results[0]->geometry->location->lng;
        return $result;
    }

    /**
     * @param $input
     */
    public function addToIndexTable($input){
        $this->location->create($input);
    }

    /**
     * @param $lat
     * @param $lng
     * @param $distance
     * @return array
     */
    public function search($lat,$lng,$distance=10){
        $locations = \DB::table('locations')->selectRaw('id, ( 3959 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin(radians(lat)) ) ) AS distance')->having('distance','<',$distance)->orderBy('distance')->lists('id');
        if(empty($locations)){
            throw new NoSearchResultsException('no jobs in radius');
        }
        return $locations;
    }

    public function usersSearch($lat,$lng,$distance=10){
        $userIds = \DB::table('users')->where('locked','=','0')->selectRaw('id, ( 3959 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin(radians(lat)) ) ) AS distance')->having('distance','<',$distance)->orderBy('distance')->lists('id');
        if(empty($userIds)){
            throw new NoSearchResultsException('no users in radius');
        }
        return $userIds;
    }


} 