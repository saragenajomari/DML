<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

</script>
<div class="user-dashboard">
	<h1 id="hdr-acc">Select Items</h1>
	<div id="btn-add-acc">
		
	</div>
	<div class="">
    <form id="myform" class="myform" method="post" name="myform" action="<?php echo site_url('Orders/add_order') ?>">  
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>Item Name</th>
                <th>Value</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
        
         <?php foreach($items as $data_items){ ?>   
            <tr>
                <td><input type="checkbox" name="id_list[]" value="<?php echo $data_items->id; ?>"></td>
                <td><?php echo $data_items->item_name; ?></td>
                <td><?php echo $data_items->value; ?></td>
                <td><?php echo $data_items->quantity; ?></td>
            </tr>
         <?php } ?> 
         
        </tbody>
    </table>
    <?php foreach($class_details as $data_details){?>
    <input type="hidden" name="cid" value="<?php echo $data_details->id; ?>">   
    <?php } ?>
    <input type="submit" class="btn btn-success" value="Proceed">
    </form>
    
    </div>
    <div id="myResponse"></div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>