<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 25/07/2017
 * Time: 15:46
 */

namespace Services;


class ChildrenIds
{
    public function getChildrenIds($comment)
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
}