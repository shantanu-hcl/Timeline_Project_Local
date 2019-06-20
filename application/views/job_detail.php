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
            <div class="col-md-12 lower-text-format"><?php echo $name; ?></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Job Number</div>
            <div class="col-md-12 lower-text-format"><?php echo $maconomy_job_c; ?></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Proposal Id</div>
            <div class="col-md-12 lower-text-format"> <?php echo $id; ?></div>
        </div>
    </div>   
</div>
<div class="container">
    <div class="row timeline-margin">
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Account Name</div>
            <div class="col-md-12 lower-text-format"><?php echo $accountName ?></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Proposal Status</div>
            <div class="col-md-12 lower-text-format"><?php echo $status ?></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Maconomy Status</div>
            <div class="col-md-12 lower-text-format"><?php echo $maconomyStatus ?></div>
        </div>
    </div>   
</div>
<div class="container">
    <div class="row timeline-margin">
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Project Start Date (PST)</div>
            <div class="col-md-12 lower-text-format">
                <div class="form-group">
                    <input id="datepicker" value="<?php echo $startDate; ?>" />
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Project End Date (PET)</div>
            <div class="col-md-12 lower-text-format">
            <div class="form-group">
                    <input id="datepicker_pet" value="<?php echo $estimatedCloseDate; ?>" />
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="col-md-12 upper-text-format">Project Close Date (PCT)</div>
            <div class="col-md-12 lower-text-format">
                <div class="form-group">
                    <input id="datepicker_pct" value="<?php echo $closeDate; ?>"/>
                </div>
            </div>
        </div>
    </div>   
</div>
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
<script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'YYYY-mm-dd'
        });
        $('#datepicker_pet').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'YYYY-mm-dd'
        });
        $('#datepicker_pct').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'YYYY-mm-dd'
        });
    </script>