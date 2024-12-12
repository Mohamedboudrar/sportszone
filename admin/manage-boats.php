<?php
include('../includes/alert-handler.php');

if(isset($_GET['del'])) {
    $bid = $_GET['del'];
    $query = mysqli_query($con, "DELETE FROM tblboat WHERE ID='$bid'");
    if($query) {
        showToastAndRedirect('Zone deleted successfully', 'manage-boats.php');
    } else {
        showToast('Failed to delete zone');
    }
} 