<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: aliceblue;

        padding: 30px 10px;
    }

    .card {
        max-width: 500px;
        margin: auto;
        color: black;
        border-radius: 20 px;
    }

    p {
        margin: 0px;
    }

    .container .h8 {
        font-size: 30px;
        font-weight: 800;
        text-align: center;
    }

    .btn.btn-primary {
        width: 100%;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 15px;
        background-image: linear-gradient(to right, #77A1D3 0%, #79CBCA 51%, #77A1D3 100%);
        border: none;
        transition: 0.5s;
        background-size: 200% auto;

    }


    .btn.btn.btn-primary:hover {
        background-position: right center;
        color: #fff;
        text-decoration: none;
    }



    .btn.btn-primary:hover .fas.fa-arrow-right {
        transform: translate(15px);
        transition: transform 0.2s ease-in;
    }

    .form-control {
        color: white;
        background-color: #223C60;
        border: 2px solid transparent;
        height: 60px;
        padding-left: 20px;
        vertical-align: middle;
    }

    .form-control:focus {
        color: white;
        background-color: #0C4160;
        border: 2px solid #2d4dda;
        box-shadow: none;
    }

    .text {
        font-size: 14px;
        font-weight: 600;
    }

    ::placeholder {
        font-size: 14px;
        font-weight: 600;
    }
</style>
<script>


</script>
<?php
require 'customer_authgaurd.php';
require '../shared/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}


// Get order ID from GET request
$order_id = $_GET['order_id'];
$payment_method = $_GET['payment_method'];
// Fetch order details
$sql = "SELECT * FROM orders WHERE order_id='$order_id' AND user_id='$_SESSION[user_id]'";
$result = $connection->query($sql);
?>



<?php
if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();

    ?>


    <div class="container p-0">

        <form action="process_payment.php" method="post"  >
            <div class="card px-4">
                <p class="h8 py-3">Payment Details</p>
                <div class="row gx-3">
                    <div class="col-12">
                        <div class="d-flex flex-column">

                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <input type="hidden" name="amount" value="<?php echo $order['total_amount']; ?>">
                            <input type="hidden" name="payment_method" value="<?php echo $payment_method; ?>">

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Person Name</p>
                            <input required class="form-control mb-3" type="text" name="person_name" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Card Number</p>
                            <input required class="form-control mb-3" type="text" name="card_number"
                                placeholder="1234 5678 435678" maxlength="14">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">Expiry</p>
                            <input required class="form-control mb-3" type="text" name="card_expiry" placeholder="MM/YYYY" maxlength="7">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column">
                            <p class="text mb-1">CVV/CVC</p>
                            <input required class="form-control mb-3 pt-2 " name="cvv" type="password" placeholder="***" maxlength="3">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary mb-3" >
                            
                            <span class="ps-3">Pay <?php echo $order['total_amount']; ?> &#8377; </span> 
                            <span class="fas fa-arrow-right"></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <?php

} else {
    echo "Order not found.";
}
?>