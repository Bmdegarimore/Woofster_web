<h1 class="text-center">Admin Event List:</h1>
    <br>
    
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Event Date</th>
                <th>Email Address</th>
                <th>Event Title</th>
                <th>Notes</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Event Date</th>
                <th>Email Address</th>
                <th>Event Title</th>
                <th>Notes</th>
            </tr>
        </tfoot>
 
        <tbody>
          <?php
            foreach($events as $row){
                $emailAddress = $row['username'];
                $eventTitle =$row['title'];
                $miltaryDate=$row['eventDate'];
                $eventDate = date('m/d/Y h:i a', strtotime($miltaryDate));
                $notes =$row['notes'];
                echo "<tr><td class='timeDate'>$eventDate</td><td>$emailAddress</td><td>$eventTitle</td><td>$notes</td></tdtr>";
            };
           ?>
        </tbody>
    </table>
 
     
    
    



