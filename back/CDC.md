# Résumé

Le but de ce projet est simplement de faciliter l’organisation et la gestion de stands, sur un marché, par exemple. Typiquement, Un utilisateur doit voir au premier coup d'œil quelles sont les personnes qui tiennent le stand, à quelle(s) date(s), quel(s) créneau(x) horaire(s) et où.
L’utilisateur lambda doit pouvoir se connecter pour voir l’affichage. L’administrateur et les modérateurs peuvent ajouter-modifier-supprimer des informations.

L’idée est aussi de permettre à un utilisateur lambda d'envoyer une notification à l'admin et aux modérateurs pour s'inscrire sur un créneau....
Cet utilisateur voit un créneau de libre. Il pourrait cliquer dessus, soumettre un formulaire "Demande de réservation" => "Avec quelqu’un" ou "En attente" (comme ils doivent être deux).
L'admin reçoit une notification, et accepte ou non l'inscription et renvoie la réponse à l'utilisateur.

# Cahier des charges:

- ### Authentification et autorisation :

Les utilisateurs lambda peuventoivent se connecter pour voir l'affichage.
L'administrateur et les modérateurs ont des privilèges pour ajouter, modifier et supprimer des informations.

- ### Affichage des stands :

Afficher les informations sur les stands, y compris les personnes, les dates et les créneaux horaires.

- ### Réservation de créneaux :

Les utilisateurs lambda peuvent soumettre des demandes de réservation pour les créneaux libres.
Les demandes peuvent être soumises avec un partenaire spécifique ou en attente d'un partenaire.
Les administrateurs reçoivent des notifications pour approuver la réservation ou signaler que le créneau est déjà pris.

## Routes API (REST) :

- Authentification :

```
/api/login - Se connecter avec des informations d'identification.
Méthode : POST
Code de retour : 200 OK si la connexion réussit, 401 Unauthorized si les informations d'identification sont incorrectes.
Contrôleur : AuthController
```

- Stands et Créneaux horaires :

```
/api/stands - Obtenir la liste des stands.
Méthode : GET
Code de retour : 200 OK avec la liste des stands, 404 Not Found si les stands sont introuvables.
Contrôleur : StandController
```

```
/api/stands/{id} - Obtenir les détails d'un stand spécifique.
Méthode : GET
Code de retour : 200 OK avec les détails du stand, 404 Not Found si le stand n'est pas trouvé.
Contrôleur : StandController
```

```
/api/schedule - Obtenir le planning des créneaux horaires.
Méthode : GET
Code de retour : 200 OK avec le planning des créneaux horaires, 404 Not Found si les créneaux horaires ne sont pas trouvés.
Contrôleur : ScheduleController
```

```
/api/schedule/{date} - Obtenir les créneaux horaires disponibles pour une date donnée.
Méthode : GET
Code de retour : 200 OK avec les créneaux horaires disponibles, 404 Not Found si les créneaux horaires ne sont pas trouvés.
Contrôleur : ScheduleController
```

- Gestion des réservations :

```
GET /api/reservations - Obtenir la liste des réservations.
Méthode : GET
Code de retour : 200 OK avec la liste des réservations, 404 Not Found si les réservations ne sont pas trouvées.
Contrôleur : ReservationController
```

```
GET /api/reservations/{id} - Obtenir les détails d'une réservation spécifique.
Méthode : GET
Code de retour : 200 OK avec les détails de la réservation, 404 Not Found si la réservation n'est pas trouvée.
Contrôleur : ReservationController
```

```
POST /api/reservations/request - Soumettre une demande de réservation.
Méthode : POST
Code de retour : 201 Created si la demande est soumise avec succès, 400 Bad Request si les données sont invalides.
Contrôleur : ReservationController
```

```
PUT /api/reservations/{id}/approval - Accepter ou refuser une réservation spécifique.
Méthode : PUT
Code de retour : 200 OK si la mise à jour est réussie, 404 Not Found si la réservation n'est pas trouvée, 400 Bad Request si les données sont invalides.
Contrôleur : ReservationController
```

## Entités :

- ##### Utilisateur

```
  ID (unique identifier)
Name
Email
Password (encrypted)
Role (lambda, administrator, moderator)
```

- ##### Stand

```
ID (unique identifier)
Name
Location
```

- ##### Créneau Horaire

```
ID (unique identifier)
Datetime
Stand_ID (foreign key linked to Stand entity)
```

- ##### Réservation

```
ID (unique identifier)
Status (pending, accepted, refused)
User_ID (foreign key linked to User entity)
TimeSlot_ID (foreign key linked to Time Slot entity)

```
