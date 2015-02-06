<?php
/*
Template Name: Grad Hub
*/
get_header(); ?>

<!doctype html>
<html class="no-js" lang="">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
/* Generated by Fontie - the magic webfont generator <http://fontie.flowyapps.com> */

@font-face {
	font-family:'HelveticaRounded-Black';
	src: url('<?php echo get_template_directory_uri(); ?>/fontie/HelveticaRounded-Black_gdi.eot');
	src: url('<?php echo get_template_directory_uri(); ?>/fontie/HelveticaRounded-Black_gdi.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo get_template_directory_uri(); ?>/fontie/HelveticaRounded-Black_gdi.woff') format('woff'),
		 url('<?php echo get_template_directory_uri(); ?>/fontie/HelveticaRounded-Black_gdi.ttf') format('truetype'),
		 url('<?php echo get_template_directory_uri(); ?>/fontie/HelveticaRounded-Black_gdi.otf') format('opentype'),
		 url('<?php echo get_template_directory_uri(); ?>/fontie/HelveticaRounded-Black_gdi.svg#HelveticaRounded-Black') format('svg');
	font-weight: 900;
	font-style: normal;
	font-stretch: normal;
	unicode-range: U+000D-02DC;
}



/*! normalize.css v3.0.2 | MIT License | git.io/normalize */html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section,summary{display:block}audio,canvas,progress,video{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden],template{display:none}a{background-color:transparent}a:active,a:hover{outline:0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:700}dfn{font-style:italic}h1{font-size:2em;margin:.67em 0}mark{background:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-.5em}sub{bottom:-.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:1em 40px}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0}pre{overflow:auto}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}button{overflow:visible}button,select{text-transform:none}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}input{line-height:normal}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{height:auto}input[type=search]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}input[type=search]::-webkit-search-cancel-button,input[type=search]::-webkit-search-decoration{-webkit-appearance:none}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend{border:0;padding:0}textarea{overflow:auto}optgroup{font-weight:700}table{border-collapse:collapse;border-spacing:0}td,th{padding:0}



/*! HTML5 Boilerplate v5.0.0 | MIT License | http://h5bp.com/ */html{color:#000;font-size:1em;line-height:1.4}::-moz-selection{background:#b3d4fc;text-shadow:none}::selection{background:#b3d4fc;text-shadow:none}hr{display:block;height:1px;border:0;border-top:1px solid #ccc;margin:1em 0;padding:0}audio,canvas,iframe,img,svg,video{vertical-align:middle}fieldset{border:0;margin:0;padding:0}textarea{resize:vertical}.browserupgrade{margin:.2em 0;background:#ccc;color:#000;padding:.2em 0}.hidden{display:none!important;visibility:hidden}.visuallyhidden{border:0;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px}.visuallyhidden.focusable:active,.visuallyhidden.focusable:focus{clip:auto;height:auto;margin:0;overflow:visible;position:static;width:auto}.invisible{visibility:hidden}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}@media print{*,:after,:before{background:transparent!important;color:#000!important;box-shadow:none!important;text-shadow:none!important}a,a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}abbr[title]:after{content:" (" attr(title) ")"}a[href^="#"]:after,a[href^="javascript:"]:after{content:""}blockquote,pre{border:1px solid #999;page-break-inside:avoid}thead{display:table-header-group}img,tr{page-break-inside:avoid}img{max-width:100%!important}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}}



* {
	/**
	* Reset fix padding/margin/border sizing
	*/
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	/* END */
}



body {
	width: 980px;
	margin: 0 auto;
	font-family: 'HelveticaRounded-Black', Arial, sans-serif;
}
header {
	border-bottom: 26px solid #000000;
	padding: 32px;
}
header .logo-left { float: left; }
header .logo-right { float: right; padding: 16px 0 0 0; }

header .clear { clear: both; }

footer {
	background-color: #000000;
	padding: 32px;
}
footer p {
	color: #ffffff;
	font-size: 24px;
	margin: 0;
	padding: 0;
}
footer p span {
	color: #ed1c24;
}

#slider-wrapper {
	position: relative;
	overflow: hidden;
	width: 100%;
	max-width: 100%;
	height: 600px;

	margin: 0 auto;
	padding: 0;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	letter-spacing: -2px;
}
#slider { 
	position: relative;
	width: 100%;
	height: 600px;

	overflow: hidden;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
#slider img {
	width: 100%;
	height: auto;
	position: absolute;
	margin:0;
	padding:0; 
	border:0;
}
#slider p {
	position: absolute;
	top: 32px;
	left: 32px;
	display: block;
	margin:0;
	padding: 0;
	line-height: 1;
}

#slider .red { color: #ed1c24; }
#slider .logo { font-size: 54px; display: block; margin: 0 0 32px 0; }

#slider .black { color: #000000; font-size: 44px; display: block; }
#slider .white { color: #ffffff; font-size: 44px; display: block; }
#slider .regular { color: #ed1c24; font-size: 44px; display: block; }

