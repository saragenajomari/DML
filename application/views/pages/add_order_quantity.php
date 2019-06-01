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
            text: "Doesnt have enough stock on the requested item or something went wrong. Try again or contact administrator",
            icon: "error",
            button: "Continue",
        }).then(function(isConfirm){
            location.reload();
        }); 
        }
    }
});

}
</script>
<div class="user-dashboard">
	<h1 id="hdr-acc">Add Quantity</h1>
	<div id="btn-add-acc">
		
	</div>
	<div class="">
        <div class="form-add col-md-6" >
    <form id="myform" class="myform" method="post" name="myform">        
    <?php foreach ($array as $details) { ?>
        <div class="form-group">
        <label for="id_num" class="col-md-3 control-label"><?php echo $details['item_name']; ?></label>
        <p style="float:left; margin:1em 0em 0em 2em;">X</p>
            <div style="float:left;" class="col-md-8">
                <input type="hidden" name="id_list[]" value="<?php echo $details['id']; ?>">
                <input class="form-control" type="number" name="quan_list[]" value = "<?php if($details['quantity'] == 1){ echo $details['quantity']; } ?>"> 
            </div>
        </div><br>
    <?php } ?>
    <?php foreach($class_details as $data_details){?>
    <input type="hidden" name="cid" value="<?php echo $data_details->id; ?>">   
    <?php } ?>
    </form>
    <button type="button" class="btn btn-success" onclick="submitForm()">Submit</button>
        </div>
    </div>
    <div id="myResponse"></div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>