<?php
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

//require __DIR__ . '/src/DataMapper.php';
require __DIR__ . '/src/Repository.php';
require_once __DIR__ . '/vendor/autoload.php';
$loader = new FilesystemLoader(__DIR__ . '/views');
$twig = new Environment($loader);
echo $twig->render('index.html');

//---------------------------------------------------------

$rep = new Repository();

if (isset($_GET['getAllRecords'])) {
    $rep->getRecords();
}

if (isset($_GET['getRecordID']) && isset($_GET['ID']) && (string)$_GET['ID'] !== '') {
    $id = $_GET['ID'];
    $rep->getRecordID($id);
}

if (isset($_GET['getFilter']) && isset($_GET['dbLogin'])){
    $login = $_GET['dbLogin'];
    $rep->getFilter($login);
}

if (isset($_GET['saveRecord']) && isset($_GET['dbLogin']) && isset($_GET['dbMessage'])) {
    $id = $_GET['ID'];
    $login = $_GET['dbLogin'];
    $message = $_GET['dbMessage'];
    $rep->saveRecord($id, $login, $message);
}

if (isset($_GET['deleteRecord']) && isset($_GET['ID']) && (string)$_GET['ID'] !== ''){
    $id = $_GET['ID'];
    $rep->deleteRecord($id);
}


//--------------------------------------------------------------

function addToHistory($login, $message){
    $messageJson = (object) ['user' => $login, 'message' => $message];
    $content = json_decode(file_get_contents("history.json"));
    $content->messages[] = $messageJson;
    file_put_contents("history.json", json_encode($content));
    
    $db = new PDO('mysql:dbname=chat;host=localhost', 'kailey', '12345');
    $stm = $db->prepare("insert into history(user,message) values ('$login','$message')");
    $stm->execute();
}

function printMessages(){
    $content = json_decode(file_get_contents("history.json"));
    foreach($content->messages as $message){
        echo "<p>";
        echo "$message->user: $message->message";
        echo "</p>";
    }
}

$adminLogin = "admin";
$adminPassword = "12345";

$login = $_GET["login"];
$password = $_GET["password"];
$message = $_GET["message"];    


if (($login === $adminLogin) && ($password === $adminPassword)){
    addToHistory($login, $message);
}
else{
    echo "<p>";
    echo "Incorrect login or password";
    echo "</p>";
}


printMessages();
?>