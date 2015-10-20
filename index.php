<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-Frame-Options" content="deny">
<title>WAFyy</title>

	<head>
		<script src="js/jquery-1.10.2.js" type="text/javascript"></script>
		<script src="js/functions.js" type="text/javascript"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css" media="screen">
		<link rel="stylesheet" type="text/css" href="style/style.css" media="screen">

	</head>

	<body>

		<div class="container">
			<div id="tabs">
			<ul class="nav nav-pills">
		    <li><a href="#main">Main^</a></li>
		    <li><a href="#filter">Filtering#</a></li>
		    <li><a href="#firewall">|Application Firewall|</a></li>
		    <li><a href="#cogwheel">CogWWheel*</a></li>
			</ul>

				<div id="main">  <!--  ### Main section ### -->
					<div class="col-lg-12">
					<h2 id="type-blockquotes">WAFyy welcomes you (:</h2>
					<blockquote>
					<p>A starting sentance.</p>
					<small>Stav van Pelt</small>
					</blockquote>
					</div>
				</div>


				<div id="cogwheel">  <!--  ### CogWWheel section ### -->
					
					<div class="col-lg-12">
					<h2 id="type-blockquotes">Global CogWWheel</h2>
					<blockquote>
					<p>Use your own taste and brains to custom your defance!</p>
					<small>Stav van Pelt</small>
					</blockquote>
					</div>

					<div class="col-lg-7">
						<div class="well bs-component">
						<legend>Tuning erea</legend>
							<div id="tuning"></div>
						</div>
					</div>

				</div>


				<div id="filter">  <!--  ### filter section ### -->

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
					</div>	
				</div>




				<div id="firewall"> <!--  ### firewall section ### -->
					<div class="col-lg-12">
						<h2 id="type-blockquotes">Web app firewall (WAF)</h2>
						<blockquote>
							<p>A web application firewall (WAF) is an appliance, server plugin, or filter that applies a set of rules to an HTTP conversation. Generally, these rules cover common attacks such as cross-site scripting (XSS) and SQL injection. By customizing the rules to your application, many attacks can be identified and blocked.</p>
							<small>OWASP</small>
						</blockquote>
					</div>

					<div class="col-lg-12">
						<div class="well bs-component">
						<legend>Payload pool</legend>
							<div id="PayloadList"></div>
						</div>
					</div>


					<div class="col-lg-7">
						<div class="well bs-component">
							<form class="form-horizontal">
								<fieldset>
								<legend>Add Payload</legend>
									<div class="form-group">
									<label class="col-lg-2 control-label">Type</label>
										<div class="col-lg-10">
											<input class="form-control" id="payload_type" placeholder="(xss,sqli,code injection..)" type="text">
										</div>
									</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Value</label>
										<div class="col-lg-10">
											<input class="form-control" id="payload_value" placeholder="(Exm: <script>)" type="text">
										</div>
								</div>
								<div class="form-group">
									<div class="col-lg-10 col-lg-offset-2">
										<button type="reset" class="btn btn-default">Reset</button>
										<button id="submit_payload" class="btn btn-primary">Submit</button>
									</div>
								</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>



			</div>  <!-- div:tabs -->
	</div> 	<!-- div:container -->
</body>
</html>	<!-- END:html-->
