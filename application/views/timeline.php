<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title> 
<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.min.css?<?php echo rand(); ?>">
<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/custom.css?<?php echo rand(); ?>">
<link rel="stylesheet" type = "text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css?<?php echo rand(); ?>">
<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.min.css?<?php echo rand(); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.mobile-1.4.5.min.css?<?php echo rand(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- search div start -->
    <div class="container">
        <div class="form-group timeline-margin">
            <div class="row">
                <div class="col-md-2 col-sm-3 timeline-center-h webApp">
                    <label for="job_number_tile">Job Number:</label>
                </div>
                <div class="col-md-4 col-sm-3 webApp">
                    <input type="text" class="form-control stopEvent" max="9" id="job_number">
                </div>
                <div class="col-md-1 col-sm-3 webApp">
                    <button type="submit" class="btn btn-primary" id="job_number_submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-2 col-sm-3 webApp">
                    <div class="loader"></div>
                </div>
                <div class="col-md-3 col-sm-3 webApp">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close">&times;</button>
                        <span class="display_error"></span>
                    </div>
                    <?php if($this->session->flashdata('msg')){?>
                    <div class="alert alert-success">
                        <button type="button" class="close">&times;</button>
                        <?php echo $this->session->flashdata('msg')?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-xs-9 mobile">
                        <input type="job_number" max="9" class="form-control stopEvent" id="job_number_mob" placeholder="Job number">
                    </div>
                    <div class="col-xs-3 mobile">
                        <button type="button" class="btn btn-primary" id="job_number_submit_mob"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 mobile">
                    <div class="row">
                        <div class="col-xs-11 mobile">
                            <div class="alert alert-danger alert-dismissible timeline-margin-header">
                                <button type="button" class="close">&times;</button>
                                <span class="display_error_mob"></span>
                            </div>
                            <?php if($this->session->flashdata('msg')){?>
                            <div class="alert alert-success">
                                <button type="button" class="close">&times;</button>
                                <?php echo $this->session->flashdata('msg')?>
                            </div>
                            <?php } ?>
                        </div>    
                    </div>
                </div> 
            </div>
        </div>    
    </div>
    <!-- search div end here -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 bottomline"></div>
        </div>   
    </div>

    <!-- job detail div start here -->
    <?php echo validation_errors(); ?>
    
    <?php $attributes = array('id' => 'myform'); echo form_open('update_timeline',$attributes); ?>
        <input type="hidden" id="site_url" value="<?php echo base_url(); ?>"/>
        <section id="jobDetailsDescription">
           <?php $this->load->view('job_detail'); ?>
        </section>    
        <!-- job detail div end here -->
     </form>
    <button class="customVisibility show-page-loading-msg" data-theme="b" data-textonly="false" data-textvisible="true" data-msgtext="Please wait..." data-inline="true">B</button>
    <button class="customVisibility hide-page-loading-msg" data-inline="true" data-icon="delete">Hide</button>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/jquery-3.4.1.min.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/custom.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery.mobile-1.4.5.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
        $('.datePick').datetimepicker({
            format: 'yyyy-mm-dd',
            pickTime: false,
            maxView: 4,
            minView: 2,
            autoclose: true
        });
        $(document).on("click",".reset",function() {
            $(".datePick").val('');
        });
    });
    
    </script>
</body>
</html>