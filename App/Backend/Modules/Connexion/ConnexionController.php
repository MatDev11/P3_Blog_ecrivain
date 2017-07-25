<?php
namespace App\Backend\Modules\Connexion;

use \core\BackController;
use \core\HTTPRequest;

class ConnexionController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Connexion');
    
    if ($request->postExists('login'))
    {
      $login = $request->postData('login');
      $password = $request->postData('password');
      
      if ($login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass'))
      {
        $this->app->user()->setAuthenticated(true);
        $this->app->httpResponse()->redirect('.');
      }
      else
      {
        $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
      }
    }
  }
    public function executeDisconect(HTTPRequest $request)
    {
        $this->app->user()->disconect();
        $this->app->httpResponse()->redirect('http://localhost/Blog_Billet_simple_pour_l_Alaska/web/');
    }


}