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
										<input type="text" name="login" id="login" tabindex="1" class="form-control" placeholder="Username" value="<?php if (isset($_POST["login"])) echo $_POST["login"]; ?>">
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
								        <input type="text" placeholder="Prenom" name="prenom" id="prenom" required="required" value="<?php if (isset($_POST["prenom"])) echo $_POST["prenom"]; ?>">
                                    </div>
                                    <div class="form-group">
								        <input type="text" placeholder="Nom" name="nom" id="nom" required="required" value="<?php if (isset($_POST["nom"])) echo $_POST["nom"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="avatar" id="avatar">
                                    </div>
									<div class="form-group">
										<input type="text" name="login" id="login" tabindex="1" class="form-control" placeholder="Username" value="<?php if (isset($_POST["login"])) echo $_POST["login"]; ?>" required="required">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>" required="required">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required="required">
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" required="required">
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
