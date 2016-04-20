<?php
   
?>
<head>
    <title>Event's Page</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<header>
    <h1 class="text-center">Events Page:</h1>
</header>

<div class="container">
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Edit</th>
                <th>Delete</th>
                <th>Dog Name</th>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Repeated</th>
                <th>Repeat Frequency</th>
                <th>Notes</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Edit</th>
                <th>Delete</th>
                <th>Dog Name</th>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Repeated</th>
                <th>Repeat Frequency</th>
                <th>Notes</th>
            </tr>
        </tfoot>
 
        <tbody>
          <?php
            foreach($events as $row){
                $dogName = $row['name'];
                $eventTitle =$row['title'];
                $eventDate =$row['eventDate'];
                $isRepeated =$row['repeated'];
                $repeatFreq =$row['repeatFrequency'];
                $notes =$row['notes'];
                $uuid = $row['eventID'];
                $edit ="<a href='?action=edit&id=$uuid'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
                $delete ="<a href='?action=delete&id=$uuid'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                
                echo "<tr><td>$edit</td><td>$delete</td><td>$dogName</td><td>$eventTitle</td><td>$eventDate</td><td>$isRepeated</td><td>$repeatFreq</td><td>$notes</td></tdtr>";
            };
           ?>
        </tbody>
    </table>
</div>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>