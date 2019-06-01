<script type="text/javascript">
    $(document).ready(function(){
   $('[data-toggle="offcanvas"]').click(function(){
       $("#navigation").toggleClass("hidden-xs");
   });
});

</script>
<?php foreach ($info as $data_info){ ?>
<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a href="<?php echo site_url('Pages/teacher_home_page'); ?>"><img src="<?php echo base_url().'assets/image/logo.png'; ?>" alt="merkery_logo" class="hidden-xs hidden-sm">
                    </a>
                </div>
                <div class="navi">
                    <ul>
                        <li class="active"><a href="<?php echo site_url('Pages/teacher_home_page'); ?>"><i class="fa fa-check-square-o"></i><span class="hidden-xs hidden-sm">Pending Orders</span></a></li>  
                        <li class="active"><a href="<?php echo site_url('Pages/approved_orders_page'); ?>"><i class="fa fa-check-square"></i><span class="hidden-xs hidden-sm">Approved Orders</span></a></li> 
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                
                <div class="row">
                    <header>
                        <div class="col-md-7">
                            <nav class="navbar-default pull-left">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                            <div class="search hidden-xs hidden-sm">
                                <div id="div_img">
                                <img id="user_image" src="<?php echo base_url().'uploads/userImage/'.$data_info->profilepic; ?>">
                                </div>
                                <h4 id="name_user"><?php echo $data_info->fname.' '.$data_info->mname.' '.$data_info->lname; ?></h4>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                    <!--<li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#add_project">Add Project</a></li>
                                    
                                    <li>
                                        <a href="#" class="icon-info">
                                            <i class="fa fa-bell" aria-hidden="true"></i>
                                            <span class="label label-primary">3</span>
                                        </a>
                                    </li>-->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i> <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <a href="<?php echo site_url('Pages/edit_account_page_student/'.$data_info->id); ?>" class="">Edit Account</a>
                                                    <div class="divider">
                                                    </div>
                                                    <a href="<?php echo site_url('Pages/logout/'); ?>" class="view btn-sm active"><i style="color:white;" class="glyphicon glyphicon-log-out"></i> Logout </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                </div>
<?php } ?>