<script type="text/javascript">
    $(document).ready(function(event){

        $('#submit').click(function(e){

            var id_num = $("input#id_num").val();
            var fname = $("input#fname").val();
            var mname = $("input#mname").val();
            var lname = $("input#lname").val();
            //var uname = $("input#uname").val();
            var password = $("input#password").val();
            var email = $("input#email").val();
            var cnum = $("input#cnum").val();
            var file = $("input#file").val();
            var type = $("input#type").val();


            swal({
                title: "Are you sure you want update this account?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Accounts/do_edit_account",
                data: {id_num:id_num,fname:fname,mname:mname,lname:lname,password:password,email:email,cnum:cnum,file:file},
                success: function(data){
                    if (data) {
                        swal("Poof! This Account has been updated!", {
                        icon: "success",
                        }); 
                    }  
                }
                });   
            } else {
            swal("No changes made on this account!");
            }
            });

             
        });

    });
</script>

<?php foreach ($info as $data_info) {
?>
<div class="user-dashboard">
    <h1>Edit Account</h1>
        <div class="row col-md-6">
            <form id="updateform" method="post">
                <div class="form-group">
                    <label for="id_num" class="col-md-3 control-label">ID Number</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="id_num" id="id_num" value="<?php echo $data_info->school_id; ?>" disabled>
                    </div>
                </div><br><br><br>
                                    
                <div class="form-group">
                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $data_info->fname; ?>" disabled>
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label for="middlename" class="col-md-3 control-label">Middle Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="mname" id="mname" value="<?php echo $data_info->mname; ?>" disabled>
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                    <div class="col-md-9 " disabled>
                        <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $data_info->lname; ?>" disabled>
                    </div>
                </div><br><br>

                <!--<div class="form-group">
                    <label for="username" class="col-md-3 control-label">User Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="uname" id="uname" value="<?php //echo $data_info->username; ?>" disabled>
                     </div>
                </div><br><br>-->

                <div class="form-group">
                    <label for="password" class="col-md-3 control-label">Password</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="password" id="password" value="<?php echo $data_info->password; ?>">
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Email</label>
                    <div class="col-md-9">
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $data_info->email; ?>">
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label for="cnum" class="col-md-3 control-label">Contact No.</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="cnum" id="cnum" value="<?php echo $data_info->contact; ?>">
                    </div>
                </div><br><br>
                <input type="hidden" name="file" id="file" value="<?php echo $data_info->profilepic; ?>">

                <div class="form-group">
                    <!-- Button -->                                        
                    <div class="col-md-offset-3 col-md-9">
                        <button type="button" id="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
</div>
<?php } ?>

