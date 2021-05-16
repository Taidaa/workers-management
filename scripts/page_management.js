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

function isLoggedIn(){
	
	let login = "";
	let sid = "";
	// We get all the cookies
	let cookieJar = [];
	document.cookie.split(";").forEach(a=>{
		b = a.trim().split("=");
		cookie = new Object();
		Object.defineProperty(cookie, b[0], {value: b[1]});
		cookieJar.push(cookie);
	});

	// Find in cookies login and sid
	cookieJar.forEach(cookie=>{
		
		if (Object.getOwnPropertyNames(cookie)[0] == "login"){
			login = cookie["login"];
		}

		if (Object.getOwnPropertyNames(cookie)[0] == "sessionid"){
			sid = cookie["sessionid"];
		}


		let formData = new FormData();
		if (login && sid){
			formData.append("login", login);
			formData.append("sessionid", sid);
			fetch("/php/checklogin.php", {
				method: "POST", 
				body: formData
			}).then(res => {
				return res.json();
			}).then(res=>{
				if (!res.success){
					console.log("You are not logged in cause your cookies is broken");
					return false;
				} else {
					console.log(`You are logged in as ${login}`);
					return true;
				}
			})
		}

	});

	console.log("You are not logged in");
	return false;
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
			loadPage("page/profile.html", "Профиль");
			break;
		case "/Профиль":
			loadPage("page/profile.html", "Профиль");
			break;
		case "/Список группы":
			nav_items[1].click();
			break;
		case "/Таблица":
			nav_items[2].click();
			break;
	}

	isLoggedIn();
})();