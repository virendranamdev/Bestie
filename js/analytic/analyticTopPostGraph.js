function showAnalyticTopPost(startdate,enddate,dept,loc, SITE)
{

    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
                "department": dept,
                "location":loc
            }
    var dataString = JSON.stringify(postData);
    //    alert(dataString);

    $.ajax({
        type: "post",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_getTopPostAnalytic.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
         // alert(resdata);
          //  console.log(resdata);   


          document.getElementById("toppostcontainer").innerHTML = resdata;


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