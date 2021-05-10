<!DOCTYPE html>
<html>
<head>
	<title>Дежурные | Профиль</title>
	<link rel="stylesheet" type="text/css" href="style.css? <?php echo time() ?>">
	<link rel="icon" type="image/png" href="img/logo.png">
</head>

<body>
	<div class="color-picker">
		<label>body-bg
		<input type="color" oninput="color()">
		</label>
		<label>menu-color
		<input type="color" oninput="color()">
		</label>
		<label>highlight-color
		<input type="color" oninput="color()">
		</label>
		<script type="text/javascript">
			const pickers = document.querySelectorAll(".color-picker input");
				function color() {
					document.body.style.setProperty('--body', pickers[0].value);
					document.body.style.setProperty('--menu-color', pickers[1].value);
					document.body.style.setProperty('--highlight-color', pickers[2].value);
				}
				
		</script>
	</div>

	<!-- CONTENT HERE -->


	<nav id="sidebar" class="">
		<span class="menu-pointer"></span>
		<ul>
			<li class="active" href="page/profile.html" header="Профиль" onclick="selectMenu(this)">
					<svg style="enable-background:new 0 0 24 24;" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="info"/><g id="icons"><g id="user"><ellipse cx="12" cy="8" rx="5" ry="6"/><path d="M21.8,19.1c-0.9-1.8-2.6-3.3-4.8-4.2c-0.6-0.2-1.3-0.2-1.8,0.1c-1,0.6-2,0.9-3.2,0.9s-2.2-0.3-3.2-0.9    C8.3,14.8,7.6,14.7,7,15c-2.2,0.9-3.9,2.4-4.8,4.2C1.5,20.5,2.6,22,4.1,22h15.8C21.4,22,22.5,20.5,21.8,19.1z"/></g></g></svg>
			</li>
			<li href="page/group.html" header="Список группы" onclick="selectMenu(this)">
					<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M576 1376v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm0-384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm-512-768v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm-512-768v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm0-384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm128-320v1088q0 66-47 113t-113 47h-1344q-66 0-113-47t-47-113v-1088q0-66 47-113t113-47h1344q66 0 113 47t47 113z"/>
					</svg>
			</li>
			<li onclick="selectMenu(this)" href="page/duty.html" header="Таблица">
					<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title/><path d="M2,13.5a1,1,0,0,0,1,1H8.44a3.24,3.24,0,0,0,.34.29A7,7,0,0,0,5,21a1,1,0,0,0,1,1H18a1,1,0,0,0,1-1,7,7,0,0,0-3.78-6.21,3.24,3.24,0,0,0,.34-.29H21a1,1,0,0,0,1-1,5.64,5.64,0,0,0-2.64-4.71A4,4,0,1,0,12.5,6v0A4,4,0,0,0,12,6a4,4,0,0,0-.5,0V6A4,4,0,1,0,4.64,8.79a5.32,5.32,0,0,0-1,.82A5.4,5.4,0,0,0,2,13.5ZM16.9,20H7.1a5,5,0,0,1,9.8,0Zm-.16-7.5A4.68,4.68,0,0,0,17,11a5.25,5.25,0,0,0-.1-1A3.34,3.34,0,0,1,19,11a3.47,3.47,0,0,1,.88,1.47ZM14.5,6a2,2,0,1,1,2,2,1.83,1.83,0,0,1-.61-.11,5.51,5.51,0,0,0-1.21-1.1A1.87,1.87,0,0,1,14.5,6Zm.5,5a3,3,0,1,1-3-3A3,3,0,0,1,15,11ZM7.5,4a2,2,0,0,1,2,2,1.87,1.87,0,0,1-.18.79,5.51,5.51,0,0,0-1.21,1.1A1.83,1.83,0,0,1,7.5,8a2,2,0,0,1,0-4ZM5,11A3.33,3.33,0,0,1,7.1,10,5.25,5.25,0,0,0,7,11a4.68,4.68,0,0,0,.26,1.5H4.14A3.59,3.59,0,0,1,5,11Z"/>
					</svg>
			</li>
		</ul>
	</nav>

		<div class="loader">
		<svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
  		viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
		    <path d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
		      <animateTransform 
		         attributeName="transform" 
		         attributeType="XML" 
		         type="rotate"
		         dur="0.34s" 
		         from="0 50 50"
		         to="360 50 50" 
		         repeatCount="indefinite" />
		  </path>
		</svg>
	</div>

	<section class="content">
		<h1>Профиль</h1>
		<hr>
	
	</section>

	<iframe src="page/todo.html" height='600' width="600" style="position:fixed; top: 0;height: 600px;width: 600px" id='todolist'></iframe>
	<!-- END OF CONTENT -->

	
	<script type="text/javascript" src="scripts/menu.js"></script>
	<script type="text/javascript" src="scripts/page_management.js"></script>
</body>

</html>