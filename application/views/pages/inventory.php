<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
    "columns": [
    { "width": "5%" },
    { "width": "15%" },
    null,
    { "width": "10%" },
    { "width": "15%" },
    null,
    null
    ]
    });
});

function disableItem(id){       
    swal({
        title: "Are you sure you want delete this item?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Items/delete_item",
                data: {id:id},
                success: function(data){
                    if (data) {
                        swal({
                            title: "Poof! This Item has been deleted!",
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
            swal("No changes made on this item!");
        }
    });
}

</script>
<div class="user-dashboard">
	<h1 id="hdr-acc">Inventory</h1>
	<div id="btn-add-acc">
        <?php
            if ($_SESSION['type'] == 'admin') {
                echo '<a href="'.site_url("Pages/add_item_page").'"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Item</button></a>';
            }elseif ($_SESSION['type'] == 'staff') {
                 echo '<a href="'.site_url("Pages/staff_add_item_page").'"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Item</button></a>';
            }
        ?>
		
	</div>
	<div class="">
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th></th>
            	<th>Barcode</th>
            	<th>Item Name</th>
                <th>Value</th>
                <th>Quantity</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $data_items) { ?>
        	<tr>
                <td style="font-size:1.5em;">
                    <?php 
                    if($data_items->status == 'broken'){
                        echo '<center><i style="color:orange" class="fa fa-exclamation-triangle"></i></center>';
                    }elseif ($data_items->status == 'repair') {
                        echo '<center><i style="color:green" class="fa fa-wrench"></i></center>';
                    } 
                    ?>        
                </td>
        		<td><?php echo $data_items->item_code; ?></td>
        		<td><?php echo $data_items->item_name; ?></td>
                <td><?php echo $data_items->value; ?></td>
                <td><?php echo $data_items->quantity; ?></td>
                <td>
                    <?php
                    if ($_SESSION['type'] == 'admin') {
                        echo '<center><a href="'.site_url("Pages/edit_item_page/".$data_items->id).'"><button type="button" class="btn btn-primary"><i class="fa fa-cog"></i></button></a></center>';
                    }elseif ($_SESSION['type'] == 'staff') {
                        echo '<center><a href="'.site_url("Pages/staff_edit_item_page/".$data_items->id).'"><button type="button" class="btn btn-primary"><i class="fa fa-cog"></i></button></a></center>';
                    }
                    ?>
                </td>
                <td><center><button type="button" class="btn btn-danger" id="<?php echo $data_items->id; ?>" onclick="disableItem(this.id)"><i class="fa fa-trash-o"></i></button></center></td>
            </tr>
        <?php  } ?>   
        </tbody>
    </table>
    </div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>