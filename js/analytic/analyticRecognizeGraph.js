function showRecognizeUserGraph(startdate,enddate,dept, SITE)
{

    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
                  "department": dept
            }
    var dataString = JSON.stringify(postData);
  //alert(dataString);

    $.ajax({
        type: "post",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_RecognizeAnalyitc.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
          //alert(resdata);
           // console.log(resdata);   

          var jsonData = JSON.parse(resdata);
//                                              alert(jsonData);
//          console.log("this is parsed data-" + jsonData);
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
            recognizeUserGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/

/********************************** draw chart radio button options function ********************************************************/
function recognizeUserGraph(resdata) {
    //   alert(resdata);
//console.log(resdata);
    var categorydata = resdata.categories;
     var data1 = resdata.data;
    //   console.log(JSON.stringify(resdata.categories));
    // console.log(categorydata);
    // console.log(data1);

    Highcharts.chart('RecognitionContainer', {
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
            //categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
             categories:categorydata  
        },
        yAxis: {
            title: {
                text: 'Number Of Recognition'
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
                name: 'Users',
               // data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                 data: data1 //data1
            }]
    });
}

/******************************** get top sender ********************************************/

function showRecognizeTopSenderGraph(startdate,enddate,dept, SITE)
{

    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
                  "department": dept
            }
    var dataString = JSON.stringify(postData);
  //alert(dataString);

    $.ajax({
        type: "post",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_getTopSenderRecognition.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
         // alert(resdata);
           // console.log(resdata);   


          document.getElementById("dynamicdatatopsender").innerHTML = resdata;


        //  var jsonData = JSON.parse(resdata);
//                                              alert(jsonData);
//          console.log("this is parsed data-" + jsonData);
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
          //  recognizeUserGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/
function showRecognizeTopReceiverGraph(startdate,enddate,dept, SITE)
{

    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
                  "department": dept
            }
    var dataString = JSON.stringify(postData);
  //alert(dataString);

    $.ajax({
        type: "post",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_getTopReceiverRecognition.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
         // alert(resdata);
            //console.log(resdata);   


          document.getElementById("dynamicdatatopreceiver").innerHTML = resdata;


        //  var jsonData = JSON.parse(resdata);
//                                              alert(jsonData);
//          console.log("this is parsed data-" + jsonData);
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
          //  recognizeUserGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}

function showRecognizeTopBadgesGraph(startdate,enddate,dept, SITE)
{

    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
                  "department": dept
            }
    var dataString = JSON.stringify(postData);
  //alert(dataString);

    $.ajax({
        type: "post",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_getTopBadgesRecognition.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
        //  alert(resdata);
         //   console.log(resdata);   


          document.getElementById("dynamicdatatopbadges").innerHTML = resdata;


        //  var jsonData = JSON.parse(resdata);
//                                              alert(jsonData);
//          console.log("this is parsed data-" + jsonData);
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
          //  recognizeUserGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}