<?php

use PDO;

class DataMapper
{
    private $id;
    private $login;
    private $message;
    private $link;

    public function __construct(){
        $this->link = new PDO('mysql:dbname=ardb;host=localhost', 'kailey', '12345');
    }

    public function Command($command){
        $sql = $this->link->prepare($command);
        $sql->execute();
    }

    public function getId() {return $this->id;}

    public function setId($id) {$this->id = $id;}

    public function getLogin() {return $this->login;}

    public function setLogin($login) {$this->login = $login;}

    public function getMessage() {return $this->message;}

    public function setMessage($message) {$this->message=$message;}


    private function printRecords($id, $login, $message) {
        echo "<p>" . "ID : ". $id . "; Login : " . $login . "; Message : ". $message . "</p>";
    }

    private function printOneRecord($result) {
        echo $result;
    }


    public function getAllRecords(): array{
        $command = "SELECT * FROM messages;";
        $sql = $this->link->prepare($command);
        $sql->execute();
        $result = $sql->fetchAll();
        $info = array();
        if (isset($result)) {
            foreach ($result as $record){
                $DataMap = new DataMapper();
                $DataMap->setId($record['id']);
                $DataMap->setLogin($record['login']);
                $DataMap->setMessage($record['message']);

                array_push($info, $DataMap);
            }
        }
        return $info;
    }

    public function getRecordsFromDM($users){
        foreach ($users as $record){
            $id = $record->getId();
            $login = $record->getLogin();
            $message = $record->getMessage();
            $this->printRecords($id, $login, $message);
        }
    }

    public function getRecordIDDM($id, $info){
        $result = '';
        foreach ($info as $record){
            if ($record->getId() == $id){
                $result = "<p>" . "ID : ".$record->getId() .'; Login : '. $record->getLogin() .'; Message : '. $record->getMessage();
            }
        }

        $this->printOneRecord($result);
    }

    public function getFilterDM($login, $info)
    {
        $result ='<p>';
        foreach ($info as $record){
            if (trim($record->getLogin(), " ") === $login){
                $result = "<p>" . "ID : " . $record->getId() . '; Login : ' . $record->getLogin() .'; Message : '. $record->getMessage();
            }
        }

        $this->printOneRecord($result);
    }

    public function saveRecordDM($id, $login, $message){
        $this->Command("INSERT INTO messages(id, login, message) VALUES ('$id','$login','$message');");
    }

    public function deleteRecordDM($id) {
        $this->Command("DELETE FROM messages WHERE id = $id;");
    }

}