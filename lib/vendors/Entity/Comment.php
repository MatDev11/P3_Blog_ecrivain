<?php
namespace Entity;

use \core\Entity;

class Comment extends Entity
{

    protected $news,
        $auteur,
        $contenu,
        $date,
        $idParent,
        $depth,
        $report;//,
    //$children=[];

    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;

    public function isValid()
    {
        return !(empty($this->auteur) || empty($this->contenu));
    }

    public function setNews($news)
    {
        $this->news = (int)$news;
    }

    public function setAuteur($auteur)
    {
        if (!is_string($auteur) || empty($auteur)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }

        $this->auteur = $auteur;
    }

    public function setContenu($contenu)
    {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }

        $this->contenu = $contenu;
    }

    public function setIdParent($idParent)
    {
        return $this->idParent = $idParent;
    }

    public function setDepth($depth)
    {
        return $this->depth = $depth;
    }

    public function setReport($report)
    {
        return $this->report = $report;
    }


    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /* public function setChildren($children)
     {
         return $this->children = $children;
     }*/

    public function news()
    {
        return $this->news;
    }

    public function auteur()
    {
        return $this->auteur;
    }

    public function contenu()
    {
        return $this->contenu;
    }

    public function date()
    {
        return $this->date;
    }

    public function idParent()
    {
        return $this->idParent;
    }

    public function depth()
    {
        return $this->depth;
    }

    public function report()
    {
        return $this->report;
    }

    /* public function children()
     {
         return $this->children;
     }*/

}