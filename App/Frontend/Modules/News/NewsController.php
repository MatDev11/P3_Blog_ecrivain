<?php
namespace App\Frontend\Modules\News;

use \core\BackController;
use \core\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \core\FormHandler;

class NewsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $nombreNews = $this->app->config()->get('nombre_news');
        $nombreCaracteres = $this->app->config()->get('nombre_caracteres');

        // On ajoute une définition pour le titre.
        $this->page->addVar('titleSite', 'Blog Billet simple pour l\'Alaska');
        $this->page->addVar('subtitle', 'Jean Forteroche');
        $this->page->addVar('titlePage', 'Liste des ' . $nombreNews . ' dernières news');


        // On récupère le manager des news.
        $manager = $this->managers->getManagerOf('News');

        $listeNews = $manager->getList(0, $nombreNews);

        foreach ($listeNews as $news) {
            if (strlen($news->contenu()) > $nombreCaracteres) {
                $debut = substr($news->contenu(), 0, $nombreCaracteres);
                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

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

        $comments_by_id = [];


        foreach ($comments as $comment) {
            $comments_by_id[$comment->id()] = $comment;

        }

        foreach ($comments as $k => $comment) {

            if ($comment->idParent() != 0) {
                $comments_by_id[$comment->idParent()]->children[] = $comment;
                unset($comments[$k]);
            }
        }
        $this->page->addVar('comments', $comments);

        $this->executeInsertComment($request);
    }

    public function executeInsertComment(HTTPRequest $request)
    {
        // Si le formulaire a été envoyé.
        if ($request->method() == 'POST') {

            $depth = 0;
            $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
            //$parent_id = isset($request->postData('id_parent')) ? $request->postData('id_parent') : 0;
            if ($parent_id != 0) {
                // var_dump($parent_id); die();
                $repComments = $this->managers->getManagerOf('Comments')->findIdRep($parent_id);
                if ($repComments == false) {
                    throw new \Exception('Ce parent n\'exist pas');
                }
                $depth = $repComments->depth() + 1;
            }
            $comment = new Comment([
                'news' => $request->getData('id'),
                'auteur' => $request->postData('auteur'),
                'contenu' => $request->postData('contenu'),
                'idparent' => $parent_id,
                'report' => 0,
                'depth' => $depth
            ]);

        } else {
            $comment = new Comment;
        }


        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if ($formHandler->process()) {
            $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');

            $this->app->httpResponse()->redirect('news-' . $request->getData('id') . '.html');
        }

        $this->page->addVar('comment', $comment);
        $this->page->addVar('form', $form->createView());
        $this->page->addVar('title', 'Ajout d\'un commentaire');
    }

    public function executeReportComment(HTTPRequest $request)
    {
        $this->managers->getManagerOf('Comments')->report($request->getData('id'));

        $this->app->user()->setFlash('Le commentaire a bien été signalé !');

        $this->app->httpResponse()->redirect('news-'.$request->getData('news'));

    }
}