<script type="text/javascript">


    var filter = /^[a-zA-Z]+$/;
    var alpha = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
    var ready_id = 1;
    var ready_fname = 1;
    var ready_mname = 1;
    var ready_lname = 1;
    //var ready_uname = 1;
    var ready_password = 1;
    var ready_email = 1;
    var ready_cnum = 1;

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $("#id_num").keyup(function(event){
        var id_num = $("input#id_num").val();
        var id_num_len = id_num.length;
        var count;
       

        if (isNaN(id_num)) {
            document.getElementById('id_num').style.borderColor = "red";
            ready_id = 0;
        }else if (id_num_len>8||id_num_len<8){
            document.getElementById('id_num').style.borderColor = "red";
            ready_id = 0;
        }else if (!id_num) {
            document.getElementById('id_num').style.borderColor = "red";
            ready_id = 0;
        }else{
             $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Accounts/Check_id",
                data: {id_num:id_num},
                success: function(data){
                    if(data==0){
                        document.getElementById('id_num').style.borderColor = "green";
                        ready_id = 1;
                    }else{
                        document.getElementById('id_num').style.borderColor = "red";
                        ready_id = 0;
                    }
                }
            });
        }
    }); 

    $("#fname").keyup(function(event){
        var fname = $("input#fname").val();
        if (isNaN(fname)) {
            if (alpha.test(fname)) {
                document.getElementById('fname').style.borderColor = "green";
                ready_fname = 1;
            }else{
                document.getElementById('fname').style.borderColor = "red";
                ready_fname = 0; 
            }
        }else if (!fname) {
            document.getElementById('fname').style.borderColor = "red";
            ready_fname = 0;
        }else {
            document.getElementById('fname').style.borderColor = "red";
            ready_fname = 0;
        }
    });    

    $("#mname").keyup(function(event){
        var mname = $("input#mname").val();
        if (isNaN(mname)) {
            if (filter.test(mname)) {
                document.getElementById('mname').style.borderColor = "green";
                ready_mname = 1;
            }else{
                document.getElementById('mname').style.borderColor = "red";
                ready_mname = 0; 
            }
        }else if (!mname) {
            document.getElementById('mname').style.borderColor = "red";
            ready_mname = 0;
        }else {
            document.getElementById('mname').style.borderColor = "red";
            ready_mname = 0;
        }
    });

    $("#lname").keyup(function(event){
        var lname = $("input#lname").val();
        if (isNaN(lname)) {
            if (filter.test(lname)) {
                document.getElementById('lname').style.borderColor = "green";
                ready_lname = 1;
            }else{
                document.getElementById('lname').style.borderColor = "red";
                ready_lname = 0;  
            }
        }else if (!lname) {
            document.getElementById('lname').style.borderColor = "red";
            ready_lname = 0;
        }else {
            document.getElementById('lname').style.borderColor = "red";
            ready_lname = 0;
        }
    });     

    /*$("#uname").keyup(function(event){
        var uname = $("input#uname").val();
        var lname = $("input#lname").val();
        var fname = $("input#fname").val();
        var u_fname = fname.substring(0, 3);
        var uname_cor = lname+u_fname;
        if (isNaN(uname)) {
            if (filter.test(uname)) {
                if (uname == uname_cor) {
                    document.getElementById('uname').style.borderColor = "green";
                    ready_uname = 1;
                }else{
                    document.getElementById('uname').style.borderColor = "red";
                    ready_uname = 0;
                } 
            }else{
                document.getElementById('uname').style.borderColor = "red";
                ready_uname = 0;  
            }
        }else if (!uname) {
            document.getElementById('uname').style.borderColor = "red";
            ready_uname = 0;
        }else {
            document.getElementById('uname').style.borderColor = "red";
            ready_uname = 0;
        }
    }); */

    $("#password").keyup(function(event){
        var password = $("input#password").val();
        if (!password) {
            document.getElementById('password').style.borderColor = "red";
            ready_password = 0;
        }else {
            document.getElementById('password').style.borderColor = "green";
            ready_password = 1;
        }
    }); 

    $("#email").keyup(function(event){
    var email =  $("input#email").val();
    
    if(!email){ 
        document.getElementById('email').style.borderColor = "red";
        ready_email = 0;
        
    }else if(!validateEmail(email)){
        document.getElementById('email').style.borderColor = "red";
        ready_email = 0;
        
    }else{  
        document.getElementById('email').style.borderColor = "green";
        ready_email = 1;
    } 
    }); 

    $("#cnum").keyup(function(event){
        var cnum = $("input#cnum").val();
        var cnum_len = cnum.length;
        if (isNaN(cnum)) {
            document.getElementById('cnum').style.borderColor = "red";
            ready_cnum = 0;
        }else if (cnum_len>11||cnum_len<11){
            document.getElementById('cnum').style.borderColor = "red";
            ready_cnum = 0;
        }else if (!cnum) {
            document.getElementById('cnum').style.borderColor = "red";
            ready_cnum = 0;
        }else{
            document.getElementById('cnum').style.borderColor = "green";
            ready_cnum = 1;
        }
    });  

    $(document).keyup( function(event) {
    //if (event.which === 13) {
        if (ready_id == 1 && ready_mname == 1 && ready_password == 1 && ready_email == 1 && ready_lname == 1 && ready_fname == 1 && ready_cnum == 1) {
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