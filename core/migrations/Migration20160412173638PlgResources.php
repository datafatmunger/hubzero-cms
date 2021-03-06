<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Hubzero\Content\Migration\Base;

/**
 * Migration script for adding plugins for Resource metadata
 **/
class Migration20160412173638PlgResources extends Base
{
	/**
	 * Up
	 **/
	public function up()
	{
		$this->addPluginEntry('resources', 'googlescholar');
		$this->addPluginEntry('resources', 'opengraph');
		$this->addPluginEntry('resources', 'dublincore');
	}

	/**
	 * Down
	 **/
	public function down()
	{
		$this->deletePluginEntry('resources', 'googlescholar');
		$this->deletePluginEntry('resources', 'opengraph');
		$this->deletePluginEntry('resources', 'dublincore');
	}
}
