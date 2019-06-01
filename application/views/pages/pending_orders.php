<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

function orderCancel(oid){
    swal({
        title: "Are you sure you want cancel this order?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Orders/delete_order",
                data: {oid:oid},
                success: function(data){
                    if (data) {
                        swal({
                            title: "Poof! This Order has been deleted!",
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
            swal("No changes made on this order!");
        }
    });
}

function orderApprove(oid){
    swal({
        title: "Are you sure you want approve this order?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Orders/approve_order",
                data: {oid:oid},
                success: function(data){
                    if (data == 1) {
                        swal({
                            title: "Poof! This Order has been approved!",
                            text: "",
                            icon: "success",
                            button: "Continue",
                        }).then(function(isConfirm){
                            location.reload();
                        });                    
                    }else if(data == 2){
                        swal({
                            title: "Sorry! Something went wrong",
                            text: "",
                            icon: "",
                            button: "Continue",
                        }).then(function(isConfirm){
                            location.reload();
                        }); 
                    }else if(data == 3){
                        swal({
                            title: "We dont have enough stock for the order",
                            text: "Delete this order",
                            icon: "",
                            button: "Continue",
                        }).then(function(isConfirm){
                            location.reload();
                        }); 
                    } 
                }
            });   
        } else {
            swal("No changes made on this order!");
        }
    });
}

</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Pending Orders</h1>
    <div id="btn-add-acc">
        
    </div>

    <div class="">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><center>Class Name</center></th>
                <th><center>Student Name</center></th>
                <th><center>ID Number</center></th>
                <th><center>Item Name</center></th>
                <th><center>Date Ordered</center></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
         <?php 
         $i=0;
         foreach($array as $details){ ?>
            <tr>
                <td><center><?php echo $details['class_name']; ?></center></td>
                <td><center><?php echo $details['student_name']; ?></center></td>
                <td><center><?php echo $details['id']; ?></center></td>
                <td><center><?php echo $details['date_ordered']; ?></center></td>
                <td><?php
                foreach($array1[$i] as $items) { 
                    echo ' x'.$items['quantity'].' '.$items['item_name'].'; ';
                }?></td>
                <td><center><button class="btn btn-primary" id="<?php echo $details['oid']; ?>" onclick="orderApprove(this.id)"><i class="fa fa-check"></i></button></center></td> 
                <td><center><button class="btn btn-danger" id="<?php echo $details['oid']; ?>" onclick="orderCancel(this.id)"><i class="fa fa-trash-o"></i></button></center></td> 

            </tr>
        <?php $i++; } ?>
        </tbody>
    </table>
    </div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>