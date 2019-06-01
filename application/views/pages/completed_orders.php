<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
    
});
</script>
<div class="user-dashboard">
    <h1 id="hdr-acc">Completed Orders</h1>
    <div id="btn-add-acc">
        
    </div>

    <div class="">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><center>Class</center></th>
                <th><center>A.Y.</center></th>
                <th><center>Student</center></th>
                <th><center>Approved</center></th> 
                <th><center>Dispensed</center></th>
                <th><center>Returned</center></th>
                <th><center>Instructor</center></th>
                <th></th> 
            </tr>
        </thead>
        <tbody>
        <?php 
        $i=0;
        foreach($array as $details){ ?>
            <tr>
                <td><center><?php echo $details['grpNo'].' '.$details['class_name']; ?></center></td>
                <td><center><?php echo $details['semester'].' '.$details['acadYr'].'-'.$details['acadYr_end']; ?></center></td>
                <td><center><?php echo $details['student_name'].'('.$details['id'].')'; ?></center></td>
                <td><center><?php echo $details['date_approved']; ?></center></td>
                <td><center><?php echo $details['date_dispensed']; ?></center></td>
                <td><center><?php echo $details['date_returned']; ?></center></td>
                <td><center><?php echo $details['teacher_name']; ?></center></td>
                <td><center><a href="<?php echo site_url('Pages/staff_check_completed_page/'.$details["oid"]); ?>"><button class="btn btn-primary"><i class="fa fa-retweet"></i></button></a></center></td>
                
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