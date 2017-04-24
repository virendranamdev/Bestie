var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope) {

$scope.arrayVal = [];

$scope.callValue = function(a)
{

if(a!=null){
for(var i=0;i<a;i++)
{
$scope.arrayVal.push(i);
}
}
else
{
$scope.arrayVal=[];
}


if((a==1)||(a>4)){alert("Please enter more than 1 and less than 4 option ");
$scope.arrayVal=[];}

}


//by default all option will be hide
 $scope.radioBtnDIV=false; $scope.emojiBtnDIV=false; $scope.commentBtnDIV=false;


$scope.radioBtn1=function(){

$scope.radioBtnDIV=true; $scope.emojiBtnDIV=false; $scope.commentBtnDIV=false;




//alert('this is radio button function calling');



}

$scope.emojiBtn2=function(){
 $scope.radioBtnDIV=false; $scope.emojiBtnDIV=true; $scope.commentBtnDIV=false;

//alert('this is emojiBtn button function calling');
}

$scope.commentBtn3=function(){

 $scope.radioBtnDIV=false; $scope.emojiBtnDIV=false; $scope.commentBtnDIV=true;
//alert('this is commentBtn button function calling');
}


//**************************************************************Adding new question*********************************************
//**************************************************************Adding new question*********************************************
//**************************************************************Adding new question*********************************************


$scope.QuestionAdd=function(){
alert("hello");
var myEl = angular.element( document.querySelector( '#DynamicQuestionDiv' ) );
myEl.prepend('<input type="text" class="form-control" >');     

}


});