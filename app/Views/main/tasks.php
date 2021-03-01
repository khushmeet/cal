<?php foreach ($data as $row) {  ?>
	
	<li>
		<div class="title"><?= $row['title'] ?> - </div><b><?= convertDate($row['start_time']) ?></b>
		<span class="margin-75"> 
			<!-- <span class="view-task" onclick="app.tasks.loadTask(<?= $row['id'] ?>)"><i class="fa fa-eye" aria-hidden="true"></i></span> -->
			<span class="edit-task ml-2"  data-toggle="modal" data-target="#btModal" onclick="app.tasks.loadTask(<?= $row['id'] ?>)" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
			<span class="delete-task ml-2" onclick="app.tasks.deleteTask(<?= $row['id'] ?>)" > <i class="fa fa-trash" aria-hidden="true"></i></span> 
		</span>
	</li>

<?php } ?>

