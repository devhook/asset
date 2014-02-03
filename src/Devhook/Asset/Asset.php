<?php namespace Devhook\Asset;

class Asset {

	//-------------------------------------------------------------------------

	const DEFAULT_GROUP = 'head';

	//-------------------------------------------------------------------------

	// Registered assets
	protected $assets = array();

	// Current assets
	protected $required = array();

	//-------------------------------------------------------------------------

	public function __construct() {}

	//-------------------------------------------------------------------------

	public function add($file, $group = self::DEFAULT_GROUP) {
		$type = $this->getTypeByFile($file);
		$this->assets[$file] = array($type => array($file => $group));
		$this->required($file);
	}

	//-------------------------------------------------------------------------

	public function addScript($jsCode, $group = self::DEFAULT_GROUP) {

	}

	//-------------------------------------------------------------------------

	public function addStyle($cssCode) {

	}

	//-------------------------------------------------------------------------

	public function register($asset, $settings) {
		if (is_string($settings)) {
			$type = $this->getTypeByFile($settings);
			$settings = array($type => array($settings => self::DEFAULT_GROUP));
		}

		$this->assets[$asset] = $settings;
	}

	//-------------------------------------------------------------------------

	public function required($assetName) {
		$this->required[$assetName] = $assetName;
	}

	/**************************************************************************
		RENDER METHODS
	**************************************************************************/

	public function styles() {
		return $this->render($this->required, 'css');
	}

	//-------------------------------------------------------------------------

	public function scripts($group = self::DEFAULT_GROUP) {
		return $this->render($this->required, 'js', $group);
	}

	/**************************************************************************
		PROTECTED METHODS
	**************************************************************************/

	protected function render($assets, $type, $group = self::DEFAULT_GROUP) {
		static $typeCallback = array(
			'js'  => 'script',
			'css' => 'style',
		);
		$result = '';
		foreach ($assets as $name => $settings) {

			if (is_string($settings)) {
				if (empty($this->assets[$settings])) {
					continue;
				}
				$settings = $this->assets[$settings];
			}

			if (!empty($settings['required'])) {
				$result .= $this->render((array) $settings['required'], $type, $group);
			}

			if (empty($settings[$type])) {
				continue;
			}

			foreach ($settings[$type] as $file => $asset_group) {
				if (is_numeric($file)) {
					$file        = $asset_group;
					$asset_group = self::DEFAULT_GROUP;
				}

				if ($group == $asset_group) {
					$method = $typeCallback[$type];
					$result .= app('html')->$method($file);
				}

			}
		}

		return $result;
	}

	//-------------------------------------------------------------------------

	protected function getTypeByFile($file) {
		return pathinfo($file, PATHINFO_EXTENSION);
	}

	//-------------------------------------------------------------------------

}