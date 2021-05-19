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
		} else {
			$loggedIn = false;
		}
	}
?>

<article class="group">
	<?php if ($loggedIn): ?>
		<table>
			<thead>
				<tr><th id="tableheader" colspan="3" data-groupid=<?php echo $groupID?>>
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
						<button style="position: relative;display:block; margin: auto; padding: 0; width: 1em; height: 1em;border-radius: 100%" class="deletefromgroup">
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
						<div style="position: absolute; left: 50%; transform: translateX(-50%); top: -8%" onclick="addToGroup()">+</div>
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
			

			function addToGroup(){
				let wnd = openCtxWnd("Добавить в список");
				let input = wnd.appendChild(document.createElement("input"));
				input.setAttribute("placeholder", "Фамилия Имя Отчество");
				input.style = "text-align: center";
				
				let button = wnd.appendChild(document.createElement("button"));
				button.innerText = "Добавить и сохранить";
				button.style = "position: relative; left: 50%; transform: translate(-50%)"

				button.onclick = function(){
					formData = new FormData();
					formData.append("name", input.value);
					formData.append("groupID", <?php echo $groupID?>);
					fetch("../php/addtogroup.php", {
						body: formData,
						method: "POST"
					});
					wnd.close();
					window.location.reload();
				}
			}

			function removeFromGroup(id, name){
				let wnd = openCtxWnd("Удалить");

				let p = wnd.appendChild(document.createElement("p"));
				p.innerText = `Вы действительно хотите удалить ${name} из группы?`;

				let confirm = wnd.appendChild(document.createElement("button"));
				confirm.innerText = "Да";
				confirm.style = "width: 30%";


				let deny = wnd.appendChild(document.createElement("button"));
				deny.innerText = "Нет";
				deny.style = "position:absolute; right: 1rem;width: 30%";

				confirm.onclick = function(){
					formData = new FormData();
					formData.append("id", id);
					fetch("../php/removefromgroup.php", {
						body: formData,
						method: "POST"
					});
					wnd.close();
					window.location.reload()
				}

				deny.onclick = wnd.close;
			}

			function init()
			{

				document.querySelectorAll(".table-row-student").forEach(row=>{
					row.onclick = function (e){
						let wnd = openCtxWnd();
						let div = document.createElement("div");
						div.innerHTML = `
							<label>
								ФИО:
								<input type="text" name="FIO" placeholder="${this.querySelectorAll("td")[1].innerText}" style="text-align:center"/>
							<label>
							<button style="position:relative; left: 50%; transform: translate(-50%)" onclick="RenameOnServer(${this.dataset.studId}, this.parentNode.previousElementSibling.value)">Сохранить</button>
						`;
						wnd.appendChild(div);
					};
				});

				
				document.querySelectorAll(".deletefromgroup").forEach(b=>{
					b.addEventListener("click", function(e){
						e.stopPropagation();
						let row = this.parentNode.parentNode;
						let id = row.dataset.studId;
						let name = this.parentNode.previousElementSibling.innerText;
						removeFromGroup(id, name);
					});
				})
				
				function RenameOnServer(id, name){
					let formData = new FormData();
					formData.append("id", id);
					formData.append("name", name);
					fetch("../php/renamestud.php", {
						body: formData,
						method: "POST"
					});
					window.location.reload();
				}

				window.RenameOnServer = RenameOnServer;
				window.addToGroup = addToGroup;
				window.removeFromGroup = removeFromGroup;
			}
		
		init();
		</script>

	<?php else: ?>
		Вы не вошли в профиль. Войдите на вкладке профиля.
	<?php endif; ?>
</article>