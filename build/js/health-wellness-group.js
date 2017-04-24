//<![CDATA[
$(window).on('load', function() {
/*
 * Original example found here: http://www.jquerybyexample.net/2012/05/how-to-move-items-between-listbox-using.html
 * Modified by Esau Silva to support 'Move ALL items to left/right' and add better stylingon on Jan 28, 2016.
 * 
 */

(function () {
	
	
	//here i m coding to hide selected group div
	
	$(".selectedGroupData").hide();
	
//now  when user click select to all option then selectedGroupData div will hide
	$("#sendTOAll").click(function(){
		
		$(".selectedGroupData").hide();
	});
	
	$("#sendToSelected").click(function(){
		$(".selectedGroupData").show();
		
	});
	
    $('#btnRight').click(function (e) {
		//alert("hi");
        var selectedOpts = $('#lstBox1 option:selected');
		//alert(selectedOpts.val());
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
		
		 var selections = [];
		 var finalselection = [];
        $("#lstBox1 option:selected").each(function(){
            //var optionValue = $(this).val();
			var optionValue = $(this).val();
            selections.push(optionValue);
        });
		finalselection.push(selections +',');
		var textareastr = finalselection.toString();

        $('#lstBox2').append($(selectedOpts).clone());
		$('#selectedids').append(textareastr);
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllRight').click(function (e) {
        var selectedOpts = $('#lstBox1 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeft').click(function (e) {
		//alert("hi");
        var selectedOpts = $('#lstBox2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
		
		var alldata = $('#selectedids').val();
		//alert(alldata);
		var allresult = [];   
		var allresult= alldata.split(',');
		//alert(allresult[0]);
			
		//alert(selectedOpts.val());
		var selections = [];
		 var finalselection = [];
        $("#lstBox2 option:selected").each(function(){
            //var optionValue = $(this).val();
			var optionValue = $(this).val();
            selections.push(optionValue);
        });
		var finalstring = selections.toString();
		
				
		//alert(finalstring);
		var finalselection= finalstring.split(',');
		
		for (var i in finalselection)
		{
			var itemtoRemove = finalselection[i];
			allresult.splice($.inArray(itemtoRemove, allresult),1);
			//selections.push(optionValue);
			
		}
		var textareastring = allresult.toString();

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
		$('#selectedids').text('');
		$('#selectedids').append(textareastring);
        e.preventDefault();
    });

    $('#btnAllLeft').click(function (e) {
        var selectedOpts = $('#lstBox2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
}(jQuery));

});//]]> 
