<?php
require_once('database.php');
session_start();

if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = $db->query($sql);
$row = $result->fetchArray(SQLITE3_ASSOC);

if (isset($_POST['logout']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

$clients = "SELECT * FROM clients";
$clients_result = $db->query($clients);

if (isset($_GET['view'])) {
    $client_id = $_GET['view'];

    $view_result = $db->query("SELECT * FROM clients WHERE id = $client_id");
    $client_data = $view_result->fetchArray(SQLITE3_ASSOC);
}

if (isset($_GET['edit'])) {
    $client_id = $_GET['edit'];

    $edit_result = $db->query("SELECT * FROM clients WHERE id = $client_id");
    $client_data = $edit_result->fetchArray(SQLITE3_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body-dashboard">
    <nav class="dashboard-nav">
        <h3>Photography Management System</h3>
        <div class="user-info">
            <h5><?php echo $row['name'] ?></h5>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <input class="logout-btn" type="submit" name="logout" value="Logout">
            </form>
        </div>
    </nav>

    <main class="dashboard-main">
        <aside class="sidebar">
            <a href="">
                <div class="sidebar-item selected">
                    <p>Clients</p>
                </div>
            </a>
            <a href="">
                <div class="sidebar-item">
                    <p>Projects</p>
                </div>
            </a>
        </aside>

        <section class="content">

            <?php if (isset($_GET['edit']) && $client_data): ?>

                <div class="client-edit">
                    <h2>Edit Client</h2>
                    <form action="update_client.php" method="POST">
                        <input type="hidden" name="client_id" value="<?php echo $client_data['id']; ?>">
                        <label for="client-name">Client Name:</label>
                        <input type="text" id="client-name" name="client_name" value="<?php echo $client_data['client_name']; ?>" required>
                        <input type="submit" value="Update Client" class="btn-submit">
                    </form>
                    <a href="dashboard.php"><button class="btn-back">Back to Clients</button></a>
                </div>

            <?php elseif (isset($_GET['view']) && $client_data): ?>

                <div class="client-view">
                    <h2>View Client Details</h2>
                    <p><strong>Client Name:</strong> <?php echo $client_data['client_name']; ?></p>
                    <a href="dashboard.php"><button class="btn-back">Back to Clients</button></a>
                </div>

            <?php else: ?>

                <div class="clients-container">
                    <div class="add-client-container">
                        <form action="add_client.php" method="POST">
                            <label for="client-name">Client Name:</label>
                            <input type="text" id="client-name" name="client_name" placeholder="Enter Client Name" required>
                            <input type="submit" value="Add Client" class="btn-submit">
                        </form>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Client Name</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 1;
                                while ($client_row = $clients_result->fetchArray(SQLITE3_ASSOC)) {
                                    echo "<tr>
                                <td>{$index}.</td>
                                <td>{$client_row['client_name']}</td>
                                <td>
                                    <a href='dashboard.php?view={$client_row['id']}'>
                                        <button class='btn-view'>View</button>
                                    </a>
                                    <a href='dashboard.php?edit={$client_row['id']}'>
                                        <button class='btn-edit'>Edit</button>
                                    </a>
                                    <a href='delete_client.php?id={$client_row['id']}'>
                                        <button class='btn-delete'>Delete</button>
                                    </a>
                                </td>
                            </tr>";
                                    $index++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php endif; ?>
        </section>
    </main>

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this client?</p>
            <button id="confirmBtn" class="btn-delete">Yes, Delete</button>
            <button id="cancelBtn" class="btn-cancel">Cancel</button>
        </div>
    </div>

    <script>
        deleteButtons = document.querySelectorAll('.btn-delete');

        if (deleteButtons) {
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const modal = document.getElementById('confirmModal');
                    modal.style.display = 'flex';

                    deleteLink = e.target.closest('a').getAttribute('href');
                    document.getElementById('confirmBtn').onclick = function() {
                        window.location.href = deleteLink;
                    }

                    document.getElementById('cancelBtn').onclick = function() {
                        modal.style.display = 'none';
                    }
                });
            });
        }
    </script>
</body>

</html>