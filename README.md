Bookhome
=======

Bookhome est une API permettant la gestion locative de différents biens par utilisateur.
Il est possible d'effectuer des réservations, ainsi que d'ajouter des taches ou une liste de courses par location.

- [Installation en local avec docker](#installation-en-local-avec-docker)
- [GraphQL](#graphql)


Installation en local avec docker
---------------------------------

**Pré-requis**:

- docker
- docker-compose

**Instructions**:
- Créer le fichier `.env.local` avec le contenu suivant :

```dotenv
DATABASE_URL=mysql://user:user@database:3306/bookhome
```

- Installer [mkcert](https://github.com/FiloSottile/mkcert#installation) pour générer les certificats ssl en local, puis exécuter les commandes suivantes :

```bash
mkcert -install
mkcert api.bookhome.fr.lan

# déplacer les 2 fichiers créés dans le dossier docker/nginx/certs en les renommant
mv api.bookhome.fr.lan-key.pem docker/nginx/certs/bookhome.key
mv api.bookhome.fr.lan.pem docker/nginx/certs/bookhome.crt
```
- Exécuter les commandes suivantes :

```bash
# Lancer les conteneurs
docker-compose build
docker-compose up -d

# Installer les dépendances
docker exec -it bookhome_php_1 composer install
docker exec -it bookhome_php_1 bin/console doctrine:migration:migrate --no-interaction
docker exec -it bookhome_php_1 bin/console doctrine:fixtures:load --no-interaction
docker exec -it bookhome_php_1 bin/console lexik:jwt:generate-keypair
```

- Ajouter ce nom de domaine à votre fichier dns en local :

Il s'agit de `/etc/hosts` sur linux, et `c:\Windows\System32\Drivers\etc\hosts` sur Windows.

```txt
# bookhome
127.0.0.1 api.bookhome.fr.lan
```

GraphQL
---------------------------------
**URL**
```txt
 https://api.bookhome.fr.lan/graphql
```

**Authentification**
```bash
curl -X 'POST' \
  --insecure 'https://api.bookhome.fr.lan/login' \
  -H 'Content-Type: application/json' \
  -d '{
    "email": "jdurand@bookhome.com",
    "password": "admin"
  }'
```

Réponse :
```json
{"token":"<token JWT>","refresh_token":"<refresh Token>"}
```

**Refresh Token**
```bash
curl -X 'POST' \
 --insecure 'https://api.bookhome.fr.lan/token/refresh' \
 -d refresh_token="<refresh Token>"
```

Réponse :
```json
{"token":"<token JWT>","refresh_token":"<refresh Token>"}
```

**Exemple**
Info sur l'utilisateur connecté
```graphql
{
  meUser{
    id
    email
    firstname
  }
}
```
```bash
curl -g -X 'POST' \
  --insecure 'https://api.bookhome.fr.lan/graphql' \
  -H 'Content-Type: application/json' \
  -H 'Authorization: Bearer <token JWT>' \
  -d '{"query":"query{meUser{id email firstname}}"}'
```

Réponse :
```json
{
  "data": {
    "meUser": {
      "id": "\/users\/1",
      "email": "admin@bookhome.com",
      "firstname": "admin"
    }
  }
}
```

Créer une nouvelle réservation
```graphql
mutation {
  createBooking(input:{start:"2021-06-30", finish:"2021-07-02 12:00", location:"/locations/1", quantity:2}) {
    booking {
      id
      start
      finish
    }
  }
}
```