<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Tripub</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>

<body>
<!--Google Font - Work Sans-->
<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>
<ul class="nav nav-pills" style="background-color: aliceblue">
    <a class="navbar-brand" href="#" style="padding-left: 1%">Triphub</a>
    <li class="nav-item">
        <a class="nav-link active" href="#">My Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Create Trip Plan!</a>
    </li>
</ul>
<div class="container">

</div>
  <div class="row"  id = "p1">
    <div class="col align-self-start">
      <div class = "container">
      </div>
    </div>
    <div class="col align-self-center">
      <div class="container">
        <div class="jumbotron">
        <div class="row" id = "topblank">
          <div class="col-md-12"></div>
        </div>

        <div class="row">
          <div class="col-6">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add new things to your plan!
          </button>
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select A New Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>
            <!--
            <button type="button" class="btn btn-outline-primary" id="addNew">Add new things to your plan!</button>
            -->
          </div>
        </div>

        <div class="col-6">
          <div class = "container">
            <form class="form-inline" id = "searchForm" method="post" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
      ?>">
              <label class="sr-only" for="inlineFormInput">Place</label>
              <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Things you want to explore" name = "place">

              <label class="sr-only" for="inlineFormInputGroup">Zipcode</label>
              <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                <div class="input-group-addon">@</div>
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Zipcode">
              </div>

              <button type="button" id="searchBtn" class="btn btn-primary">Submit</button>
            </form>

          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="col align-self-end">
      <div id = "planlist">
      </div>
    </div>
  </div>
</div>



<script src="js/index.js"></script>

</body>
</html>
