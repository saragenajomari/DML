<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

function releaseItem(oiid){
    var oid = $("input#oid").val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/Orders/release_item",
        data: {oiid:oiid,oid:oid},
        success: function(data){
            if (data == 2) {
                swal({
                title: "Item released!",
                text: "",
                icon: "success",
                button: "Continue",
                }).then(function(isConfirm){
                    location.reload();
                });    

            }else if(data == 1){
                swal({
                title: "All item on this order has been released!",
                text: "Click the button to return in the dispense item page",
                icon: "success",
                button: "Continue",
                }).then(function(isConfirm){
                    window.location.href = "<?php echo base_url();?>index.php/Pages/staff_approved_order_page/";  
                });
            }
        },
        error: function(data){
            swal({
                title: "Oops! Something went wrong",
                text: "",
                icon: "error",
                button: "Continue",
                }).then(function(isConfirm){
                    location.reload();
            });
        }
    });   
}


</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Items For Release</h1>
    <div id="btn-add-acc">
        
    </div>

    <div class="">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><center>Item Code</center></th>
                <th><center>Item Name</center></th>
                <th><center>Quantity</center></th> 
                <th></th> 
            </tr>
        </thead>
        <tbody>
        <?php foreach($array1 as $details){ ?>
            <tr>
                <td><center><?php echo $details['item_code']; ?></center></td>
                <td><center><?php echo $details['item_name']; ?></center></td>
                <td><center><?php echo $details['quantity']; ?></center></td>
                <td><center><button type="button" class="btn btn-primary" id="<?php echo $details['oiid']; ?>" onclick="releaseItem(this.id)"> <i class="fa fa-external-link"></i></button></center></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php foreach ($orders as $data_order) { ?>
    <input type="hidden" name="oid" id="oid" value="<?php echo $data_order->id; ?>">
    <?php } ?>
    </div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>