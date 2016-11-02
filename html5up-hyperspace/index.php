<!DOCTYPE HTML>
<!--
	Hyperspace by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
	<title>EZTV RSS Generator</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<!--[if lte IE 8]>
	<script src="html5up-hyperspace/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="html5up-hyperspace/assets/css/main.css"/>
	<!--[if lte IE 9]>
	<link rel="stylesheet" href="html5up-hyperspace/assets/css/ie9.css"/><![endif]-->
	<!--[if lte IE 8]>
	<link rel="stylesheet" href="html5up-hyperspace/assets/css/ie8.css"/><![endif]-->
</head>
<body>

<!-- Sidebar -->
<section id="sidebar">
	<div class="inner">
		<nav>
			<ul>
				<li><a href="#intro">Welcome</a></li>
				<li><a href="#start">Start</a></li>
				<!--							<li><a href="#how-to">How to</a></li>-->
			</ul>
		</nav>
	</div>
</section>

<!-- Wrapper -->
<div id="wrapper">

	<!-- Intro -->
	<section id="intro" class="wrapper style1 fullscreen fade-up">
		<div class="inner">
			<h1>EZTV RSS Generator</h1>
			<p>Simple php files to scrap the content of eztv.it show pages and generate a RSS feed that can be readed by
				utorrent clients
				and released for free under the <a href="html5up-hyperspace/http://html5up.net/license">Creative
					Commons</a>.</p>
			<ul class="actions">
				<li><a href="#start" class="button scrolly">Start Here</a></li>
			</ul>
		</div>
	</section>

	<!-- Start -->
	<section id="start" class="wrapper style2 fade-up">
		<div class="inner">
			<h2>Start</h2>
			<p>Simple php files to scrap the content of eztv.it show pages and generate a RSS feed that can be readed by
				utorrent clients.</p>
			<div class="style1">
				<section>
					<form>
						<div class="field first">
							<label for="show">Show Name</label>
							<input type="text" name="show_name">
							<input type="hidden" name="show_id">
							<input type="hidden" name="server_url" value="<?php echo curPageURL(); ?>">
						</div>
						<ul class="actions">
							<li><input type="submit" value="Generate" class="special"/></li>
						</ul>
						<div id="result" class="hidden">
							<br/>
							<div class="field first">
								<label for="rss_feed_link">Rss Feed Link</label>
								<input type="text" name="rss_feed_link" value="">
								<div class="hidden alert">Link has been copied in clip</div>
							</div>
							<!--										<div class="field">-->
							<!--											<label for="result">Result XML</label>-->
							<!--											<textarea name="result" id="result" rows="5" disabled></textarea>-->
							<!--										</div>-->
						</div>
					</form>
				</section>
			</div>
		</div>
	</section>

	<!-- How to -->
	<!--					<section id="how-to" class="wrapper style3 fade-up">-->
	<!--						<div class="inner">-->
	<!--							<h2>How to</h2>-->
	<!--							<p>Phasellus convallis elit id ullamcorper pulvinar. Duis aliquam turpis mauris, eu ultricies erat malesuada quis. Aliquam dapibus, lacus eget hendrerit bibendum, urna est aliquam sem, sit amet imperdiet est velit quis lorem.</p>-->
	<!--						</div>-->
	<!--					</section>-->

</div>

<!-- Footer -->
<footer id="footer" class="wrapper style1-alt">
	<div class="inner">
		<ul class="menu">
			<li>&copy; EZTV RSS Generator. All rights reserved.</li>
			<li>Design: <a href="html5up-hyperspace/http://html5up.net">HTML5 UP</a></li>
		</ul>
	</div>
</footer>

<!-- Scripts -->
<script src="html5up-hyperspace/assets/js/jquery.min.js"></script>
<script src="html5up-hyperspace/assets/js/jquery.scrollex.min.js"></script>
<script src="html5up-hyperspace/assets/js/jquery.scrolly.min.js"></script>
<script src="html5up-hyperspace/assets/js/skel.min.js"></script>
<script src="html5up-hyperspace/assets/js/util.js"></script>
<script src="html5up-hyperspace/assets/js/main.js"></script>
<!--[if lte IE 8]>
<script src="html5up-hyperspace/assets/js/ie/respond.min.js"></script><![endif]-->
<script src="html5up-hyperspace/assets/js/main.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
	<?php include_once('search.php'); ?>
	function copyToClipboard(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).val()).select();
		document.execCommand("copy");
		$temp.remove();
		element.focus();
	}

	function convertToSlug(Text) {
		return Text
			.toLowerCase()
			.replace(/ /g, '-')
			.replace(/[^\w-]+/g, '');
	}

	$(function () {

		// AutoComplete
		$("input[name=show_name]").autocomplete({
			minLength: 2,
			source: function (request, response) {
				var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
				response($.grep(data, function (item, index) {
					item.id = item.id;
					item.value = item.text;
					return matcher.test(item.value);
				}));
			},
			select: function (event, ui) {
				$("input[name=show_id]").val(ui.item.id);
			}
		});

		// Clean Field
		$("input[name=show_name]").on('click', function (handler) {
			$("input[name=show_name]").val("");
			$("#result").fadeOut();
		});

		// Copy to clipboard
		$("input[name=rss_feed_link]").click(function () {
			copyToClipboard(this);
			$(".alert").fadeIn();
			$(".alert").delay(500).fadeOut(2000);
		});

		// Submit
		$("form").on('submit', function (e) {
			e.preventDefault();
			var rss_link = $("input[name=server_url]").val() + "?show_id=" + $("input[name=show_id]").val() + "/" + convertToSlug($("input[name=show_name]").val());
			$("input[name=rss_feed_link]").val(rss_link);
			$("#result").fadeIn();
		});


	});
</script>

</body>
</html>