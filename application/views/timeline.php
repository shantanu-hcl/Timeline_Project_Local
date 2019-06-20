<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.min.css">
<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.grid.css">
<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/custom.css">
<link rel="stylesheet" type = "text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
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
                    <input type="text" class="form-control" id="job_number">
                </div>
                <div class="col-md-1 col-sm-3 webApp">
                    <button type="submit" class="btn btn-primary" id="job_number_submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-5 col-sm-3 webApp">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close">&times;</button>
                        <span class="display_error"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mobile">
                    <input type="job_number" class="form-control" id="job_number_mob" placeholder="Job number">
                </div>
                <div class="col-3 mobile">
                    <button type="button" class="btn btn-primary" id="job_number_submit_mob"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                <div class="col-12 mobile">
                    <div class="alert alert-danger alert-dismissible timeline-margin-header">
                        <button type="button" class="close">&times;</button>
                        <span class="display_error_mob"></span>
                    </div>
                </div>    
            </div>
        </div>    
    </div>
    <!-- search div end here -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-3 bottomline"></div>
        </div>   
    </div>
    
    <!-- job detail div start here -->
    <?php echo form_open('update_timeline'); ?>
        <input type="hidden" id="site_url" value="<?php echo base_url(); ?>"/>
        <section id="jobDetailsDescription"><section>    
        <!-- job detail div end here -->

        
    </form>

    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/jquery-3.4.1.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/bootstrap.bundle.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/bootstrap.bundle.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/custom.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    
</body>
</html>