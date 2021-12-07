<?php
/**
 * Movie class
 * 
 * @author  Abul,Abdul & Wajid.
 * @version 2.0 
 */
require_once("connection.php");

    class Todb {
        function  create_id($u_name, $tb_name) {
            
            $db = new DB();
            $con = $db->connect();
            if ($con) {
                $cQuery ="INSERT INTO ".$tb_name." (name) SELECT '".$u_name."'";
                $stmt = $con->prepare($cQuery);
                $ok = $stmt->execute();
                
                $db->disconnect($con);
                
                return($con->lastInsertId());

            } else {
                return false;
            }
        }
        /**
        * Inserts a new delivered
        * 
        * @param   ud_tbl,ud_id,ud_data,ud_what to update table:ud_tbl with data:ud_data in column 
        * @return  true if the insertion was correct, 
        *          or false if the database connection was unsuccessful or there was an error
        */
        function update($ud_tbl,$ud_id,$ud_data,$ud_what) {                            
            $db = new DB();
            $con = $db->connect();
            if ($con) {
                $cQuery = "UPDATE ".$ud_tbl." SET ".$ud_what."= '".$ud_data."' WHERE id = ".$ud_id;
                $stmt = $con->prepare($cQuery);
                $ok = $stmt->execute();

                $stmt = null;                
                $db->disconnect($con);
                
                return ($ud_data);

            } else {
                return false;
            }
        }
        /**
        * Inserts a new delivered
        * 
        * @param   msg_id,con_id to consumer
        * @return  true if the insertion was correct, 
        *          or false if the database connection was unsuccessful or there was an error
        */ 
        function  get_value($u_name, $tb_name,$what) {
            $db = new DB();
            $con = $db->connect();
            if ($con) {
                $result = 0;
                $cQuery = "SELECT  ".$what." FROM ".$tb_name." WHERE name ='".$u_name."'";
                $stmt = $con->query($cQuery);
                while($row = $stmt->fetch())
                    $result = $row[$what];

                $stmt = null;
                $db->disconnect($con);
                
                return($result);

            } else {
                return false;
            }
        }
        
    }
?>