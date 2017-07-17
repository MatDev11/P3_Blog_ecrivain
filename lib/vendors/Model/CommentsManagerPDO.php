<?php
namespace Model;

use Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
    protected function add(Comment $comment)
    {
        $q = $this->dao->prepare('INSERT INTO comments SET news = :news, auteur = :auteur, contenu = :contenu, id_parent = :idParent, depth = :depth, report = :report , date = NOW()');


        $q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());
        $q->bindValue(':idParent', $comment->idParent());
        $q->bindValue(':depth', $comment->depth());
        $q->bindValue(':report', $comment->report());

        $q->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM comments WHERE id = ' . (int)$id);
    }

    public function report($id)
    {
        $this->dao->exec('UPDATE comments SET report = 1  WHERE id = ' . (int)$id);
    }

    public function deleteFromNews($news)
    {
        $this->dao->exec('DELETE FROM comments WHERE news = ' . (int)$news);
    }

    public function getListOf($news)
    {
        if (!ctype_digit($news)) {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
        }

       // $q = $this->dao->prepare('SELECT id, news, auteur, contenu, date FROM comments WHERE news = :news');
        $q = $this->dao->prepare('SELECT *  FROM comments WHERE news = :news');
        $q->bindValue(':news', $news, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $comments = $q->fetchAll();

        foreach ($comments as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
            $comment->setIdParent($comment->id_parent);
        }

        return $comments;
    }

    protected function modify(Comment $comment)
    {
        $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');

        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());
        $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

        $q->execute();
    }

    public function get($id)
    {
        $q = $this->dao->prepare('SELECT * FROM comments WHERE id = :id');
        $q->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS , '\Entity\Comment');

        return $q->fetch();
    }

    public function getList()
    {
        $q = 'SELECT * FROM comments ';


        $requete = $this->dao->query($q);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');


        return  $requete->fetchAll();
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    public function findIdRep($id)
    {
        $q = $this->dao->prepare('SELECT id ,depth FROM comments WHERE  id = :id');
        $q->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        $q->execute();
        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        return $q->fetch();
    }

    public function findAllEnfant($idParent)
    {
        $q = $this->dao->prepare('SELECT * FROM comments WHERE id_parent = :idParent');
        $q->bindValue(':idParent', (int)$idParent, \PDO::PARAM_INT);
        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
        $q->execute();

        return $q->fetch();

    }

    public function deleteWithChildren($id)
    {

        $this->dao->exec('DELETE FROM comments WHERE id IN (' . implode(',', $id) . ')');

        // On supprime le commentaire et ses enfants
      //  return $this->pdo->exec('DELETE FROM comments WHERE id IN (' . implode(',', $ids) . ')');
    }



}