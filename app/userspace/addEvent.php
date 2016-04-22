<?php
session_start();
?>
<div class="text-center container">
    <h2>Add Event</h2>

    <form  class="form-horizontal" method="post" action="?select=events">
       <div class="col-sm-6">
            <label for="eventTitle" class="control-label">Event Title</label>
            <input type="text" class="form-control" name="eventTitle" id="eventTitle">
        </div>
        <div class="col-sm-6">
            
            <label for="eventDate" class="control-label">Event Date</label>
            <input type="text" class="form-control" name="eventDate" id="eventDate">
        </div>
        <div class="col-sm-6">
       
            <label for="isRepeated" class="control-label">Repeated</label>
            <input type="text" class="form-control" name="isRepeated" id="isRepeated">
        </div>
        <div class="col-sm-6">
            <label for="repeatFreq" class="control-label">How Frequent</label>
            <input type="text" class="form-control" name="repeatFreq" id="repeatFreq">
        </div>
       
        <div class="col-sm-12">
            <label for="notes" class="control-label">Notes</label>
            <textarea class="form-control" rows="4" name="notes" id="notes"></textarea>
        </div>
        
        <div class="row">
            <br>
            <div class="col-sm-4">
            <br>
            <button type="submit" class="btn btn-primary btn-lg" name="cancel">Cancel</button>
            </div>
            <div class="col-sm-4 col-sm-offset-4">
            <br>
            <button type="submit" class="btn btn-primary btn-lg" name="update" value="add">Add</button>
            </div>
        </div>
        
    </form>
</div>