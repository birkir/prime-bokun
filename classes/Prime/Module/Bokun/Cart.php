<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Prime Module Bokun Cart
 *
 * @author Birkir Gudjonsson (birkir.gudjonsson@gmail.com)
 * @package Prime/Module
 * @category Bokun
 * @copyright (c) 2013 SOLID Productions
 */
class Prime_Module_Bokun_Cart extends Prime_Module {

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
					'name'    => 'session',
					'caption' => 'Allow sessions',
					'field'   => 'Prime_Field_Boolean',
					'default' => TRUE
				]
			],
			'Layout' => [
				[
					'name'    => 'template',
					'caption' => 'Template',
					'field'   => 'Prime_Field_Template',
					'default' => 'standard',
					'options' => [
						'directory' => 'module/bokun/cart'
					]
				]
			]
		];
	}

	/**
	 * Process form post methods
	 *
	 * @return void
	 */
	public function process()
	{
		if (Request::current()->method() === HTTP_Request::POST)
		{
			// Get POST array
			$post = Request::current()->post();

			// Set allowed methods for gets and posts
			$allowed = array(
				Bokun::GET => array(
					'remove-activity',
					'remove-car-rental',
					'remove-car',
					'remove-room',
					'remove-extra',
					'remove-accommodation',
					'merge-session'
				),
				Bokun::POST => array(
					'activity',
					'car-rental',
					'accommodation',
					'add-or-update-extra'
				)
			);

			// Get method
			$method = Arr::get($post, 'method', NULL);

			if (! in_array($method, Arr::merge($allowed[Bokun::GET], $allowed[Bokun::POST])))
			{
				throw HTTP_Exception::factory(400, 'Method not allowed.');
			}

			// Setup Bokun Request
			$bokun = Bokun::factory(Bokun::SHOPPING_CART)
			->method(in_array($method, $allowed[Bokun::POST]) ? Bokun::POST : Bokun::GET)
			->operation($customer ? 'customer' : 'session')
			->operation($customer ? $customer : Session::instance()->id())
			->operation($method);

			if ($method === 'add-or-update-extra' OR $bokun->method() === Bokun::GET)
			{
				// Append id of resource
				$bokun = $bokun->operation(Arr::get($post, 'id', NULL));
			}

			// Set parameters and execute
			return $bokun
			->params($params)
			->execute();
		}

		return Bokun::factory(Bokun::SHOPPING_CART)
		->method(Bokun::GET)
		->operation($customer ? 'customer' : 'session')
		->operation($customer ? $customer : Session::instance()->id())
		->execute();
	}

	/**
	 * Render module
	 *
	 * @return View
	 */
	public function render()
	{
		// Setup reder view
		$this->view = self::load_view('module/bokun/cart', 'template');

		// Bind data
		$this->view->bind('data', $data);

		// Process shopping cart
		$data = $this->process();

		return $this->view;
	}
}