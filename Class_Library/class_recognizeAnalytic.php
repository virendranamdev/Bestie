<?php

if (!class_exists("Connection_Communication")) {
    include_once('class_connect_db_Communication.php');
}

class RecognizeAnalytic {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $idclient;

    /*     * ********************************** FUNCTION FOR API *********************************** */

    function getRecognizedUser($client, $fromdt, $enddte, $department) {

        try {
            if ($department == '') {
                $query = "SELECT count(recognitionTo) as totalview,DATE_FORMAT(dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails where (DATE(dateOfEntry) BETWEEN :fromdte AND :enddte) AND clientId = :client group by DATE_FORMAT(dateOfEntry,'%Y-%m-%d')";
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                
            } else {
                $query = "SELECT count(tre.recognitionTo) as totalview,DATE_FORMAT(tre.dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails as tre join Tbl_EmployeeDetails_Master as tem on tre.recognitionTo = tem.employeeId where (DATE(tre.dateOfEntry) BETWEEN :fromdte AND :enddte) AND tre.clientId = :client and tem.department = :dept group by DATE_FORMAT(tre.dateOfEntry,'%Y-%m-%d')";
                
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            $stmt->bindParam(':dept', $department, PDO::PARAM_STR);

            }
           
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response["categories"] = [];
            $response["data"] = [];
            foreach ($row as $res) {
                //  $response["categories"] = $res['date_of_entry'];
                //   $response["data"] = $res['totalview'];
                array_push($response["categories"], $res['dateOfEntry']);
                array_push($response["data"], $res['totalview']);
            }
            //   print_r($response);
            return json_encode($response, JSON_NUMERIC_CHECK);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    
     function getRecognizedTopSender($client, $fromdt, $enddte, $department) {

         $siteurl = SITE_URL;
        try {
            if ($department == '') {
                
                 $query = "SELECT count(tre.recognitionBy) as totalsender,CONCAt_WS(' ',tem.firstName,tem.middleName,tem.lastName) as username,((count(tre.recognitionBy) / total.totaluser) * 100)as percentage,total.totaluser,if(tep.userImage IS NULL or tep.userImage = '','',CONCAT('".$siteurl."',tep.userImage)) as userImage, DATE_FORMAT(tre.dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails as tre join Tbl_EmployeeDetails_Master as tem on tre.recognitionBy = tem.employeeId join Tbl_EmployeePersonalDetails as tep on tep.employeeId = tre.recognitionBy CROSS
  JOIN (SELECT COUNT(recognitionBy) AS totaluser FROM Tbl_RecognizedEmployeeDetails where (DATE(dateOfEntry) BETWEEN :fromdte AND :enddte)) as total where (DATE(tre.dateOfEntry) BETWEEN :fromdte AND :enddte) AND tre.clientId = :client group by recognitionBy order by count(tre.recognitionBy) desc";
                 
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                
            } else {
                $query = "SELECT count(tre.recognitionBy) as totalsender,CONCAt_WS(' ',tem.firstName,tem.middleName,tem.lastName) as username,((count(tre.recognitionBy) / total.totaluser) * 100)as percentage,total.totaluser,if(tep.userImage IS NULL or tep.userImage = '','',CONCAT('".$siteurl."',tep.userImage)) as userImage,DATE_FORMAT(tre.dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails as tre join Tbl_EmployeeDetails_Master as tem on tre.recognitionBy = tem.employeeId join Tbl_EmployeePersonalDetails as tep on tep.employeeId = tre.recognitionBy CROSS
  JOIN (SELECT COUNT(recognitionBy) AS totaluser FROM Tbl_RecognizedEmployeeDetails where (DATE(dateOfEntry) BETWEEN :fromdte AND :enddte)) as total where (DATE(tre.dateOfEntry) BETWEEN :fromdte AND :enddte) AND tre.clientId = :client and tem.department = :dept group by recognitionBy order by count(tre.recognitionBy) desc";
                
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            $stmt->bindParam(':dept', $department, PDO::PARAM_STR);

            }
           
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
        } catch (PDOException $e) {
            echo $e;
        }
          return json_encode($row, JSON_NUMERIC_CHECK);
    }
    
    /***************************************************/
    
    function getRecognizedTopReceiver($client, $fromdt, $enddte, $department) {

         $siteurl = SITE_URL;
        try {
            if ($department == '') {
                
                 $query = "SELECT count(tre.recognitionTo) as totalreceiver,CONCAt_WS(' ',tem.firstName,tem.middleName,tem.lastName) as username,((count(tre.recognitionTo) / total.totaluser) * 100)as percentage,total.totaluser,if(tep.userImage IS NULL or tep.userImage = '','',CONCAT('".$siteurl."',tep.userImage)) as userImage, DATE_FORMAT(tre.dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails as tre join Tbl_EmployeeDetails_Master as tem on tre.recognitionTo = tem.employeeId join Tbl_EmployeePersonalDetails as tep on tep.employeeId = tre.recognitionTo CROSS
  JOIN (SELECT COUNT(recognitionTo) AS totaluser FROM Tbl_RecognizedEmployeeDetails where (DATE(dateOfEntry) BETWEEN :fromdte AND :enddte)) as total where (DATE(tre.dateOfEntry) BETWEEN :fromdte AND :enddte) AND tre.clientId = :client group by recognitionTo order by count(tre.recognitionTo) desc";
                 
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                
            } else {
                $query = "SELECT count(tre.recognitionTo) as totalreceiver,CONCAt_WS(' ',tem.firstName,tem.middleName,tem.lastName) as username,((count(tre.recognitionTo) / total.totaluser) * 100)as percentage,total.totaluser,if(tep.userImage IS NULL or tep.userImage = '','',CONCAT('".$siteurl."',tep.userImage)) as userImage,DATE_FORMAT(tre.dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails as tre join Tbl_EmployeeDetails_Master as tem on tre.recognitionTo = tem.employeeId join Tbl_EmployeePersonalDetails as tep on tep.employeeId = tre.recognitionTo CROSS
  JOIN (SELECT COUNT(recognitionTo) AS totaluser FROM Tbl_RecognizedEmployeeDetails where (DATE(dateOfEntry) BETWEEN :fromdte AND :enddte)) as total where (DATE(tre.dateOfEntry) BETWEEN :fromdte AND :enddte) AND tre.clientId = :client and tem.department = :dept group by recognitionTo order by count(tre.recognitionTo) desc";
                
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            $stmt->bindParam(':dept', $department, PDO::PARAM_STR);

            }
           
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
        } catch (PDOException $e) {
            echo $e;
        }
          return json_encode($row, JSON_NUMERIC_CHECK);
    }
    
    
    /***************************************** get top badges ********************************/
    
     function getRecognizedTopBades($client, $fromdt, $enddte, $department) {

         $siteurl = SITE_URL;
        try {
            if ($department == '') {
                
                 $query = "SELECT count(tre.topic) as totalbadges,tem.recognizeTitle as badgename,((count(tre.topic) / total.totalbadge) * 100) as percentage,total.totalbadge,if(tem.image IS NULL or tem.image = '','',CONCAT('".$siteurl."',tem.image)) as badgeImage, DATE_FORMAT(tre.dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails as tre join Tbl_RecognizeTopicDetails as tem on tre.topic = tem.topicId CROSS
  JOIN (SELECT COUNT(topic) AS totalbadge FROM Tbl_RecognizedEmployeeDetails where (DATE(dateOfEntry) BETWEEN :fromdte AND :enddte)) as total where (DATE(tre.dateOfEntry) BETWEEN :fromdte AND :enddte) AND tre.clientId = :client group by topic order by count(tre.topic) desc";
                 
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                
            } else {
                $query = "SELECT count(tre.topic) as totalbadges,tem.recognizeTitle as badgename,((count(tre.topic) / total.totalbadge) * 100) as percentage,total.totalbadge,if(tem.image IS NULL or tem.image = '','',CONCAT('".$siteurl."',tem.image)) as badgeImage,DATE_FORMAT(tre.dateOfEntry,'%d/%m/%Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails as tre join Tbl_RecognizeTopicDetails as tem on tre.topic = tem.topicId join Tbl_EmployeeDetails_Master as tep on tep.employeeId = tre.recognitionTo CROSS
  JOIN (SELECT COUNT(topic) AS totalbadge FROM Tbl_RecognizedEmployeeDetails where (DATE(dateOfEntry) BETWEEN :fromdte AND :enddte)) as total where (DATE(tre.dateOfEntry) BETWEEN :fromdte AND :enddte) AND tre.clientId = :client and tep.department = :dept group by topic order by count(tre.topic) desc";
                
                 $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            $stmt->bindParam(':dept', $department, PDO::PARAM_STR);

            }
           
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e;
        }
          return json_encode($row, JSON_NUMERIC_CHECK);
    }
}
