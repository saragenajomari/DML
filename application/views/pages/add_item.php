<script type="text/javascript">
$(document).ready(function(event){
    $("#submit").attr("disabled", true);

    $('#addQuan').mousedown(function(e){
        $('#item_quantity').val( function(i, oldval) {
        return parseInt( oldval, 10) + 1;
        });
    });
    $('#minusQuan').mousedown(function(e){
        $('#item_quantity').val( function(i, oldval) {
        return parseInt( oldval, 10) - 1;
        });
    });

    $('#submit').click(function(e){
        var itemCode = $("input#item_code").val();
        var itemName = $("input#item_name").val();
        var itemValue = $("input#item_value").val();
        var itemQuantity = $("input#item_quantity").val();

            $.ajax({
            url:'<?php echo base_url(); ?>index.php/Items/add_item',
            type:"post",
            data:{itemCode:itemCode,itemName:itemName,itemValue:itemValue,itemQuantity:itemQuantity},
            success: function(data){
            if (data) {
                swal({
                  title: "Item Added Successfully!",
                  text: "",
                  icon: "success",
                  button: "Continue",
                }).then(function(isConfirm){
                  location.reload();
                });  

            }
            },
            error: function(data){
              swal("Sorry!", "Something went wrong. Try Again", "error");
            }               
            });
          
    });

});
</script>

<div class="user-dashboard">
	<h1 id="hdr-acc">Add Item</h1>
	<div class="form-add col-md-6">
        <form method="post" action="" id="form-item">

        <div class="form-group">
            <label for="" class="col-md-3 control-label">Item Code</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="item_code" id="item_code" placeholder="Item Code">
            </div>
        </div><br><br><br>

        <div class="form-group">
            <label for="" class="col-md-3 control-label">Item Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Item Name">
            </div>
        </div><br><br> 

        <div class="form-group">
            <label for="" class="col-md-3 control-label">Value</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="item_value" id="item_value" placeholder="Value">
            </div>
        </div><br><br> 

        <div class="form-group">
            <label for="" class="col-md-3 control-label" >Quantity</label>
            <div class="col-md-9" style=""> 
                <input type="number" class="form-control" name="item_quantity" id="item_quantity" placeholder="Quantity" value=1>
                <button type="button" id="addQuan" style="float: left" class="btn btn-default"><i class="fa fa-plus"></i></button>
                <button type="button" id="minusQuan" style="float: left" class="btn btn-default"><i class="fa fa-minus"></i></button>
            </div>
        </div><br><br> 

        <div class="form-group">
            <div class="col-md-9" style=""> 
                <button type="button" id="submit" style="float: left" class="btn btn-success"><i class="fa fa-plus"></i> Add</button>
            </div>
        </div><br><br> 

        </form>
    </div>    
</div>

<script type="text/javascript">
var ready_itemCode = 0;
var ready_itemName = 0;
var ready_itemValue = 0;
var ready_itemQuantity = 1;

$("#item_code").keyup(function(event){
    var item_code = $("input#item_code").val();
    if (item_code == '') {
        document.getElementById('item_code').style.borderColor = "red";
        ready_itemCode = 0;
    }else{
        document.getElementById('item_code').style.borderColor = "green";
        ready_itemCode = 1;
    }
});

$("#item_name").keyup(function(event){
    var item_name = $("input#item_name").val();
    if (item_name == '') {
        document.getElementById('item_name').style.borderColor = "red";
        ready_itemName = 0;
    }else{
        document.getElementById('item_name').style.borderColor = "green";
        ready_itemName = 1;
    }
});

$("#item_value").keyup(function(event){
    var item_value = $("input#item_value").val();
    if (item_value == '') {
        document.getElementById('item_value').style.borderColor = "red";
        ready_itemValue = 0;
    }else{
        document.getElementById('item_value').style.borderColor = "green";
        ready_itemValue = 1;
    }
});

$("#addQuan").mouseup(function(event){
    var item_quantity = $("input#item_quantity").val();
 
    if (item_quantity == 0) {
        document.getElementById('item_quantity').style.borderColor = "red";
        ready_itemQuantity = 0;
    }else if(item_quantity < 0) {
        document.getElementById('item_quantity').style.borderColor = "red";
        ready_itemQuantity = 0;
    }else if(item_quantity > 0){
        document.getElementById('item_quantity').style.borderColor = "green";
        ready_itemQuantity = 1;
    }
});

$("#minusQuan").mouseup(function(event){
    var item_quantity = $("input#item_quantity").val();
  
    if (item_quantity == 0) {
        document.getElementById('item_quantity').style.borderColor = "red";
        ready_itemQuantity = 0;
    }else if(item_quantity < 0) {
        document.getElementById('item_quantity').style.borderColor = "red";
        ready_itemQuantity = 0;
    }else if(item_quantity > 0){
        document.getElementById('item_quantity').style.borderColor = "green";
        ready_itemQuantity = 1;
    }
});

$(document).click( function(event) {  
    if (ready_itemQuantity ==1 && ready_itemValue == 1 &&  ready_itemName == 1 && ready_itemCode == 1) {
        $("#submit").attr("disabled", false);
    }else{
        $("#submit").attr("disabled", true);
    }   
}).keydown(function( event ) {
    if ( event.which == 13 ) {
        event.preventDefault();
    }
});

$(document).keyup( function(event) {  
    if (ready_itemQuantity ==1 && ready_itemValue == 1 &&  ready_itemName == 1 && ready_itemCode == 1) {
        $("#submit").attr("disabled", false);
    }else{
        $("#submit").attr("disabled", true);
    }   
}).keydown(function( event ) {
    if ( event.which == 13 ) {
        event.preventDefault();
    }
});

</script>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>