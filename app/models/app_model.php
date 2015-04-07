<?php

namespace APP\MODELS;

class app_model{
  
var $dB;
  
 function __construct(){
   $f3=\Base::instance();
   $this->dB=new \DB\SQL('mysql:host='.$f3->get('db_host').';port='.$f3->get('db_port').';dbname='.$f3->get('db_name'),
   $f3->get('db_login'),$f3->get('db_password'));
 } 
 
 // public function getUsers($params){
 //   return $this->getMapper()->find(array('promo=?',$params['promo']));
 // }
 
 public function getWork($params){
   return $this->getMapper()->load(array('id=?',$params['id']));
 }
 
 // public function search($name){
 //   return $this->getMapper()->find(
 //     array('firstname LIKE :name1 or lastname LIKE :name2',':name1'=>'%'.$name.'%',':name2'=>'%'.$name.'%'),
 //     array('order'=>'lastname'));
 // }
 
 // public function signin($params){
 //   return $this->getMapper()->load(array('userId=:login',':login'=>$params['login']));
 // }
 
//Ici work est la valeur par défaut de $table. Le getMapper nous permet d'éxécuter des requetes SQL sans écrire du SQL pur.
//Exemple d'un getMapper d'une autre table getMapper('autretable')
 private function getMapper($table='works'){
   return new \DB\SQL\Mapper($this->dB,$table);
 }

 // public function log(){
 //   return $this->dB->log();
 // }

}














?>