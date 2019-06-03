<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
    //$("#loading").hide();
});

function returnItem(oiid){
    var oid = $("input#oid").val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/Orders/return_item",
        data: {oiid:oiid,oid:oid},
        success: function(data){
            if (data == 2) {
                swal({
                title: "Item recieved!",
                text: "",
                icon: "success",
                button: "Continue",
                }).then(function(isConfirm){
                    location.reload();
                });                    
            }else if(data == 1){
                swal({
                title: "All item on this order has been recieved!",
                text: "Click the button to return in the return item page",
                icon: "success",
                button: "Continue",
                }).then(function(isConfirm){
                    window.location.href = "<?php echo base_url();?>index.php/Pages/staff_return_order_page/";
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

function returnItemBroken(oiid){
    var oid = $("input#oid").val();
    //$("#loading").show();
    //$("#mail").hide();
    swal({
        title: "Are you sure you want report this as broken item?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Orders/return_broken_item",
                data: {oiid:oiid,oid:oid},
                success: function(data){
                    if (data == 2) {
                    $("#loading").hide();
                    $("#mail").show();
                    swal({
                        title: "Broken Item recieved!",
                        text: "",
                        icon: "success",
                        button: "Continue",
                    }).then(function(isConfirm){
                        location.reload();
                    });                    
                    }else if(data == 1){
                    //$("#loading").hide();
                    //$("#mail").show();    
                    swal({
                        title: "All items on this order has been recieved!",
                        text: "Email has been sent to notify the student. Click the button to return in the return item page",
                        icon: "success",
                        button: "Continue",
                    }).then(function(isConfirm){
                        window.location.href = "<?php echo base_url();?>index.php/Pages/staff_return_order_page/";
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
            swal("No changes made!");
        }
    });
}

//for testing
/*function test_mail(){

    $.ajax({
        type: "POST",
        url: "<?php //echo base_url(); ?>index.php/Orders/send_email",
        success: function(data){
            alert(data);
        }
    });
}*/

</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Items For Return</h1>
    <div id="btn-add-acc">
        
    </div>

    <div class="">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><center>Item Code</center></th>
                <th><center>Item Name</center></th>
                <th><center>Quantity</center></th> 
                <th><center>If Working</center></th> 
                <th><center>If Damaged</center></th> 
            </tr>
        </thead>
        <tbody>
        <?php foreach($array1 as $details){ ?>
            <tr>
                <td><center><?php echo $details['item_code']; ?></center></td>
                <td><center><?php echo $details['item_name']; ?></center></td>
                <td><center><?php echo $details['quantity']; ?></center></td>
                <td><center><button class="btn btn-success" id="<?php echo $details['oiid']; ?>" onclick="returnItem(this.id)"> <i class="fa fa-check-circle"></i></button></center></td>
                <th><center><button type='button' class="btn btn-danger" id="<?php echo $details['oiid']; ?>" onclick="returnItemBroken(this.id)"><i id="mail" class="fa fa-times-circle"></i></button></center></th> 
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php foreach ($orders as $order) { ?>
    <input type="hidden" name="oid" id="oid" value="<?php echo $order->id; ?>">
    <?php } ?>
    </div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>