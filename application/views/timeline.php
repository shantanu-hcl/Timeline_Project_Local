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
        <section id="jobDetailsDescription">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-3 timeline-margin-header">
                        <h5>Job Details</h5>
                    </div>
                </div>   
            </div>
            <div class="container ">
                <div class="row timeline-margin">
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Project Name</div>
                        <div class="col-md-12 lower-text-format"></div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Job Number</div>
                        <div class="col-md-12 lower-text-format"></div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Proposal Id</div>
                        <div class="col-md-12 lower-text-format"></div>
                    </div>
                </div>   
            </div>
            <div class="container">
                <div class="row timeline-margin">
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Account Name</div>
                        <div class="col-md-12 lower-text-format"></div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Proposal Status</div>
                        <div class="col-md-12 lower-text-format"></div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Maconomy Status</div>
                        <div class="col-md-12 lower-text-format"></div>
                    </div>
                </div>   
            </div>
            <div class="container">
                <div class="row timeline-margin">
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Project Start Date (PST)</div>
                        <div class="col-md-12 lower-text-format">
                            <div class="form-group">
                                <input id="datepicker" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Project End Date (PET)</div>
                        <div class="col-md-12 lower-text-format">
                        <div class="form-group">
                                <input id="datepicker_pet" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-md-12 upper-text-format">Project Close Date (PCT)</div>
                        <div class="col-md-12 lower-text-format">
                            <div class="form-group">
                                <input id="datepicker_pct" />
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        <section>    
        <!-- job detail div end here -->

        <div class="container">
            <div class="form-group timeline-margin">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <button type="submit" class="btn btn-primary">Save</button> 
                        <span class="reset">Reset</span>
                    </div>
                </div>
            </div>  
        </div>
    </form>

    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/jquery-3.4.1.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/bootstrap.bundle.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/bootstrap.bundle.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/custom.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#datepicker_pet').datepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#datepicker_pct').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
</body>
</html>