const pointer = document.getElementsByClassName("menu-pointer")[0];
const menuItems = document.querySelectorAll("nav ul li");


// Event to highlight pointer when hover on active menu item
menuItems.forEach(item => {
	item.addEventListener("mouseover", () => {
		if (item.classList.contains("active")){
			pointer.style.backgroundColor = "var(--highlight-color)";
		}
	})
})

// Event to set initial color to
// pointer when hover on active menu item
menuItems.forEach(item => {
	item.addEventListener("mouseout", () => {
		if (item.classList.contains("active")){
			pointer.style.backgroundColor = "var(--menu-color)";
		}
	})
})

function selectMenu(elem){
	if (elem.classList.contains("active"))
	{
		return;
	} else {
		menuItems.forEach((item) => {
			if (item.classList.contains("active")) 
				item.classList.remove("active")
		});

		unloadPage();
		item = elem.getBoundingClientRect();
		elem.classList.add("active");
		pointerInit();
		
		loadPage(elem.getAttribute("href"), elem.getAttribute("header"));
	}
}

function pointerInit(){ 
	let horizontal = false;
	// Changing layout of menu
	if (window.innerHeight > window.innerWidth){
		document.querySelector("#sidebar").classList.add("horizontal");
		document.querySelector("section.content").classList.add("vertical");
		horizontal = true;	
	} else {
		document.querySelector("#sidebar").classList.remove("horizontal");
		document.querySelector("section.content").classList.remove("vertical");
		horizontal = false;
	}

	// Call when the page loads to show the pointer
	let currentPos = document.querySelector("li.active");
	let item = currentPos.getBoundingClientRect();

	if (horizontal){
		pointer.style.transform = `translateX(${item.left}px)`;
		pointer.style.bottom = 0;
		pointer.style.width = "33%";
	} else {
		pointer.style.transform = `translateY(${item.top}px)`;
		pointer.style.bottom = undefined;
		pointer.style.width = "5px";
	}
	
	
	
	setTimeout(()=>{
		pointer.style.opacity = 1;
	}, 500)
}

window.addEventListener("resize", function (e) {
	// Get pointer on right position on resize
	setTimeout(pointerInit, 300)
})

pointerInit();