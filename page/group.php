<?php 
	include '../php/checklogin.php'; 
	$loggedIn = checkLogin();
	if ($loggedIn){
		include("../php/db_connect.php");
		$res = $conn->query("SELECT
								FIO, 
								groups.mark as 'group',
								groups.id as 'gid',
								roles.name as 'role'
							 FROM 
								profile, groups, roles 
							 WHERE
								profile.login='{$_COOKIE['login']}' 
									AND
								groups.id=profile.groupID
									AND
								roles.id=profile.roleID 
							");

		if ($res = $res->fetch_assoc()){
			$FIO = $res["FIO"];
			$group = $res["group"];
			$groupID = $res["gid"];
			$role = $res["role"];
		}
	}
?>

<article class="group">
	<?php if ($loggedIn): ?>
		<table>
			<thead>
				<tr><th colspan="3">
					<?php echo $group ?>
				</th></tr>
				
			</thead>
			<tbody>
				<tr>
					<td class='number'>
						#
					</td>
					<td class="stud_fio">
						Фамилия Имя Отчество
					</td>
					<td>
						Удалить
					</td>
				</tr>
				<?php
				$i = 0;
				$res = $conn->query("SELECT FIO, id role FROM students WHERE groupID={$groupID} ORDER BY `students`.`FIO` ASC"); 

				// Выводим список в цикле // 
				while ($row = $res->fetch_row()){
					$i++;
				?>
				
				<tr data-stud-id="<?php echo $row[1]?>" class="table-row-student">
					<td class='number'>
						<?php echo $i; ?>
					</td>
					<td class="stud_fio">
						<?php print($row[0]); ?>
					</td>
					<td>
						<button style="position: relative;display:block; margin: auto; padding: 0; width: 1em; height: 1em;border-radius: 100%">
							<div style="position: absolute; left: 50%; transform: translateX(-51%); top: -17%">-</div>
						</button>
					</td>
				</tr>
				<?php } 
				//  	--  END  -- 	//  	?>
			</tbody>
			<tfoot>
				<tr><td colspan="3">
					<button style="position: relative;display:block; margin: auto; padding: 0; width: 1em; height: 1em;border-radius: 100%">
						<div style="position: absolute; left: 50%; transform: translateX(-50%); top: -8%">+</div>
					</button>
				</td></tr>
			</tfoot>
		</table>

		<small>
		<p>* Кликните по кнопке "+" в футере таблицы чтобы добавить в список студента. </p>
		<p>* Кликниет по кнопке "-" в той же строке, что и студент, которого вы хотите удалить из списка.</p>
		<p>* Кликните по строчке студента, имя которого вы хотите изменить.</p>
		</small>

		<script id="pageloaded">
			

			function init()
			{

				document.querySelectorAll(".table-row-student").forEach(row=>{
					row.onclick = function (e){
						console.log(this);
						let wnd = openCtxWnd();
						
						let div = document.createElement("div");
						div.innerHTML = `
							<label>
								ФИО:
								<input type="text" name="FIO" placeholder="${this.querySelectorAll("td")[1].innerText}" style="text-align:center"/>
							<label>
							<button style="position:relative; left: 50%; transform: translate(-50%)" onclick="openCtxWnd()">Сохранить</button>
						`;
						wnd.appendChild(div);
						
					};
				});
			}
		
		init();
		</script>

	<?php else: ?>
		Вы не вошли в профиль. Войдите на вкладке профиля.
	<?php endif; ?>
</article>