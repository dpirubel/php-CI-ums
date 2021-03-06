<div class="row">
	
	<div class="col-md-9">

		<div class="col-md-12 alert alert-success" role="alert">
			<h4 class="alert-heading">University Management System (UMS)</h4>
			<p>
				University Management System (UMS) is a large database system which can be used to manage, maintain and secure universitys day to day business.
				<br> 
				<br> In 21st century, with the latest technology the world is moving towards multidirectional force in order to achieve, to give the best solutions to the people in a short period of time, user firiendly, flexible and important securable application. Considering the need to achieve the desired application.
			</p>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="card-box noradius noborder bg-default">
					<i class="fa fa-user-o float-right text-white"></i>
					<h6 class="text-white text-uppercase m-b-20">Teachers</h6>
					<h1 class="m-b-20 text-white counter"><?php echo $this->db->get_where('ums_teacher',['id'=>$_SESSION['user']['dept_id']])->num_rows(); ?></h1>
					<span class="text-white">|</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card-box noradius noborder bg-warning">
					<i class="fa fa-university float-right text-white"></i>
					<h6 class="text-white text-uppercase m-b-20">Students</h6>
					<h1 class="m-b-20 text-white counter"><?php echo $this->db->get_where('ums_student',['dept_id'=>$_SESSION['user']['dept_id']])->num_rows(); ?></h1>
					<span class="text-white">|</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card-box noradius noborder bg-danger">
					<i class="fa fa-database float-right text-white"></i>
					<h6 class="text-white text-uppercase m-b-20">Batchs</h6>
					<h1 class="m-b-20 text-white counter"><?php echo $this->db->get_where('ums_batch',['dept_id'=>$_SESSION['user']['dept_id']])->num_rows(); ?></h1>
					<span class="text-white">|</span>
				</div>
			</div>
		</div>
		

	</div>

	<div class="col-md-3">
		<div class="card">
		<?php if(empty($_SESSION['user']['avatar'])): ?>
			<img class="card-img-top" src="http://via.placeholder.com/350x150?text=Profile+Image" alt="Card image cap">
		<?php else: ?>
			<img class="card-img-top" src="assets/uploads/teacher/<?php echo $_SESSION['user']['avatar'];?>" alt="Card image cap">
		<?php endif; ?>
			<div class="card-body">
				<h5 class="card-title"><?php echo $_SESSION['user']['name']; ?></h5>
				<h6 class="card-title">Depertment: <?php echo $this->db->get_where('ums_dept_list',['id'=>$_SESSION['user']['dept_id']])->row()->name; ?></h6>
				<h6 class="card-title">Email: <?php echo $_SESSION['user']['email']; ?></h6>
				<h6 class="card-title">Phone: <?php echo $_SESSION['user']['phone']; ?></h6>
				
			</div>
		</div>
	</div>	
</div>



		