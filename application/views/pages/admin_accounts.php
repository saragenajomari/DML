<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

function disableAcc(id){       
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
                url: "<?php echo base_url(); ?>index.php/Accounts/disable_account",
                data: {id:id},
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
	<h1 id="hdr-acc">Accounts</h1>
	<div id="btn-add-acc">
		<a href="<?php echo site_url('Pages/add_account_page'); ?>"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Account</button></a>
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
        <?php foreach ($accounts as $data_accounts) { ?>	
        	<tr>
        		<td><img id="img_acc_tbl" src="<?php echo base_url().'uploads/userImage/'.$data_accounts->profilepic;?>"></td>
        		<td><?php echo $data_accounts->school_id; ?></td>
                <td><?php echo $data_accounts->fname.' '.$data_accounts->mname.' '.$data_accounts->lname; ?></td>
                <td><?php echo $data_accounts->type; ?></td>
                <td><?php echo $data_accounts->email; ?></td>
                <td><?php echo $data_accounts->contact; ?></td>
                <td><button class="btn btn-danger disable-btn" id="<?php echo $data_accounts->id;?>" onclick="disableAcc(this.id)" <?php if($data_accounts->status=='disabled'){echo 'style="display:none"';}?>><i class="fa fa-trash-o"></i></button>
                </td>
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