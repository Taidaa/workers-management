<?php 
include "../php/db_connect.php";
include "../php/checklogin.php";
$loggedin = checkLogin();
$admin = false;
if ($loggedin){
    $login = $_COOKIE["login"];
    $res = $conn->query("SELECT profile.roleID as 'role' FROM profile WHERE profile.login='{$login}'");
    $res = $res->fetch_assoc();
    $roleID = isset($res["role"]) ? $res["role"] : 0;

    if ($roleID >= 100){
        $admin = true;
    } else {
        echo 'У вас не прав чтобы что-то менять на сервере. Пшел нах.';
    }
} else {
    echo 'Вы не залогинены.';
}
?>

<?php if ($loggedin && $admin): ?>
    <article class="adminpanel" style="display: flex; flex-wrap: wrap; flex-direction: column">
            <script id="pageloaded"> 
                function instRegister(){
                    let wnd = openCtxWnd('Регистрация учебного заведения');
                    let div = wnd.appendChild(document.createElement('div'));
                    div.innerHTML = `
                    <label>
                        Наименование:
                        <input type="text" name="instname">
                    </label>
                        <button onclick='registerInstOnServer()' style='position: relative; left: 50%; transform: translateX(-50%)'>Зарегистрировать</button>
                    `;
                    
                }

                function groupRegister(){
                    let wnd = openCtxWnd('Регистрация группы');
                    let div = wnd.appendChild(document.createElement('div'));

                    div.innerHTML = `
                        <label>
                        Учебное заведение
                            <input list='inst' name="instID" onmouseover='fetchInst()'>
                            <datalist id=inst></datalist>
                        </label>
                        <label>
                            Шифр группы
                            <input type='text' name='group'>
                        </label>
                        <button onclick='registerGroupOnServer()' style='position: relative; left: 50%; transform: translateX(-50%)'>Зарегистрировать</button>
                    `;
                }
                
                function registerInstOnServer(){
                    let input = document.querySelector("input[name='instname']");
                    if (input.value == '' || input.value.length < 5 ) return;
                    let fD = new FormData();
                    fD.append('instname', input.value);
                    fetch('../php/registerInst.php', {
                        method: "POST",
                        body: fD
                    });
                }

                function registerGroupOnServer(){
                    let instID = '';
                    let inputInstID = document.querySelector("input[name='instID']");
                    let instDatalist = document.querySelector("datalist#inst");
                    for (const o of instDatalist.options){
                        if (o.value == inputInstID.value) {
                            instID = o.dataset.id
                        }
                    }
                    
                    if (instID !== ''){
                    
                        let inputGroup = document.querySelector("input[name='group']");

                        if (inputGroup.value == '' || inputGroup.value.length < 2) return;


                        let fD = new FormData();

                        fD.append('instID', instID);
                        fD.append('group', inputGroup.value);

                        fetch('../php/registerGroup.php', {
                            method: "POST",
                            body: fD
                        });
                  }
                }

                function init(){
                    window.instRegister = instRegister;
                    window.groupRegister = groupRegister;
                    window.registerInstOnServer = registerInstOnServer;
                    window.registerGroupOnServer = registerGroupOnServer;
                }

                init();
            </script>
			<section class='panel'>
                <h1>
                <a href="#1" id="1" onclick="instRegister()">Зарегестрировать учебное заведение</a></h1>
            </section>
            <section class='panel'>
                <h1> <a href="#2" id="2" onclick="groupRegister()">Зарегестрировать группу</a> </h1>
            </section>

            
    </article>
<?php else: ?>
    <article class="adminpanel">
        <h1>Ты не залогинен</h1>
    </article>
<?php endif; ?>