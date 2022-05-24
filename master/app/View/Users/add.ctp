<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('user');
		echo $this->Form->input('password');
		echo $this->Form->input('confirm_password', array('type'=>'password','required'=>true,'div'=>'required'));
		echo $this->Form->input('nome');
		echo $this->Form->input('almoxarifado_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Almoxarifados'), array('controller' => 'almoxarifados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Almoxarifado'), array('controller' => 'almoxarifados', 'action' => 'add')); ?> </li>
	</ul>
</div>
