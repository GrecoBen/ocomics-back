# Endpoints API

| Contrôleur                | Endpoint                            | Méthodes HTTP | Description                            |
|---------------------------|-------------------------------------|---------------|----------------------------------------|
| ApiCharacterController    | `/api/character`                    | GET           | List all the characters                 |
| ApiCharacterController    | `/api/home-character`               | GET           | List the five first characters   |
| ApiCharacterController    | `/api/character/{id}`               | GET           | Show a specific character       |
| ApiComicsController       | `/api/comics`                       | GET           | List all the comics                      |
| ApiComicsController       | `/api/comics/{id}`                  | GET           | Show a specific comics            |
| ApiComicsController       | `/api/home-comics`                  | GET           | List of the nine first comics        |
| ApiComicsController       | `/api/search-comics`                | GET           | Search comics by title      |
| ApiComicsController       | `/api/admin/comics/add`             | POST          | Add a comics                      |
| ApiComicsController       | `/api/admin/comics/update/{id}`     | PUT           | Update a comics       |
| ApiComicsController       | `/api/admin/comics/delete/{id}`     | DELETE        | Delete a comics          |
| ApiOwnListController      | `/api/ownedlist`                    | GET           | List all the comics owned by a user |
| ApiOwnListController      | `/api/ownedlist/add/{comicsId}`     | POST          | Add a comics in the list of the comics owned by a user    |
| ApiOwnListController      | `/api/ownedlist/remove/{comicsId}`  | DELETE        | Delete a comics  |
| ApiWishListController     | `/api/wishlist`                     | GET           | List all the comics that a user wish to have |
| ApiWishListController     | `/api/wishlist/add/{comicsId}`      | POST          | Add a comics in the list of the comics a user wish to have     |
| ApiWishListController     | `/api/wishlist/remove/{comicsId}`   | DELETE        | Remove a comics in the list of the comics a user wish to have    |
| ApiRegisterController     | `/api/register`                     | POST          | Create a new User          |