<?php
session_start();

$accepted_type = array("image/png", "image/jpg", "image/jpeg", "image/gif");

$php_file_errors = [
	0 => "There is no error, the file uploaded with success.",
	1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
	2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
	3 => "The uploaded file was only partially uploaded.",
	4 => "No file was uploaded.",
	6 => "Missing a temporary folder. Introduced in PHP 5.0.3.",
	7 => "Failed to write file to disk. Introduced in PHP 5.1.0.",
	8 => "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0."
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['saveProfile'])) {
		$username = $_SESSION['username'];
		$filename = "users/" . $username . ".txt";
		$avatarDirectory = "avatars/";

        // User data
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
		$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$avatar = isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0 ? $_FILES['avatar'] : null;

		if ($avatar !== null) {
			$image_size = $avatar['size'];
			$image_type = $avatar['type'];

			if ($image_size < 1024000) {
				if (in_array($image_type, $accepted_type)){
					$extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
					$avatarFilename = $username . '.' . $extension;
					$targetFile = $avatarDirectory . $avatarFilename;

					// If an old avatar exists, delete it
					foreach (glob($avatarDirectory . $username . '.*') as $oldAvatarFile) {
						unlink($oldAvatarFile);
					}

					// Move the uploaded file, this will overwrite if the filename is the same (which won't happen because we deleted it)
					if (move_uploaded_file($avatar['tmp_name'], $targetFile)) {
						$message = "Congrats, image file was saved";
						$messageType = 'success';
					} else {
						$message = "Sorry, the image could not be saved.";
						$messageType = 'error';
					}

				} else {
					$message = "Sorry, not accepted file type";
					$messageType = 'error';
				}

			} else {
				$message = "Sorry, image size is too big for my server";
				$messageType = 'error';
			}
			
		}

		$messageType = "Succes";
		$message = "You profile was updated with success";

        // Update user data in the text file
		$newData = [
			'Gender: ' . $gender,
			'First Name: ' . $firstName,
			'Last Name: ' . $lastName,
			'Age: ' . $age,
			'Avatar: ' . $avatarFilename,
		];
		file_put_contents($filename, implode("\n", $newData));

		header('Location: index.php?msgType=' . $messageType . '&msg=' . $message);
	}
}
