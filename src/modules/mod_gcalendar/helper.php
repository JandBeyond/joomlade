<?php use Joomla\Registry\Registry;

defined('_JEXEC') or die;

/**
 * Class ModGCalendarHelper
 */
class ModGCalendarHelper {

	/**
	 * @var string
	 */
	protected $apiKey;

	/**
	 * @var string
	 */
	protected $calendarId;

	/**
	 * @var int
	 */
	protected $maxListEvents;

	/**
	 * @param Registry $params
	 */
	public function __construct(Registry $params)
	{
		$this->apiKey        = $params->get('api_key', null);
		$this->calendarId    = $params->get('calendar_id', null);
	}

	/**
	 * Get the next google events
	 *
	 * @param $maxEvents
	 *
	 * @return array
	 */
	public function nextEvents($maxEvents)
	{
		$options = array(
			'timeMin'      => JDate::getInstance()->toISO8601(),
			'maxResults'   => $maxEvents,
		);

		$events = $this->getEvents($options);

		return $events;
	}

	/**
	 * Get the events from the google calendar api
	 *
	 * @param $options The query parameter options
	 *
	 * @return mixed
	 */
	protected function getEvents($options)
	{
		$defaultOptions = array(
			'orderBy'      => 'startTime',
			'singleEvents' => 'true',
		);

		$options = array_merge($defaultOptions, $options);

		// Create an instance of a default Http object.
		$http = JHttpFactory::getHttp();
		$url  = 'https://www.googleapis.com/calendar/v3/calendars/'
			. urlencode($this->calendarId) . '/events?key=' . urlencode($this->apiKey)
			. '&' . http_build_query($options);

		$response = $http->get($url);
		$data     = json_decode($response->body);

		// todo exception handling

		return $data->items;
	}

	/**
	 * Prepare events
	 *
	 * @param $events
	 *
	 * @return array
	 */
	protected function prepareEvents($events)
	{
		foreach ($events AS $i => $event)
		{
			$events[$i] = $this->prepareItem($event);
		}

		return $events;
	}

	/**
	 * Prepare an event
	 *
	 * @param $event
	 *
	 * @return object
	 */
	protected function prepareItem($event)
	{
		//$item->startDate = $this->getItemDate($item->start)

		return $event;
	}
}