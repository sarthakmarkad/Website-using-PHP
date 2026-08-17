<?php

$name = "";
$units = "";
$bill = 0;
$error = "";
$breakdown = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $units = trim($_POST["units"]);

    // Server-side validation
    if ($name == "" || $units == "") {

        $error = "Please fill in all the fields.";

    } elseif (!is_numeric($units) || $units < 0) {

        $error = "Please enter a valid number of units.";

    } else {

        $units = (float)$units;

        // First 50 units
        if ($units <= 50) {

            $amount = $units * 3.50;

            $breakdown[] = [
                "slab" => "First 50 Units",
                "units" => $units,
                "rate" => 3.50,
                "amount" => $amount
            ];

            $bill = $amount;

        }

        // 51 - 150 units
        elseif ($units <= 150) {

            $amount1 = 50 * 3.50;
            $amount2 = ($units - 50) * 4.00;

            $breakdown[] = [
                "slab" => "First 50 Units",
                "units" => 50,
                "rate" => 3.50,
                "amount" => $amount1
            ];

            $breakdown[] = [
                "slab" => "Next 100 Units",
                "units" => $units - 50,
                "rate" => 4.00,
                "amount" => $amount2
            ];

            $bill = $amount1 + $amount2;

        }

        // 151 - 250 units
        elseif ($units <= 250) {

            $amount1 = 50 * 3.50;
            $amount2 = 100 * 4.00;
            $amount3 = ($units - 150) * 5.20;

            $breakdown[] = [
                "slab" => "First 50 Units",
                "units" => 50,
                "rate" => 3.50,
                "amount" => $amount1
            ];

            $breakdown[] = [
                "slab" => "Next 100 Units",
                "units" => 100,
                "rate" => 4.00,
                "amount" => $amount2
            ];

            $breakdown[] = [
                "slab" => "Next 100 Units",
                "units" => $units - 150,
                "rate" => 5.20,
                "amount" => $amount3
            ];

            $bill = $amount1 + $amount2 + $amount3;

        }

        // Above 250 units
        else {

            $amount1 = 50 * 3.50;
            $amount2 = 100 * 4.00;
            $amount3 = 100 * 5.20;
            $amount4 = ($units - 250) * 6.50;

            $breakdown[] = [
                "slab" => "First 50 Units",
                "units" => 50,
                "rate" => 3.50,
                "amount" => $amount1
            ];

            $breakdown[] = [
                "slab" => "Next 100 Units",
                "units" => 100,
                "rate" => 4.00,
                "amount" => $amount2
            ];

            $breakdown[] = [
                "slab" => "Next 100 Units",
                "units" => 100,
                "rate" => 5.20,
                "amount" => $amount3
            ];

            $breakdown[] = [
                "slab" => "Above 250 Units",
                "units" => $units - 250,
                "rate" => 6.50,
                "amount" => $amount4
            ];

            $bill = $amount1 + $amount2 + $amount3 + $amount4;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>PowerBill | Electricity Calculator</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<!-- Background Decoration -->

<div class="background-circle circle-one"></div>
<div class="background-circle circle-two"></div>


<!-- Navbar -->

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a class="navbar-brand" href="#">

            <i class="fa-solid fa-bolt"></i>

            Power<span>Bill</span>

        </a>

        <div class="navbar-text">

            Electricity Management

        </div>

    </div>

</nav>


<!-- Main Section -->

<main class="container main-container">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <!-- Header -->

            <div class="hero-section text-center">

                <div class="icon-circle">

                    <i class="fa-solid fa-lightbulb"></i>

                </div>

                <h1>
                    Electricity Bill Calculator
                </h1>

                <p>
                    Calculate your electricity bill quickly
                    and accurately using our smart calculator.
                </p>

            </div>


            <!-- Calculator Card -->

            <div class="calculator-card">

                <div class="row g-0">


                    <!-- Left Side -->

                    <div class="col-lg-6 calculator-left">

                        <div class="section-title">

                            <span class="title-icon">
                                <i class="fa-solid fa-calculator"></i>
                            </span>

                            <div>

                                <h3>Calculate Your Bill</h3>

                                <p>Enter your consumption details</p>

                            </div>

                        </div>


                        <?php if ($error != "") { ?>

                            <div class="error-message">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                <?php echo $error; ?>

                            </div>

                        <?php } ?>


                        <form method="POST"
                              id="billForm">


                            <!-- Name -->

                            <div class="input-group-custom">

                                <label for="name">

                                    <i class="fa-solid fa-user"></i>

                                    Customer Name

                                </label>

                                <div class="input-wrapper">

                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        placeholder="Enter your name"
                                        value="<?php echo htmlspecialchars($name); ?>"
                                    >

                                </div>

                                <small
                                    class="validation-message"
                                    id="nameError">
                                </small>

                            </div>


                            <!-- Units -->

                            <div class="input-group-custom">

                                <label for="units">

                                    <i class="fa-solid fa-bolt"></i>

                                    Units Consumed

                                </label>

                                <div class="input-wrapper">

                                    <input
                                        type="number"
                                        name="units"
                                        id="units"
                                        placeholder="e.g. 250"
                                        min="0"
                                        step="1"
                                        value="<?php echo htmlspecialchars($units); ?>"
                                    >

                                    <span>kWh</span>

                                </div>

                                <small
                                    class="validation-message"
                                    id="unitsError">
                                </small>

                            </div>


                            <!-- Buttons -->

                            <div class="button-group">

                                <button
                                    type="submit"
                                    class="calculate-btn"
                                    id="calculateBtn">

                                    <i class="fa-solid fa-bolt"></i>

                                    Calculate Bill

                                </button>


                                <button
                                    type="button"
                                    class="reset-btn"
                                    id="resetBtn">

                                    <i class="fa-solid fa-rotate-left"></i>

                                    Reset

                                </button>

                            </div>

                        </form>

                    </div>


                    <!-- Right Side -->

                    <div class="col-lg-6 calculator-right">

                        <div class="tariff-header">

                            <div class="tariff-icon">

                                <i class="fa-solid fa-indian-rupee-sign"></i>

                            </div>

                            <div>

                                <h3>Tariff Slabs</h3>

                                <p>Current electricity rates</p>

                            </div>

                        </div>


                        <div class="tariff-list">


                            <div class="tariff-item">

                                <div class="tariff-number">
                                    01
                                </div>

                                <div class="tariff-details">

                                    <h5>First 50 Units</h5>

                                    <p>0 – 50 units</p>

                                </div>

                                <div class="tariff-rate">

                                    ₹3.50

                                    <small>/ unit</small>

                                </div>

                            </div>


                            <div class="tariff-item">

                                <div class="tariff-number">
                                    02
                                </div>

                                <div class="tariff-details">

                                    <h5>Next 100 Units</h5>

                                    <p>51 – 150 units</p>

                                </div>

                                <div class="tariff-rate">

                                    ₹4.00

                                    <small>/ unit</small>

                                </div>

                            </div>


                            <div class="tariff-item">

                                <div class="tariff-number">
                                    03
                                </div>

                                <div class="tariff-details">

                                    <h5>Next 100 Units</h5>

                                    <p>151 – 250 units</p>

                                </div>

                                <div class="tariff-rate">

                                    ₹5.20

                                    <small>/ unit</small>

                                </div>

                            </div>


                            <div class="tariff-item">

                                <div class="tariff-number">
                                    04
                                </div>

                                <div class="tariff-details">

                                    <h5>Above 250 Units</h5>

                                    <p>251+ units</p>

                                </div>

                                <div class="tariff-rate">

                                    ₹6.50

                                    <small>/ unit</small>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            <?php if ($bill > 0) { ?>

            <!-- Result Section -->

            <div class="result-card">

                <div class="result-header">

                    <div>

                        <span class="result-label">
                            BILL CALCULATION
                        </span>

                        <h2>
                            Hello, <?php echo htmlspecialchars($name); ?>!
                        </h2>

                    </div>

                    <div class="success-icon">

                        <i class="fa-solid fa-check"></i>

                    </div>

                </div>


                <div class="total-bill">

                    <p>Total Electricity Bill</p>

                    <h1>
                        ₹<?php echo number_format($bill, 2); ?>
                    </h1>

                    <span>
                        <?php echo $units; ?> units consumed
                    </span>

                </div>


                <!-- Breakdown -->

                <div class="breakdown-section">

                    <h4>
                        <i class="fa-solid fa-receipt"></i>

                        Bill Breakdown
                    </h4>


                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>Slab</th>

                                    <th>Units</th>

                                    <th>Rate</th>

                                    <th class="text-end">
                                        Amount
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php foreach ($breakdown as $item) { ?>

                                    <tr>

                                        <td>
                                            <?php echo $item["slab"]; ?>
                                        </td>

                                        <td>
                                            <?php echo $item["units"]; ?>
                                        </td>

                                        <td>
                                            ₹<?php echo number_format($item["rate"], 2); ?>
                                        </td>

                                        <td class="text-end">

                                            ₹<?php echo number_format($item["amount"], 2); ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>


                            <tfoot>

                                <tr>

                                    <th colspan="3">
                                        Total
                                    </th>

                                    <th class="text-end">

                                        ₹<?php echo number_format($bill, 2); ?>

                                    </th>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

            <?php } ?>


            <!-- Footer -->

            <<div class="footer-text">

                <div class="student-name">
                    Sarthak Changdeo Markad
                </div>

                <div class="student-details">
                    <span>Roll No: 02</span>
                    <span>•</span>
                    <span>CS-H-1</span>
                    <span>•</span>
                    <span>12411896</span>
                </div>

                <div class="project-tech">
                    <i class="fa-solid fa-bolt"></i>
                    PowerBill — PHP, Bootstrap & jQuery
                </div>

            </div>

        </div>

    </div>

</main>


<!-- jQuery -->

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<!-- Custom JavaScript -->

<script src="js/script.js"></script>

</body>

</html>