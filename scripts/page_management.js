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
 * Dinamically
 * @param {string} href page pattern directory/name
 * @param {string} h page header
 */
function loadPage(href, h){
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
			initLoader(false);

			// Change URI
			window.history.pushState("","",`/${h}`)
		},200);
		

	}).catch(function (err){
		console.warn('Page loading went wrong. \n', err);
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
			loadPage("page/profile.txt", "Профиль");
			break;
		case "/Профиль":
			loadPage("page/profile.txt", "Профиль");
			break;
		case "/Список группы":
			nav_items[1].click();
			break;
		case "/Таблица":
			nav_items[2].click();
			break;
	}

})();