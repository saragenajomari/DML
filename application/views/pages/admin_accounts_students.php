<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();

    $('[data-toggle="offcanvas"]').click(function(){
       $("#navigation").toggleClass("hidden-xs");
   });

    $('#rfid').change(function(event){
        $( "#add_code" ).toggle();
        activateAcc();
    });
});
function assignValAcc(id){
    $('#uid').val(id);
}

function activateAcc(){   
    var id = $("input#uid").val(); 
    var rfid = $("input#rfid").val();    
    swal({
        title: "RFID recieved, Continue?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Accounts/activate_account",
                data: {id:id,rfid:rfid},
                success: function(data){
                    if (data) {
                        swal({
                            title: "Poof! This Account has been updated!",
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
            swal("No changes made on this account!"); 
        }
    });
}
</script>

<div class="user-dashboard">
	<h1 id="hdr-acc">Pending Accounts</h1>
	<div id="btn-add-acc">
	</div>
	<div class="">
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            	<th></th>
            	<th>ID Number</th>
                <th>Name</th>
                <th>Type</th>
                <th>Email</th>
                <th>Contact</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $data_accounts) { ?>	
        	<tr>
        		<td><img id="img_acc_tbl" src="<?php echo base_url().'uploads/userImage/'.$data_accounts->profilepic;?>"></td>
        		<td><?php echo $data_accounts->school_id; ?></td>
                <td><?php echo $data_accounts->fname.' '.$data_accounts->mname.' '.$data_accounts->lname; ?></td>
                <td><?php echo $data_accounts->type; ?></td>
                <td><?php echo $data_accounts->email; ?></td>
                <td><?php echo $data_accounts->contact; ?></td>

                <?php 
                if ($data_accounts->status == 'pending') {
                    echo '
                    <td><a href="#" data-toggle="modal" data-target="#add_code"><button class="btn btn-primary disable-btn" id="'.$data_accounts->id.'" onclick="assignValAcc(this.id)" ><i class="glyphicon glyphicon-ok"></i></button></a>
                    </td>';
                }elseif($data_accounts->status == 'active'){
                    echo '
                    <td><a href="#" data-toggle="modal" data-target="#add_code"><button class="btn btn-default disable-btn" id="'.$data_accounts->id.'" onclick="assignValAcc(this.id)" ><i class="fa fa-qrcode"></i></button></a>
                    </td>';
                }
                ?>
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

<div id="add_code" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Scan ID</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="uid" id="uid" value="">
                    <input class="form-control" type="text" name="rfid" id="rfid" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel" data-dismiss="modal">Close</button>
                    
                </div>
            </div>

        </div>
</div>