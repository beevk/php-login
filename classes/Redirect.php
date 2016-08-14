<?php 
	class Redirect {
		public static function to($location = null) {
			if($location) {
				if(!is_nan($location)) {
						switch ($location) {
							case 404:
								header('HTTP/1.0 404 not Found');
								include 'includes/errors/404.php';
								exit();
								break;
							
						}
				}
				header('Location: ' . $location);
				exit();
			}
		}
	}
 ?> 
