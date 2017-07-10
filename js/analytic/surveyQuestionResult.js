/*************************** survey analytic graph ******************************/
function showRadioGraph(quid, sid, department, location,SITE)
{
    var postData =
            {
                "questionid": quid,
                "surveyid": sid,
                "department": department,
                "location": location
            }
     // console.log(postData);
    var dataString = JSON.stringify(postData);
    //  console.log(dataString);
  //    alert(dataString);

    jQuery.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE+"surveyQuestionRadioResult.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
           //     alert(resdata);
            console.log(resdata);

            var jsonData = JSON.parse(resdata);

            document.getElementById("respondent").innerHTML = "Respondent : " + JSON.stringify(jsonData.respondent.respondent);
              console.log(jsonData.comment);  
            var commentdata = jsonData.comment;
          
            console.log(commentdata);
            var clength = commentdata.length;
              console.log(clength);
            /************************************************************/
            if (clength > 0)
            {

                $('#datatable tbody').remove();
                for (var i = 0; i < clength; i++)
                {
                   
                    var newRow = '<tbody><tr><td>' + commentdata[i].answeredDate + '</td><td>' + commentdata[i].firstName + ' '+commentdata[i].lastName + '</td><td>' + commentdata[i].answer + '</td></tr><tbody>';
                    $('#datatable').append(newRow);

                }

            }   
            else    
            {
                 $('#datatable tbody').remove();
                var newRow = '<tbody><tr><td colspan = 3>No Record Available</td></tr><tbody>';
                $('#datatable').append(newRow);
            }

            /***************************************************************/

            surveyRadioGraph(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/

/********************************** draw chart radio button options function ********************************************************/
function surveyRadioGraph(resdata) {
   //    alert(resdata);

    var categorydata = resdata.data;
    console.log(resdata.respondent);

    Highcharts.chart('MiniSurveyQuestion', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: JSON.stringify(resdata.question.question)
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
                name: 'Response',
                colorByPoint: true,
                data: categorydata
//                data: [{
//                        "name": 'Very Good',
//                        "y": 56.33
//                    }, {
//                        "name": 'Good',
//                        "y": 24.03,
//                       // sliced: true,
//                       // selected: true
//                    }, {
//                        "name": 'Normal',
//                        "y": 10.38
//                    }, {
//                        "name": 'Sad',
//                        "y": 4.77
//                    }]
            }]
    });
}
/************************************** end draw chart of options function **************************************/
/*
 * 
 * 
 * 
 * /*************************** survey analytic  for emoji graph ************************************/
function showEmojiGraph(quid, sid, department, location)
{

    var postData =
            {
                "questionid": quid,
                "surveyid": sid,
                "department": department,
                "location": location
            }
  //  console.log(postData);
    var dataString = JSON.stringify(postData);
  //  alert(dataString);
    jQuery.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: "surveyQuestionEmojiResult.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
             // alert(resdata);
            console.log(resdata);
            var jsonData = JSON.parse(resdata);
            document.getElementById("respondent").innerHTML = "Respondent : " + JSON.stringify(jsonData.respondent.respondent);
              console.log(jsonData.comment);  
            var commentdata = jsonData.comment;
         
            console.log(commentdata);
            var clength = commentdata.length;
              console.log(clength);
//              /************************************************************/
            if (clength > 0)
            {

                $('#datatable tbody').remove();
                for (var i = 0; i < clength; i++)
                {
                   
                    var newRow = '<tbody><tr><td>' + commentdata[i].answeredDate + '</td><td>' + commentdata[i].firstName + ' '+commentdata[i].lastName + '</td><td>' + commentdata[i].answer + '</td></tr><tbody>';
                    $('#datatable').append(newRow);

                }

            }   
            else    
            {
                 $('#datatable tbody').remove();
                var newRow = '<tbody><tr><td colspan = 3>No Record Available</td></tr><tbody>';
                $('#datatable').append(newRow);
            }

            /***************************************************************/
            surveyGraphEmoji(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/

/********************************** draw chart radio button options function ********************************************************/
function surveyGraphEmoji(resdata) {
    //   alert(resdata);

    var categorydata = resdata.data;
    // console.log(JSON.stringify(resdata.question));

    Highcharts.chart('MiniSurveyEmoji', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: JSON.stringify(resdata.question.question)
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
                name: 'Response',
                colorByPoint: true,
                data: categorydata
//                data: [{
//                        "name": 'Very Good',
//                        "y": 56.33
//                    }, {
//                        "name": 'Good',
//                        "y": 24.03,
//                       // sliced: true,
//                       // selected: true
//                    }, {
//                        "name": 'Normal',
//                        "y": 10.38
//                    }, {
//                        "name": 'Sad',
//                        "y": 4.77
//                    }]
            }]
    });
}
/************************************** end draw chart of emoji function **************************************/
/*
 * 
 * 
 * 
 * /*************************** survey analytic  for world graph ************************************/

