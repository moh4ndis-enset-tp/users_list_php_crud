<?php
// Start session to pass messages between requests
session_start();

// Database connection
$pdo = new PDO(
    "mysql: host=localhost;dbname=enset_2025",
    "root",
    ""
);

// Function to safely handle SQL operations
function executeSQL($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add user
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $role = $_POST['role'];
        
        $sql = "INSERT INTO users (name, email, pass, role) VALUES (?, ?, ?, ?)";
        executeSQL($sql, [$name, $email, $pass, $role]);
        
        $_SESSION['message'] = "User added successfully!";
        header('Location: /');
        exit;
    }
    
    // Update user
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = $_POST['idd'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $role = $_POST['role'];
        
        $sql = "UPDATE users SET name = ?, email = ?, pass = ?, role = ? WHERE idd = ?";
        executeSQL($sql, [$name, $email, $pass, $role, $id]);
        
        $_SESSION['message'] = "User updated successfully!";
        header('Location: /');
        exit;
    }
}

// Handle GET requests for delete and edit
if (isset($_GET['action'])) {
    // Delete user
    if ($_GET['action'] === 'delete' && isset($_GET['idd'])) {
        $id = $_GET['idd'];
        $sql = "DELETE FROM users WHERE idd = ?";
        executeSQL($sql, [$id]);
        
        $_SESSION['message'] = "User deleted successfully!";
        header('Location: /');
        exit;
    }
    
    // Edit user - fetch data
    if ($_GET['action'] === 'edit' && isset($_GET['idd'])) {
        $id = $_GET['idd'];
        $sql = "SELECT * FROM users WHERE idd = ?";
        $stmt = executeSQL($sql, [$id]);
        $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$editUser) {
            header('Location: /');
            exit;
        }
    }
}

// Fetch all users
$stmt = executeSQL("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Users Management</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['message'] ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($editUser)): ?>
            <!-- Edit User Form -->
            <div class="card bg-secondary mb-4">
                <div class="card-header">
                    <h3>Edit User</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="idd" value="<?= $editUser['idd'] ?>">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" value="<?= $editUser['name'] ?>" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="<?= $editUser['email'] ?>" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" name="pass" id="pass" value="<?= $editUser['pass'] ?>" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="guest" <?= ($editUser['role'] == 'guest') ? 'selected' : '' ?>>Guest</option>
                                <option value="author" <?= ($editUser['role'] == 'author') ? 'selected' : '' ?>>Author</option>
                                <option value="admin" <?= ($editUser['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="/" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- Add New User Form -->
            <div class="card bg-secondary mb-4">
                <div class="card-header">
                    <h3>Add New User</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" name="pass" id="pass" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="guest">Guest</option>
                                <option value="author">Author</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Add User</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Users List Table -->
        <div class="card bg-dark">
            <div class="card-header">
                <h3>Users List</h3>
            </div>
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th class="text-center" colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['idd'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['pass'] ?></td>
                                    <td><?= $user['role'] ?></td>
                                    <td class="text-center">
                                        <a href="?action=edit&idd=<?= $user['idd'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" onclick="confirmDelete(<?= $user['idd'] ?>)" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = '?action=delete&idd=' + id;
            }
        }
    </script>
</body>
</html>
