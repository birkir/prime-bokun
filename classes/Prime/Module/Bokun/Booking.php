<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Prime Module Bokun Booking
 *
 * @author Birkir Gudjonsson (birkir.gudjonsson@gmail.com)
 * @package Prime/Module
 * @category Bokun
 * @copyright (c) 2013 SOLID Productions
 */
class Prime_Module_Bokun_Booking extends Prime_Module {

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
					'default' => 'questions',
					'options' => [
						'items' => [
							'abort-reserved'    => 'Abort reserved',
							'confirm'           => 'Confirm',
							'move-back-to-cart' => 'Move back to cart',
							'questions'         => 'Questions',
							'reserve'           => 'Reserve'
						]
					]
				]
			],
			'Reserve' => [
				[
					'name'    => 'reserve_success',
					'caption' => 'Success page',
					'field'   => 'Prime_Field_Page',
					'default' => '',
				],
				[
					'name'    => 'reserve_cancel',
					'caption' => 'Cancel page',
					'field'   => 'Prime_Field_Page',
					'default' => '',
				],
				[
					'name'    => 'reserve_error',
					'caption' => 'Error page',
					'field'   => 'Prime_Field_Page',
					'default' => '',
				]
			],
			'Layout' => [
				[
					'name'    => 'template',
					'caption' => 'Template',
					'field'   => 'Prime_Field_Template',
					'default' => 'standard',
					'options' => [
						'directory' => 'module/bokun/booking'
					]
				]
			]
		];
	}

	/**
	 * Render module
	 *
	 * @return View
	 */
	public function render()
	{
		$view = self::load_view('module/bokun/booking', 'template');

		return $view;
	}
}