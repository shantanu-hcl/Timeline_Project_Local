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
        <form action="">
            <div class="form-group timeline-margin">
                <div class="row">
                    <div class="col-md-2 col-sm-3 timeline-center-h">
                        <label for="job_number_tile">Job Number:</label>
                    </div>
                    <div class="col-md-4 col-sm-3">
                        <input type="job_number" class="form-control" id="job_number">
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>    
        </form>
    </div>
    <!-- search div end here -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-3 bottomline"></div>
        </div>   
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-3 timeline-margin">
                <h5>Job Details</h5>
            </div>
        </div>   
    </div>
    <!-- job detail div start here -->
    <div class="container">
        <div class="row timeline-margin">
            <div class="col-md-4 col-sm-12">
                <div class="col-md-12 upper-text-format">Project Name</div>
                <div class="col-md-12 lower-text-format">Demo project</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="col-md-12 upper-text-format">Job Number</div>
                <div class="col-md-12 lower-text-format">123456</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="col-md-12 upper-text-format">Proposal Id</div>
                <div class="col-md-12 lower-text-format">123456</div>
            </div>
        </div>   
    </div>
    <div class="container">
        <div class="row timeline-margin">
            <div class="col-md-4 col-sm-12">
                <div class="col-md-12 upper-text-format">Account Name</div>
                <div class="col-md-12 lower-text-format">Demo project</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="col-md-12 upper-text-format">Proposal Status</div>
                <div class="col-md-12 lower-text-format">Client Accepted</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="col-md-12 upper-text-format">Maconomy Status</div>
                <div class="col-md-12 lower-text-format">Success</div>
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
    <!-- job detail div end here -->

    <div class="container">
        <div class="form-group timeline-margin">
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <button type="submit" class="btn btn-primary">Save</button> 
                    <span class="reset">Reset</span>
                </div>
            </div>
        </div>  
    </div>

    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/jquery-3.4.1.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/bootstrap.bundle.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url(); ?>js/bootstrap.bundle.min.js"></script>
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