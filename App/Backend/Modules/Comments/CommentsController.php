<?php
namespace App\Backend\Modules\Comments;

use core\BackController;
use core\FormHandler;
use core\HTTPRequest;
use Entity\Comment;
use FormBuilder\CommentFormBuilder;


class CommentsController extends BackController
{


    private function getChildrenIds($comment)
    {

        if (isset($comment->children)) {
            $ids = [];
            foreach ($comment->children as $child) {
                $ids[] = $child->id();
                if (isset($child->children)) {
                    $ids = array_merge($ids, $this->getChildrenIds($child));
                }
            }
            return $ids;
        }
    }

    public function executeDeleteComment(HTTPRequest $request)
    {
        $comments = $this->managers->getManagerOf('Comments')->getListOf($_POST['news']);

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

        $ids = $this->getChildrenIds($comments_by_id[$_POST['id']]);
        $ids[] = $_POST['id'];

        $this->managers->getManagerOf('Comments')->deleteWithChildren($ids);

        $this->app->user()->setFlash('Le commentaire a bien été supprimé !');

        $this->app->httpResponse()->redirect('./comments/');
    }

    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Gestion des commentaires');

        $manager = $this->managers->getManagerOf('Comments');

        $this->page->addVar('listeComments', $manager->getList());
        $this->page->addVar('nombreComments', $manager->count());
    }

    public function executeInsert(HTTPRequest $request)
    {
        $this->processForm($request);

        $this->page->addVar('title', 'Ajout d\'un');
    }

    public function executeUpdateComment(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Modification d\'un commentaire');

        if ($request->method() == 'POST') {
            $comment = new Comment([
                'id' => $request->getData('id'),
                'auteur' => $request->postData('auteur'),
                'report' => $request->postData('report'),
                'contenu' => $request->postData('contenu')
            ]);
        } else {
            $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if ($formHandler->process()) {
            $this->app->user()->setFlash('Le commentaire a bien été modifié');

            $this->app->httpResponse()->redirect('./comments/');
        }

        $this->page->addVar('form', $form->createView());
    }


}