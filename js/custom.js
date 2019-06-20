$(document).ready(function(e){
    $(document).on("click","#job_number_submit",function() {
        var job_number = $('#job_number').val();
        if(job_number==''){
            $(".alert-danger").show();
            $(".display_error").text("Please enter job number. ");
            return true;
        }else{
            jobDetailSection();
        }
    });

    $(document).on("click","#job_number_submit_mob",function() {
        var job_number = $('#job_number_mob').val();
        if(job_number==''){
            $(".alert-danger").show();
            $(".display_error_mob").text("Please enter job number. ");
            return true;
        }else{
            jobDetailSection();
        }
    });

    $(document).on("click",".close",function() {
        $(this).parent().hide();
    });

    $(document).on("click",".reset",function() {
        $("#datepicker").val('');
        $("#datepicker_pet").val('');
        $("#datepicker_pct").val('');
    });
});

function jobDetailSection(){
    $('#jobDetailsDescription').show();
}