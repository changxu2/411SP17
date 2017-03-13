
    <div class="row">
            <div class="col-6">
            <form id = "displaySearchForm" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <?php
                foreach ($result as $loc) {
                                echo "<div class="form-check">";
                                echo "<label class="form-check-label">";
                                echo "<input class="form-check-input" type="radio" name="$result[ID]" value="option1">";
                                echo $result[NAME]." ".$result[TYPE];
                                echo "</label>";
                                echo "</div>";
                            }
            ?>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </div>
    </div>
