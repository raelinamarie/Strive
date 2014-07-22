<?php namespace Authority\AuthToken;

use Illuminate\Support\ServiceProvider;

/**
 * Class AuthTokenServiceProvider
 * @package Authority\AuthToken
 */
class AuthTokenServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->package('authority/laravel-auth-token');
		$this->app['router']->filter('auth.token', 'authority.auth.token.filter');
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app->bindShared('authority.auth.token', function ($app) {
			return new AuthTokenManager($app);
		});

		$app->bindShared('authority.auth.token.filter', function ($app) {
			$driver = $app['authority.auth.token']->driver();
      $events = $app['events'];

      return new AuthTokenFilter($driver, $events);
		});

		$app->bind('Authority\AuthToken\AuthTokenController', function ($app) {
			$driver = $app['authority.auth.token']->driver();
			$credsFormatter = $app['config']->get('laravel-auth-token::format_credentials', null);
      return new AuthTokenController($driver, $credsFormatter);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('authority.auth.token', 'authority.auth.token.filter');
	}

}