<script type="text/javascript">
	$(document).ready(function(event){
   // $("#submit").attr("disabled", true);


	 	$('#submit').click(function(e){
	 	 	var ccode = $("input#classCode").val();
	 	 	var grpNo = $("input#grpNum").val();
	 	 	var ts = $("input#timeStart").val();
	 	 	var te = $("input#timeEnd").val();
	 	 	var teacher = $("#teacher option:selected" ).val();
      var day = $("#day option:selected" ).val();
      var pname = $("input#pname").val();

      $.ajax({
        url:'<?php echo base_url(); ?>index.php/Classes/check_class_availability_add',
        type:"post",
        data:{ccode:ccode,grpNo:grpNo},
        success: function(data){
          if (data==1) {
            swal("Sorry!", "Class already in the list", "warning");
            
          }else if(data == 0){
           
            $.ajax({
            url:'<?php echo base_url(); ?>index.php/Classes/add_class',
            type:"post",
            data:{ccode:ccode,grpNo:grpNo,ts:ts,te:te,teacher:teacher,day:day,pname:pname},
            success: function(data){
            if (data) {
                swal({
                  title: "Class Added Successfully!",
                  text: "",
                  icon: "success",
                  button: "Continue",
                }).then(function(isConfirm){
                  location.reload();
                });                    
            }
            },
            error: function(data){
              swal("Sorry!", "Something went wrong. Contact the administrator for assistance", "error");
            }               
            });
          }
        },
        error: function(data){
          swal("Sorry!", "Something went wrong. Contact the administrator for assistance", "error");
        }
      });
	 	});
	});
</script>

<div class="user-dashboard">
    <h1>Add Class</h1>
     <div class="form-add col-md-12">
     	<form>
     		<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Class Code:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="number" class="form-control" name="classCode" id="classCode" placeholder="Class Code">
            </div>
        	</div>

        	<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Group Number:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="number" class="form-control" name="grpNum" id="grpNum" placeholder="Group Number">
            </div>
        	</div>

      <!--  	<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Semester:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="semester" name="semester">
                    <option value=""></option>
    				<option value="1">First</option>
    				<option value="2">Second</option>
    				<option value="3">Summer</option>
  				</select>
  			</div>
			</div>

			<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Academic Year:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="acadYr" name="acadYr">
                    <option value=""></option>
    				<option value="2019">2019</option>
    				<option value="2020">2020</option>
    				<option value="2021">2021</option>
    				<option value="2022">2022</option>
    				<option value="2023">2023</option>
    				<option value="2024">2024</option>
  				</select>
  			</div>
			</div> -->

			<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Schedule Time Start:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="time" class="form-control" name="timeStart" id="timeStart" placeholder="Time Start">
            </div>
        	</div>

        	<div class="form-group" id="form-input-class">
            <label id="form-label-class" for="id_num" class="col-md-3 control-label">Schedule Time End:</label>
            <div class="col-md-4" id="form-input-div">
                <input type="time" class="form-control" name="timeEnd" id="timeEnd" placeholder="Time End">
            </div>
        	</div>

        	<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Day:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="day" name="day">
            <option value=""></option>
    				<option value="MW">MW</option>
    				<option value="TTH">TTH</option>
    				<option value="FSat">FSat</option>
    				<option value="Sat">Sat</option>
    				<option value="F">Friday</option>
  				</select>
  			</div>
			</div>

			<div class="form-group" id="form-input-class">
  			<label id="form-label-class" for="sel1" class="col-md-3 control-label">Instructor:</label>
  			<div class="col-md-4" id="form-input-div">
  				<select class="form-control" id="teacher" name="teacher">
                    <option value=''></option>
                    <?php foreach ($teachers as $data_teachers) {
                    	echo "<option value='".$data_teachers->id."'>".$data_teachers->fname." ".$data_teachers->lname."</option>";
                    } ?>
  				</select>
  			</div>
			</div>

      <div class="form-group" id="form-input-class" style="width: 40em;">
          <label id="form-label-class" for="id_num" class="col-md-3 control-label">Program Name:</label>
          <div class="col-md-12" id="form-input-div" style="width: 32em;">
              <input type="text" class="form-control" name="pname" id="pname" placeholder="">
          </div>
      </div>

			<div class="form-group" id="add-class-btn">
        	<!-- Button -->                                        
            <div  class="col-md-offset-3 col-md-9">
            <button type="button" id="submit" class="btn btn-primary">Continue</button>
            </div>
        	</div><br>

     	</form>
     </div>
</div>
<script type="text/javascript">
  var ccode_ready = 0;
  var grpNum_ready = 0;
  var semester_ready = 0;
  var acadYr_ready = 0;
  var ts_ready = 0;
  var te_ready = 0;
  var day_ready = 0;
  var teacher_ready = 0;
  var pname_ready = 0;

  $("#classCode").keyup(function(event){
    var ccode = $("input#classCode").val();
    var ccode_len = ccode.length;

    if (ccode == '') {
      document.getElementById('classCode').style.borderColor = "red";
      ccode_ready = 0;
    }else if(ccode_len > 5 || ccode_len < 3){
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
</script>

<!--Dont delete these 3 divs -->
</div>
</div>
</div>