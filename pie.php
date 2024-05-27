<?php
require('dbConfig.php');

// Query to count occurrences of each product ID
$sql = "SELECT od.productId, p.productName, COUNT(*) AS productCount 
        FROM orders_detail od 
        INNER JOIN product p ON od.productId = p.productId 
        GROUP BY od.productId 
        ORDER BY productCount DESC 
        LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->execute();
$productData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the pie chart
$productLabels = [];
$productCounts = [];
foreach ($productData as $product) {
    $productLabels[] = $product['productName']; // Using productName instead of productId
    $productCounts[] = $product['productCount'];
}
$productLabels = json_encode($productLabels);
$productCounts = json_encode($productCounts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 50%;">
        <canvas id="productPieChart"></canvas>
    </div>

    <script>
        // Parse product labels and counts from PHP to JavaScript
        var productLabels = <?php echo $productLabels; ?>;
        var productCounts = <?php echo $productCounts; ?>;

        // Create pie chart
        var ctx = document.getElementById('productPieChart').getContext('2d');
        var productPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: productLabels,
                datasets: [{
                    label: 'Top 5 Products',
                    data: productCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'right'
                }
            }
        });
    </script>
</body>
</html>
<?php
echo phpversion();
?>