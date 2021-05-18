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
				$res = $conn->query("SELECT FIO role FROM students WHERE groupID={$groupID} ORDER BY `students`.`FIO` ASC"); 
				
				while ($row = $res->fetch_row()){
					$i++;
				?>
				
				<tr>
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
				<?php } ?>
			</tbody>
			<tfoot>
				<tr><td colspan="3">
					<button style="position: relative;display:block; margin: auto; padding: 0; width: 1em; height: 1em;border-radius: 100%">
						<div style="position: absolute; left: 50%; transform: translateX(-50%); top: -8%">+</div>
					</button>
				</td></tr>
			</tfoot>
		</table>
	<?php else: ?>
		Вы не вошли в профиль. Войдите на вкладке профиля.
	<?php endif; ?>
</article>