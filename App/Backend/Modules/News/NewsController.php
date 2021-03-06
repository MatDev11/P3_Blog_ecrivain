<?php
namespace App\Backend\Modules\News;

use \core\BackController;
use \core\HTTPRequest;
use \Entity\News;
use \FormBuilder\NewsFormBuilder;
use \core\FormHandler;
use Services\csrf;

class NewsController extends BackController
{
    public function executeDelete(HTTPRequest $request)
    {

        $csrf = new csrf();

        if ($csrf->getCsrf() == true) {

            $newsId = $request->getData('id');
           $this->managers->getManagerOf('News')->delete($newsId);
           $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

            $this->app->user()->setFlash('La news a bien été supprimée !', 'success');
        }
        else
        {
            $this->app->user()->setFlash('La news n\'a pas été supprimée !', 'danger');
        }

        $this->app->httpResponse()->redirect('.');
    }


    public function executeIndex(HTTPRequest $request)
    {

        $token=$this->app->user()->getToken();
        $this->page->addVar('token', $token);
        $this->page->addVar('title', 'Gestion des Articles');
        $manager = $this->managers->getManagerOf('News');
        $this->page->addVar('listeNews', $manager->getList());
        $this->page->addVar('nombreNews', $manager->count());
    }

    public function executeInsert(HTTPRequest $request)    {

        $this->processForm($request);
        $token=$this->app->user()->getToken();
        $this->page->addVar('token', $token);
        $this->page->addVar('title', 'Ajout d\'un article');

    }

    public function executeUpdate(HTTPRequest $request)
    {
        $this->processForm($request);
        $token=$this->app->user()->getToken();
        $this->page->addVar('token', $token);
        $this->page->addVar('title', 'Modification d\'un article');
    }

    public function processForm(HTTPRequest $request)
    {
        $csrf = new csrf();
        //$this->page->addVar('token', $_SESSION['token']);
        if ($request->method() == 'POST')
        {
            if ($csrf->getCsrf() == true)
            {

                $news = new News([
                    'auteur' => $request->postData('auteur'),
                    'titre' => $request->postData('titre'),
                    'contenu' => $request->postData('contenu')
                ]);
            }
        else {
            $this->app->user()->setFlash('Erreur le formulaire n\'a pas été transmis !', 'danger');
            $this->app->httpResponse()->redirect('.');
        }
            if ($request->getExists('id'))
            {
                $news->setId($request->getData('id'));
            }
        }
        else
        {
            // L'identifiant de la news est transmis si on veut la modifier
            if ($request->getExists('id'))
            {
                $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
            }
            else
            {
                $news = new News;
            }
        }

        $formBuilder = new NewsFormBuilder($news);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('News'), $request);

        if ($formHandler->process())
        {
            $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !','success');

            $this->app->httpResponse()->redirect('.');
        }

        $this->page->addVar('form', $form->createView());
    }
}