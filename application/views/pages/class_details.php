<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
    $('#example_two').DataTable();

    $('[data-toggle="offcanvas"]').click(function(){
       $("#navigation").toggleClass("hidden-xs");
   });
});

function addStudent(id){
    var cid = $("input#class_id").val();
    var acadYr = $("input#acadYr").val();
    var semester = $("input#semester").val();

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/Classes/check_student",
        data: {id:id,cid:cid,acadYr:acadYr,semester:semester},
        success: function(data){
            if (data == 0) {
                swal({
                    title: "Continue to add this account?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>index.php/Classes/add_student_to_class",
                            data: {id:id,cid:cid,acadYr:acadYr,semester:semester},
                            success: function(data){
                                if (data) {
                                    swal({
                                        title: "Poof! Account added to the class list!",
                                        text: "",
                                        icon: "success",
                                        button: "Continue",
                                    }).then(function(isConfirm){
                                        location.reload();
                                    });                    
                                } 
                            }
                        });   
                    } else {
                        swal("No changes made on the list!");
                    }
                });
            }else if(data == 1){
                swal("Sorry!", "Student is already enrolled in this program or conflict in the student's schedule", "warning");  
            }
        }
    });

    
}

function deleteMember(id){       
    swal({
        title: "Are you sure you want delete this student from the list?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Classes/delete_member",
                data: {id:id},
                success: function(data){
                    if (data) {
                        swal({
                            title: "Poof! This Class list has been updated!",
                            text: "",
                            icon: "success",
                            button: "Continue",
                        }).then(function(isConfirm){
                            location.reload();
                        });                    
                    } 
                }
            });   
        } else {
            swal("No changes made on the list!");
        }
    });
}
</script>

<div class="user-dashboard">
    <?php foreach ($array as $data_array_one) { ?>
	<h1 id="hdr-acc"><?php echo $data_array_one['pname'];  ?></h1>
    <?php } ?>
	<div id="btn-add-acc">  
    <li class="hidden-xs">                        
	<a href="#" data-toggle="modal" data-target="#add_project"><button class="btn btn-primary hidden-xs" ><i class="fa fa-plus-circle"></i> Add Student</button></a>
    </li>
	</div>
	<div class="">
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            	<th></th>
            	<th>ID Number</th>
            	<th>First name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($array_two as $data_array_two) { ?>
        	<tr>
        		<td><img id="img_acc_tbl" src="<?php echo base_url().'uploads/userImage/'.$data_array_two["pp"];?>"></td>
        		<td><?php echo $data_array_two['school_id']; ?></td>
                <td><?php echo $data_array_two['fname']; ?></td>
                <td><?php echo $data_array_two['mname']; ?></td>
                <td><?php echo $data_array_two['lname']; ?></td>
                <td><button onclick="deleteMember(this.id)" id="<?php echo $data_array_two['lid']; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>   
            </tr>
         <?php } ?>
        </tbody>
    </table>
    </div>
</div>



<!--Dont delete these 3 divs -->
</div>
</div>
</div>

<div id="add_project" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Add Project</h4>
                </div>
                <div class="modal-body">
                    <table id="example_two" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                            <th></th>
                            <th>ID Number</th>
                            <th>First name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $flag=0;
                        foreach($students_master_list as $data_master){
                            foreach ($class_master_list as $data_class) {
                                if ($data_master->id == $data_class->student) {
                                    $flag=1;
                                }else{
                                    $flag=0;
                                }
                            }

                            if ($flag!=1) {
                                echo '
                                <tr>
                                <td><img id="img_acc_tbl" src="'.base_url().'uploads/userImage/'.$data_master->profilepic.'"></td>
                                <td>'.$data_master->school_id.'</td>
                                <td>'.$data_master->fname.'</td>
                                <td>'.$data_master->mname.'</td>
                                <td>'.$data_master->lname.'</td>
                                <td><button onclick="addStudent(this.id)" id="'.$data_master->id.'" class="btn btn-primary"><i class="fa fa-plus"></i></button></td>   
                                </tr>
                                ';
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php foreach ($array as $data_array) { ?>
                    <input type="hidden" id="class_id" name="class_id" value="<?php echo $data_array['cid'];  ?>">
                    <input type="hidden" id="acadYr" name="acadYr" value="<?php echo $data_array['acadYr'];  ?>">
                    <input type="hidden" id="semester" name="semester" value="<?php echo $data_array['semester'];  ?>">
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
</div>