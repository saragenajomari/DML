<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

function brokenItemOkay(oiid){
    var oid = $("input#oid").val();

    swal({
        title: "You are about to update the status of the item, Continue?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Orders/broken_item_ok",
                data: {oiid:oiid,oid:oid},
                success: function(data){
                    if (data == 2) {
                    swal({
                        title: "Item Cleared!",
                        text: "",
                        icon: "success",
                        button: "Continue",
                    }).then(function(isConfirm){
                        location.reload();
                    });    
                    }else if(data == 1){
                    swal({
                        title: "All Broken Items(s) On This Order Has Been Cleared!",
                        text: "Click the button to return in the damaged item page",
                        icon: "success",
                        button: "Continue",
                    }).then(function(isConfirm){
                        window.location.href = "<?php echo base_url();?>index.php/Pages/staff_broken_item_page/";  
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
        } else {
            swal("No changes made");
        }
    });

    
}


</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Broken Items</h1>
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
                <td><center><button type="button" class="btn btn-success" id="<?php echo $details['oiid']; ?>" onclick="brokenItemOkay(this.id)"><i class="fa fa-check-circle"></i></i></button></center></td>
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