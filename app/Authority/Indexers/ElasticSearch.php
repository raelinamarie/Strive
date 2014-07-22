<?php namespace Authority\Indexers;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Elasticsearch\Client;

/**
 * Class ElasticSearch
 * @package Authority\Indexers
 */
class ElasticSearch implements IndexerInterface
{
    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    /**
     * @param $item
     */
    public function save($item){
        var_dump('item saved');
    }

    /**
     * @param $id
     */
    public function find($id){
        var_dump('item found');
    }

    /**
     * @param $job
     */
    public function indexJob($job){
        $params = array();
        $params['index'] = $_ENV['ELASTICSEARCH_INDEX'];
        $params['type'] = 'jobs';
        $params['refresh'] = true;
        $j = json_decode($job,true)[0];
        $body = array(
            'id' => $j['id'],
            'posted_by' => $j['user'],
            'title' => $j['title'],
            'description' => $j['description'],
            'max_payrate' => $j['max_payrate'],
            'contact_phone' => $j['contact_phone'],
            'contact_email' => $j['contact_email'],
            'location' => $j['location'],
            'address1' => $j['address1'],
            'city' => $j['city'],
            'state' => $j['state'],
            'zip' => $j['zip'],
            'skills' => $j['skills'],
            'date_closed' => $j['date_closed'],
            'reported' => 0,
            'active' => 1,
            'deleted_at' => NULL,
            'created_at' => $j['created_at'],
            'updated_at' => $j['updated_at']
        );
        $params['body'] = $body;
        #$this->client->index($params);
    }

    /**
     * @param $user
     */
    public function indexUser($user){

    }
}