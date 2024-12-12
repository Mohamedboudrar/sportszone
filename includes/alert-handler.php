<?php
function showToast($message, $type = 'error') {
    $backgroundColor = ($type == 'success') ? '#22c55e' : '#ef4444';
    
    ob_clean(); // Clear any previous output
    echo '<!DOCTYPE html><html><head>';
    echo '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">';
    echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>';
    echo '</head><body>';
    echo "<script>
        Toastify({
            text: '$message',
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'center',
            backgroundColor: '$backgroundColor',
            stopOnFocus: true,
        }).showToast();
        setTimeout(() => { window.history.back(); }, 3000);
    </script>";
    echo '</body></html>';
    exit();
}

function showToastAndRedirect($message, $redirectUrl, $type = 'success') {
    $backgroundColor = ($type == 'success') ? '#22c55e' : '#ef4444';
    
    ob_clean(); // Clear any previous output
    echo '<!DOCTYPE html><html><head>';
    echo '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">';
    echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>';
    echo '</head><body>';
    echo "<script>
        Toastify({
            text: '$message',
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'center',
            backgroundColor: '$backgroundColor',
            stopOnFocus: true,
        }).showToast();
        setTimeout(() => { window.location.href = '$redirectUrl'; }, 3000);
    </script>";
    echo '</body></html>';
    exit();
}
?> 