<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$assetTabs = array();

// Sort tabs so that asset tabs are together
foreach ($this->tabs as $tab)
{
	if ($tab['submenu'] == 'Assets')
	{
		$assetTabs[] = $tab;
	}
}
$a = 0;

$counts = $this->model->get('counts');

?>
<ul class="projecttools">
	<?php
	foreach ($this->tabs as $tab)
	{
		if (!isset($tab['icon']))
		{
			$tab['icon'] = 'f009';
		}

		/*if (isset($tab['submenu']) && $tab['submenu'] == 'Assets' && count($assetTabs) > 0)
		{
			// counter for asset tabs
			$a++;

			// Header tab
			if ($a == 1)
			{
				?>
				<li class="assets">
					<span class="tab-assets" data-icon="&#xf0d7"><?php echo Lang::txt('COM_PROJECTS_TAB_ASSETS'); ?></span>

					<ul class="assetlist">
						<?php foreach ($assetTabs as $aTab) { ?>
							<li<?php if ($aTab['name'] == $this->active) { echo ' class="active"'; } ?>>
								<a class="tab-<?php echo $aTab['name']; ?>" data-icon="&#x<?php echo $aTab['icon']; ?>" href="<?php echo Route::url('index.php?option=' . $this->option . '&alias=' . $this->model->get('alias') . '&active=' . $aTab['name']); ?>" title="<?php echo Lang::txt('COM_PROJECTS_VIEW') . ' ' . strtolower(Lang::txt('COM_PROJECTS_PROJECT')) . ' ' . strtolower($aTab['title']); ?>">
									<span><?php echo $aTab['title']; ?></span>
									<?php if (isset($counts[$aTab['name']]) && $counts[$aTab['name']] != 0) { ?>
										<span class="mini" id="c-<?php echo $aTab['name']; ?>"><span id="c-<?php echo $aTab['name']; ?>-num"><?php echo $counts[$aTab['name']]; ?></span></span>
									<?php } ?>
								</a>
								<?php if (isset($aTab['children']) && count($aTab['children']) > 0) { ?>
									<ul>
										<?php foreach ($aTab['children'] as $item) { ?>
											<li<?php if ($item['class']) { echo ' class="' . $item['class'] . '"'; } ?>>
												<a class="tab-<?php echo $aTab['name']; ?>" data-icon="&#x<?php echo $item['icon']; ?>" href="<?php echo Route::url($item['url']); ?>">
													<span><?php echo $item['title']; ?></span>
												</a>
											</li>
										<?php } ?>
									</ul>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				</li>
				<?php
			}

			continue;
		}*/
		?>
		<li<?php if ($tab['name'] == $this->active) { echo ' class="active"'; } ?>>
			<a class="tab-<?php echo $tab['name']; ?>" data-icon="&#x<?php echo $tab['icon']; ?>" href="<?php echo Route::url('index.php?option=' . $this->option . '&alias=' . $this->model->get('alias') . '&active=' . $tab['name']); ?>" title="<?php echo Lang::txt('COM_PROJECTS_VIEW') . ' ' . strtolower(Lang::txt('COM_PROJECTS_PROJECT')) . ' ' . strtolower($tab['title']); ?>">
				<span><?php echo $tab['title']; ?></span>
				<?php if (isset($counts[$tab['name']]) && $counts[$tab['name']] != 0) { ?>
					<span class="mini" id="c-<?php echo $tab['name']; ?>"><span id="c-<?php echo $tab['name']; ?>-num"><?php echo $counts[$tab['name']]; ?></span></span>
				<?php } ?>
			</a>
			<?php if (isset($tab['children']) && count($tab['children']) > 0) { ?>
				<ul>
					<?php foreach ($tab['children'] as $item) { ?>
						<li<?php if ($item['class']) { echo ' class="' . $item['class'] . '"'; } ?>>
							<a class="tab-<?php echo $item['name']; ?>" data-icon="&#x<?php echo $item['icon']; ?>" href="<?php echo Route::url($item['url']); ?>">
								<span><?php echo $item['title']; ?></span>
							</a>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</li>
		<?php
	}
	?>
</ul>
<ul>
	<?php
		$integrations = Event::trigger('projects.onProjectIntegrationList', array($this->model));
		$integrations = array_filter($integrations);
	?>
	<?php foreach ($integrations as $integration): ?>
		<li><?php echo $integration; ?></li>
	<?php endforeach; ?>
</ul>
