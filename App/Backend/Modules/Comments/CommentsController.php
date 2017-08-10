<?php
namespace App\Backend\Modules\Comments;

use core\BackController;
use core\FormHandler;
use core\HTTPRequest;
use Entity\Comment;
use FormBuilder\CommentFormBuilder;
use Services\ChildrenIds;
use Services\CommentsLevel;
use Services\csrf;


class CommentsController extends BackController
{

    public function executeDeleteComment(HTTPRequest $request)
    {
        $csrf = new csrf();

        if ($csrf->getCsrf() == true) {
            $comments = $this->managers->getManagerOf('Comments')->getListOf($_POST['news']);

            $commentsLevel = new CommentsLevel($comments);
            $comments_by_id = $commentsLevel->getCommentsLevel($comments, true);

            $childrenIds = new ChildrenIds();
            $ids = $childrenIds->getChildrenIds($comments_by_id[$_POST['id']]);
            $ids[] = $_POST['id'];

            $this->managers->getManagerOf('Comments')->deleteWithChildren($ids);

            $this->app->user()->setFlash('Le commentaire a bien été supprimé !', 'success');

        } else {

            $this->app->user()->setFlash('Le commentaire n\'a pas été supprimé !', 'danger');
        }
        $this->app->httpResponse()->redirect('./comments/');

    }

    public function executeIndex(HTTPRequest $request)
    {

        $token = $this->app->user()->getToken();
        $this->page->addVar('token', $token);
        $this->page->addVar('title', 'Gestion des commentaires');
        $manager = $this->managers->getManagerOf('Comments');
        $this->page->addVar('listeComments', $manager->getList());
        $this->page->addVar('nombreComments', $manager->count());
    }

    public function executeUpdateComment(HTTPRequest $request)
    {
        $this->processForm($request);
        $token = $this->app->user()->getToken();
        $this->page->addVar('token', $token);
        $this->page->addVar('title', 'Modification d\'un commentaire');
    }

    public function processForm(HTTPRequest $request)
    {
        if ($request->method() == 'POST') {
            $csrf = new csrf();
            if ($csrf->getCsrf() == true) {
                $comment = new Comment([
                    'id' => $request->getData('id'),
                    'auteur' => $request->postData('auteur'),
                    'report' => $request->postData('report'),
                    'contenu' => $request->postData('contenu')
                ]);
            } else {
                $this->app->user()->setFlash('Le commentaire n\'a pas été supprimé !', 'danger');
                $this->app->httpResponse()->redirect('./comment-update-' . $request->getData('id') . '.html');
            }
        } else {
            $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if ($formHandler->process()) {
            $this->app->user()->setFlash('Le commentaire a bien été modifié', 'success');

            $this->app->httpResponse()->redirect('./comments/');
        }
        $this->page->addVar('form', $form->createView());
    }


}