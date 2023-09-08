# Endpoints API

| Contrôleur                | Endpoint                            | Méthodes HTTP | Description                            |
|---------------------------|-------------------------------------|---------------|----------------------------------------|
| ApiCharacterController    | `/api/character`                    | GET           | Liste des personnages                 |
| ApiCharacterController    | `/api/home-character`               | GET           | Liste des cinq premiers personnages   |
| ApiCharacterController    | `/api/character/{id}`               | GET           | Afficher un personnage donné        |
| ApiComicsController       | `/api/comics`                       | GET           | Liste des comics                      |
| ApiComicsController       | `/api/comics/{id}`                  | GET           | Afficher un comics donné               |
| ApiComicsController       | `/api/home-comics`                  | GET           | Liste des neuf premiers comics        |
| ApiComicsController       | `/api/search-comics`                | GET           | Rechercher des comics par titre       |
| ApiComicsController       | `/api/admin/comics/add`             | POST          | Ajouter un comic                      |
| ApiComicsController       | `/api/admin/comics/update/{id}`     | PUT           | Update un comics       |
| ApiComicsController       | `/api/admin/comics/delete/{id}`     | DELETE        | Supprimer un comics          |
| ApiOwnListController      | `/api/ownedlist`                    | GET           | Liste des comics possédés par l'utilisateur |
| ApiOwnListController      | `/api/ownedlist/add/{comicsId}`     | POST          | Ajouter un comics à la liste des comics possédés par l'utilisateur     |
| ApiOwnListController      | `/api/ownedlist/remove/{comicsId}`  | DELETE        | Retirer un comics de la liste des comics possédés par l'utilisateur    |
| ApiWishListController     | `/api/wishlist`                     | GET           | Liste de la wishlist de l'utilisateur |
| ApiWishListController     | `/api/wishlist/add/{comicsId}`      | POST          | Ajouter un comics à la wishlist de l'utilisateur      |
| ApiWishListController     | `/api/wishlist/remove/{comicsId}`   | DELETE        | Retirer un comics de la wishlist de l'utilisateur     |
| ApiRegisterController     | `/api/register`                     | POST          | Créer un nouvel utilisateur           |