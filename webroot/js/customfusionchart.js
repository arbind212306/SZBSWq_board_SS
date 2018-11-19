function getfilter(){
    $('#chartdiv').remove();
//    $('#chartConfirmation').remove();
    $('#loader1').show();
//    $('#loader2').show();
    var business_unit = $('#bu_unit').val();
    var department = $('#department').val();
    var sub_department = $('#sub_department').val();
    var location = $('#location').val();
    var days = $('#days').val();
    //ajax call to method getFilterDashboardData for getting data for first graph i.e., onboard garph
    $.ajax({
        url: webroot + 'dashboard/get-filter-dashbordData',
        type: 'POST',
        dataType: 'JSON',
        data: {"business_unit":business_unit, "department":department, "sub_department":sub_department,
    "location":location, "days":days},

        success: function(data){
            //script for displaying onboard graph
            $("#chartdiv2").insertFusionCharts({
                type: "line",
                width: "100%",
                height: "100%",
                dataFormat: "json",
                dataSource: {
               "chart": {
                 "caption": "Onboard",
                 "yaxisname": "Number of onboard",
                 "showLegend": "1",
                 "legendPosition": "top",
                 "setadaptiveymin": "1",
                 "theme": "fusion"
               },
               "data": data
             }
             });
            $('#chartdiv2').show(); 
            $('#loader1').hide();
        }
    });
    
    getConfirmation(business_unit,department,sub_department,location,days);
}

function getConfirmation(business_unit,department,sub_department,location,days){
    $.ajax({
        url: webroot + 'dashboard/get-filter-confirmation',
        type: 'POST',
        dataType: 'JSON',
        data: {"business_unit":business_unit, "department":department, "sub_department":sub_department,
    "location":location, "days":days},

        success: function(response){
            console.log(response);
            return false;
            $("#chartConfirmation").insertFusionCharts({
                type: "msline",
                width: "100%",
                height: "100%",
                dataFormat: "json",
                dataSource: {
               "chart": {
                 "caption": "Confirmation",
                 "yaxisname": "Number of values(Active/confirmed/Rejected/Inactive)",
                 "yAxisMinValue": "0",
                 "showhovereffect": "1",
                 "drawcrossline": "1",
                 "legendPosition": "top",
                 "showLegend": "1",
                 "plottooltext": "<b>$dataValue</b>  $seriesName",
                 "theme": "fusion"
               },
               "categories": [
                 {
                   "category": label
                 }
               ],
               "dataset": [
                 {
                   "seriesname": "Active",
                   "data": active
                 },
                 {
                   "seriesname": "Confirmed",
                   "data": confirmed,
                   "color": "#006400"
                 },
                 {
                   "seriesname": "Rejected",
                   "data": rejected
                 },
                 {
                   "seriesname": "Inactive",
                   "data": inactive
                 }
               ]
             }
             });
        }
    });
}