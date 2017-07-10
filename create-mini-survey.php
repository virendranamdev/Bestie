<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>

<?php
$clientId = $_SESSION['client_id'];
require_once('Class_Library/class_MiniSurvey.php');
$surveyObj = new MiniSurvey();
$data1 = $surveyObj->getSurveyQuestionOption($clientId);
$data = json_decode($data1,true);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
$optcount = count($data['data']);
//echo "thisis option count".$optcount;
?>
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create New Mini-Survey</h2>
                         <?php   
    
      date_default_timezone_set('Asia/Calcutta');
          //$post_date = date("Y-m-d");
      $countsurvey = $surveyObj->checkSurveyAvailablity($clientId,$post_date);
     // print_r($countsurvey);
    $value1 = json_decode($countsurvey,true);
    if($value1['success'] == 1)
    {
        echo '<h5 style="Color:red; float:right;"> One Survey is already Live. Please close this before creating the New Survey.</h5>';
    }
   
?>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" ng-app="myApp" ng-controller="myCtrl">

                        <form class="form" action="Link_Library/link_createSurvey.php" method="post" class="myform form-horizontal form-label-left" onsubmit="return check();">

                            <!--  Question Container:- {{questionContent}}-->
                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Survey Title</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Enter Survey Title..." name = "surveytitle" required/>
                                    <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Valid From </label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="date" name="validfrom" id="validfrom" class="form-control has-feedback-left" placeholder="Survey Start Date" required/>
                                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Valid Till</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="date" name="validtill" id="validtill" class="form-control has-feedback-left"placeholder="Survey End Date" required/>
                                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Questions</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" name="questionno"  ng-model="noOfquestions" ng-change="questionsNumber(noOfquestions)" class="form-control has-feedback-left" placeholder="Enter Number of Questions..." required/>
                                    <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                     <div ng-if="noOfquestions>5    " style="color:red;"> No of question can not be more than 5</div>
                                </div>
                            </div>

                            <hr style="width:100%">
                           
                            <div ng-if="noOfquestions<=5" ng-repeat="quesDiv in questionContent">
                            <!--Question {{$index+1}}:<input type="text" ng-model="question" ng-keyup="passQuestionText($index,question)"/>-->

                                <div class="form-group">
                                    <label class=" control-label col-md-3 col-sm-3 col-xs-12">Question {{$index + 1}}</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                       <input type="text" name="surveyquestion{{$index}}"  ng-model="question" ng-keyup="passQuestionText($index, question)" class="form-control has-feedback-left"placeholder="Write Your Question{{$index}}..." required/>
                                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>


                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class=" control-label col-md-3 col-sm-3 col-xs-12">Answer Type</label>
                                     <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                         <input type="hidden" name="optioncount" value="<?php echo $optcount;?>">   
                                    <?php 
                                    for($i=0;$i<$optcount;$i++)
                                    {
                                        $radioname = $data['data'][$i]['optionTypeName'];
                                        $optionvalue = $data['data'][$i]['optionValue'];
                                         $optiontype = $data['data'][$i]['optionTypeId'];
                                     echo '<input type="hidden" name="optiontypeid{{$index}}'.$i.'" value="'.$optiontype.'">';
                                        echo '<label class="radio-inline"><input type="radio" name="radio{{$index}}'.$i.'" ng-model="passValue" value="'.$optionvalue.'" ng-click="clickMe($index, question, passValue)">'.$radioname.'</label>&nbsp;&nbsp;&nbsp;';
                                    }
                                    ?>
                                  
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <div  ng-if="quesDiv.questionType == 'option'">
                                                        <div class="row">
                                                            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                                                <input type="text" name="numberoption{{$index}}" ng-model="noOfoptions" ng-keyup="optionContentData($index, noOfoptions)"class="form-control has-feedback-left"placeholder="Enter Number of option..." required/>
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <div ng-repeat="options in quesDiv.ansNumber" ng-if="quesDiv.ansNumber != 0">
                                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                     <input type="text" name="radiooption{{$parent.$parent.$index}}{{$index+1}}" ng-model="optionAnsData" ng-keyup="forwardData($parent.$parent.$index, $index, optionAnsData)"class="form-control has-feedback-left"placeholder="option {{$index + 1}}..." required/><br>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!--<div>
                                <input type="radio" name="{{$index}}" ng-model="passValue" value="option" ng-click="clickMe($index,question,passValue)"/>Options
                                <input type="radio" name="{{$index}}" ng-model="passValue" value="mouji" ng-click="clickMe($index,question,passValue)"/>Mouji
                                <input type="radio" name="{{$index}}" ng-model="passValue" value="text" ng-click="clickMe($index,question,passValue)"/>Text
                                </div>-->
                                <!--
                                <div  ng-if="quesDiv.questionType=='option'">
                                
                                <input type="text" ng-model="noOfoptions" ng-keyup="optionContentData($index, noOfoptions) "/>
                                <br><br>
                                <div ng-repeat="options in quesDiv.ansNumber" ng-if="quesDiv.ansNumber!=0"> <input type="text" ng-model="optionAnsData" ng-keyup="forwardData($parent.$parent.$index,$index,optionAnsData)"/><br>
                                </div>
                                </div>-->
                                <hr style="width:100%">
                            </div>
                           
                            <div class="form-group" ng-if="noOfquestions > 0">
                                <div class="col-md-12"><center>
                                 <input type="submit" name="submitbutton" class="btn btn-round btn-primary" value ="Submit">
                                  <input type="reset" name="resetbutton" class="btn btn-round btn-warning" value ="Cancel">
                                    
                                    </center></div>
                            </div>

                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script src="js/angular/mini-surveyfinal.js"></script>

<!--------------------- these script for custom date picker -------------------------------------------->
<script type="text/javascript">
    var datefield = document.createElement("input")
    datefield.setAttribute("type", "date")
    if (datefield.type != "date") { //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n')
    }
</script>

<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#validfrom').datepicker();
        })
    }
</script>
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#validtill').datepicker();
        })
    }
</script>

<!--------------------- these script for custom date picker -------------------------------------------->

<?php include 'footer.php'; ?>
       
