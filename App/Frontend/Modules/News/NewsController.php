<?php
namespace App\Frontend\Modules\News;

use core\BackController;
use core\FormHandler;
use core\HTTPRequest;
use Entity\Comment;
use FormBuilder\CommentFormNewsBuilder;
use Services\CommentsLevel;
use Services\EditComment;



class NewsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $nombreNews = $this->app->config()->get('nombre_news');
        $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
        $url = $this->app->config()->get('url');

        // On ajoute une définition pour le titre.

        $this->page->addVar('subtitle', 'Jean Forteroche');
        $this->page->addVar('titlePage', 'Liste des ' . $nombreNews . ' dernières news');
        ////
        $this->page->addVar('url', $url);

        // On récupère le manager des news.
        $manager = $this->managers->getManagerOf('News');

        $listeNews = $manager->getList(0, $nombreNews);

        foreach ($listeNews as $news) {
            if (strlen($news->contenu()) > $nombreCaracteres) {
                $debut = substr($news->contenu(), 0, $nombreCaracteres);
                $debut = substr($debut, 0, strrpos($debut, ' '))
                    . ' ... <a href="' . $url . 'news-' . $news['id'] . '.html">Voir la suite</a>';

                $news->setContenu($debut);
            }
        }

        // On ajoute la variable $listeNews à la vue.
        $this->page->addVar('listeNews', $listeNews);

    }

    public function executeShow(HTTPRequest $request)
    {
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));

        if (empty($news)) {
            $this->app->httpResponse()->redirect404();
        }

        $this->page->addVar('title', $news->titre());
        $this->page->addVar('news', $news);
        // $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));

        $comments = $this->managers->getManagerOf('Comments')->getListOf($news->id());

        $commentsLevel = new CommentsLevel();
        $ShowCommentsLevel = $commentsLevel->getCommentsLevel($comments,false);

        $this->page->addVar('comments', $ShowCommentsLevel);

        $this->executeInsertComment($request);
    }

    public function executeInsertComment(HTTPRequest $request)
    {


        // Si le formulaire a été envoyé.
        if ($request->method() == 'POST') {

            $depth = 0;
            $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
            $repComments = $this->managers->getManagerOf('Comments')->findIdRep($parent_id);
            $insertComment = new EditComment();
            $comment = $insertComment->InsertComment($request, $depth, $repComments, $parent_id);

        } else {
            $comment = new Comment;
        }

        $formBuilder = new CommentFormNewsBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if ($formHandler->process()) {
            //$this->app->user()->setFlash('flash','Le commentaire a bien été ajouté, merci !');
            $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !', 'success');

            $this->app->httpResponse()->redirect('news-' . $request->getData('id') . '.html');
        }

        $this->page->addVar('comment', $comment);
        $this->page->addVar('form', $form->createView());
        $this->page->addVar('title', 'Ajout d\'un commentaire');
    }

    public function executeReportComment(HTTPRequest $request)
    {
        $this->managers->getManagerOf('Comments')->report($request->getData('id'));

        // $this->app->user()->setFlash('flash','Le commentaire a bien été signalé !');
        $this->app->user()->setFlash('Le commentaire a bien été signalé !', 'success');

        $this->app->httpResponse()->redirect('news-' . $request->getData('idNews') . '.html');

    }
}