<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

function disableClass(id){       
    swal({
        title: "Are you sure you want disable this account?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Classes/disable_class",
                data: {id:id},
                success: function(data){
                    if (data) {
                        swal({
                            title: "Poof! This Class has been updated!",
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
            swal("No changes made on this class!");
        }
    });
}
</script>
<div class="user-dashboard">
	<h1 id="hdr-acc">Classes</h1>
	<div id="btn-add-acc">
		<a href="<?php echo site_url('Pages/add_class_page'); ?>"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Classes</button></a>
	</div>
	<div class="">
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            	<th>Class Code</th>
            	<th>Group Number</th>
                <th>Semester</th>
                <th>Academic Year</th>
                <th>Time</th>
                <th>Day</th>
                <th>Instructor</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($array as $data_class_info){ ?>
        	<tr>
        		<td><?php echo $data_class_info['ccode'];  ?></td>
        		<td><?php echo $data_class_info['grpNo'];  ?></td>
                <td><?php echo $data_class_info['semester'];  ?></td>
                <td><?php echo $data_class_info['acadYr'].'-'.$data_class_info['acadYr_end'];  ?></td>
                <td><?php echo $data_class_info['ts'].'-'.$data_class_info['te']; ?></td>
                <td><?php echo $data_class_info['day'];  ?></td>
                <td><?php echo $data_class_info['fname'].' '.$data_class_info['lname']; ?></td>
                <td><a href="<?php echo site_url('Pages/check_class_page/'.$data_class_info['id']); ?>"><button class="btn btn-primary"><i class="fa fa-folder-open-o"></i></button></a></td>
                <td><a <?php if($data_class_info['flag']){echo "style='display:none'";} ?> href="<?php echo site_url('Pages/edit_class_page/'.$data_class_info['id']); ?>"><button class="btn btn-warning" name="Edit"><i class="fa fa-cogs"></i></button></a></td>
                <td><button <?php if($data_class_info['flag']){echo "style='display:none'";} ?> class="btn btn-danger" id="<?php echo $data_class_info['id']; ?>" onclick="disableClass(this.id)"><i class="fa fa-trash-o"></i></button></td>   
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