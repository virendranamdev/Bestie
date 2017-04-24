$(document).ready(function(){
            $("#RadioDIV").show();
	    $("#EmojiDIV").hide();
	    $("#TextDIV").hide();

		
    $('#radioBtn1').click(function(){
      // alert('Radio option visible only');
	    $("#RadioDIV ").show();
	    $("#EmojiDIV ").hide();
	    $("#TextDIV ").hide();
		
   });
   
    $('#emojiBtn2').click(function(){
      // alert('emoji option visible only');
	   
	    $("#EmojiDIV ").show();
	    $("#RadioDIV ").hide();
	    $("#TextDIV ").hide();
   });
 $('#commentBtn3').click(function(){
     //  alert('Radio option visible only');
	   
	    $("#TextDIV ").show();
	    $("#RadioDIV ").hide();
	    $("#EmojiDIV ").hide();
   });
   
});