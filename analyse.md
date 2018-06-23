# Notes de conception/dev

## Données de jeu à stocker en session
- player
  - Board
  - shots
- opponent
  - Board
  - shots


## Les bateaux
Les bateaux doivent être d'un type parmis les suivants :
1	Carrier	5
2	Battleship	4
3	Cruiser	3
4	Submarine	3
5	Destroyer	2


Tous les bateaux ont les mêmes caractéristiques :

Certaines caractéristiques dépendent directement du type de bateau :
- name
- size

caractéristiques de jeu : vont changer pour chaque bateau, selon comment on va jouer avec
- latStart
- longStart
- axe (vertical, horizontal)
- nbTouch = 0

### Modélisation objet ?
- une classe CoreShip qui définit le comportement générique de tous les bateaux
- une classe par type de bateau, qui hérite de CoreShip et précise les caractéristiques particulières de son type.



## Etats d'une case

#### Board "Vos Tirs"
- vide
```
<div class="column bs-case">
  <div></div>
</div>
```

- plouf
```
<div class="column bs-case">
  <div class="bs-case__empty"></div>
</div>
```

- touché
```
<div class="column bs-case">
  <div class="bs-case__fire"></div>
</div>
```

### Board "Vos vaisseaux"
- plouf
```
<div class="column bs-case">
  <div class="bs-case__empty"></div>
</div>
```

- bateau
```
<div class="column bs-case">
  <div class="bs-case__ship"></div>
</div>
```

- bateau touché
```
<div class="column bs-case">
  <div class="bs-case__ship-touch"></div>
</div>
```


## Gameplay avec IA
_- J1: on espère aller jusqu'au codage de la fonction "nouvelle partie"_
_- chaque `==>` représente une communication entre client et serveur_


Déroulement d'une partie :

1. Nouvelle partie
- *FRONT* Cliquer sur le bouton "nouvelle partie"
==>
- *BACK*
  - Génération de 2 plateaux de jeu (pour le joueur et pour l'adversaire)
  - Placement aléatoire des bateaux sur ces plateaux
  - est renvoyé au Front, la map du joueur
==>
- *FRONT* reçois la map Joueur et l'affiche dans le tableau de droite

PUIS
2. Shooter l'adversaire
- *FRONT* détecter le clic sur une case du board Adversaire ("vos tirs")
==>
- *BACK*
  - vérifie s'il y a qqchose dans la case cliquée dans le board adversaire
  - envoie "touch" "not touch"
==>
- *FRONT*
  - reçoit le résultat,
  - met à jour l'affichage du tableau de l'adversaire
  ...
  - demande au serveur de jouer à son tour ("dodge")

==>
3. A l'IA de jouer
- *BACK*
  - choisis une case au hasard, (qu'il n'a pas encore shootée)
  - vérifie si la board du joueur contient qqchose dans cette case
  - envoie au Front les coordonnées de la case choisir par l'adversaire/IA et le résultat
==>
- *FRONT*
  - mets à jour le board du joueur (droite) avec le résultat du coup de l'adversaire
