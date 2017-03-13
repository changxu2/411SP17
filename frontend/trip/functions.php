<?php
         function connectToDb() {
            $db = new mysqli('localhost', 'tripubproject_adm', 'tripubproject_DB1', '12345shangshandalaohu');



            if($db->connect_errno > 0) {
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
            if ($result = $db->query("SELECT Plan.Title, contains.locationID FROM Plan, contains WHERE Plan.planID = $pid AND contains.planID = $pid")) {
//              $currentfield = mysqli_field_tell($result);
//              printf("Column %d:\n", $currentfield);
//              printf("Name:     %s\n", $finfo->name);
//              printf("Table:    %s\n", $finfo->table);
//              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//              return $row;
              $myArray = array();
              while($row = $result->fetch_array(MYSQL_ASSOC)) {
                            $myArray[] = $row;
                          }
              //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              return $myArray;
            }
            echo "SELECT failed: (" . $mysqli->errno . ") " . $mysqli->error;
            return NULL;
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
            $zip = ltrim($zipcode, '0');
            $sql = "SELECT longtitude, latitude FROM Zipcode WHERE Zip = $zip";
            $result = $db->query($sql);
            if (!$result) {
                printf("Errormessage: %s\n", $db->error);
                return NULL;
            }
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $latitude = $row['Latitude']
            $longitude = $row['Longitude']
            $sql = "SELECT ID, NAME, TYPE FROM locations WHERE (locations.Latitude < $latitude + 20) AND (locations.Latitude > $latitude - 20 ) AND (locations.Longitude < $longitude +20) AND (locations.Longitude > $longitude -20) AND (locations.NAME LIKE %place%)";
            $result = $db->query($sql);
            $myArray = array();
            while($row = $result->fetch_array(MYSQL_ASSOC)) {
              $myArray[] = $row;
            }

            return $myArray;
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
