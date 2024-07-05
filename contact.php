<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stationery Stash Online Shop</title>
    <link rel="stylesheet" href="loginStyle.css">
    <link rel="stylesheet" href="mystyle.css">
    <style>
        body {
            overflow: visible;
        }

        .contact-container {
            margin: 20px auto;
            width: 400px;
            background-color: lavenderblush;
            border-radius: 10px;
            padding: 20px;
        }

        .contact-container h1 {
            text-align: center;
            padding: 0 0 20px 0;
            color: darkblue;
            border-bottom: 1px solid silver;
        }

        .contact-container form {
            padding: 0 20px;
            box-sizing: border-box;
        }

        .contact-container.txt_field {
            position: relative;
            border-bottom: 2px solid lightgreen;
            margin: 30px 0;
        }

        .txt_field select {
            width: 100%;
            padding: 0;
            height: 40px;
            font-size: 16px;
            border: none;
            background: none;
            outline: none;
            color: skyblue;
            font-family: fantasy;
            letter-spacing: 2px;
        }

        .txt_field select option {
            color: skyblue;
        }

        .txt_field textarea {
            width: 100%;
            padding: 0 5px;
            height: 100px;
            font-size: 16px;
            border: none;
            background: none;
            outline: none;
            resize: none;
        }

        .txt_field textarea:focus+label {
            top: -30px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <?php include('navigation.php'); ?>
    <div class="contact-container">

        <h1>Contact Us</h1>
        <?php if (isset($error)) : ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php
        if (isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
            $conn = mysqli_connect('localhost', 'root', '', 'stationery');

            if (!$conn) {
                die('Connection failed: ' . mysqli_connect_error());
            }

            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            $sql = "INSERT INTO contact (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

            if (mysqli_query($conn, $sql)) {
                echo "<p class='success-message'>Message sent successfully</p>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);
        }
        ?>

        <form action="" method="post">
            <div class="txt_field">
                <input type="text" name="name" id="name" required>
                <label for="name">Name</label>
                <span></span>
            </div>
            <div class="txt_field">
                <input type="email" name="email" id="email" required>
                <label for="email">Email</label>
                <span></span>
            </div>
            <div class="txt_field">
                <select type="text" name="subject" id="subject" required>
                    <option value="">Select Subject</option>
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Order Inquiry">Order Inquiry</option>
                    <option value="Feedback">Feedback</option>
                    <option value="Other">Other</option>
                </select>
                <span></span>
            </div>
            <div class="txt_field">
                <textarea name="message" id="message" rows="4" required></textarea>
                <label for="message" style="top: -10px">Message</label>
                <span></span>
            </div>
            <input type="submit" name="submit" value="Send">
        </form>
        <div class="link">
            <a href="index.php">Back to Home</a>
        </div>
        <div class="error-message"></div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>