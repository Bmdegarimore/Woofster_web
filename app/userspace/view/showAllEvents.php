<?php
   echo "Showing the showAllEvents.php page";
?>


    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../app/userspace/assets/css/style.css">
    

 
    <h1 class="text-center">User Events Page:</h1>
    <br>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
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
            </tr>
        </tfoot>
 
        <tbody>
          <?php
            // Counter to keep track of multidimensional array
            $counter = 0;
            foreach($events as $row){
                $eventTitle =$row['title'];
                $miltaryDate=$row['eventDate'];
                $eventDate = date('m/d/Y h:i a', strtotime($miltaryDate));
                $notes =$row['notes'];
                $eventID = $row['eventID'];
                //$userID = $row['unique_loginID'];
                $counter++;
                echo "<tr><td>$eventTitle</td><td class='timeDate'>$eventDate</td><td>$notes</td>></tdtr>";
            };
           ?>
        </tbody>
    </table>
    
     
    
    



