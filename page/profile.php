<?php 
	include '../php/checklogin.php'; 
	$loggedIn = checkLogin();
	if ($loggedIn){
		include("../php/db_connect.php");
		$res = $conn->query("SELECT
								FIO, 
								groups.mark as 'group',
								roles.name as 'role'
							 FROM 
								profile, groups, roles 
							 WHERE
								profile.login='{$_COOKIE['login']}' 
									AND
								groups.id=profile.groupID
									AND
								roles.id=profile.roleID");

		if ($res = $res->fetch_assoc()){
			$FIO = $res["FIO"];
			$group = $res["group"];
			$role = $res["role"];
		}
	}
?>

<article class="profile">
	<div class="profile-photo">
		<img class="profile-photo" src="img/profile.svg">
	</div>
	
	<div class="info">
		<div class="name">
			<?php
			if ($loggedIn){
				echo $FIO;
			} else {
				echo "Вы не вошли";
			}
			?>
		</div>
		<div class="group">
			<?php
			if ($loggedIn){
				echo $group;
			} else {
				echo "-";
			}
			?>
		</div>
		<div class="role">
			<?php
			if ($loggedIn){
				echo $role;
			} else {
				echo "-";
			} 
			?>
		</div>
		<?php 
		if ($loggedIn){
			echo "<button onclick='unlog()'>Выйти</button>";
		} else {
			echo "<button onclick='login()'>Войти</button>";
		}
		?>
		
	</div>
	
	
	<template id="loginWnd">
				<div class="inputform">
					<div style="position: absolute; top: 10px;left: 1rem; font-weight: bold;font-size: 1.3em;">Вход</div>
					<div class="closeWnd">x</div>
					<form onsubmit="return false" method="POST" target="_self">
						<label>
							Логин:
							<br>
							<input type="text" name="login">
							<br>
						</label>
						<label>
							Пароль:
							<br>
							<input type="password" name="pwd">
							<br>
						</label>
						<br>
						<span id="infopanel"></span>
						<br>
						<button onclick="LoginOnServer(this)">Войти</button>
						<span><a onclick="register();return false" style="position: relative; left: 1.5rem">Зарегестрироваться</a></span>
					</form>
				</div>
	</template>
	

	<script id="pageloaded">
		function init(){
			// Insert script with our profile management
			script = document.createElement("script");
			script.setAttribute("src", "scripts/profile.js");
			script.setAttribute("async", "false");
			document.head.insertBefore(script, document.head.firstElementChild);
		}
	init();
	</script>
</article>
