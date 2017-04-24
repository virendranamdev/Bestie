/*************************** survey analytic graph ******************************/
function showRadioGraph(quid, sid)
{
  var postData =
            {
                "questionid": quid,
                "surveyid": sid
            }
    var dataString = JSON.stringify(postData);
    // alert(dataString);
    jQuery.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: "surveyQuestionRadioResult.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
//            alert(resdata);
//            console.log(resdata);   
            
             var jsonData = JSON.parse(resdata);
//             
//             alert(jsonData);
             console.log("this is parsed data-"+jsonData);   
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
  //   alert(resdata);
   
     var categorydata = resdata.data;
 //   console.log(JSON.stringify(resdata.question));
   
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
                 data:categorydata
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
function showEmojiGraph(quid, sid)
{
  
    var postData =
            {
                "questionid": quid,
                "surveyid": sid
            }
    var dataString = JSON.stringify(postData);
    // alert(dataString);
    jQuery.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: "surveyQuestionEmojiResult.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
          //  alert(resdata);
      //    console.log(resdata);   
            var jsonData = JSON.parse(resdata);
             
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
                 data:categorydata
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