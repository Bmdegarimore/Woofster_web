<?php
   
?>

    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/style.css">
    


    
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
                $edit ="<a href='?select=events&action=edit&row=$counter&id=$eventID'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
                $delete ="<a href='?select=events&action=delete&row=$counter&id=$eventID'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $counter++;
                echo "<tr><td>$eventTitle</td><td>$eventDate</td><td>$notes</td><td>$edit</td><td>$delete</td></tdtr>";
            };
           ?>
        </tbody>
    </table>
    <br>
     <div class='text-center'>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd">Add Contact</button>
        <br><br>
    </div>
     
    <!-- Modal to Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Event</h4>
          </div>
          <div class="modal-body">
            <div class="text-center container">
            
                <form  class="form-horizontal" method="post" action="?select=events">
                   <div class="col-sm-12">
                        <label for="eventTitle" class="control-label">Event Title</label>
                        <input type="text" class="form-control" name="eventTitle" id="eventTitle">
                    </div>
                    <div class="col-sm-12">
                        
                        <label for="eventDate" class="control-label">Event Date</label>
                        <input type="text" class="form-control" name="eventDate" id="eventDate">
                    </div>
                   
                    <div class="col-sm-12">
                        <label for="notes" class="control-label">Notes</label>
                        <textarea class="form-control" rows="4" name="notes" id="notes"></textarea>
                    </div>
                </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" name="cancel">Close</button>
            <button type="button" class="btn btn-primary" name="add">Add Event</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End of Add -->
    


<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>