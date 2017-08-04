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

        }
        else {

            $this->app->user()->setFlash('Le commentaire n\'a pas été supprimé !', 'danger');
        }
            $this->app->httpResponse()->redirect('./comments/');


    }

    public function executeIndex(HTTPRequest $request)
    {
        $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $_SESSION['token'] = $token;
        $this->page->addVar('token', $token);

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


        $this->page->addVar('token',  $_SESSION['token']);


        $this->page->addVar('title', 'Modification d\'un commentaire');

        if ($request->method() == 'POST') {
            $csrf = new csrf();
            if ($csrf->getCsrf() == true) {
                $comment = new Comment([
                    'id' => $request->getData('id'),
                    'auteur' => $request->postData('auteur'),
                    'report' => $request->postData('report'),
                    'contenu' => $request->postData('contenu')
                ]);
            }
            else {
                $this->app->user()->setFlash('Le commentaire n\'a pas été supprimé !', 'danger');
                $this->app->httpResponse()->redirect('./comment-update-'.$request->getData('id').'.html');
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