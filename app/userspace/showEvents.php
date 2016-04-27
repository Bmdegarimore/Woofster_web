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
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Notes</th>
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
            $counter = 0;
            foreach($events as $row){
                $eventTitle =$row['title'];
                $eventDate =$row['eventDate'];
                $notes =$row['notes'];
                $eventID = $row['eventID'];
                $userID = $row['unique_loginID'];
                $edit ="<a href='?select=events&action=edit&row=$counter&id=$eventID'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
                $delete ="<a href='?select=events&action=delete&row=$counter&id=$eventID'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                $counter++;
                echo "<tr><td>$eventTitle</td><td>$eventDate</td><td>$notes</td><td>$edit</td><td>$delete</td></tdtr>";
            };
           ?>
        </tbody>
    </table>
    <br>
     <div class='text-center'>
        <a href="?select=events&action=add"><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal">Add Contact</button></a>
        <br><br>
    </div>
    


<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>