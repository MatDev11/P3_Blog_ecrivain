<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 25/07/2017
 * Time: 15:46
 */

namespace Services;


class CommentsLevel
{

    public function getCommentsLevel($comments,$editCom)
    {
       // $comments_by_id = $this->CommentsById($comments);
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
        if($editCom != true){
            return $comments;
        }
        else
        {
            return $comments_by_id;
        }

    }



}