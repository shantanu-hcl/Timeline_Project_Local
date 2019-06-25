$(document).ready(function(e){
    $(document).on("click","#job_number_submit",function() {
        var job_number = $('#job_number').val();
        var site_url = $('#site_url').val();
        site_url = site_url+'job_detail';
        if(job_number==''){
            $(".alert-danger").show();
            $(".display_error").text("Please enter job number. ");
            return false;
        }else{
            var mobile_device = 0;
            jobDetailSection(job_number,site_url,mobile_device);
        }
    });

    $(document).on("click","#job_number_submit_mob",function() {
        var job_number = $('#job_number_mob').val();
        var site_url = $('#site_url').val();
        site_url = site_url+'job_detail';
        if(job_number==''){
            $(".alert-danger").show();
            $(".display_error_mob").text("Please enter job number. ");
            return false;
        }else{
            var mobile_device = 1;
            $(".show-page-loading-msg").trigger("click");
            jobDetailSection(job_number,site_url,mobile_device);
        }
    });
    
    $('.stopEvent').keyup(function(event) {
        var textlen = $(this).val().length;
        if(textlen < 10){
           event.stopPropagation();
        }
    });
    
    $('.stopEvent').on('keyup', function() {
        limitText(this, 9)
    });

    $(document).on("click",".close",function() {
        $(this).parent().hide();
    });

    
    
    $(".stopEvent").on("keypress keyup blur",function (event) {    
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    
    $( document ).on( "click", ".show-page-loading-msg", function() {
        var $this = $( this ),
            theme = $this.jqmData( "theme" ) || $.mobile.loader.prototype.options.theme,
            msgText = $this.jqmData( "msgtext" ) || $.mobile.loader.prototype.options.text,
            textVisible = $this.jqmData( "textvisible" ) || $.mobile.loader.prototype.options.textVisible,
            textonly = !!$this.jqmData( "textonly" );
            html = $this.jqmData( "html" ) || "";
        $.mobile.loading( "show", {
                text: msgText,
                textVisible: textVisible,
                theme: theme,
                textonly: textonly,
                html: html
        });
    }).on( "click", ".hide-page-loading-msg", function() {
        $.mobile.loading( "hide" );
    });
    
    //$('#myform').on('submit', function () {
//    $( document ).on( "click", ".datePick", function() {
//        $(this).parent().removeClass("custom-border-color");
//        
//    });
    
    $( document ).on( "change", ".datePick", function() {
        $(this).parent().removeClass("custom-border-color");
        if((new Date($(this).val()) <= new Date($("#pst-date").val())) && $(this).attr("id")!="pst-date")
        {
            $(this).val("");
            $(".alert-danger").show();
            $(".display_error").text("Date always greater then project start date");
            $(this).parent().addClass("custom-border-color");
        }
    });
    
    $( document ).on( "click", ".formSubmit", function() {
        var isMobile=$(".display_error");
        var isMobileFlag=false;
        if($(this).hasClass("mobile")){
            isMobile = $(".display_error_mob");
            isMobileFlag = true;
        }
        if($('#pst-date').val() == ""){
            $(".alert-danger").show();
            isMobile.text("Enter project start date. ");
            $('#pst-date').parent().addClass("custom-border-color");
            return false;
        }else if($('#pet-date').val() == ""){
            $(".alert-danger").show();
            isMobile.text("Enter project estimate date. ");
            $('#pet-date').parent().addClass("custom-border-color");
            return false;
        }else if($('#pct-date').val() == ""){
            $(".alert-danger").show();
            isMobile.text("Enter project closed date. ");
            $('#pct-date').parent().addClass("custom-border-color");
            return false;
        }else {
            if(isMobileFlag){
                $(".show-page-loading-msg").trigger("click");
            }else{
                $(".loader").show();
            }
            return true;
        }
    });
});

function jobDetailSection(job_number,jobdetail_url,mobile_device){
   
    $(".loader").show();
    $.ajax({
        type: "post",
        url: jobdetail_url,
        dataType:'json',
        cache: false,               
        data: {
            "job_number":job_number
        },
        success: function(res){                        
            try{
                var projectStatus = [
                    "Commissioning",
                    "Closing Re Commissioning",
                    "Pending Re Commissioning",
                    "Closed Invoiced",
                    "Cancelled Invoiced",
                    "Cancelled Expired",
                    "Pending Cancellation",
                    "Closed Invoice Finalized"
                ];
                var data = jQuery.parseJSON(res);
                if(data.status === "Fail"){
                    $(".alert-danger").show();
                    if(mobile_device){
                        $(".display_error_mob").text(data.msg);
                    }else{
                        $(".display_error").text(data.msg);
                    }
                    $(".loader").hide();
                    $('#jobDetailsDescription').hide();
                }else{
                    if(jQuery.inArray(data.status, projectStatus) !== -1) {
                        $(".datePick").attr("disabled", true);
                    }else{
                        $(".datePick").attr("disabled", false);
                    }
                    $("#proposal_id").val(data.id);
                    $("#maconomyNo").val(data.maconomy_job_c);
                    $("#project_name").text(data.name);
                    $("#jobNumber").text(data.maconomy_job_c);
                    $("#proposalNo").text(data.proposalNO);
                    $("#accountName").text(data.accountName);
                    $("#status").text(data.status);
                    $("#maconomyStatus").text(data.maconomyStatus);
                    $("#pst-date").val(data.startDate);
                    $("#pet-date").val(data.closeDate);
                    $("#pct-date").val(data.estimatedCloseDate);
                    $("#lastmodify").val(data.date_modified);
                    $('#jobDetailsDescription').show();
                    $(".loader").hide();
                    if(mobile_device){  
                        $(".hide-page-loading-msg").trigger("click");
                    }
                }
            }catch(e) {     
                console.log('Exception while request..');
            }       
        },
        error: function(){                      
            console.log('Error while request..');
        }
    });
    
}

function limitText(field, maxChar){
    var ref = $(field),
        val = ref.val();
    if ( val.length >= maxChar ){
        ref.val(function() {
            return val.substr(0, maxChar);       
        });
    }
}