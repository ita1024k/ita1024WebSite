<?php $this->beginContent(Rights::module()->appLayout); ?>

<div id="rights">

	<?php if( $this->id!=='install' ): ?>

		<div id="menu"><?php $this->renderPartial('/_menu'); ?></div>

	<?php endif; ?>

	<?php $this->renderPartial('/_flash'); ?>

	<?php echo $content; ?>

</div>

<?php $this->endContent(); ?>