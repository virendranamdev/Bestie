var count = 1;
var allCities = [];
var selectedItems = [];
var allTextIds = [];
var selectedTextIds = [];


$(document).ready(function(){
    //alert("fafsadregr gg ehrehre");
    
    var url = window.location.href;
    var server_url = url.substring(0, url.lastIndexOf("/") + 1);
    var device1 = 'd2';
    var uid = $("#userid").val();
    var client = $("#clientid").val(); 
   /* $.ajax({
        type: 'POST',
        url: server_url + '/Class_Library/api_getgroup.php',
        data: {
            userid: uid,
            clientid: client,
            device: device1,
        },
        dataType: 'jsonp',
        jsonp: 'callback',
       // jsonpCallback: 'locationCall',
        success: function () {
        }
    });*/
	jQuery.ajax({
            type: "POST",
            url: server_url + '/Class_Library/api_getgroup.php',
            data:  {
            userid: uid,
            clientid: client,
            device: device1,
			},
            success: function (response) {
                var resdata = response;
				var jsonData = JSON.parse(response);
				//alert(jsonData.posts.length);
				var options = '';
				if(jsonData.posts.length > 0)
				{
				 for (i = 0; i < jsonData.posts.length; i++)
				{
				options += '<option value="'+ jsonData.posts[i].groupId +'">'+ jsonData.posts[i].groupName +'</option>';
				
				allCities.push(jsonData.posts[i].groupName);
				allTextIds.push(jsonData.posts[i].groupId);
				
				}
				//alert(jsonData.posts[0].groupId);
				//alert(jsonData.posts[0].groupName);
				 $('#lstBox1').append(options);	
				 addArrayToDiv(allTextIds, "allids", allCities, "#allitems");
					//alert(allTextIds);
					//alert(allCities);
				}
            },
            error: function (e) {
                alert(e);
                console.log(e.message);
            }
        });

});



function  removeItemAndRePopulateDiv(value, theIdValue, theDiv) {
    var primaryArray = [];
    var secondryArray = [];

    var primaryTextIds = [];
    var secondryTextIds = [];

    var primaryDiv;
    var secondryDiv;

    var primaryid;
    var secondryid;

    if (theDiv == "#allitems") {
        primaryTextIds = "allids";
        secondryTextIds = "selectedids";

        primaryTextArray = allTextIds;
        secondryTextArray = selectedTextIds;

        primaryDiv = "#allitems";
        secondryDiv = "#selecteditems";

        primaryArray = allCities;
        secondryArray = selectedItems;
    }


    else

    {

        primaryTextIds = "selectedids";
        secondryTextIds = "allids";
        primaryTextArray = selectedTextIds;
        secondryTextArray = allTextIds;

        primaryDiv = "#selecteditems";
        secondryDiv = "#allitems";
        primaryArray = selectedItems;
        secondryArray = allCities;
    }
    secondryArray.push(value);
    secondryTextArray.push(theIdValue);

    var index = primaryArray.indexOf(value);
    var index2 = primaryTextArray.indexOf(theIdValue);

    if (index > -1) {

        primaryArray.splice(index, 1);



    }

    if (index2 > -1) {

        primaryTextArray.splice(index, 1);



    }

    addArrayToDiv(primaryTextArray, primaryTextIds, primaryArray, primaryDiv);

    addArrayToDiv(secondryTextArray, secondryTextIds, secondryArray, secondryDiv);



}


function addArrayToDiv(theIdsArray, theId, theArray, theDiv)
{
    $(theDiv).html("");
    $("textarea#" + theId).val("");


    var ids = "";

    for (i = 0; i < theArray.length; i++)
    {
        if (theDiv == "#allitems")
        {
            $(theDiv).append('<div class="col-xs-12 col-md-12"style="margin-left:10px;">' + ' <a href="#selecteditems1" style="text-decoration:none;" onclick="return removeItemAndRePopulateDiv(\'' + theArray[i] + '\',\'' + theIdsArray[i] + '\',\'' + theDiv + '\')"> <p style="margin:12px 8px 7px;border-bottom:1px dotted gray;">' + theArray[i] + ' </p></a></div><br>');
            ids = ids + theIdsArray[i] + ",";

        }
        else
        {
            $(theDiv).append('<div class="col-xs-12 col-md-12"style="margin-left:10px;">' + '<p id="group" style="margin:0px 8px 7px;border-bottom:1px dotted gray;"> ' + theArray[i] + ' <a href="#allitems" style="text-decoration:none;float:right;" onclick="return removeItemAndRePopulateDiv(\'' + theArray[i] + '\',\'' + theIdsArray[i] + '\',\'' + theDiv + '\')">X</a> ' + '</p>' + '</div>');

            ids = ids + theIdsArray[i] + ",";
        }
        $("textarea#" + theId).val(ids);





    }
    return theArray;
}

function locationCall(data) {
	
    if (count == 1)
    {
        var mesg = JSON.stringify(data);
		//alert(mesg);
        var jsonData = JSON.parse(mesg);
		//alert(jsonData.posts);
        var alltext = "";
        for (i = 0; i < jsonData.posts.length; i++)
        {
            allCities.push(jsonData.posts[i].groupName);
            allTextIds.push(jsonData.posts[i].groupId);

        }
		//alert(allTextIds);
		//alert(allCities);

        addArrayToDiv(allTextIds, "allids", allCities, "#allitems");

        count++;
    }

}
