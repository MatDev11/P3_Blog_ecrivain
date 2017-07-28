<?php
namespace App\Backend\Modules\News;

use \core\BackController;
use \core\HTTPRequest;
use \Entity\News;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \core\FormHandler;

class NewsController extends BackController
{
    public function executeDelete(HTTPRequest $request)
    {
        $newsId = $request->getData('id');


        $this->managers->getManagerOf('News')->delete($newsId);
        $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

        $this->app->user()->setFlash('La news a bien été supprimée !','success');

        $this->app->httpResponse()->redirect('.');
    }


    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Gestion des Articles');

        $manager = $this->managers->getManagerOf('News');

        $this->page->addVar('listeNews', $manager->getList());
        $this->page->addVar('nombreNews', $manager->count());
    }

    public function executeInsert(HTTPRequest $request)
    {
        $this->processForm($request);

        $this->page->addVar('title', 'Ajout d\'un article');
    }

    public function executeUpdate(HTTPRequest $request)
    {
        $this->processForm($request);

        $this->page->addVar('title', 'Modification d\'un article');
    }

    public function processForm(HTTPRequest $request)
    {
        if ($request->method() == 'POST')
        {
            $news = new News([
                'auteur' => $request->postData('auteur'),
                'titre' => $request->postData('titre'),
                'contenu' => $request->postData('contenu')
            ]);

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