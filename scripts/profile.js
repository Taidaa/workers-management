function login(){
    const wrapper = document.querySelector("#loginWnd").innerHTML;
    
    let div = document.createElement("div");
    div.innerHTML = wrapper;
    div.classList.add("loginWnd");

    let loginWnd = document.querySelector(".content").appendChild(div);
    document.querySelector(".closeWnd").onclick = function () {
        this.parentNode.parentNode.remove();
    }
}