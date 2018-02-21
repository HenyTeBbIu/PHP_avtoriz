<?php
$name = $_REQUEST['name']; 
$login = $_REQUEST['login'];
$password = $_REQUEST['password'];
$email = $_REQUEST['email'];
$password = md5($password);
$xml = simplexml_load_file('./DB.xml');
/************добавляем нового юзера****************/
$user = $xml->addChild('user'); 
$user->addChild('name', $name); 
$user->addChild('login', $login); 
$user->addChild('password',$password); 
$user->addChild('email',$email);
$xml->asXML('./DB.xml'); 