<?php


View::addNamespace('Frontend',__DIR__.'/../views/frontend');
/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

    app_path().'/commands',
    app_path().'/controllers',
    app_path().'/models',
    app_path().'/database/seeds'

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

App::error(function(Exception $exception, $code)
{
    Log::error($exception);
});


/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

require __DIR__.'/../globalExceptions.php';


/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require __DIR__.'/../filters.php';


// Require the Observables file.
require __DIR__.'/../observables.php';


User::setStripeKey(Config::get('stripe.secret'));
/*
|--------------------------------------------------------------------------
| Prep Sentry for dependency Injection
|--------------------------------------------------------------------------
*/
/*
if (getenv('APPSETTING_ELASTICSEARCH_HOST')) {
    $_ENV['ELASTICSEARCH_HOST'] = getenv('APPSETTING_ELASTICSEARCH_HOST');
}

if (getenv('APPSETTING_ELASTICSEARCH_API_KEY')) {
    $_ENV['ELASTICSEARCH_API_KEY'] = getenv('APPSETTING_ELASTICSEARCH_API_KEY');
}

if (getenv('APPSETTING_ELASTICSEARCH_INDEX')) {
    $_ENV['ELASTICSEARCH_INDEX'] = getenv('APPSETTING_ELASTICSEARCH_INDEX');
}

class SslGuzzleConnection extends Elasticsearch\Connections\GuzzleConnection
{
    public function __construct($hostDetails, $connectionParams, Psr\Log\LoggerInterface $log, Psr\Log\LoggerInterface $trace)
    {
        $params = array();
        $params['guzzleClient'] = new Guzzle\Http\Client();

        parent::__construct($hostDetails, array_merge($connectionParams, $params), $log, $trace);

        $this->host = 'https://' . $_ENV['ELASTICSEARCH_API_KEY'] . ':@' . $hostDetails['host'];
    }
}

App::singleton('Elasticsearch\Client', function()
{
    $params = array();
    $params['logging'] = true;
    $params['hosts'] = array($_ENV['ELASTICSEARCH_HOST']);
    $params['connectionClass'] = 'SslGuzzleConnection';

    return new Elasticsearch\Client($params);
});
*/

