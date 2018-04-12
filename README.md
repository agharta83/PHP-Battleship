# oBattleShip

:spock-hand: Hello Galaxy 🌌
Ta mission, aujourd'hui : réaliser un jeu de bataille navale !

Rappel des règles du jeu : https://fr.wikipedia.org/wiki/Bataille_navale_(jeu).


* Le placement des vaisseaux sera aléatoire
* L'adversaire sera dans un premier temps une IA
* Ton code sera :
  - en objet,
  - basé sur MVC,
  - et tu géreras les dépendances du projet avec Composer.

## Instructions

0. Explorer le code fourni

1. Initialisation du projet
Avec Composer :
  - initialiser ce projet
  - configurer les dépendances : Altorouter, Plates et [le var_dumper de Symfony](https://packagist.org/packages/symfony/var-dumper)
  - configurer le namespace pour le code de notre jeu : BattleShip

2. Base du projet, route `/`

Créer le squelette du projet, et afficher le tableau de jeu sur la page d'accueil.  
_Amélioration : rendre complètement dynamique l'affichage de ces tableaux._


3. Conception des modèles
Quelles classes sont utiles pour notre jeu ?
- créer une classe Board représentant un plateau de jeu. Quelles sont ses caractéristiques ?
- modifier le code existant pour que les tableaux soient générés selon les caractéristiques de la classe Board créée.

4. Générer une nouvelle map
- Bouton "Nouvelle partie" qui déclenche un appel AJAX à la route ajax/generate
- Créer la méthode de controller correspondante
- afficher le résultat côté Front

5. Tir
- détecter le clic sur le tableau "vos tirs"
- faire la méthode de controller correspondante

6. Tir de l'IA
- déclencher l'appel à dodge
- faire la méthode de controller correspondante
