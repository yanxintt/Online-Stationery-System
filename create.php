<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="loginStyle.css"></link>
    </head>
    <body>
        <div class = "center">
        <h1>Create Account</h1>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $conn = mysqli_connect('localhost', 'root', '', 'stationery');

            if(!$conn){
                die('Connection failed: ' .mysqli_connect_error());
            }

            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $checkQuery = "SELECT * FROM users WHERE email = '$email'";
            $checkResult = mysqli_query($conn, $checkQuery);

            if(mysqli_num_rows($checkResult) > 0){
                echo '<div class="error-message">Email already exists. Please use a different email.</div>';
            }else{
                $hashed_password = md5($password);
                $query = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
                if(mysqli_query($conn, $query)){
                    echo 'Account created successfully. ';
                    echo '<a href="login.php">Login here</a>';
                }else{
                    echo 'Error creating account: ' .mysqli_error($conn);
                }
            }
    
            mysqli_close($conn);
        }
        ?>
        <form method="POST">
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

        
        <input type="submit" value="Create Account">
        </form>
        <br>

    <div class="link">Already have an account?
        <a href="login.php">Click here to login</a><br><br>

    </div>

        </div>
    </body>
</html>
