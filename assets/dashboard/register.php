<?php
session_start();
include 'db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Data validation
    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($username) < 3 || strlen($password) < 6) {
        $error = "Username must be at least 3 characters and password at least 6 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (!preg_match('/^[0-9]{8,15}$/', $phone)) {
        $error = "Invalid phone number.";
    } else {
        // Check if the user already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email or phone number is already in use.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $phone, $hashed);

            if ($stmt->execute()) {
                $success = "Account created successfully. You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "An error occurred while creating the account.";
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
<section class='signup-container'>
    <div class='wrapper'>
        <div class='signup-title'>Sign in to your account</div>
        <div class='login-page'>Don't have an account? <a href="signup.php">Get started</a></div>


        <form method="post">
            <div class="sub-container login-margin">
                <label for='username'>username</label>
                <input type="text" name="username" class='username' id='username' required>
            </div>

            <div class="sub-container login-margin">
                <label for='email'>Email address</label>
                <input type='email' class='email' name='email' id='email' required>
            </div>

            <div class="sub-container login-margin">
                <label for='phone'>phone</label>
                <input type='tel' class='phone' name='phone' id='phone' required>
            </div>

            <div class="sub-container login-margin">
    <label for='password'>password</label>
    <input type='password' class='email' name='password' id='password' required>
    <span class="password-svgs login-password" data-target="password">
  
    <svg xmlns="http://www.w3.org/2000/svg" class="password-close-svg" viewBox="0 0 24 24">
                        <path fill="var(--gray-color)" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001l.003.009l.021.045l.094.194c.086.172.219.424.4.729a13.4 13.4 0 0 0 1.67 2.237a12 12 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.7 8.7 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13 13 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14 14 0 0 1-.741 1.348a15.4 15.4 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a12 12 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.4 15.4 0 0 1-1.87-2.519a14 14 0 0 1-.591-1.107l-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"></path>
                    </svg>

    
 <svg xmlns="http://www.w3.org/2000/svg" class="password-open-svg" viewBox="0 0 24 24" style="display: block;">
                        <path fill="var(--gray-color)" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"></path>
                        <path fill="var(--gray-color)" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20s7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4S4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"></path>
                    </svg>
    </span>
</div>

<div class="sub-container">
    <label for='confirm'>confirm</label>
    <input type='password' class='confirm' name='confirm' id='confirm' placeholder='6+ characters' required>
    <span class="password-svgs login-password" data-target="confirm">
      <svg xmlns="http://www.w3.org/2000/svg" class="password-close-svg" viewBox="0 0 24 24">
                        <path fill="var(--gray-color)" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001l.003.009l.021.045l.094.194c.086.172.219.424.4.729a13.4 13.4 0 0 0 1.67 2.237a12 12 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.7 8.7 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13 13 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14 14 0 0 1-.741 1.348a15.4 15.4 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a12 12 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.4 15.4 0 0 1-1.87-2.519a14 14 0 0 1-.591-1.107l-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"></path>
                    </svg>

    
 <svg xmlns="http://www.w3.org/2000/svg" class="password-open-svg" viewBox="0 0 24 24" style="display: block;">
                        <path fill="var(--gray-color)" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"></path>
                        <path fill="var(--gray-color)" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20s7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4S4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"></path>
                    </svg>
    </span>
    <div class='message'></div>
</div>

<script>
    // التعامل مع جميع أيقونات العين
    document.querySelectorAll('.password-svgs').forEach(container => {
        const passwordInputId = container.getAttribute('data-target');
        const input = document.getElementById(passwordInputId);
        const closeSvg = container.querySelector('.password-close-svg');
        const openSvg = container.querySelector('.password-open-svg');

        closeSvg.addEventListener('click', () => {
            input.type = 'text';
            closeSvg.style.display = 'none';
            openSvg.style.display = 'block';
        });

        openSvg.addEventListener('click', () => {
            input.type = 'password';
            openSvg.style.display = 'none';
            closeSvg.style.display = 'block';
        });
    });
</script>

            

            <div class="sub-container">

        <?php if ($error): ?>
            <p style="color:red"><?= $error ?></p>
        <?php elseif ($success): ?>
            <p style="color:green"><?= $success ?></p>
        <?php endif; ?>
            </div>



            <button class='submit-button' type="submit" id='user-login-submit'>Sign in</button>

            <div class='seller-signup'>Wanna login in sellers account? <a href="seller-login">Get started</a></div>
            <div class='alternative'><span>OR</span></div>
        </form>

        <div class="social-signup">
                <div class="social-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="#FFC107" d="M21.8055 10.0415H21V10H12V14H17.6515C16.827 16.3285 14.6115 18 12 18C8.6865 18 6 15.3135 6 12C6 8.6865 8.6865 6 12 6C13.5295 6 14.921 6.577 15.9805 7.5195L18.809 4.691C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12C2 17.5225 6.4775 22 12 22C17.5225 22 22 17.5225 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z">
                        </path>
                        <path fill="#FF3D00" d="M3.15332 7.3455L6.43882 9.755C7.32782 7.554 9.48082 6 12.0003 6C13.5298 6 14.9213 6.577 15.9808 7.5195L18.8093 4.691C17.0233 3.0265 14.6343 2 12.0003 2C8.15932 2 4.82832 4.1685 3.15332 7.3455Z">
                        </path>
                        <path fill="#4CAF50" d="M12.0002 22C14.5832 22 16.9302 21.0115 18.7047 19.404L15.6097 16.785C14.5719 17.5742 13.3039 18.0011 12.0002 18C9.39916 18 7.19066 16.3415 6.35866 14.027L3.09766 16.5395C4.75266 19.778 8.11366 22 12.0002 22Z">
                        </path>
                        <path fill="#1976D2" d="M21.8055 10.0415H21V10H12V14H17.6515C17.2571 15.1082 16.5467 16.0766 15.608 16.7855L15.6095 16.7845L18.7045 19.4035C18.4855 19.6025 22 17 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z">
                        </path>
                    </svg>
                </div>
                <div class="social-svg">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <path fill="#1877F2" d="M15 8a7 7 0 00-7-7 7 7 0 00-1.094 13.915v-4.892H5.13V8h1.777V6.458c0-1.754 1.045-2.724 2.644-2.724.766 0 1.567.137 1.567.137v1.723h-.883c-.87 0-1.14.54-1.14 1.093V8h1.941l-.31 2.023H9.094v4.892A7.001 7.001 0 0015 8z">
                        </path>
                        <path fill="#ffffff" d="M10.725 10.023L11.035 8H9.094V6.687c0-.553.27-1.093 1.14-1.093h.883V3.87s-.801-.137-1.567-.137c-1.6 0-2.644.97-2.644 2.724V8H5.13v2.023h1.777v4.892a7.037 7.037 0 002.188 0v-4.892h1.63z">
                        </path>
                    </svg>
                </div>
                <div class="social-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M17.7242 3H20.779L14.1069 10.624L21.956 21H15.8117L10.9959 14.7087L5.49201 21H2.43288L9.56798 12.8438L2.04346 3H8.34346L12.692 8.75048L17.7242 3ZM16.6511 19.174H18.343L7.42182 4.73077H5.60451L16.6511 19.174Z">
                        </path>
                    </svg>
                </div>
            </div>
    </div>
</section>



</body>
</html>
