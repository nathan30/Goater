<?php
    if(context::getSessionAttribute("connect") == "true"){
        header('Location:goater.php');
    }
?>
<body id="goater-index">
    <div class="container-fluid">
        <!-- ********** GOATER - ERRORS ********** -->
        <?php
            if(isset($_GET["error"])){
                $error = $_GET["error"];
                if ($error == '1'){
                    echo "<script>alert(\"Wrong login\")</script>";
                }
                else if($error == '2'){
                    echo "<script>alert(\"Wrong password\")</script>";
                }
            }
        ?>
        <!-- ********** END GOATER - ERRORS ********** -->
    	<div class="row">
        <!-- ********** GOATER - TEXT ********** -->
    	    <div class="col-sm-offset-2 col-sm-5 goater-home">
                <h1 class="goater-title">Welcome to Goater.</h1>
                <p class="goater-description">
                    Connect with your goats — and other fascinating goats. Get in-the-moment updates on the things that interest you. And watch events unfold, in real time, from every angle.
                </p>
            </div>
        <!-- ********** END GOATER - TEXT ********** -->
        <!-- ********** GOATER - LOGIN AND REGISTER ********** -->
			<div class="col-sm-offset-1 col-sm-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
							    <?php
                                    if(isset($_REQUEST['redirect'])){
                                        $action = "?action=login&redirect=$context->redirect&id=1";
                                    }
                                    else{
                                        $action = "?action=login";
                                    }
                                ?>
								<form id="login-form" action='<?php echo $action?>' method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="login" id="login" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group text-center">
										<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
										<label for="remember" class="goat-login-error"> Remember Me</label>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" action="?action=login" method="POST" role="form" enctype="multipart/form-data" style="display:none;">
                                    <div class="form-group">
								        <input type="text" placeholder="Prenom" name="prenom" id="prenom" required="required">
                                    </div>
                                    <div class="form-group">
								        <input type="text" placeholder="Nom" name="nom" id="nom" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="avatar" id="avatar" required="required">
                                    </div>
									<div class="form-group">
										<input type="text" name="login" id="login" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
									</div>
									<!--<div class="form-group">
									    <div class="col-sm-3">
                                            <div id="captcha" class="g-recaptcha" data-sitekey="6Ld0Ew8TAAAAAN-FRKE15g9Gb1RkzoTWI75atTk8"></div>
                                        </div>
									</div>-->
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
                            <!-- ********** GOATER - LOGIN AND REGISTER - PHP ********** -->
								<?php
                                    $bdd = new PDO('pgsql:host=localhost dbname=etd user=uapv1402577 password=jenYv1'); //L3 pour O1a et etd pour 00c
                                    if($_SERVER['REQUEST_METHOD']==='POST' ){
                                        if(isset($_POST["login-submit"])){
                                            if(isset($_POST["login"]) && isset($_POST["password"])){
                                                if($res = utilisateurTable::getUserByLoginAndPass($_POST["login"],$_POST["password"])){
                                                    foreach($res as $r) {
                                                        $id = $r["id"];
                                                    }
                                                    echo "<script>alert(\'.$id.'\")</script>";
                                                    context::setSessionAttribute("id",$id);
                                                    context::setSessionAttribute("connect","true");
                                                    if(isset($_REQUEST['redirect'])){
                                                        echo '<script language="javascript" type="text/javascript">
                                                        window.location.replace("goater.php?action='.$context->redirect.'&id=1");
                                                      </script>';
                                                    }
                                                    else{
                                                        echo '<script language="javascript" type="text/javascript">
                                                        window.location.replace("goater.php");
                                                      </script>';
                                                    }
                                                }
                                                else{
                                                    echo "<p class='goat-login-error'>Couple incorrect</p>";
                                                }
                                            }
                                        }
                                        /*$key='6Ld0Ew8TAAAAABI7-lGauNK_trSpLDGj2xONhLFp';
                                        $response=$_POST['g-recaptcha-response'];
                                        $ip=$_SERVER['REMOTE_ADDR'];
                                        $gapi='https://www.google.com/recaptcha/api/siteverify?secret=' .$key. '&response='.$response. '&remoteip='.$ip;
                                        $json=json_decode(file_get_contents($gapi),true);
                                        if(!$json[ 'success']){
                                            foreach ($json[ 'error-codes'] as $error){
                                                echo"
                                                    <script>
                                                        var error = '$error';
                                                        console.log(error);
                                                    </script>
                                                ";
                                                if($error == "missing-input-response"){
                                                    echo"
                                                       <script>
                                                        alert(\"Veuillez confirmez que vous êtes bien un humain\");
                                                       </script>
                                                    ";
                                                }
                                            }
                                        }
                                        else{*/
                                            if(isset($_POST["register-submit"])){
                                                $prenom = $_POST["prenom"];
                                                $nom = $_POST["nom"];
                                                $login = $_POST["login"];
                                                $password = sha1($_POST["password"]);
                                                // ********** GOATER - LOGIN AND REGISTER - PHP - IMAGE TRANSFER **********
                                                include 'upload_image.php';
                                                // ********** END GOATER - LOGIN AND REGISTER - PHP - IMAGE TRANSFER **********
                                                // ********** GOATER - LOGIN AND REGISTER - PHP - ADD IN DATABASE **********
                                                if($uploadOk == 1){
                                                    $req = $bdd->prepare('INSERT INTO jabaianb.utilisateur(identifiant, pass, nom,prenom,avatar) VALUES(:identifiant, :pass, :nom,:prenom,:avatar)')
                                                    or exit(print_r($bdd->errorInfo()));
                                                    $req->execute(array(
                                                        'identifiant' => $login,
                                                        'pass' => $password,
                                                        'nom' => $nom,
                                                        'prenom' => $prenom,
                                                        'avatar' => $target_file
                                                    ));
                                                }
                                            }
                                            // ********** END GOATER - LOGIN AND REGISTER - PHP - ADD IN DATABASE **********
                                        //}
                                    }
                                ?>
                            <!-- ********** END GOATER - LOGIN AND REGISTER - PHP ********** -->
							</div>
						</div>
					</div>
				</div>
			</div>
        <!-- ********** END GOATER - LOGIN AND REGISTER ********** -->
		</div>
    </div>
    <?php

    ?>
    <!-- ********** GOATER - JAVASCRIPT ********** -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <!-- ********** END GOATER - JAVASCRIPT ********** -->
</body>
</html>
