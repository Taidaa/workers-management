/**
 * Set loader visibility
 * @param {bool} visible Loader visibility param
 */
function initLoader(visible) {
	const loader = document.querySelector("div.loader");
	let vis = visible ? "visible" : "hidden";
	loader.style.visibility = vis;
}

/**
 * @param code Code to evaluate on window open.
 * Opens context window.
 * @returns Node Opened window
 */
function openCtxWnd(code = "")
			{
				// Close other windows
				document.querySelectorAll(".pagewrapper").forEach(w=>{
					w.querySelector(".closeWnd").click();
				})

				let wrapper = document.createElement("div");
					wrapper.classList.add("pagewrapper");
					wrapper = document.querySelector(".content").appendChild(wrapper);

					// Open window for rename
					let wnd = document.createElement("div");
					wnd.classList.add("wnd");
					wrapper.appendChild(wnd);
					wnd.style.height = "auto";

					if (isVertical()){
						wnd.classList.add("vertical");
					}

					// Программно анимируем
					wnd.style.opacity = 0;
					wnd.style = `
					transition: 0.5s;
					transform: rotateX(90deg) translateX(100%);
					height: auto;`;

					setTimeout(()=>{
						wnd.style.transform = ``;
						wnd.style.opacity = 1;
					}, 200);


					// Make close button
					let close = document.createElement("div");
					close.classList.add("closeWnd");
					close = wnd.appendChild(close);
					close.innerText = "X";
					close.onclick = ()=>{
						wnd.style.transform = "rotateX(90deg) translateX(100%)";
        				setTimeout(()=>wrapper.remove(), 250);
					}

					wnd.close = ()=>close.click();

					if (typeof code === "string"){
						try {
							eval(code);
						} catch (e) {
							console.warn("Cannot evaluate code in context window because of error: " + e.message);
						}
					}
					return wnd;
			}

/**
 * Delete current page before opening another so they not intersect or stack on each other
 */
function unloadPage() {
	let mainBlock = document.querySelectorAll("section article");
	mainBlock.forEach((article)=> {
		if (article) {
		article.remove();
	}
	});
	
}

/**
 * Dinamically load the page
 * @param {string} href page pattern directory/name
 * @param {string} h page header
 */
function loadPage(href, h){
	console.clear();
	fetch(href).then(function (res) {
		return res.text();
	}).then(function (html) {
		initLoader(true);

		setTimeout(function (){
			// Parse txt to html
			var parser = new DOMParser();
			var doc = parser.parseFromString(html, 'text/html');

			// attach article to page
			var article = doc.body.querySelector("article");
			document.querySelector("section.content").appendChild(article);

			// Replace header
			var header = document.querySelector("section.content h1");
			header.innerText = h;

			// Change Title
			document.title = "Дежурные | " + h;

			// Run script on the page
			let code = document.querySelector("script#pageloaded") ?? "";
			eval(code.text);

			// Turn off loader
			initLoader(false);

			// Change URI
			window.history.pushState("","",`/${h}`)
		},200);
		

	}).catch(function (err){
		console.warn('Page loading went wrong. \n', err);
	})
}

/**
 * We split window.cookie into several parts in one object so we can access it by its keys
 */
function CookieSplit(){
	let cookieJar = [];
	document.cookie.split(";").forEach(a=>{
		b = a.trim().split("=");
		cookie = new Object();
		Object.defineProperty(cookie, b[0], {value: b[1]});
		cookieJar.push(cookie);
	});

	window.cookieJar = cookieJar;
	window.cookies = {};
	cookieJar.forEach(cookie=>{
		Object.defineProperty(cookies, Object.getOwnPropertyNames(cookie)[0], {value: cookie[Object.getOwnPropertyNames(cookie)[0]]});
	})
}

/** 
 * Initialize page on uri filled or page reload
 */
(function () {
	let path = window.decodeURI(window.location.pathname);
	console.log(path);
	const nav_items = document.querySelectorAll("nav ul li");
	switch (path) {
		case "/":
			loadPage("page/profile.php", "Профиль");
			break;
		case "/Профиль":
			loadPage("page/profile.php", "Профиль");
			break;
		case "/Список группы":
			nav_items[1].click();
			break;
		case "/Таблица":
			nav_items[2].click();
			break;
		default:
			loadPage("page/profile.php", "Профиль");
			break;
	}

	window.openCtxWnd = openCtxWnd;
})();