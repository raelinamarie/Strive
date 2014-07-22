<?php namespace Authority\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class BackendServiceProvider
 * @package Authority\Providers
 */
class BackendServiceProvider extends ServiceProvider {

    /**
     * Register the binding
     */
    public function register()
    {
        $this->app->bind(
            'Authority\Interfaces\TranslationsInterface','Authority\Repositories\TranslationRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\CategoryRepositoryInterface','Authority\Repositories\CategoryRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\JobRepositoryInterface','Authority\Repositories\JobRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\RatingRepositoryInterface','Authority\Repositories\RatingRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\SkillRepositoryInterface','Authority\Repositories\SkillRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\UserRepositoryInterface','Authority\Repositories\UserRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\ChargeRepositoryInterface','Authority\Billing\Gateways\StripeGateway'
        );
        $this->app->bind(
            'Authority\Interfaces\SessionsAuthTokenInterface','Authority\AuthToken\AuthTokenController'
        );
        $this->app->bind(
            'Authority\Interfaces\ProductInterface','Authority\Repositories\ProductRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\AnalyticsInterface','Authority\Repositories\AnalyticsRepository'
        );
        $this->app->bind(
            'Authority\Interfaces\GMapsInterface','Authority\Service\LocationServices\GMaps'
        );

        /*

        $this->app->bind(
            'Authority\Billing\BillingInterface','Authority\Billing\StripeBilling'
        );
        */
    }

}