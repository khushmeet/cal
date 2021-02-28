<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="#">
    TaskO
  </a>
  <ul class="navbar-nav">
    <li class="nav-item bg-dark">
      <a class="nav-link" href="<?= base_url('logout'); ?>">logout</a>
    </li>
   </ul> 
</nav>

<div class="container mt-3">

   <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-white">
                <div class="card-body">
                    
					<div id="myDIV" class="header">
						<h2 > <span>Khush</span> To Do List</h2>
						<input type="text" id="myInput" placeholder="Title...">
						<input type="date" id="myInput" placeholder="Title...">
						<span class="addBtn">Add</span>
					</div>
					<ul id="myUL" class="load-tasks">
						<li>Hit the gym 
							<span class="margin-75"> 
								<span class="view-task"><i class="fa fa-eye" aria-hidden="true"></i></span>
								<span class="edit-task ml-2"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
								<span class="delete-task ml-2"> <i class="fa fa-trash" aria-hidden="true"></i></span> 
							</span></li>

						<li>Organize office</li>
					</ul>

                </div>
            </div>
        </div>
    </div>

</div>
