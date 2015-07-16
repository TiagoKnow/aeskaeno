<?php

namespace Aeskaeno\System\Core;


use Zend\ServiceManager\ServiceManager;

/**
 * Created by PhpStorm.
 * User: dacol
 * Date: 26/12/14
 * Time: 19:18
 */

  class Controller  {

     protected $layout = true;
     protected $serviceManager;
     protected $request = null;

     public final function  __construct() {
        $this->serviceManager = new ServiceManager();
        $this->init();
     }

     public function view($view = null,Array $dados = array())
     {
         if(null === $view)
         {
             $view = $this->getRequest()->getAction();
         }
         $dados['baseUrl'] = $this->getBaseUrl();
         extract($dados,EXTR_OVERWRITE);

         if(file_exists('../Aeskaeno/App/view/'.strtolower($this->getRequest()->getController()).'/'.$view.'.phtml')){
             $return = '';
             if($this->layout){
                 $return .= include_once('../Aeskaeno/App/view/layout/header.phtml');

                 $return .= include_once('../Aeskaeno/App/view/'.strtolower($this->getRequest()->getController()).'/'.$view.'.phtml');

                 $return .= include_once('../Aeskaeno/App/view/layout/footer.phtml');
             } else {
                 $return .= include_once('../Aeskaeno/App/view/'.strtolower($this->getRequest()->getController()).'/'.$view.'.phtml');
             }

             return $return;
         }
         die("View solicitada não existe.");
     }

     public function disableLayout()
     {
         $this->layout = false;
     }

     public function enableLayout()
     {
         $this->layout = true;
     }

     public function getServiceLocator() {
         return $this->serviceManager;
     }

     protected function init() {}

     public function getParams($params = null, $return = null) {
         return $this->getRequest()->getParams($params, $return);
     }

     public function getRequest() {
         if(null === $this->request)
             $this->request = new Request();
         return $this->request;
     }
     
     public function getBaseUrl() {
         return "http://localhost/aeskaeno/public/";
     }
}