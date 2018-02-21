<?php
/**
*Copyright ©2018
*Powered by Дмитрий Познанский
*Email: ramzes_xxl@bk.ru
*/

session_start();
function is_guest()
{
	if(!empty($_SESSION['user'])||($_SESSION['user']=''))
	{
		return false;
	}
	return true; 
}
if(is_guest()){ 
	echo "Доброго времени суток, Guest";
}
else{echo "Доброго времени суток, ".$_SESSION['user']."<button type='submit' class='btn btn-primary' id='exit'>Выйти</button>";}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/bootstrap.min.css" >
	<link href="css/bootstrap-editable.css" rel="stylesheet"/>
	<meta charset="utf-8">
	<link href="css/MyStyle.css" rel="stylesheet"/>
	<script src="js/jquery-3.3.1.js"></script>
	<title>Регистрация и авторизация DB(XML)</title>
</head>
<script type="text/javascript">
	$(document).on("click", "#reg", function(){
        var name = $("#inputName").val();
        var login = $("#inputLogin").val();
        var email = $("#inputEmail").val();
        var password = $("#inputPassword").val();var password2 = $("#inputPassword2").val();
		//обрабатываю данные
	  	var error_arr = [];
	  	if(name.length == 0) error_arr.push('Ваше имя');
	  	if(login.length == 0) error_arr.push('Ваш логин');
	  	if(password.length == 0) error_arr.push('Ваш пароль');
	  	if(password2.length == 0) error_arr.push('Повторите пароль ещё раз');	  
	  	if(email.length == 0) error_arr.push('Ваш Email');
	  	if($("#inputPassword").val() !== $("#inputPassword2").val()) error_arr.push('Пароли не совпадают');
	  	// проверка на наличие ошибок
	  	if(error_arr.length > 0){
			alert("Вы не заполнили следующие поля:\n" + error_arr.join(', '));
			// блокировка перехода на другую страницу
			return false;
		}
		else
		{

	        $.ajax({
	        	
	            type: 'POST', // метод отправки
	            url: 'scripts/sign_up.php', // путь к обработчику
	            data: {
	                "name": name,
	                "login": login,
	                "password":password,
	                "email": email 
	            },
	            dataType: 'text',
	            success: function(data){
	            	
	                alert("Поздравляем с регестрацией :)");
	   
	              $("#inputName").val("");$("#inputLogin").val("");$("#inputEmail").val("");$("#inputPassword").val("");$("#inputPassword2").val("");$("#check_login").val("");$("#check_email").val("");
	            },
	            error: function(data){
	                console.log(data); // выводим ошибку в консоль
	            }
	        });

	        return false;
       }  
    })
$(function(){
    $("#sign_in").on("click", function(){
        var login = $("#Login").val();
        var pass = $("#Password").val();
        if (login.length==0 || pass.length==0) {
        	alert('Введите данные логин и пароль');
        	return false;
        }
        else
        {
        	$.ajax({
	            type: 'POST', // метод отправки
	            url: 'scripts/sign_in.php', // путь к обработчику
	            data: {
	                "login": login,
	                "password":pass
	           	            },
	            dataType: 'text',
	            success: function(data){
	               $("#Login").val("");$("#Password").val("");
	               location.reload();
	            },
	            error: function(data){
	                console.log(data); // выводим ошибку в консоль
	            }
	        });

	        return false;  
        }
        
    });

});
$(function(){
    $("#exit").on("click", function(){
        //действия
       $.ajax({
	            type: 'POST', // метод отправки
	            url: 'scripts/exit.php', // путь к обработчику
	            dataType: 'text',
	            success: function(data){

	               location.reload();
	            },
	            error: function(data){
	                console.log(data); // выводим ошибку в консоль
	            }
	        });

	        return false;  
        

    });

});
/* Функция, создающая экземпляр XMLHTTP */
  function getXmlHttp() {
    var xmlhttp;
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (E) {
        xmlhttp = false;
      }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
      xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
  }
  function checkLogin(login) {
    var xmlhttp = getXmlHttp(); // Создаём объект XMLHTTP
    xmlhttp.open('POST', 'scripts/log_u.php', true); // Открываем асинхронное соединение
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем тип содержимого
    xmlhttp.send("login=" + encodeURIComponent(login)); // Отправляем POST-запрос
    xmlhttp.onreadystatechange = function() { // Ждём ответа от сервера
      if (xmlhttp.readyState == 4) { // Ответ пришёл
        if(xmlhttp.status == 200) { // Сервер вернул код 200 (что хорошо)
          if (xmlhttp.responseText) document.getElementById("check_login").innerHTML = "Логин занят!";
         //alert('NO');
          else document.getElementById("check_login").innerHTML = "Логин свободен!";
          //alert('Yes');
        }
      }
    };
  }
  function checkEMail(email) {
    var xmlhttp = getXmlHttp(); // Создаём объект XMLHTTP
    xmlhttp.open('POST', 'scripts/log_e.php', true); // Открываем асинхронное соединение
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем тип содержимого
    xmlhttp.send("email=" + encodeURIComponent(email)); // Отправляем POST-запрос
    xmlhttp.onreadystatechange = function() { // Ждём ответа от сервера
      if (xmlhttp.readyState == 4) { // Ответ пришёл
        if(xmlhttp.status == 200) { // Сервер вернул код 200 (что хорошо)
          if (xmlhttp.responseText) document.getElementById("check_email").innerHTML = "Email занят!";
         //alert('NO');
          else document.getElementById("check_email").innerHTML = "Email свободен!";
          //alert('Yes');
        }
      }
    };
  }
