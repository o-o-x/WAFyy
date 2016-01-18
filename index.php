<? require_once('login.php'); ?>
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-Frame-Options" content="deny">
<title>WAFyy</title>

	<head>
		<script src="js/jquery-1.10.2.js" type="text/javascript"></script>
		<script src="js/functions.js" type="text/javascript"></script>
		<script src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.jcryption.3.1.0.js"></script> <!-- jcryption -->
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css" media="screen">
		<link rel="stylesheet" type="text/css" href="style/style.css" media="screen">

	</head>

	<body>
		<div id="login_popup">
		<div class="modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">WAFyy - Login</h4>
					</div>

					<div class="modal-body">
						<login class="form-horizontal">
							<fieldset>
								<div class="form-group">
								<label class="col-lg-2 control-label">Password</label>
									<div class="col-lg-10">
										<input class="form-control" autocomplete="off" id="password" placeholder="Ex: Pa$sw0rd" type="password">
							        </div>
								</div>
							</fieldset>
						</login>
					</div>

							<div class="modal-footer">
								<button id="submit_password" class="btn btn-primary">Submit</button>
							</div>
				</div>
			</div>
		</div>
	</div>


<? 
	if(!$auth->isAuthorized())
		exit;
?>

		<div class="container">
			<div id="tabs">
			<ul class="nav nav-pills">
		    <li><a href="#main">First page</a></li>
		    <li><a class="body" href="#body">boDy</a></li>
		    <li><a class="headers" href="#headers">headErs</a></li>
		    <li><a class="regex" href="#regex">regeX</a></li>
		    <li><a class="cogwheel" href="#cogwheel">Cogwheel</a></li>
		    <li id="logout" class="logout"><a>exiT</a></li>

			</ul>

				<div id="main">  <!--  ### Main section ### -->
					<div class="col-lg-12">
					<h2 id="type-blockquotes">WAFyy welcomes you (:</h2>
					<blockquote>
					<p>A starting sentance.</p>
					<small>WAFyy</small>
					</blockquote>
					</div>
				</div>


				<div id="cogwheel">  <!--  ### CogWWheel section ### -->
					
					<div class="col-lg-12">
					<h2 id="type-blockquotes">Global CogWWheel</h2>
					<blockquote>
					<p>Use your own taste and brains to custom your defance!</p>
					<small>WAFyy</small>
					</blockquote>
					</div>

					<div class="col-lg-7">
						<div class="well bs-component">
						<legend>Tuning erea</legend>
							<div id="tuning"></div>
						</div>
					</div>

				</div>


				<div id="headers">  <!--  ### headErs section ### -->
				<div id="popup"></div>
					<div class="col-lg-12">
					<h2 id="type-blockquotes">HeadErs</h2>
					</div>

					<div class="col-lg-12">
						<div class="well bs-component">
							<div id="headers_config"><a>HOST: 8.43.143.2</a></div>
						</div>

					<blockquote>
					<small>Collect new headers ?<span class="label label-success collection-status HeadersCollectionTrue">Yes</span><span class="label label-danger collection-status HeadersCollectionFalse">No</span>
					</blockquote>
					</div>


				</div>


				<div id="body">  <!--  ### body section ### -->

				<div id="popup"></div>
					<div class="col-lg-12">
						<h2 id="type-blockquotes">Parameter Validation Filter</h2>
						<blockquote>
							<p>PVF is implemented as a Servlet filter that intercepts requests to web pages, runs submitted parameters through a configurable sequence of validation rules, and either sanitises the parameters before they are sent through to the web application, or returns a HTTP error code if validation errors were detected.</p>
							<small>OWASP</small>
						</blockquote>
					</div>

					<div class="col-lg-12">
						<div class="well bs-component">
						<legend>Filtering rules</legend>
							<div id="FilterRules"></div>
						</div>
					</div>	

					<div class="col-lg-12">
						<div class="well bs-component">
						<legend>Unfiltered parameters</legend>
							<div id="Unconfigured"></div>
						</div>
						<blockquote>
						<small>Collect new parameters ?<span class="label label-success collection-status BodyCollectionTrue">Yes</span><span class="label label-danger collection-status BodyCollectionFalse">No</span>
						</blockquote>
					</div>	
				</div>




				<div id="regex"> <!--  ### regex section ### -->
					<div class="col-lg-12">
						<h2 id="type-blockquotes">RegeX</h2>
						<blockquote>
							<p>A web application firewall (WAF) is an appliance, server plugin, or filter that applies a set of rules to an HTTP conversation. Generally, these rules cover common attacks such as cross-site scripting (XSS) and SQL injection. By customizing the rules to your application, many attacks can be identified and blocked.</p>
							<small>OWASP</small>
						</blockquote>
					</div>
					<div class="col-lg-12"><div id="regex_console" class="well bs-component"><a>WAFyy:~$ Sample output</a></div></div><br>
					<div class="col-lg-12">
						<div class="well bs-component">
						<legend>Payload pool<a id="add_regex_button" class="btn btn-default btn-sm">Add regeX</a></legend>
							<div id="RegexPool"></div>
						</div>
					</div>

					<div id="add_regex_popup">
					<div class="modal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
								<button type="button" class="close close_popup" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title">Add regex value</h4>
								</div>

								<div class="modal-body">

										<fieldset>
											<div class="form-group">
											        <select class="form-control" id="payload_type">
											        	<option>general</option>
											        	<option>xss</option>
											        	<option>sqli</option>
											        	<option>code injection</option>
											        </select>

											</div>

											<div class="form-group">
											<label class="col-lg-2 control-label">Value</label>
												<div class="col-lg-10">
													<input class="form-control" id="payload_value" placeholder="(Exm: <script>)" type="text">
										        </div>
											</div>
										</fieldset>

								</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-default close_popup" data-dismiss="modal">Close?</button>
											<button id="reset_regex_form" class="btn btn-default">Reset</button>
											<button id="add_regex" class="btn btn-primary">Submit</button>
										</div>
							</div>
						</div>
					</div>
				</div>



			</div>  <!-- div:tabs -->
	</div> 	<!-- div:container -->
	
</body>
</html>
