function getfilter(){
    $('#chartdiv').remove();
    $('#chartConfirmation').remove();
    $('#loader1').show();
    $('#loader2').show();
    var business_unit = $('#bu_unit').val();
    var department = $('#department').val();
    var sub_department = $('#sub_department').val();
    var location = $('#location').val();
    var days = $('#days').val();
    $.ajax({
        url: webroot + 'dashboard/get-filter-OnBoardData',
        type: 'POST',
        dataType: 'JSON',
        data: {"business_unit":business_unit, "department":department, "sub_department":sub_department,
    "location":location, "days":days},
        
        success: function(response){
            console.log(response);
            $("#chartdiv2").insertFusionCharts({
                   type: "line",
                   width: "100%",
                   height: "100%",
                   dataFormat: "json",
                   dataSource: {
                  "chart": {
                    "caption": "Onboard",
                    "yaxisname": "Number of onboard",
                    "xaxisname": "Month",
                    "showLegend": "1",
                    "legendPosition": "top",
                    "exportEnabled": "1",
                    "yAxisMinValue": "0",
                    "theme": "fusion"
                  },
                  "data": response
                }
            });
            $('#loader1').hide();
            $('#chartdiv2').show();
        }
    });
    
    getConfirmation(business_unit,department,sub_department,location,days);
}


function getConfirmation(business_unit,department,sub_department,location,days){
    $.ajax({
        url: webroot + 'dashboard/get-filter-OnConfirmation',
        type: 'POST',
//        dataType: 'JSON',
        data: {"business_unit":business_unit, "department":department, "sub_department":sub_department,
    "location":location, "days":days},
        
        success: function(data){
            var da = JSON.parse(data);
//            console.log(da);
            var l = da[0];
            var i = da[1]
            var a = da[2];
            var c = da[3];
            var r = da[4];
//            var labeldata = JSON.stringify(l);
//            var inactive = JSON.stringify(i);
//            var active = JSON.stringify(a);
//            var confirmed = JSON.stringify(c);
//            var rejected = JSON.stringify(r);
//            console.log(labeldata);
//            console.log(inactive);
//             console.log(active);
//              console.log(confirmed);
//               console.log(rejected);
               
            $("#chartConfirmation2").insertFusionCharts({
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
                      "xaxisname": "Month",
                     "showLegend": "1",
                     "exportEnabled": "1",
                     "plottooltext": "<b>$dataValue</b>  $seriesName",
                     "theme": "fusion"
                   },
                   "categories": [
                       {
                        "category": l
                       }
                   ],
                   "dataset": [
                        {
                          "seriesname": "InActive",
                          "data": i
                        },
                        {
                          "seriesname": "Active",
                          "data": a
                        },
                        {
                          "seriesname": "Confirmed",
                          "data": c
                      },
                        {
                          "seriesname": "Rejected",
                          "data": r
                        }
                      ]
                }
            });
            $('#loader2').hide();
            $('#chartConfirmation2').show();
        }
    });         
}