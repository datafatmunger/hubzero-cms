<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$message  = $this->subject ."\n";
$message .= '-------------------------------' ."\n";
$message .= Lang::txt('Publication') . ': ' . $this->publication->title . ' (' . $this->publication->id . ')' . "\n";

// Append a message
if ($this->message)
{
	$message .= $this->message ."\n";
}

$message = str_replace('<br />', '', $message);
$message = preg_replace('/\n{3,}/', "\n\n", $message);

echo $message;
