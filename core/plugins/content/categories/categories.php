<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

defined('_HZEXEC_') or die;

/**
 * Plugin for ensuring categories are empty before deleting
 */
class plgContentCategories extends \Hubzero\Plugin\Plugin
{
	/**
	 * Don't allow categories to be deleted if they contain items or subcategories with items
	 *
	 * @param   string   $context  The context for the content passed to the plugin.
	 * @param   object   $data     The data relating to the content that was deleted.
	 * @return  boolean
	 */
	public function onContentBeforeDelete($context, $data)
	{
		// Skip plugin if we are deleting something other than categories
		if ($context != 'com_categories.category')
		{
			return true;
		}

		// Check if this function is enabled.
		if (!$this->params->def('check_categories', 1))
		{
			return true;
		}

		$extension = Request::getString('extension');

		// Default to true if not a core extension
		$result = true;

		$tableInfo = array (
			'com_content'   => array('table_name' => '#__content'),
			'com_newsfeeds' => array('table_name' => '#__newsfeeds')
		);

		// Now check to see if this is a known core extension
		if (isset($tableInfo[$extension]))
		{
			// Get table name for known core extensions
			$table = $tableInfo[$extension]['table_name'];

			// See if this category has any content items
			$count = $this->_countItemsInCategory($table, $data->get('id'));

			// Return false if db error
			if ($count === false)
			{
				$result = false;
			}
			else
			{
				// Show error if items are found in the category
				if ($count > 0)
				{
					$msg = Lang::txt('COM_CATEGORIES_DELETE_NOT_ALLOWED', $data->get('title')) . Lang::txts('COM_CATEGORIES_N_ITEMS_ASSIGNED', $count);

					App::abort(403, $msg);

					$result = false;
				}
				// Check for items in any child categories (if it is a leaf, there are no child categories)
				if (!$data->isLeaf())
				{
					$count = $this->_countItemsInChildren($table, $data->get('id'), $data);

					if ($count === false)
					{
						$result = false;
					}
					elseif ($count > 0)
					{
						$msg = Lang::txt('COM_CATEGORIES_DELETE_NOT_ALLOWED', $data->get('title')) . Lang::txts('COM_CATEGORIES_HAS_SUBCATEGORY_ITEMS', $count);

						App::abort(403, $msg);

						$result = false;
					}
				}
			}

			return $result;
		}
	}

	/**
	 * Get count of items in a category
	 *
	 * @param   string  $table  table name of component table (column is catid)
	 * @param   int     $catid  id of the category to check
	 * @return  mixed   Count of items found or false if db error
	 */
	private function _countItemsInCategory($table, $catid)
	{
		$db = App::get('db');

		// Count the items in this category
		$query = $db->getQuery()
			->select('COUNT(id)')
			->from($table)
			->whereEquals('catid', $catid);
		$db->setQuery($query->toString());
		$count = $db->loadResult();

		// Check for DB error.
		if ($error = $db->getErrorMsg())
		{
			App::abort(500, $error);
		}

		return $count;
	}

	/**
	 * Get count of items in a category's child categories
	 *
	 * @param   string  $table  table name of component table (column is catid)
	 * @param   int     $catid  id of the category to check
	 * @param   object  $data
	 * @return  mixed   Count of items found or false if db error
	 */
	private function _countItemsInChildren($table, $catid, $data)
	{
		$db = App::get('db');

		// Create subquery for list of child categories
		$childCategoryTree = $data->getTree();

		// First element in tree is the current category, so we can skip that one
		unset($childCategoryTree[0]);
		$childCategoryIds = array();
		foreach ($childCategoryTree as $node)
		{
			$childCategoryIds[] = $node->id;
		}

		// Make sure we only do the query if we have some categories to look in
		if (count($childCategoryIds))
		{
			// Count the items in this category
			$query = $db->getQuery()
				->select('COUNT(id)')
				->from($table)
				->whereIn('catid', $childCategoryIds);
			$db->setQuery($query->toString());
			$count = $db->loadResult();

			// Check for DB error.
			if ($error = $db->getErrorMsg())
			{
				App::abort(500, $error);
			}

			return $count;
		}

		// If we didn't have any categories to check, return 0
		return 0;
	}
}
