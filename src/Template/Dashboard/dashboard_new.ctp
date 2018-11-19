<?php 

?>
<div class="overlay" data-sidebar-overlay></div>

<!-- fluid container starts here -->
<div class="container-fluid container-padding-top">
    <div class="row" id="dashboard_graph">
        <div class="col-md-12 text-right">
            <?php $chart_dashboard= $this->Url->build(['controller' => 'Users', 'action' => 'manageUser']); ?>
            <a href="<?= $chart_dashboard; ?>" class="btn btn-danger btn-sm" title="Manage users"><i class="fa fa-table"></i></a>
            <!--<button type="button" class="btn btn-danger btn-sm" onclick="dashboard.toggleDashboard()"><i class="fa fa-table"></i></button>-->
        </div>
        <div class="col-xs-12 margin-top-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="padding-md bg-white">
                        <div class="row">
                            <div class="col-md-2">
                                <h5 class="text-center"><strong>Business Unit</strong></h5>
                                <div class="form-group">
                                    <select class="form-control" id="bu_unit" name="bu_unit" 
                                            onchange="getDepartment(this,'0');">
                                        <option value="All">All</option>
                                        <?php if(!empty($business_units)){
                                            foreach ($business_units as $value_business): 
                                        ?>
                                        <option value="<?= $value_business['id'] ?>" <?php
                                        if(!empty($bu_unit) && $value_business['id'] == $bu_unit)
                                            echo 'selected=selected' ?> ><?= $value_business['title'] ?>
                                        </option>
                                        <?php endforeach; } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <h5 class="text-center"><strong>Department</strong></h5>
                                <div class="form-group">
                                    <select class="form-control" id="department" name="department" 
                                            onchange="return getsubDepartment(this,'0');">
                                        <option value="All">All</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <h5 class="text-center"><strong>Sub Department</strong></h5>
                                <div class="form-group">
                                    <select class="form-control" id="sub_department" name="sub_department">
                                        <option value="All">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <h5 class="text-center"><strong>Location</strong></h5>
                                <div class="form-group">
                                    <select class="form-control" name="location" id="location">
                                        <option value="All">All</option>
                                        <?php if(!empty($location)){
                                            foreach ($location as $value){
                                        ?>
                                        <option value="<?= $value['city'] ?>" <?php
                                        if(!empty($city) && $value['city'] == $city)
                                            echo 'selected=selected' ?> ><?= $value['city'] ?></option>
                                            <?php }; } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <h5 class="text-center"><strong>Days</strong></h5>
                                <div class="form-group">
                                    <select class="form-control" name="days" id="days" onchange="getfilter();">
                                        <option value="All">All</option>
                                        <option value="7">Last 7 Days</option>
                                        <option value="30">Last 1 Month</option>
                                        <option value="90">Last 3 Months</option>
                                        <option value="180">Last 6 Months</option>
                                        <option value="365">Last 1 Year</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="padding-md bg-white">
<!--                        <div class="row">
                        <div class="col-md-6 text-center">
                                <h4 class="text-center">Onboard</h4>
                        </div>
                        </div>    -->
                        <div id="chartdiv" style="height: 500px;"></div>
                        <div style="display:none;" id="chartdiv2"></div>
                        <div>
                            <?= $this->Html->image('loading.gif',['class' => 'loader','id' =>'loader1',
                                      'style'=>'display:none']); ?>  
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="padding-md bg-white">
<!--                        <div class="row">
                            <h4 class="text-center">Confirmation</h4>
                           
                        </div>-->
                        <div id="chartConfirmation" style="height: 500px;"></div>
                        <div style="display:none;" id="chartConfirmation2"></div>
                        <div>
                            <?= $this->Html->image('loading.gif',['class' => 'loader','id' =>'loader2',
                                      'style'=>'display:none']); ?>  
                        </div>
                        </div>
                    </div>
                </div>
            <!-- new row strats here for gauge graph -->
            <div class="row">
                <div class="col-md-6">
                    <div class="padding-md bg-white">
