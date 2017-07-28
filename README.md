# Notice Blog Billet simple pour l'Alaska

<h3>Installation</h3>

* Version de PHP :  5.6.25
* Télécharger le projet au format .zip

## Base de donnée

* Créer une base de donnée 
* Importer le fichier BDD.sql  qui se trouve dans le fichier zip
* Pour modifier les données de connexion à la BDD, rendez-vous dans le fichier lib/core/PDOFactory.php  
 remplacer le name, log et mdp "$db = new \PDO('mysql:host=localhost;dbname=name', 'log', 'mdp');"

## Administration
* **Adminitrateur** :

    * identifiant par défaut loging = admin, password = mdp
    * Pour les modifier rendez-vous dans App/Backend/Config/app.xml  
    remplacer les value de loging et de pass 

* **Utilisation** :

    * Pour accéder à la page d'administration Cliquer sur *Administraion* connectez-vous  
    * Article : 
        * Pour l'ajouter cliquer sur ajouter, renseigner le formulaire puis cliquer *Ajouter*.    
        * Pour le modifier cliquer sur le bouton bleu dans action, modifier puis cliquer *Modifier* .  
        * Pour le supprimer cliquer sur le bouton rouge dans action.
    
   * Commentaire :
        * Pour le modifier cliquer sur le bouton bleu dans action, modifier puis cliquer *Modifier* .  
        * Pour le supprimer cliquer sur le bouton rouge dans action.

## Utilisation
    
   * Pour accéder à l'article cliquer sur *le titre* ou sur *Voir la suite*. 
   * Pour poster un commentaire renseigner le formulaire cliquer sur commenter.
   * Pour y répondre cliquer sur *Répondre* dans le commentaire .
   * Pour le sigaler cliquer sur *Signaler*.
