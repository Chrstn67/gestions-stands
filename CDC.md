Noms, Lieux, Crénaux horaire => Back

Utilisateurs (connexion obligatoire):

- Lambda -> Accès aux données correspondantes à une date
- Admin + Modérateur -> Accès backoffice -> Ajoute-modifie-supprime des infos dans le calendrier

Routes:

1. Route : GET /sites

- Permet de récupérer la liste des lieux disponibles.
  Récupérer les détails d'un site en fonction d'une date (créneaux horaires) :

2. Route : GET /sites/:code_site/:date

- Permet de récupérer les créneaux horaires disponibles pour un site donné à une date donnée.

3. Route : GET /runners

- Permet de récupérer la liste des personnes tenant le stand.
  Récupérer les détails d'un runner en fonction de son code :

4. Route : GET /runners/:code_runner

- Permet de récupérer les détails (y compris le site) d'une personne tenant le stand en utilisant son code.

5. Route : POST /runs

- Permet d'ajouter une correspondance entre un runner et un site pour une date donnée.

6. Route : PUT /runs/:id

- Permet de mettre à jour la correspondance entre un runner et un site (peut être utilisée pour changer de runner ou de site pour une date donnée).

7. Route : DELETE /runs/:id

- Permet de supprimer une correspondance entre un runner et un site pour une date donnée.
