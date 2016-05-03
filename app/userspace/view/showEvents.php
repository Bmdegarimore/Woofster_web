<?php
   
?>

    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="assets/css/style.css">
    

    <?php
        //Check if an event had been added, edited, or removed
        if(isset($_SESSION['event_flag'])){
            $alert_message = '';

            //Switch to see what message to put into the alert
            switch ($_SESSION['event_flag']) {
                case 'edited':
                    $alert_message = "Event was updated";
                    break;
                case 'deleted':
                    $alert_message = "Event was deleted";
                    break;
                case 'added':
                    $alert_message = "Event was added";
                    break;
            }

            //unset the session variable for event_flag
            unset($_SESSION['event_flag']);

            //Display the alert
            echo "<div class='alert alert-success fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>$alert_message</strong></div>";
        }
    ?>
    
    <h1 class="text-center">Events Page:</h1>
    <br>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Notes</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Notes</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </tfoot>
 
        <tbody>
          <?php
            // Counter to keep track of multidimensional array
            $counter = 0;
            foreach($events as $row){
                $eventTitle =$row['title'];
                $eventDate =$row['eventDate'];
                $notes =$row['notes'];
                $eventID = $row['eventID'];
                $userID = $row['unique_loginID'];
                $edit="<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modalAdd' data-title='Edit' data-value='update' data-event=$eventID data-row=$counter><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button>";
                $delete="<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modalAdd' data-title='Delete' data-value='delete' data-event=$eventID data-row=$counter><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>";
                $counter++;
                echo "<tr><td>$eventTitle</td><td>$eventDate</td><td>$notes</td><td>$edit</td><td>$delete</td></tdtr>";
            };
           ?>
        </tbody>
    </table>
    <br>
     <div class='text-center'>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd" data-title='Add' data-value='add'>Add Event</button>
        <br><br>
    </div>
     
    <!-- Modal to Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <form id="addForm"  class="form-horizontal" method="post" action="?select=events">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Event</h4>
              </div>
              <div class="modal-body">
                <div class="text-center container">
                
                    
                       <div class="col-lg-12">
                            <label for="eventTitle" class="control-label">Event Title</label>
                            <input type="text" class="form-control" name="eventTitle" id="eventTitle" maxlength="128" required>
                        </div>
                        <br>
                        <div class="col-lg-12">
                            <label for="notes" class="control-label">Notes</label>
                            <textarea class="form-control" rows="4" name="notes" id="notes" maxlength="255"></textarea>
                        </div>
                        <br>
                        <div class="col-lg-12">
                            <div class="row">
                                    <label for="datetimepicker12" class="control-label">Event Date</label>
                                    <div type="datetime" class="eventDate" id="datetimepicker12" name="eventDate" required></div>
                            </div>
                        </div>
                        
                         <input type="hidden" id="eventID" name="eventID" value="">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" name="cancel">Close</button>
                <button type="submit" class="btn btn-primary" id="button" name="update" value="add">Add Event</button>
              </div>
            </div>
        </form>
      </div>
    </div>
    <!-- End of Add -->
    



