<?php
if ($tasks):
 foreach($tasks['data'] as $task): ?>
<div class="row">
	<div class="col-sm-12">
			<div> <span>Task Name:</span><?php echo $task['name']; ?></div>
			<div> <span>Task Description:</span> <?php echo $task['notes']; ?></div>
			<div> <span>Date Added:</span> <?php echo ($task['created_at']!='')?date('d M Y H:i',strtotime($task['created_at'])):''; ?></div>
			<div> <span>Date Completed:</span> <?php echo ($task['completed_at']!='')?date('d M Y H:i',strtotime($task['completed_at'])):''; ?></div>
			<div><span>Assigned to </span> <?php echo (isset($task['assignee']['name']))?$task['assignee']['name']:''; ?></div>
	</div>	
</div>
<br>
<?php endforeach; ?>		
<?php else: ?>
<div class="row">
		<div class="col-sm-12">
			No tasks available
		</div>
</div>
<?php endif; ?>