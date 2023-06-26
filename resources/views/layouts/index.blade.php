<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kabarin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">


    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
	@stack('styles')
	<style>
		.swal2-top-end .swal2-title { color: white !important; }
	</style>
</head>
<body>

<div id="colorlib-page">
	<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
	<aside id="colorlib-aside" role="complementary" class="js-fullheight">
		<nav id="colorlib-main-menu" role="navigation">
			<ul>
				<li class="{{ Request::segment(1) === null ? 'colorlib-active' : null }}"><a href="{{ route('home') }}">Home</a></li>

				@guest
					<li class="{{ Request::segment(1) === 'auth' ? 'colorlib-active' : null }}"><a href="{{ route('auth') }}">Login / Daftar</a></li>
				@endguest

				@if (!is_null(Auth::user()))
					@if (Auth::user()->role == 'admin')
						<li class="{{ Request::segment(1) === 'post' ? 'colorlib-active' : null }}"><a href="{{ route('post') }}">Berita</a></li>
						<li class="{{ Request::segment(1) === 'eligibility' ? 'colorlib-active' : null }}"><a href="{{ route('eligibility') }}">Sistem Kelayakan</a></li>
						<li class="{{ Request::segment(1) === 'category' ? 'colorlib-active' : null }}"><a href="{{ route('category') }}">Kategori</a></li>
					@else
						<li class="{{ Request::segment(1) === 'saved' ? 'colorlib-active' : null }}"><a href="{{ route('saved') }}">Berita Tersimpan</a></li>
					@endif
				@endif
				@auth
					<li><a href="{{ route('logout') }}">Logout</a></li>
				@endauth
			</ul>
		</nav>

		<div class="colorlib-footer">
			<h1 id="colorlib-logo" class="mb-4"><a href="">Kabarin</a></h1>
			<p class="pfooter">Copyright &copy;<script>document.write(new Date().getFullYear());</script> Kabarin</a></p>
		</div>
	</aside>
	<div id="colorlib-main">
		<section class="ftco-section ftco-no-pt ftco-no-pb">
			<div class="container">
				<div class="row d-flex">
					@yield('content')
				</div>
			</div>
		</section>
	</div>
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('js/scrollax.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
function createCkeditor(id, url) {
	CKEDITOR.plugins.addExternal('autogrow', url);
	CKEDITOR.replace(id, {
		extraPlugins: 'autogrow',
		autoGrow_minHeight: 200,
		autoGrow_maxHeight: 400,
		autoGrow_bottomSpace: 0,
		resize_enabled : false,
		height: 200,
		removePlugins: 'elementspath',
		toolbarGroups: [
			{ name: 'document', groups: [ 'mode', 'doctools', 'document' ] },
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
			{ name: 'forms', groups: [ 'forms' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'insert', groups: [ 'insert' ] },
			{ name: 'links', groups: [ 'links' ] },
			{ name: 'colors', groups: [ 'colors' ] },
			{ name: 'tools', groups: [ 'tools' ] },
			'/',
			'/',
			{ name: 'styles', groups: [ 'styles' ] },
			{ name: 'others', groups: [ 'others' ] },
			{ name: 'about', groups: [ 'about' ] }
		],
		removeButtons: 'Source,Templates,Save,NewPage,ExportPdf,Preview,Print,Cut,Copy,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,Subscript,Superscript,CopyFormatting,RemoveFormat,Outdent,Indent,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Table,HorizontalRule,Smiley,PageBreak,Iframe,Styles,Format,Font,FontSize,ShowBlocks,About'
	});
}
</script>
@include('shared.ajax')
@stack('scripts')
</body>
</html>
