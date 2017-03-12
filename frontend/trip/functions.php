<?php
         function connectToDb() {
            $db = new mysqli('localhost', 'triphubAdmin', 'xxxxx', 'xxxxx');

            if($db->connect_errno > 0) {
                die('Unable to connect to database [' . $db->connect_error . ']');
            }
            return $db;
         }

         function createPlan($crr_user, $pre_user, $db) { //insert a new plan and return the id
            if (!$db->query("INSERT INTO Plan VALUES ($pre_user, $crr_user)")) {
                echo "INSERT failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            return $mysqli->insert;
         }

         function closeDb($db) {
            $db->close();
         }

//         function getTrans($db) {
//            $sql = "SELECT id, firstname, lastname FROM MyGuests";
//            $result = $conn->query($sql);
//         }
//         function initTransQuery($db) {
//            $stmt = $db->prepare("SELECT Name FROM Transportation WHERE TrDID = ?");
//            return $stmt;
//         }
         function getPlaces($db, $zipcode, $place) {
            $zip = //trimmmmmm
            $sql = "SELECT Longtitude, Altitude FROM Zipcode WHERE Zip = $zip";
            $result = $db->query($sql);
            if (!$result) {
                printf("Errormessage: %s\n", $db->error);
            }

         }

         function getTransById($transID, $db) {
            $sql = "SELECT Type FROM Transportation WHERE TrDID = $transID";
            $result = $db->query($sql);
            if (!$result) {
                printf("Errormessage: %s\n", $db->error);
            }
            return $result;
         }

        function getLocById($locID, $db) {
            $sql = "SELECT Name, Type1, Longitude, Latitude FROM locations WHERE PlacesID = $locID";
                $result = $db->query($sql);
            if (!$result) {
                printf("Errormessage: %s\n", $db->error);
            }
            return $result;
        }

?>