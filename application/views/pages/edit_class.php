<script type="text/javascript">
	$(document).ready(function(event){

    $('#submit').click(function(e){
      var ccode = $("input#classCode").val();
      var grpNo = $("input#grpNum").val();
      var ts = $("input#timeStart").val();
      var te = $("input#timeEnd").val();
      var teacher = $("#teacher option:selected" ).val();
      var day = $("#day option:selected" ).val();
      var cid = $("input#cid").val();
      var pname = $("input#pname").val();

     

      swal({
            title: "Are you sure you want update this account?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
      }).then((willDelete) => {
            if (willDelete) {
              $.ajax({
              url:'<?php echo base_url(); ?>index.php/Classes/check_class_availability_edit',
              type:"post",
              data:{ccode:ccode,grpNo:grpNo,cid:cid},
              success: function(data){
              if (data==1) {
                swal("Sorry!", "Class already in the list", "warning");  
              }else if(data == 0){
              //
                $.ajax({
                type: "POST",
                url:'<?php echo base_url(); ?>index.php/Classes/edit_class',
                data:{ccode:ccode,grpNo:grpNo,ts:ts,te:te,teacher:teacher,day:day,cid:cid,pname:pname},
                success: function(data){
                    if (data) {
                        swal("Poof! This Class has been updated!", {
                        icon: "success",
                        }); 
                    }  
                }
                }); 
              //
              }
              },
              error: function(data){
                swal("Sorry!", "Something went wrong. Contact the administrator for assistance", "error");
              }
              });    
            } else {
            swal("No changes made on this account!");
            }
      });  
    });

	});
</script>

<div class="user-dashboard">
    <h1>Edit Class</h1>
     <div class="form-add col-md-12">
     	<form>
        <?php foreach($class_info as $data_class_info){ ?>
        <input type="hidden" name="cid" id="cid" value="<?php echo $data_class_info->id; ?>">  
     		<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Class Code:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="number" class="form-control" name="classCode" id="classCode" placeholder="Class Code" value="<?php echo $data_class_info->ccode; ?>">
            </div>
        	</div>

        	<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Group Number:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="number" class="form-control" name="grpNum" id="grpNum" placeholder="Group Number" value="<?php echo $data_class_info->grpNo; ?>">
            </div>
        	</div>

        	<!--<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Semester:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="semester" name="semester">
          
    				<option <?php// if($data_class_info->semester == '1'){ echo 'selected';}?> value="1">First</option>
    				<option <?php //if($data_class_info->semester == '2'){ echo 'selected';}?> value="2">Second</option>
    				<option <?php //if($data_class_info->semester == '3'){ echo 'selected';}?> value="3">Summer</option>
  				</select>
  			</div>
			</div>

			<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Academic Year:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="acadYr" name="acadYr">
                  
    				<option <?php //if($data_class_info->acadYr == 2019){ echo 'selected';}?> value="2019">2019</option>
    				<option <?php //if($data_class_info->acadYr == 2020){ echo 'selected';}?> value="2020">2020</option>
    				<option <?php //if($data_class_info->acadYr == 2021){ echo 'selected';}?> value="2021">2021</option>
    				<option <?php //if($data_class_info->acadYr == 2022){ echo 'selected';}?> value="2022">2022</option>
    				<option <?php //if($data_class_info->acadYr == 2023){ echo 'selected';}?> value="2023">2023</option>
    				<option <?php //if($data_class_info->acadYr == 2024){ echo 'selected';}?> value="2024">2024</option>
  				</select>
  			</div>
			</div>-->

			<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Schedule Time Start:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="time" class="form-control" name="timeStart" id="timeStart" placeholder="Time Start" value="<?php echo $data_class_info->time_start; ?>">
            </div>
        	</div>

        	<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Schedule Time End:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="time" class="form-control" name="timeEnd" id="timeEnd" placeholder="Time End" value="<?php echo $data_class_info->time_end; ?>">
            </div>
        	</div>

        	<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Day:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="day" name="day">
          
    				<option <?php if($data_class_info->day == 'MW'){ echo 'selected';}?> value="MW">MW</option>
    				<option <?php if($data_class_info->day == 'TTh'){ echo 'selected';}?> value="TTH">TTH</option>
    				<option <?php if($data_class_info->day == 'FSat'){ echo 'selected';}?> value="FSat">FSat</option>
    				<option <?php if($data_class_info->day == 'Sat'){ echo 'selected';}?> value="Sat">Sat</option>
    				<option <?php if($data_class_info->day == 'F'){ echo 'selected';}?> value="F">Friday</option>
  				</select>
  			</div>
			</div>

			<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Instructor:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="teacher" name="teacher">
                   
                    <?php foreach ($teachers as $data_teachers) {
                      if ($data_class_info->teacher == $data_teachers->id) {
                        echo "<option selected value='".$data_teachers->id."'>".$data_teachers->fname." ".$data_teachers->lname."</option>";
                      }else{
                        echo "<option value='".$data_teachers->id."'>".$data_teachers->fname." ".$data_teachers->lname."</option>";
                      }
                    
                    } ?>
  				</select>
  			</div>
			</div>

      <div class="form-group" id="form-input-class" style="width: 40em;">
          <label id="form-label-class" for="id_num" class="col-md-3 control-label">Program Name:</label>
          <div class="col-md-12" id="form-input-div" style="width: 32em;">
              <input type="text" class="form-control" name="pname" id="pname" value="<?php echo $data_class_info->pname; ?>">
          </div>
      </div>

			<div class="form-group" id="add-class-btn">
        	<!-- Button -->                                        
            <div  class="col-md-offset-3 col-md-9">
            <button type="button" id="submit" class="btn btn-primary">Update</button>
            </div>
        	</div><br>
        <?php } ?>
     	</form>
     </div>