</script>
<body>
	
	<div class="container">
        <div class="jumbotron">
        	<center> 
           		<h1>Регистрация и авторизация</h1>
            	<p>PHP + AJAX + БД(файл XML) + SESSIONS + Bootstrap 3</p>
        	</center>   
        </div></div>
	<!--Форма авторизации-->
	<?php if(is_guest()){ 
		echo "<div id='block1'>
	<form class='form-horizontal' method='POST' name='sign_in'>
	  <!--<fieldset disabled='disabled'>-->
	  	<fieldset id='id1'>
	    <div class='form-group'>
	      <label for='Login' class='control-label col-xs-2'>Логин</label>
	      <div class='col-xs-4'>
	        <input type='text' class='form-control' id='Login' placeholder='Login' >
	      </div>
	    </div>
	    <div class='form-group'>
	      <label for='Password' class='control-label col-xs-2'>Пароль</label>
	      <div class='col-xs-4'>
	        <input type='password' class='form-control' id='Password' placeholder='Пароль'>
	      </div>
	    </div>
	    <div class='form-group'>
	      <div class='col-xs-offset-2 col-xs-10'>
	        <div class='checkbox' >
	          <label><input type='checkbox'> Запомнить</label>
	        </div>
	      </div>
	    </div>
	    <div class='form-group'>
	      <div class='col-xs-offset-2 col-xs-10'>
	        <button type='submit' class='btn btn-primary' id='sign_in'>Войти</button>
	      </div>
	    </div>
	  </fieldset>
	</form>
</div>

<!--Форма регистрации-->
<div id='block2'>
	<form name ='register' class='form-horizontal' method='POST' onsubmit='return validate_form();'>
	  <fieldset>
	  	<div class='form-group'>
	      <label for='inputName' class='control-label col-xs-2'>Ваше имя</label>
	      <div class='col-xs-4'>
	        <input type='text' class='form-control' id='inputName' placeholder='Ваше имя'>
	      </div>
	    </div>
	    <div class='form-group'>
	      <label for='inputName' class='control-label col-xs-2'>Ваш логин</label>
	      <div class='col-xs-4'>
	        <input type='text' class='form-control' id='inputLogin' placeholder='Ваш логин' onblur='checkLogin(this.value)'> <span id='check_login'></span>
	      </div>
	    </div>
	    <div class='form-group'>
	      <label for='inputEmail' class='control-label col-xs-2'> Ваш Email</label>
	      <div class='col-xs-4'>
	        <input type='email' class='form-control' id='inputEmail' placeholder='Email'onblur='checkEMail(this.value)'> <span id='check_email'></span>
	      </div>
	    </div>
	    <div class='form-group'>
	      <label for='inputPassword' class='control-label col-xs-2'>Ваш пароль</label>
	      <div class='col-xs-4'>
	        <input type='password' class='form-control' id='inputPassword' placeholder='Пароль'>
	      </div>
	    </div>
	     <div class='form-group'>
	      <label for='inputPassword' class='control-label col-xs-2'>Повторите пароль</label>
	      <div class='col-xs-4'>
	        <input type='password' class='form-control' id='inputPassword2' placeholder='Пароль'>
	      </div>
	    </div>
	    <div class='form-group'>
	      <div class='col-xs-offset-2 col-xs-10'>
	        <button type='submit' class='btn btn-primary' id='reg'>Регистрация</button>
	      </div>
	    </div>
	  </fieldset>
	</form>
</div>";
}?>
</body>
</html>