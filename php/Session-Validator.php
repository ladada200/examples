<?php

    if (session_id() == '') {
        session_start();
    } else {
        if (!isset($_SESSION['password']) OR $_SESSION['password'] == null) {
            header("location /");   
        } elseif (!isset($_SESSION['username']) OR $_SESSION['username'] == null) {
            header("location /");
        } else {
            //intentionally left blank    
        }
        
        if (!isset($_SESSION['userAuthCrypt'])) {
            // THIS SECTION
            //should be used to compare the user's username 
            //and password against the database.
            
            $input = mt_rand(50,100);
            $getMe = ceil($input / 10 ) * 10;
            
            $firstDig = rand(1,5);
            
            $testIt = $getMe - $firstDig;
            
            $arraySet = array($firstDig,0);
            
            $setforNum = $testIt;
            for ($i=1; $i < 16; $i++) {
                $rando = rand(1,9);
                array_push($arraySet, $rando);
                $setforNum = $setforNum - $rando;
            }
            $newCCArr = array();
            $oldCCArr = array();
            array_push($oldCCArr, $firstDig);
            
            foreach(range(0, 15, 2) as $numbers) {
                if ($arraySet[$numbers]*2 > 9) {
                    $changedNum = $arraySet[$numbers]*2 - 9;
		            array_push($newCCArr, $changedNum);
                } else {
                    array_push($newCCArr, $arraySet[$numbers]);
                }
            }
            foreach(range(0,15,3) as $numbers) {
		        array_push($oldCCArr, $arraySet[$numbers]);
	    	}
		    
		    $result = array_merge($newCCArr, $oldCCArr);
		    $total = 0;
		    for ($i=0; $i < count($result); $i++) {
		        $total = $total + $result[$i];
		    }
		    if ($total % 10 != 0) {
		        $fixed = ceil($total / 10) * 10;
		        $numGrab = $fixed - $total;
		        array_push($result, $numGrab);
		    } else {
		        $fixed = $total;
		        array_push($result, "0");
		    }
		    
		    $gimmie = "";
		    
		    for ($i=0; $i < count($result); $i++) {
		        $gimmie .= $result[$i];
		    }
		    
		    function validate($data, $secondData, $password) {
		        $bdata = str_split($data);
		        $altChange = $secondData;
		        for ($i = 0; $i < count($bdata); $i++) {
		            $altChange = $altChange - $bdata[$i];
		            if ($altChange == 0 xor $bdata[$i] == 0) {
		                $cryptoSet = crypt($password, '$6$rounds=5000$' . $data . '$');
		                $grabbed = explode('$', $cryptoSet);
		                $_SESSION['key'] = $data;
		                $_SESSION['userAuthCrypt'] = $grabbed[4];
		            }
		        }
		    }
		    $alt = $fixed;
		    if (count(str_split($gimmie)) != 16) {
		        session_destroy();
		        header("location: /");
		    } else {
		        $password = $_SESSION['password'];
		        validate($gimmie, $salt, $password);
		        
		        /*
		         *  NOTE:
		         * +--------------------------------------------
		         * |
		         * |  $newLocation should be used to point
		         * |  the validated user to a different location.
		         * |
		         * +---------------------------------------------
		         */
		        
		        $newLocation = '';
		        
		        header('location: ' . $newLocation);
		    }
		    //IF THE USER MET ALL THE REQUIREMENTS;
        } elseif (isset($_SESSION['userAuthCrypt'])) {
            if (!isset($_SESSION['key']) OR !isset($_SESSION['password'])) {
                session_destroy();
                header("location: /");
                // This section is used because they're where they're not supposed to be.
                // So we kick them out entirely.
                
            } else {
                $key = $_SESSION['key'];
            	$password = $_SESSION['password'];
	            $grabbed = $_SESSION['userAuthCrypt'];

            	function validateAgain($data, $password, $grabbed) {

        			function modulusConfirm($data) {
        				$bdata = str_split($data);
        				$altChange = "";
            		    for ($i=0; $i < 16; $i++) {
            		        $altChange += $bdata[$i];
            		        if ($i == count($bdata) ) {
    							return $altChange;
	    					}
		                }
		    	}

			    if (modulusConfirm($data) % 10 == 0) {
					$cryptoSet = crypt($password, '$6$rounds=5000$'.$data.'$');
					$grabbedAgain = explode('$', $cryptoSet);
					if ($grabbedAgain[4] == $grabbed) {
						header("location: /admin/controllers/");
					} else {
						header("location: /");
					}
			    }
        	}

        	validateAgain($key, $password, $grabbed);
        }
        }   
    }

?>
