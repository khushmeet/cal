<div class="modal-data">
	<div class="msg"></div>
	<div class="form-inline">

		
		<div class="form-group mb-2">
			<label for="title" class="sr-only">Title</label>
			<input type="text" class="form-control" id="title" name="title" value="<?= $data[0]['title'] ?>">
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label for="date" class="sr-only">Date</label>
			<input type="text" class="form-control" name="start_time" id="start_time" value="<?= convertDate($data[0]['start_time']) ?>" >
			<input type="hidden" class="form-control" name="id"  value="<?= $data[0]['id'] ?>" >
		</div>

		<button type="button" class="btn btn-primary save-task">Save changes</button>
	</div>
</div>