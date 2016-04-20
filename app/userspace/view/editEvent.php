<div class="text-center container">
    <h2>Edit Event</h2>

    <form  class="form-horizontal" method="post" action="controllerEvents.php">
    
        <div class="col-sm-6">
            <label for="eventTitle" class="control-label">Event Title</label>
            <input type="text" class="form-control" id="eventTitle" value="<?php if(isset($_GET['row'])){echo($events[$_GET['row']][title]);}; ?>">
        </div>
        <div class="col-sm-6">
            
            <label for="eventDate" class="control-label">Event Date</label>
            <input type="text" class="form-control" id="eventDate" value="<?php if(isset($_GET['id'])){echo($events[$_GET['row']][eventDate]);}; ?>">
        </div>
        <div class="col-sm-6">
       
            <label for="isRepeated" class="control-label">Repeated</label>
            <input type="text" class="form-control" id="isRepeated" value="<?php if(isset($_GET['id'])){echo($events[$_GET['row']][repeated]);}; ?>">
        </div>
        <div class="col-sm-6">
            <label for="repeatFreq" class="control-label">How Frequent</label>
            <input type="text" class="form-control" id="repeatFreq" value="<?php if(isset($_GET['id'])){echo($events[$_GET['row']][repeatFrequency]);}; ?>">
        </div>
       
        <div class="col-sm-12">
            <label for="notes" class="control-label">Notes</label>
            <textarea class="form-control" rows="4" id="notes"><?php if(isset($_GET['id'])){echo($events[$_GET['row']][notes]);}; ?></textarea>
        </div>
        
        <div class="row">
            <div class="col-sm-4">
            <button type="submit" class="btn btn-primary btn-lg" name="cancel">Cancel</button>
            </div>
            <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" class="btn btn-primary btn-lg" name="update" value="update">Update</button>
            </div>
        </div>
        
    </form>
</div>