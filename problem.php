<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Results</title>
  </head>
  <body>

    <?php
    // The start of the program
          $gender = "m";
          $son = 0;
          $daughter = 1;
          $father = "false";
          $mother = "false";
          $wife = 0;
          $husband = "false";
          $brothers = 0;
          $sisters = 0;
          $StepSiblingsMotherSide = 0;
          $uncles = 0;
          $x = 0;
        if (isset($_POST['submit'])) {
          $gender=$_POST['gender'];
          $son = $_POST['sons'];
          $daughter = $_POST['daughters'];
      		$wife = $_POST['wifes'];
          $husband=$_POST['husband'];
      		$brothers = $_POST['brothers'];
          $sisters = $_POST['sisters'];
      		$uncles = $_POST['uncles'];
          $StepSiblingsMotherSide = $_POST['siblings'];
          $father= $_POST['father'];
          $mother=$_POST['mother'];
          $x=$_POST['money'];
        }

    		// Shares

    		$sonShare = 0;
        $daughterShare = 0;
    	  $fatherShare = 0;
        $motherShare = 0;
    		$wifeShare = 0;
        $husbandShare = 0;
    		$brothersShare = 0;
        $sistersShare = 0;
    	  $StepSiblingsMotherSideShare = 0;
    		$unclesShare = 0;

    		// T	.	H	.	E			F	.	A	.	R	.	D			S	.	H	.	A	.	R	.	E

    		// Daughters Share
    		if($son === 0) {
    			// 1 daughter Share
    			if($daughter === 1) {
    			$daughterShare = 1.0/2;
        }else if($daughter > 1){
    			// more than one daughter Share
    			$daughterShare = 2.0/3;
    		  $daughterShare = $daughterShare/$daughter;
    			}
    		}


    		// Husband Share

    		if($husband == "true") {
    			// Husband without kids
    			if($son+$daughter == 0) {
    			$husbandShare = 1.0/2;
    			}else {
    			// Husband with kids
    			$husbandShare = 1.0/4;
    			}
    		}

    		// Wife Share

    		if($wife>0) {
    			// Wife without children
    			if($son+$daughter === 0) {
    			$wifeShare = (1.0/4)/$wife;
    			}else {
    			$wifeShare = (1.0/8)/$wife;
    			}
    		}

    		// Parents Share
    					// parents with kids
    				if ($son+$daughter >0) {

    					if($father == "true") {
    					$fatherShare = 1.0/6;
    					}
    					if($mother == "true") {
    					$motherShare = 1.0/6;
    					}

    					// parents without kids
    				}else{
    					// parents with siblings
    					if($brothers+$sisters+$StepSiblingsMotherSide > 1) {
    						if($mother == "true") {
    						$motherShare = 1.0/6;
    						}

    					// parents without siblings
    					}else {
    						if(($husband == "true"|| $wife>0) && $brothers+$sisters+$StepSiblingsMotherSide == 0 ){

    							// The Omar's Questions
    							if($mother == "true") {
    							$motherShare =( (1-$husbandShare-$wifeShare*$wife) ) * (1.0/3);
    							}

    						}else {
    							if($mother == "true") {
    							$motherShare = 1.0/3;
    							}

    						}
    					}
    				}

    		// Step Siblings Mother Side Share

    		if($father == "false" && $son+$daughter === 0) {
    			if($StepSiblingsMotherSide === 1) {
            $StepSiblingsMotherSideShare = 1.0/6;
    			}else if($StepSiblingsMotherSide > 1){
    				$StepSiblingsMotherSideShare = (1.0/3)/$StepSiblingsMotherSide;
    			}
    		}



    		// Sisters Share
    		if($father == "false" && $brothers === 0 && $daughter+$son === 0 && $sisters === 1) {
    			$sistersShare = 1.0/2;
    		}else if($father == "false" && $brothers === 0 && $daughter+$son === 0 && $sisters >1){
    			$sistersShare = (2.0/3)/$sisters;
    		}





    		// Calculate the remainder

    		$sumOfFards = ($daughterShare*$daughter) + $motherShare + $fatherShare + $husbandShare + ($wifeShare*$wife)
    							+ ($StepSiblingsMotherSideShare*$StepSiblingsMotherSide) + ($sistersShare*$sisters);



    			//			T	.	H	.	E			O	.	V	.	E	.	R	.	F	.	L	.	O	.	W

    		if($sumOfFards === 1 && $StepSiblingsMotherSide>0 && $brothers > 0 && $brothersShare === 0) {
    			$StepSiblingsMotherSideShare = (1.0/3)/($StepSiblingsMotherSide+$brothers);
    			$brothersShare = $StepSiblingsMotherSideShare;

    		}

    		if($sumOfFards>1) {
    			$daughterShare = $daughterShare/$sumOfFards;
    			$motherShare = $motherShare/$sumOfFards;
    			$fatherShare = $fatherShare/$sumOfFards;
    			$husbandShare = $husbandShare/$sumOfFards;
    			$wifeShare = $wifeShare/$sumOfFards;
    			$StepSiblingsMotherSideShare = $StepSiblingsMotherSideShare/$sumOfFards;
    			$sistersShare = $sistersShare/$sumOfFards;

    		}else

    			//			T	.	H	.	E			A	.	S	.	A	.	B			S	.	H	.	A	.	R	.	E



    		// The sons and daughters
    		if((1-$sumOfFards)>0) {
    			if($son > 0 && $daughter > 0) {
    				$kidsShare = 0;
    				$kidsShare =( $son * 2 ) + ($daughter);
    				$daughterShare = (1-$sumOfFards)/$kidsShare;
    				$sonShare = $daughterShare*2;

    			}else if($son > 0 && $daughter == 0) {
    				// only sons Share
    				$sonShare = (1-$sumOfFards)/$son;
    			}else if($father == "true") {
    				// father share
    				$fatherShare = $fatherShare + (1-$sumOfFards);
    			}else if($brothers > 0 && $sisters > 0) {
    				// Siblings Share
    				$SiblingsShare = 0;
    				$SiblingsShare =( $brothers * 2 ) + ($sisters);
    				$sistersShare = (1-$sumOfFards)/$SiblingsShare;
    				$brothersShare = $sistersShare*2;

    			}else if($brothers > 0 && $sisters === 0) {
    				// only sons Share
    				$brothersShare = (1-$sumOfFards)/$brothers;
    			}else if($sisters > 0 && $daughter > 0) {
    				// sisters with daughters Share
    				$sistersShare = (1-$sumOfFards)/$sisters;
    			}else if($uncles>0){
    				$unclesShare = (1-$sumOfFards)/$uncles;
    			}else {


    				// A	.	L	.	R	.	A	.	D

    					if($wife==0 && $husband == "false") {
    						$daughterShare = $daughterShare/$sumOfFards;
    						$motherShare = $motherShare/$sumOfFards;
    						$StepSiblingsMotherSideShare = $StepSiblingsMotherSideShare/$sumOfFards;
    						$sistersShare = $sistersShare/$sumOfFards;
    					}else if($wife > 0 or $husband == "true") {
    						$remain = 1 - ($husbandShare + $wifeShare*$wife);
    						$sumOfFards = ($daughterShare*$daughter) + $motherShare
    								+ ($StepSiblingsMotherSideShare*$StepSiblingsMotherSide) + ($sistersShare*$sisters);
    						$daughterShare = $daughterShare/$sumOfFards;
    						$motherShare = $motherShare/$sumOfFards;
    						$StepSiblingsMotherSideShare = $StepSiblingsMotherSideShare/$sumOfFards;
    						$sistersShare = $sistersShare/$sumOfFards;
    						$daughterShare = $daughterShare*$remain;
    						$motherShare = $motherShare*$remain;
    						$StepSiblingsMotherSideShare = $StepSiblingsMotherSideShare*$remain;
    						$sistersShare = $sistersShare*$remain;

    					}




    			}
    		}



    		// Test Result
  		  echo "The Shares will be as follows :";
        echo "<br>";
    		if($father == "true") {
    			echo"father Share = ".($fatherShare*$x)." $";
          echo "<br>";

    		}
    		if($mother == "true") {
          echo"mother Share = ".($motherShare*$x)." $";
          echo "<br>";

    		}
    		if($son>0) {
          echo"son Share = ".($sonShare*$x)." $";
          echo "<br>";

    		}
    		if($daughter>0) {
          echo"daughter Share = ".($daughterShare*$x)." $";
          echo "<br>";

    		}
    		if($husband == "true") {
          echo"husband Share = ".($husbandShare*$x)." $";
          echo "<br>";

    		}
    		if($wife>0) {
          echo"wife Share = ".($wifeShare*$x)." $";
          echo "<br>";

    		}
    		if($StepSiblingsMotherSide>0) {
          echo"step brother/sister (Mother-Side) Share = ".($StepSiblingsMotherSideShare*$x)." $";
          echo "<br>";

    		}
    		if($brothers>0) {
          echo"brother Share = ".($brothersShare*$x)." $";
          echo "<br>";

    		}
    		if($sisters>0) {
          echo"sisters Share = ".($sistersShare*$x)." $";
          echo "<br>";

    		}
    		if($uncles>0) {
          echo"uncles Share = ".($unclesShare*$x)." $";
          echo "<br>";

    		}


      function CheckGender($c){
        if($c != 'm' && $c != 'f'){
          echo "Error in Gender Check";
        }
      }
    	function CheckAlive($c) {
    		if ($c != 'n' && $c != 'y') {
    			echo"Character Not Valid !!";
    		}
    	}
      function CheckValid($n){
        if($n < 0){
          echo "Not Valid Number !!";
        }
      }
      function CheckValidWife($n){
        if($n < 0 || $n > 4){
          echo "Number Not Valid !!";
        }
      }

      function CheckValidMoney($n){
        if($n<0){
          echo "Number Not Valid !!";
        }
      }
?>



  </body>
</html>
