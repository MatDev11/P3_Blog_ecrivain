<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 25/07/2017
 * Time: 15:46
 */

namespace Services;

use \Entity\Comment;


class EditComment
{
    public function InsertComment($request,$depth,$repComments,$parent_id)
    {
               if ($parent_id != 0) {

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
                'depth' => $depth,
                'report' =>$request->postData('report') ,
            ]);

        return $comment;
    }
}