<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Prime Module Bokun Customer
 *
 * @author Birkir Gudjonsson (birkir.gudjonsson@gmail.com)
 * @package Prime/Module
 * @category Bokun
 * @copyright (c) 2013 SOLID Productions
 */
class Prime_Module_Bokun_Customer extends Prime_Module {

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
					'default' => 'details',
					'options' => [
						'items' => [
							'authenticate'    => 'Authenticate',
							'change-password' => 'Change password',
							'change-username' => 'Change username'
							'details'         => 'Details',
							'new'             => 'New',
							'update-details'  => 'Update details',
							'username-exists' => 'Username exists',
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
						'directory' => 'module/bokun/customer'
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
		$view = self::load_view('module/bokun/customer', 'template');

		return $view;
	}
}