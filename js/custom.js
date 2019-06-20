$(document).ready(function(e){
    $(document).on("click","#job_number_submit",function() {
        var job_number = $('#job_number').val();
        var site_url = $('#site_url').val();
        site_url = site_url+'job_detail';
        if(job_number==''){
            $(".alert-danger").show();
            $(".display_error").text("Please enter job number. ");
            return true;
        }else{

            jobDetailSection(job_number,site_url);
        }
    });

    $(document).on("click","#job_number_submit_mob",function() {
        var job_number = $('#job_number_mob').val();
        var site_url = $('#site_url').val();
        site_url = site_url+'job_detail';
        if(job_number==''){
            $(".alert-danger").show();
            $(".display_error_mob").text("Please enter job number. ");
            return true;
        }else{
            jobDetailSection(job_number,site_url);
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

function jobDetailSection(job_number,jobdetail_url){
    $.ajax({
        type: "post",
        url: jobdetail_url,
        cache: false,               
        data: {
            "job_number":job_number
        },
        success: function(data){                        
        try{        
            $('#jobDetailsDescription').html(data);
            $('#jobDetailsDescription').show();
        }catch(e) {     
            alert('Exception while request..');
        }       
        },
        error: function(){                      
            alert('Error while request..');
        }
    });
    
}

function makeAjaxCall(ajax_url){
    $.ajax({
        type: "post",
        url: ajax_url,
        cache: false,               
        data: $('#userForm').serialize(),
        success: function(json){                        
        try{        
            var obj = jQuery.parseJSON(json);
            alert( obj['STATUS']);


        }catch(e) {     
            alert('Exception while request..');
        }       
        },
        error: function(){                      
            alert('Error while request..');
        }
 });
}