#slider-wrapper .arrows {
	position: absolute;
	bottom: 64px;
	right: 0;
}

a.mas, a.menos {
	display: none;
	position: absolute;
	top: 50%;
	left: 0px;
	z-index: 10;
	width: 20px;
	height: 30px;
	text-align: center;
	line-height: 30px;
	font-size: 30px;
	color:  white;
	background: #333;
	text-decoration: none;
  transition: .5s margin ease;
}
a.mas {
left: 100%;
margin-left: 100px;
}
#slider-wrapper:hover a.mas {
  margin-left: -40px;
}
a.menos {
  left: 0;
  margin-left: -100px;
}
#slider-wrapper:hover a.menos {
  margin-left: 10px;
}

.slide-1 { background-color: #efea28; }
.slide-2 { background-color: #efea28; }
.slide-3 { background-color: #9ddb49; }
.slide-4 { background-color: #f493bc; }
.slide-5 { background-color: #6dcff4; }
.slide-6 { background-color: #9ddb49; }
.slide-7 { background-color: #efea28; }

/* take that, responsiveness! */
@media screen and (max-width: 980px) {
	body { width: 100%; }
	#slider img { width: auto; height: 120%; right: 0; }
}
@media screen and (max-width: 720px) {
	#slider .logo { font-size: 48px; }
	#slider .black { font-size: 28px; }
	#slider .white { font-size: 28px; }
	#slider .regular { font-size: 28px; }
	footer p { font-size: 20px; }

	#slider img { height: 100%; }
	#slider, #slider-wrapper { height: 480px; }
}
@media screen and (max-width: 620px) {
	header .logo-left { float: none; }
	header .logo-right { float: none; padding: 48px 0 0 0; }
}
@media screen and (max-width: 480px) {
	#slider .logo { font-size: 48px; }
	#slider .black { font-size: 28px; }
	#slider .white { font-size: 28px; }
	#slider .regular { font-size: 28px; }
	footer p { font-size: 14px; }
	.arrows { display: none; }

	#slider, #slider-wrapper { height: 480px; }
	#slider img { right: -200px; }

	.slide-3, .slide-4, .slide-5, .slide-6, .slide-7 { height: inherit; }
	.slide-3 img, .slide-4 img, .slide-5 img, .slide-6 img, .slide-7 img { display: none; }
}
</style>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
</head>
<body>
<!--[if lt IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<header>
	<div class="logo-left"><img src="images/logo-gh.png" alt=""></div>
	<div class="logo-right"><img src="images/logo-ei.png" alt=""></div>
	<div class="clear"></div>
</header>

<main>
	<div id="slider-wrapper">
		<div id="slider">
			<div class="slide-1">
				<img src="images/slide-1.jpg" alt="">
				<p>
					<span class="red logo">GRAD<br>HUB_</span>
				</p>
			</div>
			<div class="slide-2">
				<img src="images/slide-1.jpg" alt="">
				<p>
					<span class="red logo">GRAD<br>HUB_</span>
					<span class="black">Business Growth<br>Programme</span>
				</p>
			</div>
			<div class="slide-3">
				<img src="images/slide-2.jpg" alt="">
				<p>
					<span class="red logo">GRAD<br>HUB_</span>
					<span class="black">Business Growth<br>Programme</span>
					<span class="white">Your gateway to<br>100s of opportunities<br>in Enterprise Ireland’s<br>thriving SME client<br>companies</span>
				</p>
			</div>
			<div class="slide-4">
				<img src="images/slide-3.jpg" alt="">
				<p>
					<span class="red logo">GRAD<br>HUB_</span>
					<span class="black">Business Growth<br>Programme</span>
					<span class="regular">Advance your career<br>in a company that</span>
					<span class="white">knows your name</span>
				</p>
			</div>
			<div class="slide-5">
				<img src="images/slide-4.jpg" alt="">
				<p>
					<span class="red logo">GRAD<br>HUB_</span>
					<span class="black">Business Growth<br>Programme</span>
					<span class="regular">Advance your career<br>in a company that</span>
					<span class="white">values your qualifications</span>
				</p>
			</div>
			<div class="slide-6">
				<img src="images/slide-2.jpg" alt="">
				<p>
					<span class="red logo">GRAD<br>HUB_</span>
					<span class="black">Business Growth<br>Programme</span>
					<span class="regular">Advance your career<br>in a company that</span>
					<span class="white">matches your ambition</span>
				</p>
			</div>
			<div class="slide-7">
				<img src="images/slide-1.jpg" alt="">
				<p>
					<span class="red logo">GRAD<br>HUB_</span>
					<span class="black">Go further faster</span>
					<span class="regular">with Enterprise<br>Ireland’s GradHub<br>Business Growth<br>Programme for<br>Graduates.</span>
				</p>
			</div>


		</div>
		<div class="arrows"><img src="images/arrows.png" alt=""></div>
		<a href="javascript:void();" class="mas">&rsaquo;</a>
		<a href="javascript:void();" class="menos">&lsaquo;</a>
	</div>
</main>

<footer>
	<div class="content">
		<p>Your future is waiting –<br><span>gradhub.ie</span> launching March 2015</p>
	</div>
</footer>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
!function(e,t){function n(e,t){var n=e.createElement("p"),r=e.getElementsByTagName("head")[0]||e.documentElement;return n.innerHTML="x<style>"+t+"</style>",r.insertBefore(n.lastChild,r.firstChild)}function r(){var e=y.elements;return"string"==typeof e?e.split(" "):e}function a(e,t){var n=y.elements;"string"!=typeof n&&(n=n.join(" ")),"string"!=typeof e&&(e=e.join(" ")),y.elements=n+" "+e,m(t)}function c(e){var t=E[e[p]];return t||(t={},v++,e[p]=v,E[v]=t),t}function o(e,n,r){if(n||(n=t),u)return n.createElement(e);r||(r=c(n));var a;return a=r.cache[e]?r.cache[e].cloneNode():g.test(e)?(r.cache[e]=r.createElem(e)).cloneNode():r.createElem(e),!a.canHaveChildren||f.test(e)||a.tagUrn?a:r.frag.appendChild(a)}function i(e,n){if(e||(e=t),u)return e.createDocumentFragment();n=n||c(e);for(var a=n.frag.cloneNode(),o=0,i=r(),l=i.length;l>o;o++)a.createElement(i[o]);return a}function l(e,t){t.cache||(t.cache={},t.createElem=e.createElement,t.createFrag=e.createDocumentFragment,t.frag=t.createFrag()),e.createElement=function(n){return y.shivMethods?o(n,e,t):t.createElem(n)},e.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+r().join().replace(/[\w\-:]+/g,function(e){return t.createElem(e),t.frag.createElement(e),'c("'+e+'")'})+");return n}")(y,t.frag)}function m(e){e||(e=t);var r=c(e);return!y.shivCSS||s||r.hasCSS||(r.hasCSS=!!n(e,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),u||l(e,r),e}var s,u,d="3.7.2",h=e.html5||{},f=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,g=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,p="_html5shiv",v=0,E={};!function(){try{var e=t.createElement("a");e.innerHTML="<xyz></xyz>",s="hidden"in e,u=1==e.childNodes.length||function(){t.createElement("a");var e=t.createDocumentFragment();return"undefined"==typeof e.cloneNode||"undefined"==typeof e.createDocumentFragment||"undefined"==typeof e.createElement}()}catch(n){s=!0,u=!0}}();var y={elements:h.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",version:d,shivCSS:h.shivCSS!==!1,supportsUnknownElements:u,shivMethods:h.shivMethods!==!1,type:"default",shivDocument:m,createElement:o,createDocumentFragment:i,addElements:a};e.html5=y,m(t)}(this,document);



// Font Smoothie copyright 2013,14 Torben Haase <http://pixelsvsbytes.com>
// Source-URL <https://gist.github.com/letorbi/5177771>
(function(){function a(){function e(a){if(null===a.cssRules)return console.warn("Fontsmoothie warning: Browser blocks access to CSS rules in "+a.href);for(var b=a.href||location.href,b=RegExp(b.substring(0,b.lastIndexOf("/")).replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&"),"g"),c,f=0;c=a.cssRules[f];f++){if(c.style&&c.style.src&&(c.style.src=c.style.src.replace(b,".").replace(/([^;]*?),\s*(url\(\S*? format\(["']?svg["']?\))([\s,]*[^;]+|)/,"$2, $1$3"),window.opera)){var d=c.cssText;a.deleteRule(f);a.insertRule(d,
f)}c.styleSheet&&e(c.styleSheet)}}try{var a=document.head.appendChild(document.createElement("CANVAS")),b=a.getContext("2d");b.textBaseline="top";b.font="32px Arial";b.fillText("O",0,0);for(var d,h=0;255==b.getImageData(5,8,1,1).data[3]&&(d=document.styleSheets[h]);h++)d&&e(d);document.head.removeChild(a)}catch(g){throw g;}}if("complete"==document.readyState)a();else{var g=window.onload;window.onload=window.onload?function(e){g(e);a()}:a}})();



jQuery(function($){
	$('#slider div:gt(0)').hide();
	function changeDiv(){
		$('#slider div:first-child').fadeOut(1000)
		.next('div').fadeIn(1000)
		.end().appendTo('#slider');
	}
	var interval = setInterval(changeDiv, 4000);
	$('.mas').click(function(){
		$('#slider div:first-child').fadeOut(1000).next('div').fadeIn(1000).end().appendTo('#slider');
		clearInterval(interval);
		interval = setInterval(changeDiv, 6000);
	});
	$('.menos').click(function(){
		$('#slider div:first-child').fadeOut(1000);
		$('#slider div:last-child').fadeIn(1000).prependTo('#slider');
		clearInterval(interval);
		interval = setInterval(changeDiv, 6000);
	});
});
</script>

</body>
</html>


<?php get_footer(); ?>