function proveraKontakt(){

	var ime = document.getElementById("imeprezime").value;

	var regIme = /^[A-Za-z\d]{4,}$/;

	if(regIme.test(ime)){

		document.getElementById("imeprezime").style.borderColor = "green";

	}

	else {

		document.getElementById("imeprezime").style.borderColor = "red";

	}

	var password = document.getElementById("sifra").value;

	var regpassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;

	if(regpassword.test(password)){

		document.getElementById("sifra").style.borderColor = "green";

	}

	else {

		document.getElementById("sifra").style.borderColor = "red";

	}



	

}



