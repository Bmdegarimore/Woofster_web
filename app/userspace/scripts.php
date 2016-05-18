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
                    var buttonName = button.data('button');
                    
                    // Grabs row to edit or delete
                    var rowSelected = button.data('row');
                    
                    var modal = $(this);
                    // Updates the Title of Event to Add, Update, or Delete
                    modal.find('.modal-title').text(title + " Event");
                    modal.find('#button').text(buttonName + " Event");
                    modal.find('#button').val(changedValue);
                    
                    //Make sure fields avail to edit basically resets to original state
                    modal.find("button").removeClass('btn-danger');
                    modal.find('#eventTitle').prop('disabled',false);
                    modal.find('#notes').prop('disabled', false);

                    // Sets the date time picker
                        $('#datetimepicker12').datetimepicker({
                          inline: true,
                          sideBySide: true,
                          useCurrent: true
                          
                        });
                        $('#datetimepicker12').data("DateTimePicker").minDate(new Date());
                    // Loads empty modal
                    if (title == 'Add') {
                        // Make sure add fields are blank
                        rowSelected = null;
                        modal.find("input[type=text], textarea").val("");
                        
 
                    } else {
                        // Populates data to see from event either delete or edit
                        var eventID = button.data('event');
                        modal.find('#eventID').val(eventID);
                        modal.find('#eventTitle').val(jsonEvents[rowSelected].title);
                        modal.find('#notes').val(jsonEvents[rowSelected].notes);
                          
                        var testTime = jsonEvents[rowSelected].eventDate;
                        // Set date and time based on existing date set
                        $('#datetimepicker12').datetimepicker({
                          format: 'YYYY-MM-DD hh:mm:ss'
                        });
                        
                        // Uses moment.js to format time
                        $('#datetimepicker12').data("DateTimePicker").date(moment(testTime));
                       
                        if (title == 'Delete') {
                          //Adds read only to fields
                          modal.find('#button').addClass("btn-danger");
                          modal.find('#eventTitle').prop('disabled',true);
                          modal.find('#notes').prop('disabled', true);
                        }
                    }
                });
            } );
        </script>
</body>

