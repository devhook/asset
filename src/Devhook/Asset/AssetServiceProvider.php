<?php namespace Devhook\Asset;

use Illuminate\Support\ServiceProvider;
use Config;

class AssetServiceProvider extends ServiceProvider {

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
		// $this->package('devhook/asset');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['asset'] = $this->app->share(function($app) {
			return new Asset;
		});

		if (!class_exists('Devhook\Asset')) {
			class_alias('Devhook\Asset\AssetFacade', 'Devhook\Asset');
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('asset');
	}

}