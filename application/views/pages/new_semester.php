<script type="text/javascript">
     $(document).ready(function(event){

        confirm_entry();
    });  

function confirm_entry(){

swal({
  title: "PROCEED?",
  text: "Careful! This module affects some records in the system!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Welcome! Your about to start a new semester!", {
      icon: "success",
    });
  } else {
    window.location.href = "<?php echo base_url();?>index.php/Pages/admin_home_page";
  }
});

} 

function new_semester(){
    swal({
        title: "YOU ARE ABOUT TO START A NEW SEMESTER?",
        text: "Warning! Action Irrevesible!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Constants/new_semester",
                success: function(data){
                    if (data == 1) {
                        swal({
                            title: "Semester Succesfully Updated!",
                            text: "New Semester Started",
                            icon: "success",
                            button: true,
                        }).then((willDelete) => {
                            if (willDelete) {
                                window.location.href = "<?php echo base_url();?>index.php/Pages/admin_home_page";
                            }
                        });
                    }else{
                        swal("Oopps! Something went wrong!", {
                        icon: "error",
                        });
                    }               
                }
            });
        } else {
           swal("No changes made on the system!");
        }
    });
}    
</script>

<div class="user-dashboard">
    <h1>Start New Semester</h1>
    <div class="form-add col-md-6">
        <p>This functionality is only reserved when the new semester is about to start. The function of this is to set a constant that will be a basis of the whole system. This will set the current semester and eventually after three (3) reset, it will set the new academic year. Be careful though for it may affect the transactions and records of the system. Only reset this during the time where the admin starts creating classes for the semester.</p>

        <br><br>
        <div>
            <?php 
            $semester='';
            foreach ($constant as $data) { 
                if ($data->semester == 1) {
                    $semester = 'First Semester';
                }elseif($data->semester == 2){
                    $semester = 'Second Semester';
                }else{
                    $semester = 'Summer Semester';
                }
            ?>
            <p>Current Semester: <strong><?php echo $semester;  ?></strong></p><br>
            <p>Current Academic Year: <strong><?php echo $data->acadYr.'-'.$data->acadYr_end;  ?></strong></p><br>
            
            <button class="btn btn-danger" type="button"  onclick="new_semester()">START NEW SEMESTER</button>
            <?php } ?>
        </div>
    </div>
</div>


<!--Dont delete these 3 divs -->
</div>
</div>
</div>