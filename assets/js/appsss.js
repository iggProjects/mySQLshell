
//ESCUCHAMOS LOS ENLACES

document.body.addEventListener("click", function(event){
	if(event.target.classList.contains("enlace")){
		//BORRAMOS LAS CLASES ACTIVE
		for(const item of document.querySelectorAll(".enlace")){
			item.classList.remove("active");
		}

		//COGEMOS EL DATA DE LA URL
		laURL = event.target.dataset.url;
		console.log('laURL-> ' + laURL);
		//ACTIVAMOS LA CLASE ACTIVE (ROJO)
		event.target.classList.add("active");
		//BORRAMOS EL HIJO
		document.querySelector("#derecha").innerHTML = "";
		//INCLUIMOS EL IFRAME DEL ENLACE NUEVO
		textoHTML=`<iframe src="${laURL}"></iframe>`;
		// document.querySelector("#derecha").innerHTML=textoHTML;
		document.querySelector("#derecha").insertAdjacentHTML("afterbegin",textoHTML);
	}

	if(event.target.classList.contains("codigo")){
		
		//BORRAMOS LAS CLASES ACTIVE
		for(const item of document.querySelectorAll(".codigo")){
			item.classList.remove("active");
		}		
		//COGEMOS EL DATA DE LA URL
		laURLcode = event.target.dataset.urlcode;
		nombre = event.target.dataset.nombre;
		//ACTIVAMOS LA CLASE ACTIVE (ROJO)
		event.target.classList.add("active");
		//BORRAMOS EL HIJO
		/* document.querySelector("#derecha").innerHTML = ""; */
		//INCLUIMOS EL IFRAME DEL ENLACE NUEVO
	/*	
		textoHTML=`<iframe height="300" style="width: 100%;" scrolling="no" title="${nombre}" src="https://codepen.io/iggprojects/embed/${laURLcode}?default-tab=html%2Cresult&editable=true" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true">
		See the Pen <a href="https://codepen.io/iggprojects/pen/${laURLcode}">
		${nombre}</a> by iggProjects (<a href="https://codepen.io/iggProjects">@iggProjects</a>)
		on <a href="https://codepen.io">CodePen</a>.
		</iframe>`;
		*/
		textoHTML=`<iframe height="350" style="width: 100%;" scrolling="no" title="jelouuu" src="https://codepen.io/iggprojects/embed/RwQrozP?default-tab=js%2Cresult" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true">
		See the Pen <a href="https://codepen.io/iggprojects/pen/RwQrozP">
		jelouuu</a> by iggProjects (<a href="https://codepen.io/iggprojects">@iggprojects</a>)
		on <a href="https://codepen.io">CodePen</a>.
		</iframe>`;		
	
	/*	
		textoHTML=`<iframe height="300" style="width: 100%;" scrolling="no" title="${nombre}" src="https://codepen.io/igor-aranaz/embed/${laURLcode}?default-tab=html%2Cresult&editable=true" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true">
		See the Pen <a href="https://codepen.io/igor-aranaz/pen/${laURLcode}">
		${nombre}</a> by Liquid Art developers (<a href="https://codepen.io/igor-aranaz">@igor-aranaz</a>)
		on <a href="https://codepen.io">CodePen</a>.
		</iframe>`;
	*/	
		document.getElementById("home").innerHTML=textoHTML;
		// document.querySelector("#derecha").insertAdjacentHTML("afterbegin",textoHTML);
	}
});


