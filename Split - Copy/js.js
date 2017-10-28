var cards = [];
var mainUser;
var mainUserId = "jacksonleach5@gmail.com";
var base_url = "http://localhost/Split/api.php"
function addUserPRN(prn)
{
	var data = {
		function: "add_user_prn",
		user_id: 1,
		prn: prn
	};
	$.ajax({
		type: "POST",
		url: base_url,
		data: data,
		success: function(data){
			console.log(data);
			console.log("done");
		}
	});
}
function storeAccount(prn, name = "New Account", color = "blue")
{
	url = base_url;
	data = {
		function: "store_account",
		prn: prn,
		name: name,
		color: color,
		userId: mainUser.userId
	};
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(data){console.log(data);}
	})
}
function Account(userId, galileoId, accountName, user, balance, monthly_balance)
{
	this.userId = userId;
	this.galileoId = galileoId;
	this.accountName = accountName;
	this.user = user;
	this.balance = balance;
	this.monthlyBalance = monthly_balance;
	this.draw = function(id)
	{
		return '<div class="card" id="' + id + '"><h3 class="amount">$' + this.balance + '</h3><div class="card-spacer"></div><div class="container"><div class="user"><img class = "profile" src="images/profile1.jpg" alt="card_image"/></div><div class="info"><p class="info-piece name">' + mainUser.firstName + ' ' + mainUser.lastName + '</p><p class="info-piece card_description">' + this.accountName + '</p></div></div><div class="amount-spacer"></div></div>'
	}
	this.updateAccount = function()
	{
		data = {
			function: "update_account_info",
			monthly_balance: this.monthlyBalance,
			name: this.accountName,
			id: this.galileoId
		}
		console.log(this.monthlyBalance);
		$.ajax({
			type: "POST",
			data: data,
			url: base_url,
			success: function(data){updateAccounts();}
		})
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
function getMainUser()
{
	var url = base_url;
	var data = {
		function: "get_main_user",
		id: mainUserId
	};
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(data){
			console.log(data);
			var obj = JSON.parse(data);
			mainUser = new User(obj.id, obj.first_name, obj.last_name, obj.email, obj.galileo_PRN);
			if (mainUser.galileoPRN == 0)
			{
				runCreateAccount();
			}
			else
			{
				getAccounts();
			}	
		}
	})
}
function runCreateAccount()
{
	var url = base_url;
	var data = {
		function: "create_action",
		first_name: "John",
		last_name: "Smith",
		middle_name: "",
		DOB: "1980-01-25",
		addr1: "1701 Student Life Way",
		addr2: "",
		city: "Salt Lake City",
		state: "UT",
		zip: "84112",
		country_code: "840",
		express_mail: "0",
		phone: "1234567890",
		email: "text@example.com"
	}
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(data){
			console.log(JSON.parse(data).response_data.new_account.pmt_ref_no)
			addUserPRN(JSON.parse(data).response_data.new_account.pmt_ref_no);
			storeAccount(JSON.parse(data).response_data.new_account.pmt_ref_no);
			mainUser = new User(1, "Jackson", "Leach", "jacksonleach5@gmail.com", JSON.parse(data).PRN);
			cards.push(new Account(mainUser.userId, mainUser.galileoPRN, "New Account", mainUser));
			drawCards();
		}
	});
}
function getAccounts()
{
	cards = [];
	url = base_url;
	data = {
		function: "get_accounts",
		user_id: mainUser.userId
	};
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(data){
			obj = JSON.parse(data);
			console.log(obj);
			cards.push(new Account(obj.user_id, obj.galileo_id, obj.account_name, obj.color, obj.balance, obj.monthly_balance));
		}
	})
}
function createNewAccount()
{
	url = base_url;
	data = {
		function: "add_account",
		userId: mainUser.userId,
		prn: mainUser.galileoPRN
	};
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(data){console.log(data);}
	})
}
function drawCards()
{
	$("#result").html("");
	for (var i = 0; i < cards.length; i++)
	{
		$("#result").append(cards[i].draw(i));
	}
	$("#result").children().on('click', function(){
		id = $(this).attr('id');
		$('<div id="myDialog"><div class="dialog-spacer"><div class="card"><h3 class="amount">$' + cards[id].balance + '</h3><div class="card-spacer"></div><div class="container"><div class="user"><img class = "profile" src="images/profile1.jpg" alt="card_image"/></div><div class="info"><p class="info-piece name">' + cards[id].user.firstName + ' ' + cards[id].user.lastName + '</p><p class="info-piece card_description"><input id="cards-' + id + '-accountName" value="' + cards[id].accountName + '"></p></div></div><div class="amount-spacer"></div></div><div class="info"><div class="spending"><p class="secondary">Monthly spending limit</p><p class="primary" id="limit"><input id="cards-' + id + '-monthlyBalance" type="number" value="' + cards[id].monthlyBalance + '"></p></div><div class="funding"><p class="secondary">Day card gets funded every month</p><p class="primary" id="day">First of every month</p></div></div><div class="spacer"></div><div class="delete"><p id="delete">Delete Card</p></div><button id="closeCard" class="' + id + '" onClick="closeClicked(' + id + ')">Close</button></div>').dialog({width: 500});
		$(".ui-dialog-titlebar").hide();
	})
}
function closeClicked(id)
{
	acc = cards[id];
	acc.accountName = $("#cards-" + id + "-accountName").val();
	acc.monthlyBalance = $("#cards-" + id + "-monthlyBalance").val();
	console.log($("#cards-" + id + "-monthlyBalance").val());
	acc.updateAccount();
	$("#myDialog").dialog( "destroy" ).remove();
}
function findInCardsById(id)
{
	for (var i = 0; i < cards.length; i++)
	{
		if (cards[i].galileoId == id)
		{
			return cards[i];
		}
	}
	return null;
}
function getAccountBalance(id)
{
	url = base_url;
	data = {
		function: "get_account_info",
		prn: id
	}
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(data){
			obj = JSON.parse(data);
			card = findInCardsById(obj.response_data.accounts.account.pmt_ref_no);
			if (card != null)
			{
				card.balance = obj.response_data.accounts.account.balance;
			}
		}
	})
}
function updateAccounts()
{
	for (var i = 0; i < cards.length; i++)
	{
		getAccountBalance(cards[i].galileoId);
	}
	drawCards();
}
function setAccountBalance(id, value)
{
	$url = base_url;
	$data = {
		function: "set_account_balance",
		account_id: id,
		value: value
	};
	$.ajax({
		type:"POST",
		url: url,
		data: data,
		success: function(data){
			updateAccounts();
		}
	});
}
function addNewAccount()
{
	$url = base_url;
	data = {
		function: "add_account",
		account_id: mainUser.userId
	};
	$.ajax({
		type:"POST",
		url:url,
		data: data,
		success: function (data){
			updateAccounts();
		}
	})
}
$(document).ready(function(){
	getMainUser();
	updateAccounts();
	$("#button").click(function(){
		//createNewAccount();
		createNewAccount();
		

	});

})