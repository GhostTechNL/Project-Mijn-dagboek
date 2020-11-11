//============================== { Sign-in & Sign-up } ==============================
var eclipse = $("#eclipse");
var btnSignIn = $("#btn-signin");
var btnSignUp = $(".btn-signup");
var btnAccount = $(".btn-account");
var btnPassword = $(".btn-password")
var btnAnnuleren = $(".btn-annuleren");

var formSignIn = $("#form-signin");
var formSignUp = $("#form-signup");
var formAccount = $(".form-account");
var formPassword = $(".form-password")
//if they click on the darker part the form and eclipse will hide
$(eclipse).on("click", function(event){
	if (event.target.id == "eclipse") {
		eclipse.hide();
	    formSignUp.hide();
	    formSignIn.hide();
	    formAccount.hide();
	    formPassword.hide();
	}
});
//if the user click on inloggen then 
$(btnSignIn).on("click", function(event){
	eclipse.show();
	formSignIn.show();
	formSignUp.hide();

});
//if the user click on registreren then
$(btnSignUp).on("click", function(event){
	eclipse.show();
	formSignUp.show();
	formSignIn.hide();
});
//Account section
//G
$(btnAccount).on("click", function(event){
	eclipse.show();
	formAccount.show();
	formPassword.hide();
});
//G
$(btnPassword).on("click", function(event){
	//prevent form of sending the data
	event.preventDefault();
	eclipse.show();
	formPassword.show();
	formAccount.hide();
});
//
$(btnAnnuleren).on("click", function(event){
	//prevent form of sending the data
	event.preventDefault();
	eclipse.show();
	formPassword.hide();
	formAccount.show();
});
//============================== { Search-bar } ==============================
var input = $(".search");
var word_Card = $(".wordcard");
var word = $(".wordcard h5");

//
$(input).on("change",function(event){
	var value, date, year, month, day;
	//Input date
    date = new Date(input.val());
    //year
    year = date.getFullYear();
    //month
    month = (1 + date.getMonth()).toString().padStart(2, '0');
    //day
    day = date.getDate().toString().padStart(2, '0');
    //formate d-m-yyyy
    value = day + "-" + month +  "-" + year;
    //if the date is invalid( NaN-NaN-NaN ) set value to 0
    if (input.val() == "") {
    	value = 0;
    }
    //word filter
	word.filter(function(index) {
    	word_Card.eq(index).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
}); 