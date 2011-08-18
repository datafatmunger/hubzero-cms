<?php
/**
 * @package     hubzero-cms
 * @author      Shawn Rice <zooley@purdue.edu>
 * @copyright   Copyright 2005-2011 Purdue University. All rights reserved.
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3
 *
 * Copyright 2005-2011 Purdue University. All rights reserved.
 *
 * This file is part of: The HUBzero(R) Platform for Scientific Collaboration
 *
 * The HUBzero(R) Platform for Scientific Collaboration (HUBzero) is free
 * software: you can redistribute it and/or modify it under the terms of
 * the GNU Lesser General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * HUBzero is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * HUBzero is a registered trademark of Purdue University.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

$params = new JParameter( $this->page->params );

if ($this->sub) {
	$hid = 'sub-content-header';
	$uid = 'section-useroptions';
	$sid = 'sub-section-menu';
} else {
	$hid = 'content-header';
	$uid = 'useroptions';
	$sid = 'sub-menu';
}
?>
<div id="<?php echo $hid; ?>" class="full">
	<h2><?php echo $this->title; ?></h2>
</div>

<?php echo WikiHtml::subMenu( $this->sub, $this->option, $this->page->pagename, $this->page->scope, $this->page->state, $this->task, $params, $this->editauthorized ); ?>

<div class="main section">
<?php if ($this->getError()) { ?>
	<p class="error"><?php echo $this->getError(); ?></p>
<?php } ?>
<?php if ($this->warning) { ?>
	<p class="warning"><?php echo $this->warning; ?></p>
<?php } ?>
</div><!-- / .section -->
