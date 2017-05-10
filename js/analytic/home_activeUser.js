function showActiveUserGraph(startdate,enddate, department , SITE)
{

//alert(startdate);
//alert(enddate);
//alert(department);
//alert(SITE);
//die;
    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
				"department": department
            }
    var dataString = JSON.stringify(postData);
    //alert(dataString);

    $.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_getActiveUser.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
            //alert(resdata);
			
          //  console.log(resdata);   

            var jsonData = JSON.parse(resdata);
                                              //alert(jsonData);
											  
       //   console.log("this is parsed data-" + jsonData);
            /* var jsonData = JSON.parse(resdata)["data"];
             
             alert(jsonData);
             if (jsonData.length > 0)
             {
             surveyGraph(resdata);
             }  
             else
             {
             alert("No Record Found");
             }*/
            homeActiveUserGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/

/********************************** draw chart radio button options function ********************************************************/
function homeActiveUserGraph(resdata) {
     //  alert(resdata);
//console.log(resdata);
    var categorydata = resdata.categories;
     var data1 = resdata.data;
    //   console.log(JSON.stringify(resdata.categories));
    // console.log(categorydata);
    // console.log(data1);

    Highcharts.chart('container', {
        chart: {
            type: 'line'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
          //  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
             categories:categorydata  
        },
        yAxis: {
            title: {
                text: 'Users'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
                name: 'Active Users',
              //  data: [3.9] //, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                 data: data1 //data1
            }]
    });
}


/****************************happiness index grapg**********************************/

function showHappinessIndexGraph(startdate, enddate, department , SITE)
{

    var postData =
            {
                "startdate":startdate ,
                "enddate": enddate , 
				"department": department
            }
    var dataString = JSON.stringify(postData);
    //alert(dataString);

    $.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_getHappinessgraph.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
            //alert(resdata);
           // console.log(resdata);   

            var jsonData = JSON.parse(resdata);
                                            
            /* var jsonData = JSON.parse(resdata)["data"];
             
             alert(jsonData);
             if (jsonData.length > 0)
             {
             surveyGraph(resdata);
             }  
             else
             {
             alert("No Record Found");
             }*/
            homeHappinessindexGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/

/********************************** draw chart radio button options function ********************************************************/
function homeHappinessindexGraph(resdata) {
     //  alert(resdata);
//console.log(resdata);
  
     var data1 = resdata.data;
  //     console.log(JSON.stringify(resdata.categories));
   //  console.log(categorydata);
     console.log(data1);

    Highcharts.chart('container2', {
                                chart: {
                                    type: 'pie',
                                    options3d: {
                                        enabled: true,
                                        alpha: 45,
                                        beta: 0
                                    }
                                },
                                title: {
                                    text: 'Last Expired Happiness Index'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        depth: 35,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.name}'
                                        }
                                    }
                                },
                                series: [{
                                        type: 'pie',
                                        name: 'percentage',
                                        data: data1
//                                        data: [{
//                                                        "name": 'Very Good',
//                                                        "y": 56.33
//                                                    }, {
//                                                        "name": 'Good',
//                                                        "y": 24.03,
//                                                       // sliced: true,
//                                                       // selected: true
//                                                    }, {
//                                                        "name": 'Normal',
//                                                        "y": 10.38
//                                                    }, {
//                                                        "name": 'Sad',
//                                                        "y": 4.77
//                                                    }]
                                    }]
                            });
}


/**************************************************************/



