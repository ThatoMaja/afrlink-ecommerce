<?php
include 'includes/db.php';

// Get order status counts
$status_data = mysqli_query($conn, "
    SELECT status, COUNT(*) AS total 
    FROM orders 
    GROUP BY status
");

$statuses = [];
$counts = [];

while ($row = mysqli_fetch_assoc($status_data)) {
    $statuses[] = ucfirst($row['status']);
    $counts[] = (int)$row['total'];
}

// Total revenue
$revenue_query = mysqli_query($conn, "
    SELECT SUM(p.price) AS total 
    FROM orders o 
    JOIN products p ON o.product_id = p.id
    WHERE o.status = 'delivered'
");
$revenue = mysqli_fetch_assoc($revenue_query)['total'] ?? 0;

echo json_encode([
    'statuses' => $statuses,
    'counts' => $counts,
    'revenue' => $revenue ? floatval($revenue) : 1  // fallback dummy value

]);
?>