</div>

<script type="text/javascript">
  var ccode_ready = 1;
  var grpNum_ready = 1;
  var semester_ready = 1;
  var acadYr_ready = 1;
  var ts_ready = 1;
  var te_ready = 1;
  var day_ready = 1;
  var teacher_ready = 1;
  var pname_ready = 1;

  $("#pname").keyup(function(event){
    var pname = $("input#pname").val();

    if (pname == '') {
      document.getElementById('pname').style.borderColor = "red";
      pname_ready = 0;
    }else{
      document.getElementById('pname').style.borderColor = "green";
      pname_ready = 1;
    }
  });

  $("#classCode").keyup(function(event){
    var ccode = $("input#classCode").val();
    var ccode_len = ccode.length;

    if (ccode == '') {
      document.getElementById('classCode').style.borderColor = "red";
      ccode_ready = 0;
    }else if(ccode_len != 3){
      document.getElementById('classCode').style.borderColor = "red";
      ccode_ready = 0;
    }else{
      document.getElementById('classCode').style.borderColor = "green";
      ccode_ready = 1;
     
    }
  });

  $("#grpNum").keyup(function(event){
    var grpNum = $("input#grpNum").val();
    var grpNum_len = grpNum.length;

    if (grpNum == '') {
      document.getElementById('grpNum').style.borderColor = "red";
      grpNum_ready = 0;
    }else if (grpNum_len > 2) {
      document.getElementById('grpNum').style.borderColor = "red";
      grpNum_ready = 0;
    }else if (grpNum > 99 || grpNum < 0) {
      document.getElementById('grpNum').style.borderColor = "red";
      grpNum_ready = 0;
    }else{
      document.getElementById('grpNum').style.borderColor = "green";
      grpNum_ready = 1;
    }
  });

  /*$("#semester").click(function(event){
    var semester = $("#semester option:selected" ).val();

    if (semester == '') {
      document.getElementById('semester').style.borderColor = "red";
      semester_ready = 0;
    }else{
      document.getElementById('semester').style.borderColor = "green";
      semester_ready = 1;
    }
  });

    $("#acadYr").click(function(event){
    var acadYr = $("#acadYr option:selected" ).val();

    if (acadYr == '') {
      document.getElementById('acadYr').style.borderColor = "red";
      acadYr_ready = 0;
    }else{
      document.getElementById('acadYr').style.borderColor = "green";
      acadYr_ready = 1;
    }
  });*/

  $("#timeStart").keyup(function(event){
    var timeStart = $("input#timeStart").val();

    if (timeStart == '') {
      document.getElementById('timeStart').style.borderColor = "red";
      ts_ready = 0;
    }else{
      document.getElementById('timeStart').style.borderColor = "green";
      ts_ready = 1;
    }
  });

  $("#timeEnd").keyup(function(event){
    var timeEnd = $("input#timeEnd").val();

    if (timeEnd == '') {
      document.getElementById('timeEnd').style.borderColor = "red";
      te_ready = 0;
    }else{
      document.getElementById('timeEnd').style.borderColor = "green";
      te_ready = 1;
    }
  });

  $("#day").click(function(event){
    var day = $("#day option:selected" ).val();

    if (day == '') {
      document.getElementById('day').style.borderColor = "red";
      day_ready = 0;
    }else{
      document.getElementById('day').style.borderColor = "green";
      day_ready = 1;
    }
  });

  $("#teacher").click(function(event){
    var teacher = $("#teacher option:selected" ).val();

    if (teacher == '') {
      document.getElementById('teacher').style.borderColor = "red";
      teacher_ready = 0;
    }else{
      document.getElementById('teacher').style.borderColor = "green";
      teacher_ready = 1;
    }
  });


     $(document).keyup( function(event) {
    //if (event.which === 13) {
        if (ccode_ready == 1 && grpNum_ready == 1 && ts_ready == 1 && te_ready == 1 && day_ready == 1 && teacher_ready == 1 && pname_ready == 1) {
            $("#submit").attr("disabled", false);
        }else{
            $("#submit").attr("disabled", true);
        }   
    //}
    }).keydown(function( event ) {
        if ( event.which == 13 ) {
        event.preventDefault();
        }
    });

    $(document).click( function(event) {
    //if (event.which === 13) {
        if (ccode_ready == 1 && grpNum_ready == 1 && ts_ready == 1 && te_ready == 1 && day_ready == 1 && teacher_ready == 1 && pname_ready == 1) {
            $("#submit").attr("disabled", false);
        }else{
            $("#submit").attr("disabled", true);
        }   
    //}
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