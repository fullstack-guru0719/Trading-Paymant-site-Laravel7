<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Easy Installer by ViserLab</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://license.viserlab.com/external/install.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	<link rel="shortcut icon" href="https://license.viserlab.com/external/favicon.png" type="image/x-icon">
</head>
<body>
	<header class="section-bg py-2 text-center">
		<div class="container">
			<h3 class="title">Easy Installer by ViserLab</h3>
		</div>
	</header>
	<div class="installation-section padding-bottom padding-top">
		<div class="container">
			<?php 
			error_reporting(0);
			function isExtensionAvailable($name){
				if (!extension_loaded($name)) {
					$response = false;
				} else {
					$response = true;
				}
				return $response;
			}
			function checkFolderPerm($name){
				$perm = substr(sprintf('%o', fileperms($name)), -4);
				if ($perm >= '0775') {
					$response = true;
				} else {
					$response = false;
				}
				return $response;
			}
			function tableRow($name, $details, $status){
				if ($status=='1') {
					$pr = '<i class="fas fa-check"></i>';
				}else{
					$pr = '<i class="fas fa-times"></i>';
				}
				echo "<tr><td>$name</td><td>$details</td><td>$pr</td></tr>";
			}
			function getWebURL(){   
				$base_url = (isset($_SERVER['HTTPS']) &&
					$_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
				$tmpURL = dirname(__FILE__);
				$tmpURL = str_replace(chr(92),'/',$tmpURL);
				$tmpURL = str_replace($_SERVER['DOCUMENT_ROOT'],'',$tmpURL);
				$tmpURL = ltrim($tmpURL,'/');
				$tmpURL = rtrim($tmpURL, '/');
				$tmpURL = str_replace('install','',$tmpURL);
				$base_url .= $_SERVER['HTTP_HOST'].'/'.$tmpURL;
				if (substr("$base_url", -1=="/")) {
					$base_url = substr("$base_url", 0, -1);
				}
				return $base_url; 
			}

			function getStatus($arr){
				return true;
			}

			function replaceData($val,$arr){
				foreach ($arr as $key => $value) {
					$val = str_replace('{{'.$key.'}}', $value, $val);
				}
				return $val;
			}
			function setDataValue($val,$loc){
				$file = fopen($loc, 'w');
				fwrite($file, $val);
				fclose($file);
			}
			function sysInstall($sr,$pt){
				return true;
			}
			function importDatabase($pt){
					return true;

			}
			function setAdminEmail($pt){
					return true;
			}
			//------------->> Extension & Permission
			$requiredServerExtensions = [
				'BCMath', 'Ctype', 'Fileinfo', 'JSON', 'Mbstring', 'OpenSSL', 'PDO','pdo_mysql', 'Tokenizer', 'XML', 'cURL',  'GD','gmp'
			];

			$folderPermissions = [
				'../core/bootstrap/cache/', '../core/storage/', '../core/storage/app/', '../core/storage/framework/', '../core/storage/logs/'
			];
			//------------->> Extension & Permission

			if (isset($_GET['action'])) {
				$action = $_GET['action'];
			}else {
				$action = "";
			}

			if ($action=='complete') {
				?>
				<div class="installation-wrapper pt-md-5">
					<ul class="installation-menu">
						<li class="steps done">
							<div class="thumb">
								<i class="fas fa-server"></i>
							</div>
							<h5 class="content">Server<br>Requirements</h5>
						</li>
						<li class="steps done">
							<div class="thumb">
								<i class="fas fa-file-signature"></i>
							</div>
							<h5 class="content">File<br>Permissions</h5>
						</li>
						<li class="steps done">
							<div class="thumb">
								<i class="fas fa-database"></i>
							</div>
							<h5 class="content">Installation<br>Information</h5>
						</li>
						<li class="steps running">
							<div class="thumb">
								<i class="fas fa-check-circle"></i>
							</div>
							<h5 class="content">Complete<br>Installation</h5>
						</li>
					</ul>
				</div>
				<div class="installation-wrapper">
					<div class="install-content-area">
						<div class="install-item">
							<h3 class="title text-center">Complete Installation</h3>
							<div class="box-item">
								<div class="success-area text-center">
									<?php
									if ($_POST) {
										$alldata = $_POST;
										$db_name = $_POST['db_name'];
										$db_host = $_POST['db_host'];
										$db_user = $_POST['db_user'];
										$db_pass = $_POST['db_pass'];
										$email = $_POST['email'];
			                            $siteurl = getWebURL();
										$app_key = base64_encode(random_bytes(32));
										$envcontent = "
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:$app_key
APP_DEBUG=true
APP_URL=$siteurl

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=$db_host
DB_PORT=3306
DB_DATABASE=$db_name
DB_USERNAME=$db_user
DB_PASSWORD=$db_pass

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME='${APP_NAME}'

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY='${PUSHER_APP_KEY}'
MIX_PUSHER_APP_CLUSTER='${PUSHER_APP_CLUSTER}'

";
										$status = 'ok';
										$envpath = dirname(__DIR__, 1) . '/core/vendor/psr/log/.env';
										file_put_contents($envpath, $envcontent);
										if ($status == 'ok') {
											if(importDatabase($alldata)){							

   $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
   $query = file_get_contents("database.sql");
   $stmt = $conn->prepare($query);
   $stmt->execute();						

	           }
											
											if(setAdminEmail($alldata)){
														$db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
														$sql = "UPDATE admins SET email='".$email."' WHERE username='admin'";
														$stmt = $db->prepare($sql);
														$stmt->execute();
														echo '<p class="text-success warning">Email address of admin has been set successfully!</p>';
																											echo '<div class="warning">
													<p class="text-danger lead my-3">Please delete the "install" folder from the server.</p>
													<p class="text-warning lead my-3">Please change the admin password as soon as possible.</p>
													</div>';
													echo '
													<div class="warning">
													<a href="'.getWebURL().'" class="theme-button choto">Go to website</a>
													<a href="'.getWebURL().'/admin" class="theme-button choto">Go to Admin Panel</a>
													</div>';
													
											
									}
									}}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}elseif($action=='info') {
				?>
				<div class="installation-wrapper pt-md-5">
					<ul class="installation-menu">
						<li class="steps done">
							<div class="thumb">
								<i class="fas fa-server"></i>
							</div>
							<h5 class="content">Server<br>Requirements</h5>
						</li>
						<li class="steps done">
							<div class="thumb">
								<i class="fas fa-file-signature"></i>
							</div>
							<h5 class="content">File<br>Permissions</h5>
						</li>
						<li class="steps running">
							<div class="thumb">
								<i class="fas fa-database"></i>
							</div>
							<h5 class="content">Installation<br>Information</h5>
						</li>
						<li class="steps">
							<div class="thumb">
								<i class="fas fa-check-circle"></i>
							</div>
							<h5 class="content">Complete<br>Installation</h5>
						</li>
					</ul>
				</div>
				<div class="installation-wrapper">
					<div class="install-content-area">
						<div class="install-item">
							<h3 class="title text-center">Installation Information</h3>
							<div class="box-item">
								<form action="?action=complete" method="post" class="information-form-area mb--20">
									<div class="info-item">
										<h5 class="font-weight-normal mb-2">Website URL</h5>
										<div class="row">
											<div class="information-form-group col-12">
												<input name="url" value="<?php echo getWebURL(); ?>" type="text" required>
											</div>
										</div>
									</div>
									<div class="info-item">
										<h5 class="font-weight-normal mb-2">Purchase Verification</h5>
										<div class="row">
											<div class="information-form-group col-sm-6">
												<input type="text" name="user" placeholder="Username" required>
											</div>
											<div class="information-form-group col-sm-6">
												<input type="text" name="code" placeholder="Purchase Code" required>
											</div>
										</div>
									</div>
									<div class="info-item">
										<h5 class="font-weight-normal mb-2">Database Details</h5>
										<div class="row">
											<div class="information-form-group col-sm-6">
												<input type="text" name="db_name" placeholder="Database Name" required>
											</div>
											<div class="information-form-group col-sm-6">
												<input type="text" name="db_host" placeholder="Database Host" required>
											</div>
											<div class="information-form-group col-sm-6">
												<input type="text" name="db_user" placeholder="Database User" required>
											</div>
											<div class="information-form-group col-sm-6">
												<input type="text" name="db_pass" placeholder="Database Password">
											</div>
										</div>
									</div>
									<div class="info-item">
										<h5 class="font-weight-normal mb-3">Admin Credential</h5>
										<div class="row">
											<div class="information-form-group col-lg-3 col-sm-6">
												<label>Username</label>
												<input type="text" value="admin" class="bg-dark" disabled>
											</div>
											<div class="information-form-group col-lg-3 col-sm-6">
												<label>Password</label>
												<input type="text" value="admin" class="bg-dark" disabled>
											</div>
											<div class="information-form-group col-lg-6">
												<label>Email Address</label>
												<input  name="email" placeholder="Your Email address" type="email" required>
											</div>
										</div>
									</div>
									<div class="info-item">
										<div class="information-form-group text-right">
											<button type="submit" class="theme-button choto">Install Now</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php
			}elseif ($action=='file') {
				?>
				<div class="installation-wrapper pt-md-5">
					<ul class="installation-menu">
						<li class="steps done">
							<div class="thumb">
								<i class="fas fa-server"></i>
							</div>
							<h5 class="content">Server<br>Requirements</h5>
						</li>
						<li class="steps running">
							<div class="thumb">
								<i class="fas fa-file-signature"></i>
							</div>
							<h5 class="content">File<br>Permissions</h5>
						</li>
						<li class="steps">
							<div class="thumb">
								<i class="fas fa-database"></i>
							</div>
							<h5 class="content">Installation<br>Information</h5>
						</li>
						<li class="steps">
							<div class="thumb">
								<i class="fas fa-check-circle"></i>
							</div>
							<h5 class="content">Complete<br>Installation</h5>
						</li>
					</ul>
				</div>
				<div class="installation-wrapper">
					<div class="install-content-area">
						<div class="install-item">
							<h3 class="title text-center">File Permissions</h3>
							<div class="box-item">
								<div class="item table-area">
									<table class="requirment-table">
										<?php
										$error = 0;
										foreach ($folderPermissions as $key) {
											$folder_perm = checkFolderPerm($key);
											if ($folder_perm==true) {
												tableRow(str_replace("../", "", $key)," Required Permission: 0775 ",1);
											}else{
												$error += 1;
												tableRow(str_replace("../", "", $key)," Required permission: 0775 ",0);
											}
										}
										$database = file_exists('database.sql');
										if ($database==true) {
											$error = $error+0;
											tableRow('Database',' Required "database.sql" available',1);
										}else{
											$error = $error+1;
											tableRow('Database',' Required "database.sql" available',0);
										}
										$database = file_exists('../.htaccess');
										if ($database==true) {
											$error = $error+0;
											tableRow('.htaccess','  Required ".htaccess" available',1);
										}else{
											$error = $error+1;
											tableRow('.htaccess',' Required ".htaccess" available',0);
										}
										?>
									</table>
								</div>
								<div class="item text-right">
									<?php
									if ($error==0) {
										echo '<a class="theme-button choto" href="?action=info">Next Step <i class="fa fa-angle-double-right"></i></a>';
									}else{
										echo '<a class="theme-button btn-warning choto" href="?action=file">ReCheck <i class="fa fa-sync-alt"></i></a>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}elseif ($action=='server') {
				?>
				<div class="installation-wrapper pt-md-5">
					<ul class="installation-menu">
						<li class="steps running">
							<div class="thumb">
								<i class="fas fa-server"></i>
							</div>
							<h5 class="content">Server<br>Requirements</h5>
						</li>
						<li class="steps">
							<div class="thumb">
								<i class="fas fa-file-signature"></i>
							</div>
							<h5 class="content">File<br>Permissions</h5>
						</li>
						<li class="steps">
							<div class="thumb">
								<i class="fas fa-database"></i>
							</div>
							<h5 class="content">Installation<br>Information</h5>
						</li>
						<li class="steps">
							<div class="thumb">
								<i class="fas fa-check-circle"></i>
							</div>
							<h5 class="content">Complete<br>Installation</h5>
						</li>
					</ul>
				</div>
				<div class="installation-wrapper">
					<div class="install-content-area">
						<div class="install-item">
							<h3 class="title text-center">Server Requirments</h3>
							<div class="box-item">
								<div class="item table-area">
									<table class="requirment-table">
										<?php
										$error = 0;
										$phpversion = version_compare(PHP_VERSION, '7.3', '>=');
										if ($phpversion==true) {
											$error = $error+0;
											tableRow("PHP", "Required PHP version 7.3 or higher",1);
										}else{
											$error = $error+1;
											tableRow("PHP", "Required PHP version 7.3 or higher",0);
										}
										foreach ($requiredServerExtensions as $key) {
											$extension = isExtensionAvailable($key);
											if ($extension==true) {
												tableRow($key, "Required ".strtoupper($key)." PHP Extension",1);
											}else{
												$error += 1;
												tableRow($key, "Required ".strtoupper($key)." PHP Extension",0);
											}
										}
										?>
									</table>
								</div>
								<div class="item text-right">
									<?php
									if ($error==0) {
										echo '<a class="theme-button choto" href="?action=file">Next Step <i class="fa fa-angle-double-right"></i></a>';
									}else{
										echo '<a class="theme-button btn-warning choto" href="?action=server">ReCheck <i class="fa fa-sync-alt"></i></a>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}else{
				?>
				<div class="installation-wrapper">
					<div class="install-content-area">
						<div class="install-item">
							<h3 class="title text-center">Terms of Use</h3>
							<div class="box-item">
								<div class="item">
									<h4 class="subtitle">License to be used on one(1) domain(website) only!</h4>
									<p> The Regular license is for one website or domain only. If you want to use it on multiple websites or domains you have to purchase more licenses (1 website = 1 license). The Regular License grants you an ongoing, non-exclusive, worldwide license to make use of the item.</p>
								</div>
								<div class="item">
									<h5 class="subtitle font-weight-bold">You Can:</h5>
									<ul class="check-list">
										<li> Use on one(1) domain only. </li>
										<li> Modify or edit as you want. </li>
										<li> Translate to your choice of language(s).</li>
									</ul>
									<span class="text-warning"><i class="fas fa-exclamation-triangle"></i>  If any issue or error occurred for your modification on our code/database, we will not be responsible for that. </span>
								</div>
								<div class="item">
									<h5 class="subtitle font-weight-bold">You Cannot: </h5>
									<ul class="check-list">
										<li class="no"> Resell, distribute, give away, or trade by any means to any third party or individual. </li>
										<li class="no"> Include this product into other products sold on any market or affiliate websites. </li>
										<li class="no"> Use on more than one(1) domain. </li>
									</ul>
								</div>
								<div class="item">
									<p class="info">For more information, Please Check <a href="https://codecanyon.net/licenses/faq" target="_blank">The License FAQ</a></p>
								</div>
								<div class="item text-right">
									<a href="?action=server" class="theme-button choto">I Agree, Next Step</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<footer class="section-bg py-3 text-center">
		<div class="container">
			<p class="m-0 font-weight-bold">&copy;<?php echo Date('Y') ?> - All Right Reserved by <a href="https://viserlab.com/">ViserLab</a></p>
		</div>
	</footer>
	<style>
		#hide{
			display: none;
		}
	</style>
</body>
</html>