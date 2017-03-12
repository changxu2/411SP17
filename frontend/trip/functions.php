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
                return NULL;
            }
            return $mysqli->insert_id;
         }

         function checkPlan($db, $pid) { //insert a new plan and return the id
            if ($result = $db->query("SELECT Title, ArrayOfLocations FROM Plan WHERE planID = $pid")) {
              $currentfield = mysqli_field_tell($result);
              printf("Column %d:\n", $currentfield);
              printf("Name:     %s\n", $finfo->name);
              printf("Table:    %s\n", $finfo->table);
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              return $row;
            }
            echo "INSERT failed: (" . $mysqli->errno . ") " . $mysqli->error;
            return NULL;
         }

         function closeDb($db) {
            $db->close();
         }
?>
