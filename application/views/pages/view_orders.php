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
            swal("No changes made on this class!");
        }
    });
}

</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Orders</h1>
    <div id="btn-add-acc">
        
    </div>

    <div class="">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><center>Class Name</center></th>
                <th><center>Items</center></th>
                <th><center>Order Status</center></th>
                <th><center>Date Ordered</center></th>
                <th><center>Date Approved</center></th>
                <th></th>
               
            </tr>
        </thead>
        <tbody>
        <?php 
        $i=0;
        foreach($array as $details){ 
            if ($details['status'] != 'removed') { ?>
            <tr>
                <td><center><?php echo $details['class_name']; ?></center></td>
                <td><?php
                foreach($array1[$i] as $items) { 
                    echo ' x'.$items['quantity'].' '.$items['item_name'].'; ';
                }?></td>
                <td><center><?php echo $details['status']; ?></center></td>
                <td><center><?php echo $details['date_ordered']; ?></center></td>
                <td><center><?php echo $details['date_approved']; ?></center></td>
                <td><center><button  class="btn btn-danger" id="<?php echo $details['oid']; ?>" onclick="orderCancel(this.id)" style="<?php if ($details['status'] == 'approved') {
                    echo 'display: none';
                }?>"><i class="fa fa-times-circle" ></i></button></center></td> 
            </tr>
        <?php } $i++; } ?>
        </tbody>
    </table>
    </div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>