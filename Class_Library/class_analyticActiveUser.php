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
	   
		   $query = "SELECT count(track.userUniqueId) as totalview,count(distinct(track.userUniqueId)) as uniqueview,DATE_FORMAT(track.date_of_entry,'%d/%m/%Y') as date_of_entry,edm.department , ((select count(*) from Tbl_EmployeeDetails_Master where department = edm.department) - count(distinct(track.userUniqueId)))as inactive FROM Tbl_Analytic_TrackUser as track JOIN Tbl_EmployeeDetails_Master as edm ON track.userUniqueId = edm.employeeId where (DATE(track.date_of_entry) BETWEEN :fromdte AND :enddte) AND track.clientId = :client group by edm.department";
		
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
			
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
			//print_r($result);
			
            $response["categories"] = [];
            $response["data"] = [];
            $response["inactive"] = [];
            foreach ($result as $res) {
                //  $response["categories"] = $res['date_of_entry'];
                //   $response["data"] = $res['totalview'];
                array_push($response["categories"], $res['department']);
                array_push($response["data"], $res['uniqueview']);
	        array_push($response["inactive"], $res['inactive']);
            }
             //  print_r($response);
            return json_encode($response, JSON_NUMERIC_CHECK);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }
}