function showWordGraph(quid, sid)
{
    var postData =
            {
                "questionid": quid,
                "surveyid": sid
            }

    var resdata = [];

    var dataString = JSON.stringify(postData);
    //   alert(dataString);
    jQuery.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: "surveyQuestionWordResult.php",
        data: {"mydata": dataString},
        success: function (response) {
            resdata = response;
            //    alert(resdata);
            console.log(resdata);
//            var jsonData = JSON.parse(resdata);
//             
            //      alert(jsonData);
            //      console.log("this is parsed data-"+jsonData);   
//             if (jsonData.length > 0)
//             {
//             surveyGraph(resdata);
//             }  
//             else
//             {
//             alert("No Record Found");
//             }
            surveyWordGraph(resdata);
            // dummygraph();
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}

/******************************************************/

function surveyWordGraph(resdata)
{
    //  alert(resdata);
    //  console.log(resdata);
    //   window.onload = function () {
    // First define your cloud data, using `text` and `size` properties:
    var textGlobe = resdata;
    // just copy twice for extra data, else the cloud is a little boring

    var skillsToDraw = JSON.parse(textGlobe);
    console.log(skillsToDraw);
    // Next you need to use the layout script to calculate the placement, rotation and size of each word:

    var width = 400;
    var height = 300;
    var fill = d3.scale.category20();

    d3.layout.cloud()
            .size([width, height])
            .words(skillsToDraw)
            .rotate(function () {
                //this is for rotation of text
                return ~~(Math.random() * 2) * 10;
            })
            .font("Impact")
            .fontSize(function (d) {
                return d.size;
            })
            .on("end", drawSkillCloud)
            .start();

    // Finally implement `drawSkillCloud`, which performs the D3 drawing:

    // apply D3.js drawing API
    function drawSkillCloud(words) {
        d3.select("#cloud").append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", "translate(" + ~~(width / 2) + "," + ~~(height / 2) + ")")
                .selectAll("text")
                .data(words)
                .enter().append("text")
                .style("font-size", function (d) {
                    return d.size + "px";
                })
                .style("-webkit-touch-callout", "none")
                .style("-webkit-user-select", "none")
                .style("-khtml-user-select", "none")
                .style("-moz-user-select", "none")
                .style("-ms-user-select", "none")
                .style("user-select", "none")
                .style("cursor", "default")
                .style("font-family", "Impact")
                .style("fill", function (d, i) {
                    return fill(i);
                })
                .attr("text-anchor", "middle")
                .attr("transform", function (d) {
                    return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                })
                .text(function (d) {
                    return d.text;
                });
    }

    // set the viewbox to content bounding box (zooming in on the content, effectively trimming whitespace)

    var svg = document.getElementsByTagName("svg")[0];
    var bbox = svg.getBBox();
    var viewBox = [bbox.x, bbox.y, bbox.width, bbox.height].join(" ");
    svg.setAttribute("viewBox", viewBox);


}


  /*************************** survey analytic  for rating graph ************************************/
function showRatingGraph(quid1, sid1, department1, location1)
{

    var postData =
            {
                "questionid": quid1,
                "surveyid": sid1,
                "department": department1,
                "location": location1
            }
 // console.log(postData);
    var dataString = JSON.stringify(postData);
  //  alert(dataString);
   
    jQuery.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: "surveyQuestionRatingResult.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
            //  alert(resdata);
            console.log(resdata);
            var jsonData = JSON.parse(resdata);
            document.getElementById("respondent").innerHTML = "Respondent : " + JSON.stringify(jsonData.respondent.respondent);
             document.getElementById("average").innerHTML = "Average : " + jsonData.average;
             document.getElementById("mode").innerHTML = "Mode : " + jsonData.mode;
            
            // console.log(jsonData.comment);  
            var commentdata = jsonData.comment;
         
          //  console.log(commentdata);
            var clength = commentdata.length;
           //   console.log(clength);
//              /************************************************************/
            if (clength > 0)
            {

                $('#datatable tbody').remove();
                for (var i = 0; i < clength; i++)
                {
                   
                    var newRow = '<tbody><tr><td>' + commentdata[i].answeredDate + '</td><td>' + commentdata[i].firstName + ' '+commentdata[i].lastName + '</td><td>' + commentdata[i].answer + '</td></tr><tbody>';
                    $('#datatable').append(newRow);

                }

            }   
            else    
            {
                 $('#datatable tbody').remove();
                var newRow = '<tbody><tr><td colspan = 3>No Record Available</td></tr><tbody>';
                $('#datatable').append(newRow);
            }

            /***************************************************************/
            surveyGraphRating(jsonData);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
///*********************************************** end login analytic graph **********************************/

/********************************** draw chart radio button options function ********************************************************/
function surveyGraphRating(resdata) {
    //   alert(resdata);
 // console.log(resdata);
  var categorydata = resdata.category;
    
   //  console.log(categorydata); 
  //  console.log(resdata.data3);
   // console.log(categorydata.data1);
    
    /***************************/
    
    Highcharts.chart('MiniSurveyRating', {
    chart: {
        type: 'column'
    },
    title: {
        text: JSON.stringify(resdata.question.question)
    },
    subtitle: {
        text: ''
    },
    xAxis: {
      //  categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul', 'Aug', 'Sep','Oct','Nov','Dec'],
        categories: categorydata,
        crosshair: true
    },
    yAxis: {
        min: 0,
        allowDecimals: false,
        title: {
            text: 'No. of Respondent'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:12px">{series.name}:{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">No. of respondent: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Rating',
       // data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
         data: resdata.data3

    }]
});
    
}
/************************************** end draw chart of emoji function **************************************/
