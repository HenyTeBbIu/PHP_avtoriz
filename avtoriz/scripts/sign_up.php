<?php
/**
*
*
*
*
*
*/
class MyClass {
    var $name;     
    function MyClass ($aa) 
    {
        foreach ($aa as $k=>$v)
            $this->$k = $aa[$k];
    }
}
function readDatabase($filename) 
{
    // чтение XML базы данных 
    $data = implode("", file($filename));
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);
    // проход через структуры
    foreach ($tags as $key=>$val) {
        if ($key == "user") {
            $molranges = $val;
            for ($i=0; $i < count($molranges); $i+=2) {
                $offset = $molranges[$i] + 1;
                $len = $molranges[$i + 1] - $offset;
                $tdb[] = parseMol(array_slice($values, $offset, $len));
            }
        } else {
            continue;
        }
    }
    return $tdb;
}
function parseMol($mvalues) 
{
    for ($i=0; $i < count($mvalues); $i++) {
        $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
    }
    return new MyClass($mol);
}
function searchForLogin($Login, $array) {
   foreach ($array as $key => $val) {
       if ($val->login === $Login) {
           return $key;
       }
   }
   return null;
}
function searchForEmail($email, $array) {
   foreach ($array as $key => $val) {
       if ($val->email === $email) {
           return $key;
       }
   }
   return null;
}
$db = readDatabase("DB.xml");
/****************************************************/
$name = $_REQUEST['name']; 
$login = $_REQUEST['login'];
$password = $_REQUEST['password'];
$email = $_REQUEST['email'];
$password = md5($password);
$xml = simplexml_load_file('DB.xml');
/************добавляем нового юзера****************/
$res = searchForLogin($login, $db);$res1 = searchForEmail($email, $db);
$user = $xml->addChild('user'); 
$user->addChild('name', $name); 
$user->addChild('login', $login); 
$user->addChild('password',$password); 
$user->addChild('email',$email);
$xml->asXML('DB.xml'); 