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
		$this->apiKey     = $params->get('api_key', null);
		$this->calendarId = $params->get('calendar_id', null);
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
			'timeMin'    => JDate::getInstance()->toISO8601(),
			'maxResults' => $maxEvents,
		);

		$events = $this->getEvents($options);

		return $this->prepareEvents($events);
	}

	/**
	 * Template helper to get the duration
	 *
	 * @param $event
	 *
	 * @return string
	 */
	public static function duration($event)
	{
		$startTimezone = (isset($event->start->timezone)) ? $event->start->timezone : null;
		$endTimezone   = (isset($event->end->timezone)) ? $event->end->timezone : null;

		$startDate = isset($event->start->dateTime)
			? JDate::getInstance($event->start->dateTime, $startTimezone)
			: JDate::getInstance($event->start->date, $startTimezone);

		$endDate = isset($event->end->dateTime)
			? JDate::getInstance($event->end->dateTime, $endTimezone)
			: JDate::getInstance($event->end->date, $endTimezone);

		$startDateFormat = isset($event->start->dateTime) ? 'd.m.Y H:i' : 'd.m.Y';
		$endDateFormat   = isset($event->end->dateTime) ? 'd.m.Y H:i' : 'd.m.Y';

		if($startDate == $endDate)
		{
			return $startDate->format($startDateFormat);
		}

		if($startDate->dayofyear == $endDate->dayofyear)
		{
			return $startDate->format($startDateFormat) . ' - ' . $endDate->format('H:i');
		}

		return $startDate->format($startDateFormat) . ' - ' . $endDate->format($endDateFormat);
	}

	/**
	 * Get the events from the google calendar api
	 *
	 * @param array $options The query parameter options
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

		//TODO exception handling

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
			$events[$i] = $this->prepareEvent($event);
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
	protected function prepareEvent($event)
	{
		$event->startDate    = $this->unifyDate($event->start);
		$event->endDate      = $this->unifyDate($event->end);

		return $event;
	}

	/**
	 * Unify the api dates
	 *
	 * @param $date
	 *
	 * @return JDate
	 */
	protected function unifyDate($date)
	{
		$timeZone =  (isset($date->timezone)) ? $date->timezone : null;
		if(isset($date->dateTime))
		{
			return JDate::getInstance($date->dateTime, $timeZone);
		}

		return JDate::getInstance($date->date, $timeZone);
	}
}