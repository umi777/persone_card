$(document).ready(function(){
	var $fotoramaDiv = $("#slider").fotorama({
		nav: false,
		width: '100%',
		height: '408px',
		arrows: false,
		click: false,
		swipe: false
	});
	var fotorama = $fotoramaDiv.data('fotorama');
	$(".content__slider_pag span:first-child").click(function(){
		fotorama.show('<');
	});
	$(".content__slider_pag span:last-child").click(function(){
		fotorama.show('>');
	});
});

function age(arg){
	dateObj = new Date(arg);
	dateNow = new Date();
	delta = new Date(dateNow-dateObj);
	y = (delta.getFullYear()-1970);
	var txt;
	count = y % 100;
	if (count >= 5 && count <= 20) {
		txt = 'лет';
	} else {
		count = count % 10;
		if (count == 1) {
			txt = 'год';
		} else if (count >= 2 && count <= 4) {
			txt = 'года';
		} else {
			txt = 'лет';
		}
	}
	return y+" "+txt;
	//$("#age").text(delta.getFullYear()-1970);
}

function birthday(arg){
	dateObj = new Date(arg);
	dateNow = new Date();
	if (dateObj.getMonth()>dateNow.getMonth()){
		dateObj.setFullYear(dateNow.getFullYear());
		dateObj = (dateObj-dateNow)/(24*3600*1000);
		return(textDay(dateObj));
	} else
	if (dateObj.getMonth()<dateNow.getMonth()){
		dateObj.setFullYear(dateNow.getFullYear()+1);
		dateObj = (dateObj-dateNow)/(24*3600*1000);
		return(textDay(dateObj));
	} else
	if (dateObj.getMonth()==dateNow.getMonth()){
		if (dateObj.getDate()>dateNow.getDate()){
		dateObj.setFullYear(dateNow.getFullYear());
		dateObj = (dateObj-dateNow)/(24*3600*1000);
		return(textDay(dateObj));
		} else
		if (dateObj.getDate()<dateNow.getDate()){
		dateObj.setFullYear(dateNow.getFullYear()+1);
		dateObj = (dateObj-dateNow)/(24*3600*1000);
		returng(textDay(dateObj));
		} else
		if (dateObj.getDate()==dateNow.getDate()){
		return("Сегодня день рождения!!!");
		}
	}
	
}

function textDay(allday){
	var txt;
	count = Math.ceil(allday) % 100;
	if (count >= 5 && count <= 20) {
		txt = Math.ceil(allday)+' дней до ДР';
	} else {
		count = count % 10;
		if (count == 1) {
			txt = 'Завтра день рождения!';
		} else if (count >= 2 && count <= 4) {
			txt = Math.ceil(allday)+' дня до ДР';
		} else {
			txt = Math.ceil(allday)+' дней до ДР';
		}
	}
	return txt;
}


function like(slide_id){
	const request = new XMLHttpRequest();
	const url = "_like.php";
	const params = "slide_id="+slide_id+"&event=like";
	request.open("POST", url, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.addEventListener("readystatechange", () => {
		if(request.readyState === 4 && request.status === 200) {       
		$("label[for='like-"+slide_id+"'] b").text(request.responseText);
		console.log(request.responseText);
		}
	});
	request.send(params);
}

function dislike(slide_id){
	const request = new XMLHttpRequest();
	const url = "_like.php";
	const params = "slide_id="+slide_id+"&event=dislike";
	request.open("POST", url);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onload = function() {
		if(request.readyState === 4 && request.status === 200) {       
		$("label[for='like-"+slide_id+"'] b").text(request.responseText);
		console.log(request.responseText);
		}
	};
	request.send(params);
}