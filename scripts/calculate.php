<?php
function membership($x, $a, $b, $c) {
    if ($x <= $a || $x >= $c) {
        return 0;
    } elseif ($x >= $a && $x <= $b) {
        return ($x - $a) / ($b - $a);
    } else {
        return ($c - $x) / ($c - $b);
    }
}

function fuzzySugeno($responseTime, $memoryUsage, $cpuUsage, $storageUsage, $networkUsage) {
    // Define fuzzy sets for each input variable
    $responseTimeLow = membership($responseTime, 0, 0, 40);
    $responseTimeMedium = membership($responseTime, 30, 50, 70);
    $responseTimeHigh = membership($responseTime, 60, 100, 100);

    $memoryUsageLow = membership($memoryUsage, 0, 0, 40);
    $memoryUsageMedium = membership($memoryUsage, 30, 50, 70);
    $memoryUsageHigh = membership($memoryUsage, 60, 100, 100);

    $cpuUsageLow = membership($cpuUsage, 0, 0, 40);
    $cpuUsageMedium = membership($cpuUsage, 30, 50, 70);
    $cpuUsageHigh = membership($cpuUsage, 60, 100, 100);

    $storageUsageLow = membership($storageUsage, 0, 0, 40);
    $storageUsageMedium = membership($storageUsage, 30, 50, 70);
    $storageUsageHigh = membership($storageUsage, 60, 100, 100);

    $networkUsageLow = membership($networkUsage, 0, 0, 40);
    $networkUsageMedium = membership($networkUsage, 30, 50, 70);
    $networkUsageHigh = membership($networkUsage, 60, 100, 100);

    // Define rules
    $rules = [
        'critical' => max(
            min($responseTimeHigh, $memoryUsageHigh),
            min($cpuUsageHigh, $storageUsageHigh),
            min($networkUsageHigh, $responseTimeHigh)
        ),
        'warning' => max(
            min($responseTimeMedium, $memoryUsageMedium),
            min($cpuUsageMedium, $storageUsageMedium),
            min($networkUsageMedium, $responseTimeMedium)
        ),
        'normal' => max(
            min($responseTimeLow, $memoryUsageLow),
            min($cpuUsageLow, $storageUsageLow),
            min($networkUsageLow, $responseTimeLow)
        ),
    ];

    // Output values for the Sugeno method
    $outputs = [
        'critical' => 80,
        'warning' => 50,
        'normal' => 20,
    ];

    $numerator = 0;
    $denominator = 0;

    // Detail output
    $debugInfo = "<h2>Calculation Details</h2>";
    $debugInfo .= "<p>Response Time Memberships: Low: $responseTimeLow, Medium: $responseTimeMedium, High: $responseTimeHigh</p>";
    $debugInfo .= "<p>Memory Usage Memberships: Low: $memoryUsageLow, Medium: $memoryUsageMedium, High: $memoryUsageHigh</p>";
    $debugInfo .= "<p>CPU Usage Memberships: Low: $cpuUsageLow, Medium: $cpuUsageMedium, High: $cpuUsageHigh</p>";
    $debugInfo .= "<p>Storage Usage Memberships: Low: $storageUsageLow, Medium: $storageUsageMedium, High: $storageUsageHigh</p>";
    $debugInfo .= "<p>Network Usage Memberships: Low: $networkUsageLow, Medium: $networkUsageMedium, High: $networkUsageHigh</p>";

    foreach ($rules as $key => $value) {
        $numerator += $value * $outputs[$key];
        $denominator += $value;
        $debugInfo .= "<p>Rule: $key, Value: $value, Output: {$outputs[$key]}</p>";
    }

    if ($denominator == 0) {
        return [
            'value' => null,
            'category' => "Undefined (All rules resulted in zero)",
            'debug' => $debugInfo
        ];
    }

    $output = $numerator / $denominator;

    // Determine the category based on the output value
    if ($output > 75) {
        $category = 'critical';
    } elseif ($output > 45) {
        $category = 'warning';
    } else {
        $category = 'normal';
    }

    return [
        'value' => $output,
        'category' => $category,
        'debug' => $debugInfo
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $responseTime = $_POST['responseTime'];
    $memoryUsage = $_POST['memoryUsage'];
    $cpuUsage = $_POST['cpuUsage'];
    $storageUsage = $_POST['storageUsage'];
    $networkUsage = $_POST['networkUsage'];

    $result = fuzzySugeno($responseTime, $memoryUsage, $cpuUsage, $storageUsage, $networkUsage);
    $outputValue = $result['value'];
    $category = $result['category'];
    $debugInfo = $result['debug'];

    header("Location: result.php?value=$outputValue&category=$category&debug=" . urlencode($debugInfo));
    exit();
}
?>
