var cards = [];
var mainUser;
function addUserPRN(prn)
{
	$.get(encodeURI("http://localhost/Split/add_user_prn.php?prn=" + prn), function(){});
}
function Account(userId, galileoId, accountName, user)
{
	this.userId = userId;
	this.galileoId = galileoId;
	this.accountName = accountName;
	this.user = user;
	this.draw = function()
	{
		return "<div><p>" + this.userId + "</p><p>" + this.accountName + "</p><p>" + this.galileoId + "</p></div>"
	}
}
function User(userId, firstName, lastName, email, prn)
{
	this.userId = userId;
	this.firstName = firstName;
	this.lastName = lastName;
	this.email = email;
	this.galileoPRN = prn;
}
function runCreateAccount()
{
	var url = "http://localhost/Split/create_galileo_account.php?";
	url += "first_name=John" + "&";
	url += "last_name=Smith" + "&";
	url += "middle_name=" + "&";
	url += "DOB=" + "1980-01-25" + "&";
	url += "addr1=" + "1701 Student Life Way" + "&";
	url += "addr2=" + "" + "&";
	url += "city=" + "Salt Lake City" + "&";
	url += "state=" + "UT" + "&";
	url += "zip=" + "84112" + "&";
	url += "country_code=" + "840" + "&";
	url += "express_mail=" + "0" + "&";
	url += "phone=" + "1234567890" + "&";
	url += "email=" + "text@example.com" + "&";
	url += "web_username=" + "username5" + "&";
	url += "web_pass=" + "Password1"; 

	$.get(encodeURI(url), function(data){
		addUserPRN(JSON.parse(data).PRN[0]);
		mainUser = new User(1, "Jackson", "Leach", "jacksonleach5@gmail.com", JSON.parse(data).PRN);
		cards.push(new Account(mainUser.userId, mainUser.galileoPRN, "New Account", mainUser));
		console.log(mainUser);
		console.log(cards);
		drawCards();
	})
}
function getAccounts()
{

}
function drawCards()
{
	$("#result").html("");
	for (var i = 0; i < cards.length; i++)
	{
		
		$("#result").append(cards[i].draw());
	}
}
$(document).ready(function(){
	$("#button").click(function(){
		//runCreateAccount();
		mainUser = new User(1, "Jackson", "Leach", "jacksonleach5@gmail.com", 999900030803);
		cards.push(new Account(mainUser.userId, mainUser.galileoPRN, "New Account", mainUser));
		drawCards();
	});
	var thisUser = new User()
})