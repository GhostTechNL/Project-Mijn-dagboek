<?php 
include __DIR__ ."/src/autoload.php";

$diary = new diary();
$user = new user();

session_start();
//if the error has been set display the information
$PASSWORD_ERROR = (isset($_SESSION['PASSWORD_ERROR'])) ? "display: block" : "";

if (!empty($_SESSION['id'])) { ?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<title>MijnDagboek.nl | Welkom</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" integrity>
	<link rel="stylesheet" type="text/css" href="css/diaryStyle.css" integrity>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js" integrity></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<header class="bg-flatgreen col py-1">
		<h5 class="float-left ml-2 mt-2">MijnDagboek</h5>
		<ul class="nav justify-content-end">
			<li class="nav-item">
				<a class="nav-link text-dark btn btn-light mr-2" id="btn-signin" href="forms/signout_form.php">Uitloggen</a>
			</li>
			<li class="nav-item">
				<button class="nav-link text-dark btn btn-light btn-account">Account</button>
			</li>
	    </ul>
	</header>
	<div class="container-fluid">
		<div class="eclipse" id="eclipse" style="<?php echo $PASSWORD_ERROR; ?>">
			<form class="p-2 form-account" action="forms/account_form.php" method="POST" style="display: none;">
				<h5 class="text-center">Account</h5>
				<div class="form-group form-row">
					<?php
					//=============== Account read & write ===============
					$userdata = $user->getUserInfo($_SESSION['id']);
					?>
					<div class="col">
						<label>Voornaam:</label>
						<input type="text" name="firstname" class="form-control" value="<?php echo $userdata['voornaam']; ?>">
					</div>
					<div class="col">
						<label>Tussenvoegsel:</label>
						<input type="text" name="insertion" class="form-control" value="<?php echo $userdata['tussenvoegsels']; ?>">
					</div>
					<div class="col">
						<label>Achternaam:</label>
						<input type="text" name="Lastname" class="form-control" value="<?php echo $userdata['achternaam']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label>E-mailadres:</label>
					<input type="email" name="email" class="form-control" value="<?php echo $userdata['email']; ?>">
				</div>
				<div class="form-group">
					<button class="btn btn-info btn-password">Wachtwoord wijzigen</button>
				</div>
				<div class="form-group">
					<button type="submit" name="save" class="btn btn-info">Opslaan</button>
					<button type="submit" name="deleteaccount" class="btn btn-danger">Account verwijderen</button>	
				</div>
			</form>
			<!-- looking for hot stuf -->
			<form class="p-2 form-password" action="forms/passwordchange_form.php" method="POST" style="<?php echo $PASSWORD_ERROR; ?>">
				<h5 class="text-center">Wachtwoord wijzigen</h5>
				<?php 
				//=============== Change password ===============
				if (isset($_SESSION['PASSWORD_ERROR'])) { ?>
					<div class="alert alert-danger" role="alert">
  					<?php echo $_SESSION['PASSWORD_ERROR']; ?>
					</div>
				<?php } ?>
				<div class="form-group">
					<label>Oude wachtwoord:</label>
					<input type="password" name="oldpassword" class="form-control">
				</div>
				<div class="form-group">
					<label>Nieuw wachtwoord:</label>
					<input type="password" name="newpassword" class="form-control">
				</div>
				<div class="form-group">
					<label>Herhaal nieuw wachtwoord:</label>
					<input type="password" name="repeatnewpassword" class="form-control">
				</div>
				<div class="form-group">
					<button type="submit" name="save" class="btn btn-info">Opslaan</button>
					<button class="btn btn-danger btn-annuleren">Annuleren</button>
				</div>
			</form>
		</div>
	  <div class="row row-cols-2">
	  	<!-- ========================== The left col ========================== -->
	    <div class="col-md-2 bg-dark">
	    	<?php
	    	//============== diary left side view ==============
	    	if (!isset($_GET['diary'])) { ?>
		    	<!--<a class="btn btn-info font-weight-bold w-100 mt-2" href="?NewDiary">Nieuw dagboek</a>
		    	-->
	    		<ul class="nav flex-column mt-3">
					<?php 
					//SELECT diary
					$fetchdiary = $diary->getDiary($_SESSION['id']);
					//G
			        if ($fetchdiary) {
						foreach ($fetchdiary as $key => $data) { ?>
						<li class="nav-item mt-2">
							<div class="card">
								<a class="card-body text-dark"  href="?diary=<?php echo $data['id_dagboek']; ?>">
									<h5 class="card-title"><?php echo $data['naam']; ?></h5>
									<p class="card-subtitle"><?php echo "post: ". $data['postCountResult']; ?></p>
								</a>
								<form action="forms/deletediary_form.php" method="POST">
									<button class="btn btn-light text-danger w-100">Dagboek verwijderen</button>
									<input type="hidden" name="diary" value="<?php echo $data['id_dagboek']; ?>">
								</form>
							</div>
						</li>
				  <?php }
				    } else { ?>
						<li>
							<p class="text-light">Nog geen dagboek aangemaakt!</p>
						</li>
		      <?php } ?>
			    </ul>
      <?php }else
            //========================================================================
            //User has choosen the holy book
            { ?>
		   	<a class="btn btn-info font-weight-bold w-100 mt-2" href="?">< Ga terug</a>
		   	<a class="btn btn-info font-weight-bold w-100 mt-2" href="?diary=<?php echo $_GET['diary'] ?>&post">Nieuw post</a>
		   	<input type="date" class="form-control mt-2 search" id="search">
		   	<ul class="nav flex-column li_post mt-3">
		   		<?php
		   		//SELECT which post 
		   		//============= Post left side view =============
	    		$diarypost = $diary->getDiaryPost($_SESSION['id'],$_GET['diary']);
		        //G
		   		if ($diarypost) { ?>
			<?php	foreach ($diarypost as $key => $data) { ?>
				<div class="wordcard">
				    <li class="nav-item mt-2">
						<div class="card">
						<a class="card-body text-dark" href="<?php echo "?diary=" . $_GET['diary']. "&post=". $data['id_post']; ?>">
							<h5 class="card-title"><?php echo "Datum: " . date("d-m-Y",strtotime($data['datum'])); ?></h5>
						</a>
						</div>
					</li>
				</div>
				  <?php } 
				}else{ ?>
					<li>
						<p class="text-light">Nog geen niks gepost</p>
					</li>
				<?php } ?>
		   	</ul>
		   <?php } ?>
	    </div>
<!-- ================================================== The right col ================================================== -->
	    <div class="col-md-10" style="min-height: 703px;">
	    	<div class="d-block h-auto pt-5">
	    		<?php
	    		//================= read & edit & delete post right side =================
	    		if (isset($_GET['diary']) && !empty($_GET['post']) && isset($_GET['Edit'])) {
	    			//G
	    		    $Postdata = $diary->getViewPost($_SESSION['id'],$_GET['diary'],$_GET['post']);
	        		//G
	        		$diaryname = $diary->getOneDiary($_SESSION['id'],$_GET['diary']);
	    	   		//G
	    	   		if ($Postdata) { ?>
		            	<form class="" action="forms/updatepost_form.php" method="POST">
		            		<div class="d-block mt-1">
		            			<div class="row">
		            				<h3 class="col"><?php echo "Dagboek: " . $diaryname['naam']; ?></h3>
		            			</div>
		            			<div class="row">
		            				<h3 class="col d-inline"><?php echo "Datum: " . date("d-m-Y",strtotime($Postdata['datum'])); ?></h3>
		            				<div class="col-0 d-inline mr-2">
		            					<button type="submit" class="btn btn-info">Verhaal Opslaan</button>
		            				</div>
		            		    </div>
		            		</div>
		            		<div class="form-group border-top pt-2">
		            			<label>Verhaal:</label>
		            			<textarea class="form-control mw-100" name="story" style="height: 500px;"><?php echo $Postdata['post']; ?></textarea>
		            			<input type="hidden" name="post" value="<?php echo $_GET['post'] ?>">
		            			<input type="hidden" name="diary" value="<?php echo $_GET['diary'] ?>">
		            		</div>
		            	</form>
	    	  <?php } else {
	    	   		header("location: dagboek.php?diary=".$_GET['diary']);
	    	   		}
	    	   	//G
	   			}else if (isset($_GET['diary']) && !empty($_GET['post'])) {
	    		    //VIEW
	            	//================= read only & edit button post right side =================
	             	$Postdata = $diary->getViewPost($_SESSION['id'],$_GET['diary'],$_GET['post']);
	        		//G
	        		$diaryname = $diary->getOneDiary($_SESSION['id'],$_GET['diary']);
	    			//G
	        		if ($Postdata) { ?>
		            	<div class="">
		            		<div class="d-block mt-1">
		            			<div class="row">
		            				<h3 class="col"><?php echo "Dagboek: " . $diaryname['naam']; ?></h3>
		            			</div>
		            			<div class="row">
		            				<h3 class="col d-inline"><?php echo "Datum: " . date("d-m-Y",strtotime($Postdata['datum'])); ?></h3>
		            				<form class="col-0 d-inline mr-2" action="<?php echo "?diary=".$_GET['diary']."&post=".$_GET['post']."&Edit"; ?>" method="POST">
		            					<button type="submit" class="btn btn-info">Verhaal bewerken</button>
		            				</form>
		            		    	<form class="col-0 d-inline mr-2" action="forms/deletepost_form.php" method="POST">
		            		    		<button type="submit" class="btn btn-danger">Verhaal Verwijderen</button>
		            		    		<input type="hidden" name="story" value="<?php echo $_GET['post'] ?>">
		            		    		<input type="hidden" name="diary" value="<?php echo $_GET['diary'] ?>">
		            		    	</form>
		            		    </div>
		            		</div>
		            		<div class="border-top pt-2">
		            			<pre class="d-block" style="white-space: pre-line;">
		            				<span style="font-family: sans-serif;">
		            					<?php echo $Postdata['post']; ?>	
		            				</span>
		            			</pre>
		            		</div>
		            	</div>
	          <?php } else {
	          	header("location: dagboek.php?diary=".$_GET['diary']);
	        		}
		        	//G
		        } elseif (isset($_GET['diary'])) { 
		        	//================= Write post right side =================
		        	    $diaryname = $diary->getOneDiary($_SESSION['id'],$_GET['diary']);

		        	if ($diaryname) { ?>
		            	<form class="justify-content-center" action="forms/createpost_form.php" method="POST">
		            		<div class="d-block mt-1 mb-1">
		            			<div class="row">
		            				<h3 class="col"><?php echo "Dagboek: " . $diaryname['naam']; ?></h3>
		            			</div>
		            			<div class="row">
		            				<div class="col"></div>
		            		    	<button type="submit" class="col-0 btn btn-info d-inline mr-2">Verhaal Opslaan</button>
		            		    </div>
		            		</div>
		            		<div class="border-top">
		            			<div class="form-group mb-3 mt-1">
			    					<label>Verhaal:</label>
			    					<textarea class="form-control mw-100" name="story" style="height: 500px;"></textarea>
			    				</div>
		            		</div>
		            		<input type="hidden" name="diarydata" value="<?php echo $_GET['diary'] ?>">
		            	</form>
		      <?php } else{
		            	header("location: dagboek.php");
		            }
	    		} else { 
	    		//================= Create diary right side =================
	    		?>
	    		<div class="row">
	    			<div class="col"></div>
	    			<form class="col-md-5" action="forms/creatediary_form.php" method="POST">
		    			<div class="form-group">
		    				<label for>Dagboek naam:</label>
		    				<input type="text" name="diaryName" class="form-control">
		    			</div>
		    			<button type="submit" class="btn btn-info">Dagboek aanmaken</button>
	    			</form>
	    			<div class="col"></div>	
	    		</div>
	    	<?php } ?>
	    	</div>
	    </div>
	  </div>
	</div>
<!-- ================================================== Footer ================================================== -->
	<footer class="w-100 bg-flatgreen" style="height: 100px;">
		<div class="container">
			<div class="row">
				<div class="col mt-4">
					<small>Copyright © 2020 | MijnDagboek.nl</small>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/diary_js.js"></script>
	</footer>
</body>
</html>
<?php }else{
	//If the session does not have a id clear the id and go to the home page
	session_destroy();
	unset($_SESSION['id']);
	header("location: index.php");
} 
unset($_SESSION['PASSWORD_ERROR']);
?>