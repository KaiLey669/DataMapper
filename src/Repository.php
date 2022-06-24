<?php

require __DIR__ . '/DataMapper.php';

class Repository
{
    private DataMapper $dataMap;
    private $info = array();

    public function __construct(){
        $this->dataMap = new DataMapper();
        $this->info = $this->dataMap->getAllRecords();
    }

    public function getRecords(){
        $this->dataMap->getRecordsFromDM($this->info);
    }

    public function getRecordID($id){
        $this->dataMap->getRecordIDDM($id, $this->info);
    }

    public function getFilter($login){
        $this->dataMap->getFilterDM($login, $this->info);
    }

    public function saveRecord($id, $login, $message){
        $this->dataMap->saveRecordDM($id, $login, $message);
        $this->info = $this->dataMap->getAllRecords();
    }

    public function deleteRecord($id){
        $this->dataMap->deleteRecordDM($id);
        $this->info = $this->dataMap->getAllRecords();
    }

}