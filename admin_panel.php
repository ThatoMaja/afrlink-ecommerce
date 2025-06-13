<?php
session_start();
include 'includes/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['email'] !== 'admin@afrilink.com') {
    echo "Access denied.";
    exit();
}

// Fetch users
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");

// Fetch all orders
$orders = mysqli_query($conn, "SELECT o.*, u.full_name AS buyer_name, p.title 
                               FROM orders o 
                               JOIN users u ON o.buyer_id = u.id 
                               JOIN products p ON o.product_id = p.id 
                               ORDER BY o.created_at DESC");

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");


$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
                             
?>

<?php include 'includes/back_button.php'; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Afrilink</title>
    <style>
        body {
            font-family: Arial;
            padding: 40px;
            background: #f0f0f0;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background:rgb(24, 76, 153);
            color: white;
        }
        .section {
            margin-bottom: 60px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>

    <h1>👑 Afrilink Admin Panel</h1>

    <div style="display: flex; gap: 30px; margin: 20px 0;">
        <div style="background:#088178;color:#fff;padding:20px;border-radius:8px;flex:1;text-align:center;">
            <h2><?php echo $total_users; ?></h2>
            <p>Total Users</p>
        </div>
        <div style="background:#ba4593;color:#fff;padding:20px;border-radius:8px;flex:1;text-align:center;">
            <h2><?php echo $total_products; ?></h2>
            <p>Total Products</p>
        </div>
        <div style="background:#444;color:#fff;padding:20px;border-radius:8px;flex:1;text-align:center;">
            <h2><?php echo $total_orders; ?></h2>
            <p>Total Orders</p>
        </div>
    </div>

    <div style="margin: 50px 0;">
        <h2 style="text-align:center;">📊 Platform Analytics</h2>
        <canvas id="orderStatusChart" style="max-width:700px;margin:auto;"></canvas>
        <br><br>
        <canvas id="revenueChart" style="max-width:700px;margin:auto;"></canvas>
    </div>



    <h1>👑 Afrilink Admin Panel</h1>

    <div class="section">
        <h2>📋 All Users</h2>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Registered</th>
            </tr>
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><?php echo $u['full_name']; ?></td>
                    <td><?php echo $u['email']; ?></td>
                    <td><?php echo $u['phone']; ?></td>
                    <td><?php echo ucfirst($u['role']); ?></td>
                    <td><?php echo $u['created_at']; ?></td>
                    <td>
                        <?php if ($u['email'] !== 'admin@afrilink.com'): ?>
                            <a href="delete_user.php?id=<?php echo $u['id']; ?>" 
                            style="color:red;" 
                            onclick="return confirm('Are you sure you want to delete this user?');">
                            🗑️ Delete
                            </a>
                        <?php else: ?>
                            🔒
                        <?php endif; ?>
                    </td>
                </tr>

            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
        <h2>📦 All Orders</h2>
        <table>
            <tr>
                <th>Order ID</th><th>Buyer</th><th>Product</th><th>Status</th><th>Date</th>
            </tr>
            <?php while ($o = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td><?php echo $o['id']; ?></td>
                    <td><?php echo $o['buyer_name']; ?></td>
                    <td><?php echo $o['title']; ?></td>
                    <td>
                        <form method="POST" action="update_order_status.php">
                            <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                            <select name="status" onchange="this.form.submit()" style="padding:5px;">
                                <option value="pending" <?php if ($o['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                <option value="shipped" <?php if ($o['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                                <option value="delivered" <?php if ($o['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                            </select>
                        </form>
                    </td>

                    <td><?php echo $o['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
    <h2>🛍️ All Products</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th>Seller ID</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><?php echo $p['title']; ?></td>
                <td>R<?php echo number_format($p['price'], 2); ?></td>
                <td><?php echo $p['seller_id']; ?></td>
                <td><?php echo ucfirst($p['status']); ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $p['id']; ?>">✏️ Edit</a> |
                    <a href="delete_product.php?id=<?php echo $p['id']; ?>" 
                       onclick="return confirm('Delete this product?');" 
                       style="color:red;">🗑️ Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<script>
fetch('chart_data.php')
    .then(res => res.json())
    .then(data => {
        // Order Status Chart
        const ctx1 = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: data.statuses,
                datasets: [{
                    label: '# of Orders',
                    data: data.counts,
                    backgroundColor: ['#ba4593', '#088178', '#ffce56'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Revenue Chart
        const ctx2 = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Revenue (R)'],
                datasets: [{
                    label: 'Total Revenue',
                    data: [data.revenue],
                    backgroundColor: ['#4caf50'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>


</body>
</html>
