<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

// No direct access.
defined('_HZEXEC_') or die();

if (!$this->sub)
{
	// Include any CSS
	if ($this->page->get('pagename') == 'MainPage')
	{
		$this->css('introduction.css', 'system'); // component, stylesheet name, look in media system dir
	}
	$this->css();
}
// Include any Scripts
$this->js();
?>
<header id="<?php echo ($this->sub) ? 'sub-content-header' : 'content-header'; ?>">
	<?php if (count($this->parents)) { ?>
		<p class="wiki-crumbs">
			<?php foreach ($this->parents as $parent) { ?>
				<a class="wiki-crumb" href="<?php echo Route::url($parent->link()); ?>"><?php echo $parent->title; ?></a> /
			<?php } ?>
		</p>
	<?php } ?>

	<h2><?php echo $this->page->title; ?></h2>
	<?php
	if (!$this->page->isStatic())
	{
		$this->view('authors')
			//->setBasePath($this->base_path)
			->set('page', $this->page)
			->display();
	}
	?>

	<?php echo $this->page->event->afterDisplayTitle; ?>

	<?php if ($this->page->isStatic() && $this->page->access('admin') && $this->controller == 'pages' && $this->task == 'display') { ?>
		<div id="<?php echo ($this->sub) ? 'sub-content-header' : 'content-header'; ?>-extra">
			<ul>
				<li><a class="icon-edit edit btn" href="<?php echo Route::url($this->page->link('edit')); ?>"><?php echo Lang::txt('JACTION_EDIT'); ?></a></li>
				<li><a class="icon-history history btn" href="<?php echo Route::url($this->page->link('history')); ?>"><?php echo Lang::txt('COM_WIKI_HISTORY'); ?></a></li>
			</ul>
		</div><!-- /#content-header-extra -->
	<?php } ?>
</header><!-- /#content-header -->

<?php if ($this->getError()) { ?>
	<p class="error"><?php echo $this->getError(); ?></p>
<?php } ?>

<?php
echo $this->page->event->beforeDisplayContent;

if (!$this->page->isStatic())
{
	$this->view('submenu')
		//->setBasePath($this->base_path)
		->set('option', $this->option)
		->set('controller', $this->controller)
		->set('page', $this->page)
		->set('task', $this->task)
		->set('sub', $this->sub)
		->display();
	?>
	<section class="main section">
		<article class="wikipage">
			<?php echo $this->revision->get('pagehtml'); ?>

			<p class="timestamp">
				<?php echo Lang::txt('COM_WIKI_PAGE_CREATED') . ' <time datetime="' . $this->page->created() . '">'.$this->page->created('date') . '</time>, ' . Lang::txt('COM_WIKI_PAGE_LAST_MODIFIED') . ' <time datetime="' . $this->revision->created() . '">' . $this->revision->created('date') . '</time>'; ?>
				<?php /*if ($stats = $this->page->getMetrics()) { ?>
				<span class="article-usage">
					<?php echo Lang::txt('COM_WIKI_PAGE_METRICS', $stats['visitors'], $stats['visits']); ?>
				</span>
				<?php }*/ ?>
			</p>
			<?php if ($this->page->tags('cloud')) { ?>
				<div class="article-tags">
					<h3><?php echo Lang::txt('COM_WIKI_PAGE_TAGS'); ?></h3>
					<?php echo $this->page->tags('cloud'); ?>
				</div>
			<?php } ?>
		</article>
	</section><!-- / .main section -->
	<?php
}
else
{
	echo $this->revision->get('pagehtml');
}

echo $this->page->event->afterDisplayContent;
