
$(window).load(function () {
    var $fileUpload = $("#files"), $list = $('#list'), thumbsArray = [], maxUpload = 15;

// READ FILE + CREATE IMAGE
    function read(f) {
        $('#list').empty();
		$('#imagheight').text('');
		$('#imagwidth').text('');
		var selectionsheight = [];
		var selectionswidth = [];		
        return function (e) {
			
			/************ image height and width **********/
			    var img = new Image();
                img.src = e.target.result;
				img.onload = function() {
				var imageheight = this.height;
				var imagewidth = this.width;
				//alert(imagewidth);
				
				selectionsheight.push(imageheight+',');
				var textareaheightstring = selectionsheight.toString();
				$('#imagheight').append(textareaheightstring);
				//alert(textareaheightstring);
				
				selectionswidth.push(imagewidth+',');
				var textareawidthstring = selectionswidth.toString();
				$('#imagwidth').append(textareawidthstring);
				
			/***************** / image height and width ****/
            var base64 = e.target.result;
			//alert(base64);
            var $img = $('<img/>', {
                src: base64,
                title: encodeURIComponent(f.name), //( escape() is deprecated! )
                "class": "thumb"
            });

            var $thumbParent = $("<span/>", {html: $img, "class": "thumbParent"}).append('<span> \n\
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><label>Image Caption : </label><input type="text" name="imageCaption[]" class="form-control" /></div>');
				
				
            
            thumbsArray.push(base64); // Push base64 image into array or whatever.
            $list.append($thumbParent);
        };
    }
	}

// HANDLE FILE/S UPLOAD
    function handleFileSelect(e) {
        e.preventDefault(); // Needed?
		var files = e.target.files;
		var len = "";
        var len = files.length;
		//alert(thumbsArray.length);
        //if (len > maxUpload || thumbsArray.length >= maxUpload) {
			
					
			if (len > maxUpload) {
			$("#files").val("");
			$("#list").empty();
            return alert("Sorry you can upload only 15 images");	
        }
        for (var i = 0; i < len; i++) {
            var f = files[i];
			//alert(f);
			
            if (!f.type.match('image.*'))
                continue; // Only images allowed		
            var reader = new FileReader();
            reader.onload = read(f); // Call read() function
					
            reader.readAsDataURL(f);
        }
    }

    $fileUpload.change(function (e) {
        handleFileSelect(e);
    });

    $list.on('click', '.remove_thumb', function () {
        var $removeBtns = $('.remove_thumb'); // Get all of them in collection
        var idx = $removeBtns.index(this);   // Exact Index-from-collection
        $(this).closest('span.thumbParent').remove(); // Remove tumbnail parent
        thumbsArray.splice(idx, 1); // Remove from array
    });


// that's it. //////////////////////////////
// Let's test //////////////////////////////

    $('#upload').click(function () {
        var testImages = "";
        for (var i = 0; i < thumbsArray.length; i++) {
            testImages += "<div class='col-xs-6 col-sm-3 col-3 col-lg-3'><img src='" + thumbsArray[i] + "'></div>";
        }
        $('#server').empty().append(testImages);
    });
});//]]> 
