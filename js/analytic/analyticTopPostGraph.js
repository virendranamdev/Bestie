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
    //  alert(dataString);

    $.ajax({
        type: "post",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: SITE +"Link_Library/link_getTopPostAnalytic.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response;
      //   alert(resdata);
            console.log(resdata);   


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




/**************************** analytic list view *******************************/

function showListViewAnalytic(startdate,enddate,dept,loc, SITE)
{
    var postData =
            {
                "startdate":startdate,
                "enddate": enddate,
                "department": dept,
                "location":loc
            }
    var dataString = JSON.stringify(postData);
     //alert(dataString);
	 
    $.ajax({
        type: "post",
        url: SITE +"Link_Library/link_getTopPostlistAnalytic.php",
        data: {"mydata": dataString},
        success: function (response) {
        var resdata = response;
//		alert(resdata);
//                console.log(resdata);
		var jsonData = JSON.parse(resdata);
		//alert(jsonData.length);
		if (jsonData.length !== 0)
                {
					//alert('hi');
                     $('#mytable tbody').remove();
					 for (var i = 0; i < jsonData.length; i++) 
					 {
						var newRow = '<tbody><tr><td>' + jsonData[i].moduleName + '</td><td>' + jsonData[i].totalview + '</td><td>' + jsonData[i].uniqueview + '</td></tr><tbody>';
					$('#mytable').append(newRow);

					 }
					 
					}
		else
		{
			 $('#mytable tbody').remove();
			 var newRow = '<tbody><tr><td></td><td> No Record Found </td><td></td></tr><tbody>';
					$('#mytable').append(newRow);
			 
			
		}
        
		
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}

/**************************** / analytic list view *****************************/