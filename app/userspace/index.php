<?php
   //Starting session so I can grab stuff from $_SESSION
  session_start();

  if(!isset($_SESSION['user_uid'])){
    header("Location: ../../");
  }
    require("header.php");
?>
<html>
    <body class="nav-md">
        <?php
            require("nav.php");
        ?>
        <div class="right_col" role="main">
            <div class="row">
            <!-- Page content goes here -->
            <?php
               /* select makes a choice of page to load, then grab any additional GETs to change logic, or default to controllerEvents.php */

              //Check the get array for the select element
              /* Disable til add additional menus
              if (isset($_GET['select'])) {
                //If it's equal to events...
                if($_GET['select'] == "events") {
                  //Set the page to the controller for events
                  $page = "controller/controllerEvents";
                }
                else {
                  $page = "main"; //Default
                }
              //Load the page
              include($page.'.php');
              } else {
                include('controller/controllerEvents.php');
              }*/
              include('controller/controllerEvents.php');
            ?>
            </div>
            <?php
                require("footer.html");
            ?>
        </div>
        
        <!-- Global JS -->
        
        <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
        
        
         
      
      
        <!-- Custom JS -->
        <script src="assets/js/nprogress.js"></script>
        <script src="assets/js/custom.js"></script>
              
        <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
        <script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
       


        <script>
            $(document).ready(function()
            {
                //Grabs all events and puts into jsonarray
                var jsonEvents = <?php echo json_encode($events, JSON_PRETTY_PRINT) ?>;
                
                $('#example').DataTable( {
                "scrollY":        "30em",
                "scrollCollapse": false,
                "paging":         false
                } );
              
              // Coverts time back to YYYY-MM-DD HH:mm:ss format
              $('#button').click(function(){
                var convertTime = moment($('#datetimepicker12').val()).format('YYYY-MM-DD HH:mm:ss');
                $('#datetimepicker12').val(convertTime);
                
              });
                
                //When the button is clicked, show the appropriate modal
                $('#modalAdd').on('show.bs.modal', function (event) {
                        // Button that triggered the modal
                    var button = $(event.relatedTarget); 
                    
                    // Extract info from data-* attributes
                    var title = button.data('title'); 
                    var changedValue = button.data('value');
                    
                    // Grabs row to edit or delete
                    var rowSelected = button.data('row');
                    
                    var modal = $(this);
                    // Updates the Title of Event to Add, Update, or Delete
                    modal.find('.modal-title').text(title + " Event");
                    modal.find('#button').text(title + " Event");
                    modal.find('#button').val(changedValue);
                    
                    //Make sure fields avail to edit
                    modal.find('#eventTitle').prop('disabled',false);
                    modal.find('#notes').prop('disabled', false);
                    
                    // Loads empty modal
                    if (title == 'Add') {
                        // Make sure add fields are blank
                        rowSelected = null;
                        modal.find("input[type=text], textarea").val("");
                        // Sets the date time picker based on the add button
                        $('#datetimepicker12').datetimepicker({
                          inline: true,
                          sideBySide: true,
                          useCurrent: true
                        });
 
                    } else {
                        // Populates data to see from event either delete or edit
                        var eventID = button.data('event');
                        modal.find('#eventID').val(eventID);
                        modal.find('#eventTitle').val(jsonEvents[rowSelected].title);
                        modal.find('#notes').val(jsonEvents[rowSelected].notes);
                        
                        // Needed for now when edit or delete selected. Can eventually move out of condition logic
                        $('#datetimepicker12').datetimepicker({
                          inline: true,
                          sideBySide: true
                          //Make value equal edit or delete   
                        });
                        
                        var testTime = jsonEvents[rowSelected].eventDate;
                        // Set date and time
                        $('#datetimepicker12').datetimepicker({
                          format: 'YYYY-MM-DD hh:mm:ss'
                        });
                        $('#datetimepicker12').data("DateTimePicker").date(moment(testTime));
                       
                        if (title == 'Delete') {
                            //Adds read only to fields
                            modal.find('#eventTitle').prop('disabled',true);
                            modal.find('#notes').prop('disabled', true);
                            //Insert disabled calendar
                        }
                    }
                });
            } );
        </script>
        
    </body>
</html>