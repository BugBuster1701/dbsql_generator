
<div id="tl_buttons">
	<a href="<?php echo $this->referer;?>" class="header_back" title="<?php echo $this->backTitle;?>" accesskey="b" onclick="Backend.getScrollOffset();"><?php echo $this->backTitle;?></a>
</div>

<h2 class="sub_headline"><?php echo $this->Title;?></h2>
<?php if ($this->warning): ?>
<p class="tl_task_due"><?php echo $this->warning;?></p>
<?php endif; ?>
