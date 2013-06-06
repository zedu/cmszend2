<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\LoginForm; 
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result as Result;

class IndexController extends AbstractActionController
{
    
    
    public function indexAction()
    {

        /*
        $this->flashMessenger()->addMessage('You must do something.');           
        $this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
        $this->flashMessenger()->addMessage(array('alert-success'=>'Well done!'));           
        $this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 
        */
        
        return new ViewModel(array(
            'title'     => 'Home',
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));

    }
    
    public function loginAction(){
        

        $form = new LoginForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            

            if ($form->setData($request->getPost())->isValid()) {
                
                $sm = $this->getServiceLocator();
                $authService = $sm->get('Zend\Authentication\AuthenticationService');
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $authAdapter = new AuthAdapter($dbAdapter);

                // configure auth adapter
                $authAdapter->setTableName('admin')
                        ->setIdentityColumn('username')
                        ->setCredentialColumn('password');
            
                $authAdapter->setIdentity($form->getInputFilter()->getValue('username'))
                    ->setCredential(md5($form->getInputFilter()->getValue('password')));
                
                $authService->setAdapter($authAdapter);
                
                // authenticate
                $result = $authService->authenticate();

                // check if authentication was successful
                // if authentication was successful, user information is stored automatically by adapter
                if ($result->isValid()) {
                    // redirect to user index page
                    return $this->redirect()->toRoute('admin');

                } else {

                    $form->get('username')->setMessages(array('Invalid username & password combination'));
                    $form->get('password')->setMessages(array('Invalid username & password combination'));
                    /*switch ($result->getCode()) {
                        case Result::FAILURE_IDENTITY_NOT_FOUND:
                            break;
                        case Result::FAILURE_CREDENTIAL_INVALID:
                            break;
                        case Result::SUCCESS:
                            break;
                        default:
                            break;
                    }*/
                }
                
            } 
        }
        
         
        return array('form' => $form);
        
    }
    
    public function logoutAction(){
        
        $sm = $this->getServiceLocator();
        $authService = $sm->get('Zend\Authentication\AuthenticationService');
        $authService->clearIdentity();
        
        //return $this->redirect()->toRoute('admin'); // no need the redirection is picked up by the module
        
    }

}
