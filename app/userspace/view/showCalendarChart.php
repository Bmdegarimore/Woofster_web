<?php
    require('../model/chartModel.php');
    $chartModel = new ChartModel();
    $chartModel->connect();
    $totalEvents = $chartModel->selectEvents(date(m));
    print_r($totalEvents);
    $JSONTotalEvents = $chartModel->convertToJSON($totalEvents);
    print_r($JSONTotalEvents);
?>