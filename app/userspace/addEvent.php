<div class="text-center container">
    <h2>Add Event</h2>

    <form  class="form-horizontal" method="post" action="controllerEvents.php">
       <div class="col-sm-6">
            <label for="eventTitle" class="control-label">Event Title</label>
            <input type="text" class="form-control" id="eventTitle">
        </div>
        <div class="col-sm-6">
            
            <label for="eventDate" class="control-label">Event Date</label>
            <input type="text" class="form-control" id="eventDate">
        </div>
        <div class="col-sm-6">
       
            <label for="isRepeated" class="control-label">Repeated</label>
            <input type="text" class="form-control" id="isRepeated">
        </div>
        <div class="col-sm-6">
            <label for="repeatFreq" class="control-label">How Frequent</label>
            <input type="text" class="form-control" id="repeatFreq">
        </div>
       
        <div class="col-sm-12">
            <label for="notes" class="control-label">Notes</label>
            <textarea class="form-control" rows="4" id="notes"></textarea>
        </div>
        
        
        <div class="row">
            <div class="col-sm-4">
            <button type="submit" class="btn btn-primary btn-lg" name="cancel">No</button>
            </div>
            <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" class="btn btn-primary btn-lg" name="update" value="delete">Yes</button>
            </div>
        </div>
        
    </form>
</div>