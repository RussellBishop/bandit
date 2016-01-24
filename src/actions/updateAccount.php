<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	
	require_once($src.'libs/medoo/medoo.php');
	
	require_once($data.'database.php');
	
	require_once($src.'auth/authenticate.php');



	if (!empty($_POST['fullName'])) {

		$database->update('players',
		
			[
				'name' => $_POST['fullName']
			],
			
			[
				'id' => $you['id']
			]
			
		);

	}

	if (!empty($_POST['email'])) {

		$database->update('players',
		
			[
				'email' => $_POST['email']
			],
			
			[
				'id' => $you['id']
			]
			
		);

	}

	if (!empty($_POST['password'])) {

		$database->update('players',
		
			[
				'password' => $_POST['password']
			],
			
			[
				'id' => $you['id']
			]
			
		);

	}

	if (!empty($_FILES['player-photo']['name'])) {
		
		// crop1.png
		$uploadedPhoto				= basename($_FILES['player-photo']['name']);
		
		// png
		$uploadedPhotoFiletype		= pathinfo($uploadedPhoto, PATHINFO_EXTENSION);
		
		// /var/path/to/upload/player-photo/
		$playerPhotoDirectory		= $root.'upload/player-photo/';
		
		// player1-20160113231521.png
		$newFileName				= 'player' . $you['id'] . '-' . date('YmdHis') . '.' . $uploadedPhotoFiletype;
		$thumbFileName				= 'thumb-' . $newFileName;
		
		// /Library/WebServer/Documents/bandit/upload/player-photo/player1-20160113231521.png
		$newFilePath				= $playerPhotoDirectory . $newFileName;
		$thumbFilePath				= $playerPhotoDirectory . $thumbFileName;
		
		// Upload is OK
		$uploadOk					= 1;
		
		// Check if image file is a actual image or fake image
		if(isset($_POST['submit'])) {
			
		    $check = getimagesize($_FILES['player-photo']['tmp_name']);
		    
		    if($check !== false) {
			    
		        echo 'File is an image - ' . $check['mime'] . '.';
		        $uploadOk = 1;
		        
		    }
		    
		    else {
			    
		        echo 'File is not an image.';
		        $uploadOk = 0;
		        
		    }
		    
		}
		
		// Check file size
		if ($_FILES['player-photo']['size'] > 1000000) {
			
		    echo 'Sorry, your file is too large.';
		    $uploadOk = 0;
		    
		}
		
		// Allow certain file formats
		if($uploadedPhotoFiletype != 'jpg' && $uploadedPhotoFiletype != 'png' && $uploadedPhotoFiletype != 'jpeg' && $uploadedPhotoFiletype != 'gif' ) {
			
		    echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
		    $uploadOk = 0;
		    
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			
		    echo 'Sorry, your file was not uploaded.';
		    
		
		}
		
		// if everything is ok, try to upload file
		else {
			
		    if (move_uploaded_file($_FILES['player-photo']['tmp_name'], $newFilePath)) {

		    	// Include the class
				include($functions.'photoResize.php');

				// 1) Initialise / load image
				$resizeObj = new resize($newFilePath);

				// 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$resizeObj -> resizeImage(170, 170, 'crop');

				// 3) Save image
				$resizeObj -> saveImage($thumbFilePath, 100);

		        // Update Player Photo Path
				$database->update('players',
				
					[
						'photo' => $thumbFileName
					],
					
					[
						'id' => $you['id']
					]
					
				);

				// Delete the fullsize image
				unlink($newFilePath);
		        
		    } else {
			    
		        echo 'Sorry, there was an error uploading your file.';
		        
		    }
		}
	
	}

	header('Location: /');
	
?>