<?php

session_start();

if (isset($_POST['total'])) {
    $total = $_POST['total'];

    $total = number_format($total, 2, '.', '');

    //retrieve existing payments from storage
    $payments = [];

    // Use file locking to prevent race conditions
    $fileHandle = fopen('payments.json', 'c+');
    if (flock($fileHandle, LOCK_EX)) {
        $paymentsJson = fread($fileHandle, filesize('payments.json'));

        $payments = json_decode($paymentsJson, true);

        if (!is_array($payments)) {
            
            $payments = [];
        }

        $payments[] = $total;

        // Save the updated payments
        fseek($fileHandle, 0);
        fwrite($fileHandle, json_encode($payments));
        fflush($fileHandle);

        flock($fileHandle, LOCK_UN);
    }

    fclose($fileHandle);

    echo $total;
}
?>
