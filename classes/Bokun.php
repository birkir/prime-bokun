<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Bokun REST Client
 *
 * @package API
 * @category Bokun
 * @author Birkir Gudjonsson (birkir.gudjonsson@gmail.com)
 * @copyright (c) 2013 SOLID Productions
 * @license http://kohanaframework.org/license
 */
class Bokun extends Request {

	// Operation types
	const ACCOMMODATION = '/accommodation.json';
	const ACTIVITY      = '/activity.json';
	const CAR_RENTAL    = '/car-rental.json';
	const CUSTOMER      = '/customer.json';
	const SHOPPING_CART = '/shopping-cart.json';
	const BOOKING       = '/booking.json';

	/**
	 * @var string Currency flag
	 */
	public $currency = 'EUR';

	/**
	 * @var string Language flag
	 */
	public $lang = 'EN';

	/**
	 * Creates a new bokun request object for the given operation.
	 *
	 * @param   string  $uri              Operation type or plain URI
	 * @param   array   $client_params    An array of params to pass to the request client
	 * @param   bool    $allow_external   Allow external requests? (deprecated in 3.3)
	 * @param   array   $injected_routes  An array of routes to use, for testing
	 * @return  Bokun
	 * @uses    Request
	 */
	public static function factory($uri = TRUE, $client_params = array(), $allow_external = TRUE, $injected_routes = array())
	{
		return new Bokun(Kohana::$config->load('bokun')->endpoint.$uri, $client_params, $allow_external, $injected_routes);
	}

	/**
	 * Set more detailed operation to URI.
	 *
	 * @param  string Name of operation
	 * @return  Bokun
	 */
	public function operation($name = NULL)
	{
		// Attach to URI
		$this->uri($this->uri().'/'.$name);

		return $this;
	}

	/**
	 * Filter parameters for Objects
	 *
	 * @param  mixed  $val Value to filter
	 * @return string
	 */
	public function filter_param($val)
	{
		// DateTime
		if ($val instanceof DateTime)
			return $val->format('Y-m-d H:i:s');

		return $val;
	}

	/**
	 * Set parameters to Request
	 *
	 * @param  array  $params Array of parameters to parse
	 * @return Bokun
	 */
	public function params(array $params = array())
	{
		// Filter params
		$params = Arr::map(array(array($this, 'filter_param')), $params);

		// attach params to body in json format
		return $this->body(json_encode($params));
	}

	/**
	 * Calculate sha1 hmac and attach security headers
	 * before request is executed.
	 *
	 * @return Response|array
	 */
	public function execute()
	{
		// Load bokun configuration
		$config = Kohana::$config->load('bokun');

		// Append language and currency to query string
		if ( ! $this->query('currency'))
		{
			$this->query('currency', Cookie::get('currency', $this->currency));
		}

		$this->query('lang', Cookie::get('language', $this->lang));

		// Created cached date and signature
		$date = date('Y-m-d H:i:s');
		$sign = $date.$config->accesskey.$this->method().URL::site($this->uri()).URL::query($this->query(), FALSE);
		$signed = base64_encode(hash_hmac('sha1', $sign, $config->secretkey, TRUE));

		// Attach headers
		$this->headers('Content-Type', 'application/json; charset=utf-8');
		$this->headers('X-Bokun-Date', $date);
		$this->headers('X-Bokun-AccessKey', $config->accesskey);
		$this->headers('X-Bokun-Signature', $signed);

		// Execute request
		$result = parent::execute();

		// For better debug, return Response class
		if ($result->status() !== 200)
		{
			return $result;
		}

		// execute request and decode json as result
		return json_decode($result);
	}

} // End Bokun