<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	
	require_once($src.'libs/medoo/medoo.php');
	
	require_once($data.'database.php');
	
	require_once($src.'auth/authenticate.php');
	
	
	
	
	if ($_POST['fullName'] != $you['name']) {
		
		// Update Player Name
		$database->update('players',
		
			[
				'name' => $_POST['fullName']
			],
			
			[
				'id' => $you['name']
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
		
		// /Library/WebServer/Documents/bandit/upload/player-photo/player1-20160113231521.png
		$newFilePath				= $playerPhotoDirectory . 'player' . $you['id'] . '-' . date('YmdHis') . '.' . $uploadedPhotoFiletype;
		
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
			    
		        // Update Player Photo Path
				$database->update('players',
				
					[
						'photo' => $newFileName
					],
					
					[
						'id' => $you['id']
					]
					
				);
				
				header('Location: /');
		        
		        
		    } else {
			    
		        echo 'Sorry, there was an error uploading your file.';
		        
		    }
		}
	
	}
	
?>