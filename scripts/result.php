<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuzzy Sugeno Server Performance Result</title>
</head>
<link rel="stylesheet" href="assets/styleResult.css">

<body>
    <div class="container">
        <h1>Server Performance Result</h1>
        <?php
        if (isset($_GET['value']) && isset($_GET['category'])) {
            $value = htmlspecialchars($_GET['value']);
            $category = htmlspecialchars($_GET['category']);
            $debug = isset($_GET['debug']) ? urldecode($_GET['debug']) : "";

            if ($value === "null") {
                echo "<p>The result is undefined. Please make sure the input values are within the expected ranges.</p>";
            } else {
                
                echo "<p>The server usage evaluation result is ";
                if ($category == "critical") {
                    echo "more than : ";
                } elseif ($category == "warning") {
                    echo "average : ";
                } else {
                    echo "light :";
                }
                echo "$value</p>";
                echo "<p>Category: $category</p>";
                echo "<p>Recomendation : </p>";
                if ($category == "critical") {
                    echo "<p>1. Check the server's memory usage, CPU usage, storage usage, and network usage.</p>";
                    echo "<p>2. Upgrade your server immediately.</p>";
                    echo "<p>3. Check the server's storage usage and network usage.</p>";
                } elseif ($category == "warning") {
                    echo "<p>1. Check the server's response time, if it is slow, it is recommended to check the server's memory usage, CPU usage, storage usage, and network usage.</p>";
                    echo "<p>2. Prepare to upgrade your server.</p>";
                } elseif ($category == "normal"){
                    echo "<p>1. Your server is on good conditions.</p>";
                    echo "<p>2. Slow response time may caused by parallel client request. Just burst.</p>";
                }
            }

            if ($debug) {
                echo "<div>$debug</div>";
            }
        } else {
            echo "<p>No result found.</p>";
        }
        ?>
        <a href="../index.php">Evaluate Another</a>
    </div>
</body>

</html>