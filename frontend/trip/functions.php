<?php
         function connectToDb() {
            $db = new mysqli('localhost', 'triphubAdmin', 'xxxxx', 'xxxxx');

            if($db->connect_errno > 0){
                die('Unable to connect to database [' . $db->connect_error . ']');
            }
            return $db;
         }

         function createPlan($crr_user, $pre_user, $db) { //insert a new plan and return the id
            if (!$db->query("INSERT INTO Plan VALUES ($pre_user, $crr_user)")) {
                echo "INSERT failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            return $mysqli->insert_id;
         }

         function closeDb($db) {
            $db->close();
         }


?>