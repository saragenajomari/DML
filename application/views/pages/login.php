 <!DOCTYPE html>
 <html>
 <head>
     <title>USC TC: AutoLab</title>
     <!-- Latest compiled and minified CSS -->

    <!--SweetAlert-->
    <script src="https://code.jquery.com/jquery-3.4.0.js" crossorigin="anonymous"></script> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <!--Sweet Alert-->

    <!--datatables js-->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
   
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/glyphicons-halflings-regular.woff2" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/glyphicons-halflings-regular.woff" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/glyphicons-halflings-regular.ttf" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-theme.min.css" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/login.css" >
</head>
<script type="text/javascript">

     $(document).ready(function(event){

         $('#signupform').submit(function(e){
            e.preventDefault(); 
                 $.ajax({
                     url:'<?php echo base_url(); ?>index.php/Accounts/register',
                     type:"post",
                     data:new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:false,
                     success: function(data){
                        if (data==true) {
                        swal({
                            title: "Registered Successfully!",
                            text: "",
                            icon: "success",
                            button: "Continue",
                        }).then(function(isConfirm){
                            location.reload();
                        });                    
                        }else{
                        swal({
                            title: "Failed!",
                            text: "Invalid photo format",
                            icon: "error",
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
            });

        $('#loginBtn').click(function(e) {
            var unameLogin = $('#sid').val();
            var passwordLogin = $('#passwordLogin').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Accounts/login",
                data: {sid:unameLogin,password:passwordLogin},
                success: function(data){
                    if (data!=0) {
                        swal({
                            title: "Logged In!",
                            text: "",
                            icon: "success",
                            button: "Continue",
                        }).then(function(isConfirm){
                            window.location.href = "<?php echo base_url();?>index.php/Accounts/determine_user/"+data;
                        });
                    }else if(data==0){
                        swal("Sorry!", "It seems like this account isn't active or not yet registered", "warning");
                    }
                },
                error: function(data){
                    swal("Sorry!", "Something went wrong. Contact the administrator for assistance", "error");
                }
            });
    
        });
        

        $('#signup').click(function(e) {
            $('#loginbox').hide(); 
            $('#signupbox').show();
        });

        $('#signinlink').click(function(e) {
            $('#signupbox').hide(); 
            $('#loginbox').show();
        });

        $("#submit").attr("disabled", true);

        

     });  
</script>

 <body>
    <div class="container ">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 ">                    
            <div class="panel panel-info">
                    <div class="header">
                        <div class="panel-title"><strong>DML Autolab Portal</strong></div> 
                    </div>     

                    <div style="" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" method="post" action="">

                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="span-login input-group-addon"><i class="glyph-login glyphicon glyphicon-user"></i></span>
                                        <input type="number" class="form-control" name="sid" id="sid" placeholder="ID Number">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="span-login input-group-addon"><i class="glyph-login glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control" name="passwordLogin" id="passwordLogin" placeholder="Password">
                                    </div>
                                    

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    

                                    <div class="col-sm-12 controls">
                                      <button type="button" name="login" id="loginBtn" class="btn btn-primary">Login</button>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account! 
                                        <a href="#">
                                            <p id="signup">Sign Up Here</p>
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     
                        </div>                     
                    </div>  
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="header">
                            <div class="panel-title"><strong>Sign Up</strong></div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#"><em>Sign In</em></a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                

                                  
                                <div class="form-group">
                                    <label for="id_num" class="col-md-3 control-label">ID Number</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="id_num" id="id_num" placeholder="USC ID Number">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="middlename" class="col-md-3 control-label">Middle Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="mname" id="mname" placeholder="Middle Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name">
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label for="username" class="col-md-3 control-label">User Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="uname" id="uname" placeholder="[Last name][First 3 letters of first name]">
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cpassword" class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cnum" class="col-md-3 control-label">Contact No.</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="cnum" id="cnum" placeholder="Contact Number">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cnum" class="col-md-3 control-label">Profile Picture</label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="file" id="file">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                         <button type="submit" id="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </div>
                            </form>
                         </div>
                    </div>        
         </div> 
    </div>

<script type="text/javascript">


    var filter = /^[a-zA-Z]+$/;
    var alpha = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
    var ready_id = 0;
    var ready_fname = 0;
    var ready_mname = 0;
    var ready_lname = 0;
    //var ready_uname = 0;
    var ready_password = 0;
    var ready_cpassword = 0;
    var ready_email = 0;
    var ready_cnum = 0;
    var ready_file = 0;

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $("#file").change(function(event){
        var file = $("input#file").val();
        if (file != '') {
            document.getElementById('file').style.borderColor = "green";
            ready_file = 1;
        }
    });

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

    $("#cpassword").keyup(function(event){
        var password = $("input#password").val();
        var cpassword = $("input#cpassword").val();
        if (cpassword != password) {
            document.getElementById('cpassword').style.borderColor = "red";
            ready_cpassword = 0;
        }else {
            document.getElementById('cpassword').style.borderColor = "green";
            ready_cpassword = 1;
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
        if (ready_id == 1 && ready_mname == 1 && ready_password == 1 && ready_email == 1 && ready_lname == 1 && ready_fname == 1 && ready_cpassword == 1 && ready_cnum == 1 && ready_file == 1) {
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

    $(document).change( function(event) {
    //if (event.which === 13) {
        if (ready_id == 1 && ready_mname == 1 && ready_password == 1 && ready_email == 1 && ready_lname == 1 && ready_fname == 1 && ready_cpassword == 1 && ready_cnum == 1 && ready_file == 1) {
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

 

   