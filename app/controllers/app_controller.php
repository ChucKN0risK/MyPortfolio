<?php

namespace APP\CONTROLLERS;

class app_controller{
  
  private $tpl;
  private $model;
  private $dataset;
  
  function __construct(){
    $this->model=new \APP\MODELS\app_model();
    // new \DB\SQL\Session($this->model->dB,'session_handler',true);
    $f3=\Base::instance();
    // if($f3->get('PATTERN')!='/signin'&&!$f3->get('SESSION.id')){
    //   $f3->reroute('/signin');
    // }
    $this->tpl=array(
      'sync'=>'main.html',
      'async'=>'');
    
  }
  
  public function home($f3,$params){
    
  }

  public function work($f3,$params){
    //Le $params correspond au @id dans la route
    //la fleche correspond au point en js. dataset est une propriété de notre class appController. This fait référence à appController
    //1) On récupère les données
    $this->dataset=$this->model->getWork($params);
    //2) On les set dans le hive
    $f3->set('work',$this->dataset);
    //3) On précise dans quel template on va les afficher
    $this->tpl['sync']='work.html';
  }
  

  
  // public function getUser($f3,$params){
  //   $this->dataset=$this->model->getUser($params);
  //   $f3->set('one',$this->dataset);
  // }
  
  // public function search($f3){
  //   $f3->set('users',$this->model->search($f3->get('POST.name')));
  //   $this->tpl['async']='partials/users.html';
  // }
  
  // public function signin($f3){
  //   $this->tpl['sync']='signin.html';
  //   if($f3->get('VERB')=='POST'){
  //     $auth=$this->model->signin($f3->get('POST'));
  //     if($auth){
  //       $user=array(
  //         'id'=>$auth->id,
  //         'firstname'=>$auth->firstname,
  //         'lastname'=>$auth->lastname
  //       );
  //       $f3->set('SESSION',$user);
  //       $f3->reroute('/');
  //     }else{
  //       $f3->set('errorMsg','Vous n\'avez pas les credentials nécessaires.');
  //     }
  //   }
  // }
  
  // public function signout($f3){
  //   session_destroy();
  //   $f3->reroute('/signin');
  // }
  
  public function afterroute($f3){
    if(isset($_GET['format'])&&$_GET['format']=='json'){
      if(is_array($this->dataset)){
        $this->dataset=array_map(function($data){return $data->cast();},$this->dataset);
      }
      elseif(is_object($this->dataset)){
        $this->dataset=$this->dataset->cast();
      }
      else{
        $this->dataset=array('error'=>'no dataset');
      }
      if(isset($_GET['callback'])){
        header('Content-Type: application/javascript');
        echo $_GET['callback'].'('.json_encode($this->dataset).')';
      }else{
        header('Content-Type: application/json');
        echo json_encode($this->dataset);
      }
      
    }
    else{
      $tpl=$f3->get('AJAX')?$this->tpl['async']:$this->tpl['sync'];
      echo \View::instance()->render($tpl);
    }
  }

}
?>