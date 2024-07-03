<?php
require 'customer_authgaurd.php';
require '../shared/connection.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}
//If Cod is the choosen option
if ($_POST['payment_method'] == "cod") {

    // Get data from POST request
    $order_id = $_POST['order_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];


    // Process payment (simulated)
    $payment_status = ($payment_method == 'online') ? 'paid' : 'pending';

    $sql = "SELECT * FROM orders WHERE order_id='$order_id' AND user_id='$_SESSION[user_id]'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        // Insert payment record
        $insert_payment_sql = "INSERT INTO payments (order_id, amount, payment_method) VALUES ('$order_id', '$order[total_amount]', '$payment_method')";
        if ($connection->query($insert_payment_sql) === TRUE) {
            // Update order payment status
            $update_order_sql = "UPDATE orders SET payment_status='$payment_status', status='pending' WHERE order_id='$order_id'";
            if ($connection->query($update_order_sql) === TRUE) {
                echo "Payment processed successfully. Your order is now " . ($payment_status == 'paid' ? "completed." : "pending payment.");
                echo "<br>Redirecting to home page...";
                header('Refresh:3,url=home.php');
            } else {
                echo "Error updating order: " . $connection->error;
            }
        } else {
            echo "Error: " . $insert_payment_sql . "<br>" . $connection->error;
        }
    } else {
        echo "No order Found";
    }



}//If Online payment is the choosen option
else {
   

    // Get data from POST request
    $order_id = $_POST['order_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $person_name = $_POST['person_name'];
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvv = $_POST['cvv'];
    // Process payment (simulated)
    $payment_status = ($payment_method == 'online') ? 'paid' : 'pending';

    // Insert payment record
    $insert_payment_sql = "INSERT INTO payments (order_id, amount, payment_method) VALUES ('$order_id', '$amount', '$payment_method')";
    if ($connection->query($insert_payment_sql) === TRUE) {
        //Insert Card details
        
        $sql = "SELECT payment_id FROM payments WHERE order_id='$order_id'";
        $response = $connection->query($sql);

        if ($response->num_rows > 0) {
            $row = $response->fetch_assoc();
            echo "I am in online payment";
            $details_query = "INSERT INTO payment_details(person_name,card_number,expiry,cvv,payment_id) VALUES ('$person_name','$card_number','$card_expiry','$card_cvv','$row[payment_id]') ";
            if ($connection->query($details_query) === TRUE) {
                // Update order payment status
                $update_order_sql = "UPDATE orders SET payment_status='$payment_status', status='pending' WHERE order_id='$order_id'";
                if ($connection->query($update_order_sql) === TRUE) {
                    echo "Payment processed successfully. Your order is now " . ($payment_status == 'paid' ? "completed." : "pending payment.");
                    echo "<br>Redirecting to home page...";
                    header('Refresh:3,url=home.php');
                } else {
                    echo "Error updating order: " . $connection->error;
                }
            }else{
                echo "Error". $connection->error;
            }
        }
    } else {
        echo "Error: " . $insert_payment_sql . "<br>" . $connection->error;
    }
}
?>