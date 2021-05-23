/**
 * Open login window
 */
function login(){
    let wnd = openCtxWnd("Войти");
    let form = wnd.appendChild(document.createElement("div"));
    form.innerHTML = document.querySelector("#loginWnd").innerHTML;
}

/**
 * Open register window
 */
function register() {
    
    let wnd = openCtxWnd("Регистрация");

    let form = document.createElement("form");
    form.innerHTML =
    `<form action="php/register.php" target="_self" method="POST">
        <label>
            ФИО:
            <br>
            <input type="text" name="FIO">
            <br>
        </label>
        <label>
            Логин:
            <br>
            <input type="text" name="login">
            <br>
        </label>
        <label>
            Пароль:
            <br>
            <input type="password" name="password" autocomplete='current-password'>
            <br>
        </label>
        <label>
            Подтвердите пароль:
            <br>
            <input type="password">
            <br>
        </label>
        <label>
            Учебное учереждение:
            <br>
            <input list="inst" name="inst" class="inst" placeholder="Поиск.." onclick="fetchInst()" onchange="fetchGroups()">
            <datalist id="inst"></datalist>
        </label>
        <label>
            Группа:
            <br>
            <input list="groups" name="group" placeholder="Поиск.." class="groups">
            <datalist id="groups"></datalist>
        </label>
        <br>
        <button style="left: 50%;
        transform: translateX(-50%);
        position: relative;" onclick="FormValidate(this)">Зарегестрироваться</button>
        <div class="infospan"></div> 
</form>`;

    wnd.appendChild(form);
}


function FormValidate(form){
    form = form.parentNode;
    form.setAttribute("method", "POST");
    form.setAttribute("target", "_self");
    form.setAttribute("action", "/php/register.php");

    form.onsubmit = function (e) {e.preventDefault();};
    let name = form.querySelector('input[type="text"]');
    let pwd = form.querySelector('input[type="password"]');
    let pwd_ = form.querySelectorAll('input[type="password"]')[1];
    let inst = form.querySelector('input.inst');
    let group = form.querySelector('input.groups');
    let infospan = form.querySelector(".infospan");

    infospan.style = "color: red; width: 100%; text-align: center;margin-top: 1rem";


    if (pwd.value != ""     && 
        name.value != ""    && 
        pwd.value != ""     && 
        pwd_.value != ""    && 
        inst.value != ""    &&
        group.value != ""
        ) {
            
            if (!validateDatalist(inst)){
                infospan.innerText = "* Такого учереждения в списке нет!";
                return
            }
            if (!validateDatalist(group)){
                infospan.innerText = "* Такой группы в списке нет!";
                return
            }
            

            if (pwd.value.length < 5) {
                infospan.innerText = "* Пароль должен содержать не менее 5 символов!";
            } else if (pwd.value !== pwd_.value){
                infospan.innerText = "* Пароли несовпадают!";
            } else {infospan.style.color = "green"; infospan.innerText = "Форма подтверждена!"; form.onsubmit = (e)=>{
                e.preventDefault();
                // Register query
                let formData = new FormData(form);
                console.log(formData);
                fetch('/php/register.php',{
                    method: 'POST',
                    body: formData
                }).then(res=>res.json()).then(res=>{
                   if (res.success) {
                        infospan.innerText = "Регистрация прошла успешно";
                        infospan.style.color = "green";
                        setTimeout(()=>{location.reload()},4000)
                    } else if (res.code == 1){
                        infospan.innerText = "Этот логин уже занят!";
                        infospan.style.color = "red";
                    }
                    
                });
                return false
            }}
    } else {infospan.innerText = "* Не все поля заполнены!";}
    

    function validateDatalist(input){
        var o = [].map.call(input.list.options, opt => opt.value);
        var opts = o.reduce((result, v) => (result[v.toUpperCase()] = v, result), {});
        var value = input.value.toUpperCase();
        if (opts[value]) {
            this.value = opts[value];
            return true;
        } else {
            this.value = '';
            return false;
        }
    }
}

function fetchInst(){
    const datalist = document.querySelector("datalist#inst");
    if (datalist.childElementCount == 0){
        fetch('/php/fetchinst.php')
        .then((res)=>{
            return res.json();
        })
        .then((institutions)=>{
            institutions.forEach(inst => {
                console.log(inst[0]);
                let option = document.createElement("option");
                option.setAttribute("value", inst[0]);
                datalist.appendChild(option);
            });
        })
    }
}

function fetchGroups(instID = 0){
    const datalist = document.querySelector("datalist#groups");
    const institution = document.querySelector("input.inst").value;
    let fD = new FormData();
    if (inst != "" && document.querySelector("input.groups").value == "" && document.querySelector("datalist#groups").childElementCount == 0){
        document.querySelector("input.groups").value ="";
            fD.append("instID", instID); 
            fD.append("inst", institution);
        
        
        datalist.innerHTML = "";
        fetch('/php/fetchgroups.php', {
            body: fD,
            method: "POST"
        })
        .then((res)=>{
            return res.json();
        })
        .then((groups)=>{
            datalist.innerHTML = "";
            groups.forEach(g => {     
                let option = document.createElement("option");
                option.setAttribute("value", g[0]);
                option.setAttribute("data-id", g[1]);
                datalist.appendChild(option);
                return
            })
        })
    }
}

function LoginOnServer(butt){
    let form = butt.parentNode;
    let formData = new FormData(form);
    fetch("/php/login.php", {
        method: "POST",
        body: formData
    }).then((res)=>{
        return res.json();
    }).then((res)=>{
        console.log(res);
        if (res.success){
            form.querySelector("#infopanel").innerText = "Вы успешно вошли. Страница будет перезагружена.";
            setInterval(()=>{
                window.location.reload();
            }, 400)
        } else {
            if (res.code == 0){
                form.querySelector("#infopanel").innerText = "Неправильный логин или пароль";
            }
        }
    })
}

function unlog(){
    fetch("/php/unlog.php");
    setTimeout(()=>{
    	location.reload();
    },300);
}	

function changegroup(role, instID){
    let wnd = openCtxWnd("Сменить группу");

    let div = wnd.appendChild(document.createElement("div"));
    div.innerHTML = `
            <label>
                Учебное заведение
                <input list="inst" name="inst" class="inst" onmouseover="fetchInst()" ${role>50 ? "" : "disabled"} onchange="(function(){
                    let datalist = document.querySelector('datalist#groups');
                    while (datalist.firstChild) {
                        datalist.removeChild(datalist.lastChild);
                      }
                   document.querySelector('input.groups').value = '';
                   fetchGroups();
                })()">
                <datalist id="inst"></datalist>
            </label>
            <label>
                Группа
                <input list="groups" name="group" placeholder="Поиск.." class="groups" onmouseover="fetchGroups(${instID})">
                <datalist id="groups"></datalist>
            </label>
            <button style="position: relative; left: 50%; transform: translateX(-50%)" onclick='changegroupOnServer()'>Подтвердить</button>
    `;
}

function changegroupOnServer (){
    let inputGroup = document.querySelector('input[name="group"]');
    let datalist = document.querySelector('datalist#groups');
    let groupID = 0;
    let fd = new FormData();

    datalist.childNodes.forEach(option => {
        if (option.value == inputGroup.value){
            groupID = option.dataset.id;
        }
    });
    fd.append("groupID", groupID);

    fetch('/php/changegroup.php', {
        method: "POST",
        body: fd
    }).then((res)=>{
        console.log(res.text());
    });
    setTimeout(()=>{
        document.querySelector('.wnd').close();
        setTimeout(location.reload(), 250);
    },200);
}