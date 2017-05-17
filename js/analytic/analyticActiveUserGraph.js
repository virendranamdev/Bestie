function analyticActiveUserGraph(startdate,enddate,location, SITE)
{

//alert(startdate);
//alert(enddate);
//alert("this is department"+department);
//alert(SITE);
//die;
    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
	        "location": location
            }
    var dataString = JSON.stringify(postData);
   // alert(dataString);
//console.log(datastring);
    $.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_analyticActiveUser.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
         //   alert(resdata);
			
          console.log(resdata);   

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
            ActiveUserGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/

/********************************** draw chart radio button options function ********************************************************/
function ActiveUserGraph(resdata) {
     //  alert(resdata);
console.log(resdata);
    var categorydata = resdata.categories;
     var data1 = resdata.data;
   
    //   console.log(JSON.stringify(resdata.categories));
     console.log(categorydata);
     console.log(data1);
   

  Highcharts.chart('ActiveUserContainer', {
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
          tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: {point.y:,.0f}',
        split: true
    },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
                name: 'Active Users',
              //  data: [3.9] //, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                 data: data1 //data1
            }]
    });
}

 
 