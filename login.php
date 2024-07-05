<?php
session_start();

if (isset($_SESSION['email'])) {
    $_SESSION['message'] = 'You are already logged in.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = mysqli_connect('localhost', 'root', '', 'stationery');

    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '" . md5($password) . "'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['email'] = $email;

        header('Location: account.php');
        exit();
    } else {
        $error = 'Invalid email or password.';
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="loginStyle.css">
    </link>
</head>

<body>
    <div class="center">
        <h1>Login</h1>
        <?php if (isset($_SESSION['message'])) : ?>
            <p class="success-message"><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($error)) : ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <div class="txt_field">
                <input type="email" name="email" required>
                <span></span>
                <label>Email: </label>
            </div>

            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Password: </label>
            </div>

            <input type="submit" value="Login">
            <div class="link">
                Not a member?<a href="create"> Create an account</a><br>
                Already Login<a href="index"> Go To Home Page</a><br>
                <a href="logout.php">Logout</a>
            </div>
        </form>
    </div>

</body>

</html>