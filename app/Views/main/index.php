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
        						<h2 > <span>My</span> To Do List</h2>
        						<input type="text"  name="title" placeholder="Title...">
        						<input type="date"  name="start_time" placeholder="dd/mm/yyy">
        						<span class="addBtn" id="add-task">Add</span>

                    <div class="errormsg"></div>
        					</div>
					       
                  <ul id="myUL" class="load-tasks">
                  </ul>

                </div>
            </div>
        </div>
    </div>

</div>
