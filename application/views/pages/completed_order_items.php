<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});


</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Completed Order Items</h1>
    <div id="btn-add-acc">
        
    </div>

    <div class="">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><center>Item Code</center></th>
                <th><center>Item Name</center></th>
                <th><center>Quantity</center></th> 
            </tr>
        </thead>
        <tbody>
        <?php foreach($array1 as $details){ ?>
            <tr>
                <td><center><?php echo $details['item_code']; ?></center></td>
                <td><center><?php echo $details['item_name']; ?></center></td>
                <td><center><?php echo $details['quantity']; ?></center></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    
    </div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>