<!--                        <div class="row">
                        <div class="col-md-6 text-center">
                                <h4 class="text-center">Logistics</h4>
                        </div>
                        </div>    -->
                       
                        <div id="chart3" style="height: 500px;" ></div>
                        <!--<div style="display:none;" id="chartdiv2"></div>-->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="padding-md bg-white">
                        <div class="row">
                            <h4 class="text-center"></h4>
                           
                        </div>
                      
                        </div>
                </div>
            </div>
            <!-- new row ends here -->
            </div>
        </div>
    </div>
</div>

<?php //echo $this->Html->script(['jquery-1.12.4', 'bootstrap.min', 'sidebar','jquery-ui','customchartquery']); ?>
<?php echo $this->Html->script(['jquery-1.12.4', 'bootstrap.min','fusion/fusioncharts','fusion/jquery-fusioncharts','fusion/fusioncharts.theme.fusion','fusion/customchartquery']); ?>
<script>
//code for fetching department based on selected business unit
function getDepartment(val,num){
   var bu_unit = val.value;
    $.ajax({
        url: '<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'getdepartments']) ?>',
        type: 'POST',
        data: {"business_unit_id": bu_unit},
        success: function(data){
            if(num === '0'){
                $('#department').html(data);
            }
            if(num === '1'){
                $('#department_1').html(data);
            }
        }
    });
}

//code for fetching subdepartment based on selected department
function getsubDepartment(sel,idnum){
    var dept = sel.value;
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'getSubDepartments']) ?>',
            type: 'POST',
            data: {"department_id": dept},
            success: function(data){
                if(idnum === '0'){
                    $('#sub_department').html(data);
                }
                if(idnum === '1'){
                    $('#sub_department_1').html(data);
                }
            }
        });
}
</script>
<script>
    var onboard = <?= $onBoard ?>;
    var inactive = <?= $inActive ?>;
    var active = <?= $active ?>;
    var confirmed = <?= $confirmed ?>;
    var rejected = <?= $rejected ?>;
    var monthNames = <?= $monthNames ?>;
$("#chartdiv").insertFusionCharts({
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
            "exportEnabled": "1",
            "legendPosition": "top",
            "yAxisMinValue": "0",
            "theme": "fusion"
        },
        "data": onboard
    }
});  


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
                "xaxisname": "Month",
                "showLegend": "1",
                "exportEnabled": "1",
                "plottooltext": "<b>$dataValue</b>  $seriesName",
                "theme": "fusion"
            },
            "categories": [
                    {
                       "category": monthNames
                    }
                   ],
            "dataset": [
                    {
                        "seriesname": "InActive",
                        "data": inactive
                    },
                    {
                        "seriesname": "Active",
                        "data": active
                    },
                    {
                        "seriesname": "Confirmed",
                        "data": confirmed
                    },
                    {
                        "seriesname": "Rejected",
                        "data": rejected
                    }
            ]
        }
});

$("#chart3").insertFusionCharts({
   type: "pie3d",
   width: "100%",
   height: "80%",
   dataFormat: "json",
   dataSource: {
  "chart": {
    "caption": "Logistics",
    "showvalues": "1",
    "showpercentintooltip": "0",
    "enablemultislicing": "1",
    "exportEnabled": "1",
    "theme": "fusion"
  },
  "data": [
    {
      "label": "In-Progress",
      "value": "<?= $pending ?>",
      "color": "#f15a6d"
    },
    {
      "label": "Received",
      "value": "<?= $received ?>",
      "color": "#0eb890"
    },
    {
      "label": "Pending",
      "value": "<?= $pending ?>",
      "color": "#ff9900"
    }
  ]
}
});
</script>
<style>
/*    .amcharts-chart-div a {display:none !important;}
   
*/    
/*#chartdiv,#chartConfirmation {
	width	: 100%;
	height	: 400px;
}*/
#chartdiv2,#chartConfirmation2 {
        width   : 100%;
        height	: 500px;
}
/*
#chart3 {
  width: 100%;
  height: 300px;
  margin: auto;
}
.loader {
   height:400px;
}*/
</style><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

