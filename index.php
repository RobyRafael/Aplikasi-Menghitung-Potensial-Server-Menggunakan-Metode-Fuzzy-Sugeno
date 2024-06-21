<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuzzy Sugeno Server Performance</title>
    <!-- <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="number"] {
            width: 200px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style> -->
    <link rel="stylesheet" href="assets/styleHome.css">
</head>
<body>
    <h1>Server Performance Evaluation</h1>
    <form action="scripts/calculate.php" method="post">
        <label for="responseTime">Response Time:</label>
        <input type="number" id="responseTime" name="responseTime" required><br><br>

        <label for="memoryUsage">Memory Usage:</label>
        <input type="number" id="memoryUsage" name="memoryUsage" required><br><br>

        <label for="cpuUsage">CPU Usage:</label>
        <input type="number" id="cpuUsage" name="cpuUsage" required><br><br>

        <label for="storageUsage">Storage Usage:</label>
        <input type="number" id="storageUsage" name="storageUsage" required><br><br>

        <label for="networkUsage">Network Usage:</label>
        <input type="number" id="networkUsage" name="networkUsage" required><br><br>

        <div>
            <button type="submit">Calculate</button>
        </div>
    </form>
</body>
</html>
