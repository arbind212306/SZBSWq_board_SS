$(document).ready(function () {
    //console.log("inside manageuser.js");
    $('.logistic_user_arrangements').click(function () {
        var key = $(this).attr('data-key');
        showFeedbackData(key);
        showFeedbackDataForUser(key);
		showFeedbackDataForBHR(key);
		updateFeedbackDataForBHR(key);
		
    });
    $(document).on('click', '.info-sec', function () {
        var rel = $(this).attr('data-rel');
        $("#interval_feedback_outer").addClass("hidden");
        $('#detail-sec-' + rel).removeClass("hidden");
    });
    $(document).on('click', '.info-sec-emp', function () {
        var rel = $(this).attr('data-rel');
        $("#interval_feedback_outer").addClass("hidden");
        $('#detail-sec-' + rel).removeClass("hidden");
    });
    $(document).on('click', '.goback-feedback', function () {
        var rel = $(this).attr('data-rel');
        $("#interval_feedback_outer").removeClass("hidden");
        $('#detail-sec-' + rel).addClass("hidden");
    });
});



function showFeedbackData(key) {
    //console.log("inside showFeedbackData function");
    $('#f-info-sec').html('');
    $('#f-details-sec').html('');
    $.ajax({
        url: webroot + 'users/getFeedbackData/' + key

    }).done(function (data) {
        data = $.parseJSON(data);
        $('#f-info-sec,#f-details-sec').html('');
        $(data).each(function (i, u) {
            $('#f-info-sec').append(u.info);
            $('#f-details-sec').append(u.details);
        });
        $('#interval_feedback_outer').removeClass('hidden');
    });
}

function showFeedbackDataForUser(key) {
    //console.log("inside showFeedbackDataForUser function");
    $('#f-info-sec-emp').html('');
    $('#f-details-sec-emp').html('');
    $.ajax({
        url: webroot + 'users/getFeedbackDataForUser/' + key

    }).done(function (data) {
        data = $.parseJSON(data);
        $('#f-info-sec-emp,#f-details-sec-emp').html('');
        $(data).each(function (i, u) {
            $('#f-info-sec-emp').append(u.info);
            $('#f-details-sec-emp').append(u.details);
        });
        //$('#interval_feedback_outer').removeClass('hidden');
    });
}


function showFeedbackDataForBHR(key) {
    //console.log("inside showFeedbackDataForUser function");
    $('#bhr_title').html('');
    $('#f-details-sec-emp').html('');
    $.ajax({
        url: webroot + 'users/getFeedbackDataForBhr/' + key

    }).done(function (data) {
	
		data = $.parseJSON(data);
        $('#bhr_title,#f-details-sec-emp').html('');
        $(data).each(function (i, u) {
         var title=  $('#bhr_title').append(u.bhr_title);
			 $('#bemp_name').html(u.username);
			  $('#bemp_id').html(u.emp_id);
			   $('#bemp_doj').html(u.doj);
			    $('#feedback_title').html(u.feedback_title);
				 $('#feedback_id').val(u.feedback_id);
				  $('#buserid').val(key);
				 
				 
				
        });
			
    });
}
function updateFeedbackDataForBHR(key){
    
	$("div.bu_name_es_ap select").val('');
	$('#description').val('');
       
	
	$.ajax({
		 url: webroot + 'users/updateFeedbackDataForBHR/' + key
				
	}).done(function(data){
           
		data=$.parseJSON(data);
               
		$(data).each(function(i, u){
                if(u.feedback_status == ''){ internalfeedback();}
                console.log('feedback_status '+u.feedback_status);
                $("div.bu_name_es_ap select").val(u.feedback_status);
		
		$('#description').val(u.description);
                $('#fid').val(u.fid);

 var extenddate = new Date(u.extended_date);
  var doj = extenddate.toLocaleDateString();
                  $('#extended_date').val(doj);
              console.log(doj);
		});
	});
        
	
}



