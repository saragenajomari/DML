<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
    "columns": [
    { "width": "1%" },
    { "width": "1%" },
    { "width": "20%" },
    { "width": "1%" },
    { "width": "8%" },
    { "width": "10%" },
    { "width": "5%" }
    ]
    });
});
</script>
<div class="user-dashboard">
	<h1 id="hdr-acc">Laboratory Program Enrolled</h1>
	<div id="btn-add-acc">
		
	</div>
	<div class="">
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Group Number</th>
            	<th>Class Code</th>
            	<th></th>
                <th>Day</th>
                <th>Time</th>
                <th>Instructor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($array as $data_array) { ?>
        	<tr>
                <td><?php echo $data_array['grpNo']; ?></td>
        		<td><?php echo $data_array['ccode']; ?></td>
        		<td><?php echo $data_array['pname']; ?></td>
                <td><?php echo $data_array['day']; ?></td>
                <td><?php echo $data_array['ts'].' - '.$data_array['te']; ?></td>
                <td><?php echo $data_array['fname'].' '.$data_array['lname']; ?></td>
                <th><center><a href="<?php echo site_url('Pages/add_order/'.$data_array['id']); ?>"><button type="button" class="btn btn-primary"><i class="fa fa-arrow-circle-right"></i></button></a></center></th>
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