<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPassword'])) {
        $username = $_POST['username'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        $filename = "users/" . $username . ".txt";

        if (file_exists($filename)) {
            $userInfo = file_get_contents($filename);
            $lines = explode("\n", $userInfo);

            foreach ($lines as $line) {
                if (strpos($line, 'Password:') !== false) {
                    $userPassword = trim(str_replace('Password:', '', $line));
                    if (!password_verify($oldPassword, $userPassword)) {
                        $_SESSION['passwordChangeStatus'] = "Old password is incorrect";
                        header('Location: profile.php');
                        exit();
                    }
                }
            }

            if ($newPassword !== $confirmPassword) {
                $_SESSION['passwordChangeStatus'] = "New password and confirmation password do not match";
                header('Location: profile.php');
                exit();
            }

            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Replace the old password hash with the new one
            $newUserInfo = str_replace("Password: " . $userPassword, "Password: " . $hashedNewPassword, $userInfo);
            file_put_contents($filename, $newUserInfo);

            $_SESSION['passwordChangeStatus'] = "Password has been changed successfully";
            header('Location: index.php');
            exit();
        }
    }
}
