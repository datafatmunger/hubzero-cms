<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

namespace Components\Whatsnew\Api\Controllers;

use Components\Whatsnew\Helpers\Period;
use Hubzero\Component\ApiController;
use stdClass;
use Request;
use Event;
use Lang;

require_once dirname(dirname(__DIR__)) . DS . 'helpers' . DS . 'period.php';

/**
 * API controller class for What's New
 */
class Entriesv1_0 extends ApiController
{
	/**
	 * Displays a list of new content
	 *
	 * @apiMethod GET
	 * @apiUri    /whatsnew/list
	 * @apiParameter {
	 * 		"name":          "limit",
	 * 		"description":   "Number of result to return.",
	 * 		"type":          "integer",
	 * 		"required":      false,
	 * 		"default":       25
	 * }
	 * @apiParameter {
	 * 		"name":          "start",
	 * 		"description":   "Number of where to start returning results.",
	 * 		"type":          "integer",
	 * 		"required":      false,
	 * 		"default":       0
	 * }
	 * @apiParameter {
	 * 		"name":          "period",
	 * 		"description":   "Time period to return results for.",
	 * 		"type":          "string",
	 * 		"required":      false,
	 * 		"default":       "year"
	 * }
	 * @apiParameter {
	 * 		"name":          "category",
	 * 		"description":   "Category to filter by.",
	 * 		"type":          "string",
	 * 		"required":      false,
	 * 		"default":       null
	 * }
	 * @apiParameter {
	 * 		"name":          "sort_Dir",
	 * 		"description":   "Direction to sort results by.",
	 * 		"type":          "string",
	 * 		"required":      false,
	 * 		"default":       "desc",
	 * 		"allowedValues": "asc, desc"
	 * }
	 * @return  void
	 */
	public function listTask()
	{
		// get the request vars
		$period     = Request::getString('period', 'year');
		$category   = Request::getString('category', 'all');
		$limit      = Request::getInt('limit', 25);
		$limitstart = Request::getInt('limitstart', 0);
		$content    = Request::getString('content', 0);
		$order      = Request::getString('sort_Dir', 'desc');

		// get the search areas
		$areas = array();
		$searchareas = Event::trigger('whatsnew.onWhatsNewAreas');
		foreach ($searchareas as $area)
		{
			$areas = array_merge($areas, $area);
		}

		// parse our categories
		// make sure we have a category
		$category = ($category == '') ? 'all' : $category;
		$category = array_filter(array_values(explode(',', $category)));

		// if we have an array of categories lets remove any areas not passed in
		if (!in_array('all', $category))
		{
			foreach ($areas as $k => $area)
			{
				if (!in_array($k, $category))
				{
					unset($areas[$k]);
				}
			}
		}

		//parse the period
		$p = new Period($period);

		$results = Event::trigger(
			'whatsnew.onWhatsnew',
			array(
				$p,
				999,
				0,
				$areas
			)
		);

		$whatsnew = array();
		foreach ($results as $results_section)
		{
			foreach ($results_section as $result)
			{
				$item = array();
				$item['title'] = stripslashes($result->title);
				$item['link']  = $result->href;
				$item['date']  = @$result->created;
				switch ($result->section)
				{
					case "resources":
						$item['section'] = stripslashes($result->area);
						break;
					case "content":
						$item['section'] = "content articles";
						break;
					default:
						$item['section'] = stripslashes($result->section);
						break;
				}
				if ($content)
				{
					$item['text'] = $result->text;
				}
				$whatsnew[] = $item;
			}
		}

		// order by the date created
		if ($order == 'asc')
		{
			usort($whatsnew, array($this, "sorter_asc"));
		}
		else
		{
			usort($whatsnew, array($this, "sorter"));
		}

		$w = array();
		$count = 0;
		for ($i=$limitstart, $n=count($whatsnew); $i<$n; $i++)
		{
			if ($count < $limit)
			{
				$w[] = $whatsnew[$i];
			}
			$count++;
		}

		$response = new stdClass();
		$response->total = $count;
		$response->whatsnew = $w;

		$this->send($response);
	}

	/**
	 * Sort items
	 *
	 * @param   array    $a
	 * @param   array    $b
	 * @return  integer
	 */
	public function sorter($a, $b)
	{
		return (strtotime($a['date']) < strtotime($b['date'])) ? 1 : -1;
	}

	/**
	 * Sort items desc
	 *
	 * @param   array    $a
	 * @param   array    $b
	 * @return  integer
	 */
	public function sorter_asc($a, $b)
	{
		return (strtotime($a['date']) < strtotime($b['date'])) ? -1 : 1;
	}
}
