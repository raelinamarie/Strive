<?php namespace Strive\Frontend;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
class FrontendServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('strive/frontend');
        include __DIR__ . '/../../routes.php';
        include __DIR__ . '/../../filters.php';
        #class_alias('Illuminate\Routing\Controllers\Controller', 'FrontendistratorBaseController');
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['frontend'] = $this->app->share(function($app)
        {
            return new Frontend;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('frontend');
	}

}
