<?php namespace Devhook\Asset;

/**
 * @see \Devhook\Asset\Asset
 */
class AssetFacade extends \Illuminate\Support\Facades\Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'asset'; }

}
