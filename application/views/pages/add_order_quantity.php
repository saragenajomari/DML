<script type="text/javascript">
function submitForm() {

var form = document.myform;
var dataString = $(form).serialize();

$.ajax({
    type:'POST',
    url:'<?php echo base_url(); ?>index.php/Orders/add_quantity',
    data: dataString,
    success: function(data){
       if (data==1) {
        swal({
            title: "Order Added Successfully!",
            text: "",
            icon: "success",
            button: "Continue",
        }).then(function(isConfirm){
            location.replace("<?php echo site_url('Pages/student_home_page'); ?>")
        });                    
        }else{
        swal({
            title: "Failed!",
            text: "Doesnt have enough stock on the requested item or value is unacceptable. Try again or contact administrator",
            icon: "error",
            button: "Continue",
        }).then(function(isConfirm){
            location.reload();
        }); 
        }
    }
});

}

function check(id){
   
    var quantity_limit = $("input#quan"+id).val();
    var quantity = $("input#"+id).val();
    if (quantity > quantity_limit) {
        document.getElementById(id).style.borderColor = "red";
    }else if (quantity <= 0) {
        document.getElementById(id).style.borderColor = "red";
    }else{
        document.getElementById(id).style.borderColor = "green";
    }
}
</script>
<div class="user-dashboard">
	<h1 id="hdr-acc">Add Quantity</h1>
	<div id="btn-add-acc">
		
	</div>
	<div class="">
        <div class="form-add col-md-6" >
    <form id="myform" class="myform" method="post" name="myform">    
    <br>    
    <?php foreach ($array as $details) { ?>
        <div class="form-group">
        <label for="id_num" class="col-md-6 control-label"><?php echo $details['item_name']; ?></label>
        
            <div class="col-md-3">
                <input type="hidden" name="id_list[]" value="<?php echo $details['id']; ?>">
                <input class="form-control" type="number" id="<?php echo $details['id']; ?>" name="quan_list[]" min="1" max="<?php echo $details['quantity']; ?>" value="" onkeyup="check(this.id)"> 

                <input type="hidden" id="quan<?php echo $details['id']; ?>" value="<?php echo $details['quantity']; ?>">
            </div>
        </div><br>
    <?php } ?>
    <?php foreach($class_details as $data_details){?>
    <input type="hidden" name="cid" value="<?php echo $data_details->id; ?>">   
    <?php } ?>
    </form>
   
    <button id="smbt" type="button" class="btn btn-success" onclick="submitForm()">Submit</button>
        </div>
    </div>
    <div id="myResponse"></div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>