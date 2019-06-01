<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Approved Orders</h1>
    <div id="btn-add-acc">
        
    </div>

    <div class="">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><center>Class Name</center></th>
                <th><center>Student</center></th>
                <th><center>ID Number</center></th> 
                <th><center>Items</center></th> 
                <th><center>Date Ordered</center></th>
                <th><center>Date Approved</center></th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $i=0;
        foreach($array as $details){ ?>
            <tr>
                <td><center><?php echo $details['class_name']; ?></center></td>
                <td><center><?php echo $details['student_name']; ?></center></td>
                <td><center><?php echo $details['id']; ?></center></td>
                <td><?php
                foreach($array1[$i] as $items) { 
                    echo ' x'.$items['quantity'].' '.$items['item_name'].'; ';
                }?></td>
                <td><center><?php echo $details['date_ordered']; ?></center></td>
                <td><center><?php echo $details['date_approved']; ?></center></td>
            </tr>
        <?php $i++; } ?>
        </tbody>
    </table>
    </div>
</div>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>