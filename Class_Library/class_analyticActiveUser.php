<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

class ActiveUserAnalytic {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    /*     * ********************* analytic get active user Details ******************************* */

    function graphAnalyticActiveUser($client, $fromdt, $enddte , $department) {
        try {
	   
//            SELECT count(userUniqueId) as totalview,count(distinct(userUniqueId)) as uniqueview,DATE_FORMAT(date_of_entry,'%d/%m/%Y') as date_of_entry FROM Tbl_Analytic_TrackUser where (DATE(date_of_entry) BETWEEN :fromdte AND :enddte) AND clientId = :client and description = 'Open Spalsh' group by DATE_FORMAT(date_of_entry,'%Y-%m-%d')"
            
		   if($department == 'All')
		   {
		    /*$query = "SELECT count(track.userUniqueId) as totalview,count(distinct(track.userUniqueId)) as uniqueview,DATE_FORMAT(track.date_of_entry,'%d/%m/%Y') as date_of_entry,edm.department FROM Tbl_Analytic_TrackUser as track JOIN Tbl_EmployeeDetails_Master as edm ON track.userUniqueId = edm.employeeId where (DATE(track.date_of_entry) BETWEEN :fromdte AND :enddte) AND track.clientId = :client group by edm.department";
		   }*/
		   
		   

		   $query = "SELECT count(track.userUniqueId) as totalview,count(distinct(track.userUniqueId)) as uniqueview,DATE_FORMAT(track.date_of_entry,'%d/%m/%Y') as date_of_entry,edm.department , ROUND((count(distinct(track.userUniqueId)) * 100 / (select count(*) from Tbl_EmployeeDetails_Master where department = edm.department)),2) as percent FROM Tbl_Analytic_TrackUser as track JOIN Tbl_EmployeeDetails_Master as edm ON track.userUniqueId = edm.employeeId where (DATE(track.date_of_entry) BETWEEN :fromdte AND :enddte) AND track.clientId = :client group by edm.department";
		   }
		   
		   else
		   {
						
			$query = "SELECT count(track.userUniqueId) as totalview,count(distinct(track.userUniqueId)) as uniqueview,DATE_FORMAT(track.date_of_entry,'%d/%m/%Y') as date_of_entry,edm.department FROM Tbl_Analytic_TrackUser as track JOIN Tbl_EmployeeDetails_Master as edm ON track.userUniqueId = edm.employeeId where (DATE(track.date_of_entry) BETWEEN :fromdte AND :enddte) AND track.clientId = :client and track.description = 'Open Spalsh' AND edm.department = :department group by edm.department";
		   }
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
			if($department != 'All'){$stmt->bindParam(':department', $department, PDO::PARAM_STR);}
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
			//print_r($result);
			
            $response["categories"] = [];
            $response["data"] = [];
            $response["percentdata"] = [];
            foreach ($result as $res) {
                //  $response["categories"] = $res['date_of_entry'];
                //   $response["data"] = $res['totalview'];
                array_push($response["categories"], $res['department']);
                array_push($response["data"], $res['uniqueview']);
	        array_push($response["percentdata"], $res['percent']);
            }
             //  print_r($response);
            return json_encode($response, JSON_NUMERIC_CHECK);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }
}