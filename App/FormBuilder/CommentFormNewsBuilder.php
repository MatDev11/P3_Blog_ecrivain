<?php
namespace FormBuilder;


use \core\FormBuilder;
use \core\StringField;
use \core\TextField;
use \core\MaxLengthValidator;
use \core\NotNullValidator;

class CommentFormNewsBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->add(new StringField([
            'label' => 'Auteur',
            'name' => 'auteur',
            'class' => 'form-control',
            'maxLength' => 50,
            'validators' => [
                new MaxLengthValidator('L\'auteur spécifié est trop long (50 caractères maximum)', 50),
                new NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
            ],
        ]))

            ->add(new TextField([
                'label' => 'Contenu',
                'name' => 'contenu',
                'class' => 'form-control',
                'rows' => 7,
                'cols' => 50,
                'validators' => [
                    new NotNullValidator('Merci de spécifier votre commentaire'),
                ],
            ]));
    }

    

}