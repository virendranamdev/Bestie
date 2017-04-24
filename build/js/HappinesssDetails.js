
$(window).load(function(){
var word_list = [
   {text: "Cheerful", weight: 15},
   {text: "Delighted", weight: 9, url: "http://jquery.com/", title: "jQuery Rocks!"},
   {text: "Glad", weight: 6},
   {text: "Joyful", weight: 7},
   {text: "Lively", weight: 5}
   // ...other words
];

//22222222222222222222222222222222222222222222222222222222222222222222
var word_list2 = [
   {text: "nice", weight: 15},
   {text: "good", weight: 9, url: "http://jquery.com/", title: "jQuery Rocks!"},
   {text: "Dipika", weight: 6},
   {text: "Soni", weight: 7},
   {text: "monika", weight: 5}
   // ...other words
];

/// 33333333333333333333333333333333333333333333333333333333333333333333
var word_list3 = [
   {text: "normal", weight: 15},
   {text: "Ordinary", weight: 9, url: "http://jquery.com/", title: "jQuery Rocks!"},
   {text: "regular", weight: 6},
   {text: "routine", weight: 7},
   {text: "monika", weight: 5}
   // ...other words
];
//4444444444444444444444444444444444444444444444444444444444444444
var word_list4 = [
   {text: "dummy text", weight: 15},
   {text: "sad text", weight: 9, url: "http://jquery.com/", title: "jQuery Rocks!"},
   {text: "adadadad adad", weight: 6},
   {text: "sdsds ds ssdf", weight: 7},
   {text: "dsa dsf", weight: 5}
   // ...other words
];

$(document).ready(function() {
   $("#wordcloud").jQCloud(word_list);
   $("#wordcloud2").jQCloud(word_list2);
   $("#wordcloud3").jQCloud(word_list3);
   $("#wordcloud4").jQCloud(word_list4);
});






});