<?php ?> 
    <h1 class="text-center">User Events Page:</h1>
    <br>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>User</th>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Notes</th>
               
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>User</th>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Notes</th>
            </tr>
        </tfoot>
 
        <tbody>
          <?php
            foreach($events as $row){
                $user = $row['username'];
                $eventTitle =$row['title'];
                $miltaryDate=$row['eventDate'];
                $eventDate = date('m/d/Y h:i a', strtotime($miltaryDate));
                $notes =$row['notes'];
                $eventID = $row['eventID'];

                echo "<tr><td>$user</td><td>$eventTitle</td><td class='timeDate'>$eventDate</td><td>$notes</td>></tdtr>";
            };
           ?>
        </tbody>
    </table>
 
     
    
    



