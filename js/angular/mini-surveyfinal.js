
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope) {

$scope.questionContent = [];
$scope.optionContent = [];
$scope.optionArray = [];

$scope.questionsNumber = function(a)
{
if(a!="")
{
for(var i=0;i<a;i++)
{ 
var dataQuestions = {
"questionId":i,
"question":"",
"questionType":"",
"nubmerOfOptions":"",
"ansNumber":""
};
$scope.questionContent.push(dataQuestions);
}
}
else
{ $scope.questionContent = [];$scope.optionArray = [];}
}

$scope.clickMe = function(ind,q,val)
{

if(val=="option")
{
var arraySize = $scope.optionArray.indexOf(ind);
if(arraySize==-1)
{
$scope.optionArray.push(ind);
}
}
else
{
var arraySize = $scope.optionArray.indexOf(ind);
if(arraySize!=-1)
{
$scope.optionArray.splice(arraySize, 1);
}
}

for(var i=0;i<$scope.questionContent.length;i++)
{
if($scope.questionContent[i].questionId==ind)
{
$scope.questionContent[i].question = q;
$scope.questionContent[i].questionType = val;
$scope.questionContent[i].ansNumber = "";
$scope.questionContent[i].nubmerOfOptions = "";
}
}

}

$scope.optionContentData = function(parentInd,a)
{

$scope.optionContents = [];
if(a!="")
{
for(var i=0;i<a;i++)
{
var optionData = {"optionId":i,"optionName":""}
$scope.optionContents.push(optionData);}

for(var i=0;i<$scope.questionContent.length;i++)
{

if($scope.questionContent[i].questionId==parentInd)
{
$scope.questionContent[i].nubmerOfOptions = a;
}

for(var j=0;j<$scope.optionArray.length;j++)
{
if(($scope.questionContent[i].questionId==$scope.optionArray[j])&&($scope.questionContent[i].questionId==parentInd))
{
$scope.questionContent[i].ansNumber = $scope.optionContents;
}
}

}
}
else
{
//$scope.optionContent= [];
for(var i=0;i<$scope.questionContent.length;i++)
{

if($scope.questionContent[i].questionId==parentInd)
{
$scope.questionContent[i].nubmerOfOptions = a;
}

for(var j=0;j<$scope.optionArray.length;j++)
{
if(($scope.questionContent[i].questionId==$scope.optionArray[j])&&($scope.questionContent[i].questionId==parentInd))
{
$scope.questionContent[i].ansNumber = "";
}
}

}
}

$scope.forwardData = function(parentInd,optionid,passVal)
{
for(var i=0;i<$scope.questionContent.length;i++)
{
if($scope.questionContent[i].questionId==parentInd)
{
$scope.questionContent[i].nubmerOfOptions = a;
for(var j=0;j<$scope.questionContent[i].ansNumber.length;j++)
{
if($scope.questionContent[i].ansNumber[j].optionId==optionid)
{ $scope.questionContent[i].ansNumber[j].optionName=passVal}
}
}
}
}
}

$scope.passQuestionText = function(questionid,ques)
{
for(var i=0;i<$scope.questionContent.length;i++)
{
if($scope.questionContent[i].questionId==questionid)
{$scope.questionContent[i].question = ques;}
}
}

});