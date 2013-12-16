<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Prime Module Bokun Product
 *
 * @author Birkir Gudjonsson (birkir.gudjonsson@gmail.com)
 * @package Prime/Module
 * @category Bokun
 * @copyright (c) 2013 SOLID Productions
 */
class Prime_Module_Bokun_Product extends Prime_Module {

	/**
	 * Params for configuration 
	 *
	 * @return array
	 */
	public function params()
	{
		return [
			'General' => [
				[
					'name'    => 'type',
					'caption' => 'Type',
					'field'   => 'Prime_Field_Choose',
					'default' => 'accommodation',
					'options' => [
						'items' => [
							'accommodation' => 'Accommodation',
							'activity'      => 'Activity',
							'car-rental'    => 'Car rental',
							'country'       => 'Country',
							'currency'      => 'Currency',
							'language'      => 'Language',
							'tag'           => 'Tag'
						]
					]
				],
				[
					'name'    => 'method',
					'caption' => 'Method',
					'field'   => 'Prime_Field_Choose',
					'default' => 'list',
					'options' => [
						'items' => [
							'availabilities'          => 'Availabilities',
							'detail'                  => 'Detail',
							'list'                    => 'List',
							'pickup-places'           => 'Pickup places',
							'search'                  => 'Search',
							'upcoming-availabilities' => 'Upcoming availabilities'
						]
					]

				]
			],
			'Layout' => [
				[
					'name'    => 'template',
					'caption' => 'Template',
					'field'   => 'Prime_Field_Template',
					'default' => 'standard',
					'options' => [
						'directory' => 'module/bokun/product'
					]
				]
			]
		];
	}

	/**
	 * Check route
	 *
	 * @return boolean
	 */
	public function route($uri = NULL)
	{
		// if type IN [accommodation, car-rental, activity]
		// and if Bokun::TYPE($uri)->status() != 500
		// return TRUE

		return FALSE;
	}

	/**
	 * Render module
	 *
	 * @return View
	 */
	public function render()
	{
		$view = self::load_view('module/bokun/product', 'template');

		return $view;
	}
}