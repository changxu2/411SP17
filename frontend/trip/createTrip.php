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
<nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <p class="navbar-text">Tripub</p>
    </div>
</nav>
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
          <div class="col-4"></div>
          <div class="col-4">
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
          <div class="col-4"></div>
        </div>
        <!-- The Modal -->
        <!--
        <div id="myModal" class="modal">

          <div class="modal-content">
            <div class="modal-header">
              <span class="close">&times;</span>
              <h2>add to plan</h2>
            </div>
            <div class="modal-body">
              <div class="container">
                <form class="navbar-form navbar-left" role="search">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                  </div>
                  <button type="submit" class="btn btn-outline-primary">Submit</button>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <h3>click entry to add</h3>
            </div>
          </div>
        </div>
        -->
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
<script>

</script>
</body>
</html>
