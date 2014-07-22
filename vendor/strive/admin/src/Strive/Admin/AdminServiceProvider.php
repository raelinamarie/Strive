<?php namespace Strive\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
class AdminServiceProvider extends ServiceProvider {

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
		$this->package('strive/admin');
        include __DIR__ . '/../../routes.php';
        include __DIR__ . '/../../filters.php';
        #class_alias('Illuminate\Routing\Controllers\Controller', 'AdministratorBaseController');
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['admin'] = $this->app->share(function($app)
        {
            return new Admin;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('admin');
	}

}
