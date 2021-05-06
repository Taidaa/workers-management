/**
 * Open login window
 */
function login(){
    // Находим шаблон окна
    const wrapper = document.querySelector("#loginWnd").innerHTML;
    
    // Создаем пустой элемент и вставляем код шаблона
    let div = document.createElement("div");
    div.innerHTML = wrapper;
    div.classList.add("loginWnd");

    // Рендерим окно на странице
    let loginWnd = document.querySelector(".content").appendChild(div);

    // Программно анимируем
    loginWnd.style.opacity = 0;
    loginWnd.children[0].style = `
    transition: 0.5s;
    transform: rotateX(90deg) translateX(100%);`;

    setTimeout(()=>{
        loginWnd.children[0].style.transform = ``;
        loginWnd.style.opacity = 1;
    }, 200);

    // Задаем поведение кнопке закрытия
    document.querySelector(".closeWnd").onclick = function () {
        let wrapper = this.parentNode.parentNode;
        wrapper.style.opacity = 0;
        wrapper.children[0].style.transform = "rotateX(90deg) translateX(100%)";
        setTimeout(()=>wrapper.remove(), 250);
    }
}

/**
 * Open register window
 */
function register() {
    // Закрываем окно авторизации
    document.querySelector(".closeWnd").click();

    // Создаем pagewrapper
    let wrapper = document.createElement(`div`);
    

    // Рендерим на странице
    wrapper = document.querySelector(".content").appendChild(wrapper);
    wrapper.classList.add("pagewrapper");

    // Создаем окошко регистрации
    let wnd = document.createElement("div");
    wnd.classList.add("wnd")
    if (isVertical()){
        wnd.classList.add("vertical");
    }
    wrapper.appendChild(wnd);

    // Создаем кнопочку закрытия
    let closeWnd = document.createElement("div"); 
    closeWnd.classList.add("closeWnd");
    closeWnd.innerText = "x";
    
    // Рендерим кнопочку
    closeWnd = wnd.appendChild(closeWnd);

    // Создаем заголовок
    let header = document.createElement("div");
    header.style = "position: absolute; top: 10px;left: 1rem; font-weight: bold;font-size: 1.3em";
    header.innerText = "Регистрация";

    // Рендерим заголовок
    header = wnd.appendChild(header);

    let form = document.createElement("form");
    form.innerHTML =
    `<form action="register.php" target="_blank" method="POST">
        <label>
            E-mail:
            <br>
            <input type="email">
            <br>
        </label>
        <label>
            Логин:
            <br>
            <input type="text">
            <br>
        </label>
        <label>
            Пароль:
            <br>
            <input type="password">
            <br>
        </label>
        <label>
            Подтвердите пароль:
            <br>
            <input type="password">
            <br>
        </label>
        <br>
        <button style="left: 50%;
        transform: translateX(-50%);
        position: relative;" onclick="FormValidate(this)">Зарегестрироваться</button>
        <div class="infospan"></div> 
</form>`;
    wnd.style.height = "auto";

    wnd.appendChild(form);

    // Программно анимируем появление
    wrapper.style = `transition: 300ms;
                     opacity: 0;`
    setTimeout(()=>{
        wrapper.style.opacity = 1;

        // Делаем кнопочку закрытия рабочей
        closeWnd.onclick = function () {
            let wrapper = this.parentNode.parentNode;
            wrapper.style.opacity = 0;
            wrapper.children[0].style.transition = "250ms";
            wrapper.children[0].style.transform = "rotateX(90deg) translateX(100%)";
            setTimeout(()=>wrapper.remove(), 250);
        }
    }, 100);

    
    
}


function FormValidate(form){
    form = form.parentNode;
    form.setAttribute("method", "POST");
    form.setAttribute("target", "_blank");
    form.setAttribute("action", "/php/register.php");

    form.onsubmit = function (e) {e.preventDefault();};

    let email = form.querySelector(`input[type="email"]`);
    let name = form.querySelector('input[type="text"]');
    let pwd = form.querySelector('input[type="password"]');
    let pwd_ = form.querySelectorAll('input[type="password"]')[1];
    let infospan = form.querySelector(".infospan");

    infospan.style = "color: red; width: 100%; text-align: center;margin-top: 1rem";


    if (pwd.value != "" && name.value != "" && email.value != "" && pwd.value != "" && pwd_.value != "") {
        if (pwd.value.length < 5) {
            infospan.innerText = "* Пароль должен содержать не менее 5 символов!";
        } else if (pwd.value !== pwd_.value){
            infospan.innerText = "* Пароли несовпадают!";
        } else {infospan.style.color = "green"; infospan.innerText = "Форма подтверждена!"; form.onsubmit = ()=>true}
    } else {infospan.innerText = "* Не все поля заполнены!";}
    
}