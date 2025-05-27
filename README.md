# events_management 

# 📘 Eventify API – Documentation

API RESTful pour la gestion d'événements et de réservations. Implémentée avec Laravel, sécurisée avec Laravel Sanctum.

---

## 🔐 Authentification

### `POST /api/register`

**Inscription d’un utilisateur**

**Body JSON** :

```json
{
  "lastname": "Doe",
  "firstname": "John",
  "date_of_birth": "1990-01-01",
  "username": "johndoe",
  "email": "john@example.com",
  "password": "yourPassword",
  "password_confirmation": "yourPassword"
}
```

**Réponses** :

* `201 Created` : utilisateur enregistré
* `422 Unprocessable Entity` : erreur de validation

---

### `POST /api/login`

**Connexion utilisateur**

**Body JSON** :

```json
{
  "username": "johndoe",
  "password": "yourPassword"
}
```

**Réponse** :

```json
{
  "access_token": "auth_token_here",
  "token_type": "Bearer"
}
```

---

### `POST /api/logout`

**Déconnexion de l’utilisateur**

**Headers** :

```
Authorization: Bearer {token}
```

**Réponse** : `200 OK`

---

## 👤 Utilisateur

### `GET /api/user/profile`

**Afficher les informations du profil utilisateur**

**Headers** : `Authorization: Bearer {token}`
**Réponse** :

```json
{
  "id": 1,
  "firstname": "John",
  "lastname": "Doe",
  "username": "johndoe",
  ...
}
```

---

### `PUT /api/user/profile`

**Modifier les informations du profil utilisateur**

**Headers** : `Authorization: Bearer {token}`
**Body JSON (exemple)** :

```json
{
  "firstname": "Jane",
  "lastname": "Smith",
  ...
}
```

---

## 📅 Événements

### `POST /api/events/create`

**Créer un événement (admin uniquement)**

**Headers** : `Authorization: Bearer {token}`
**Body JSON** :

```json
{
  "title": "Conférence Laravel",
  "description": "Introduction à Laravel",
  "datetime": "2025-07-01T10:00:00",
  "location": "Ouagadougou",
  "category": "Conférence",
  "capacity": 100
}
```

---

### `GET /api/events`

**Lister tous les événements disponibles**
**Headers** : `Authorization: Bearer {token}`
**Réponse** : liste d’objets `Event`

---

### `GET /api/events/{id}`

**Afficher les détails d’un événement**

**Headers** : `Authorization: Bearer {token}`

---

### `PUT /api/events/{id}`

**Modifier un événement (admin uniquement)**

**Headers** : `Authorization: Bearer {token}`
**Body JSON** : champs modifiables

---

### `DELETE /api/events/{id}`

**Supprimer un événement (admin uniquement)**

**Headers** : `Authorization: Bearer {token}`

---

## 🎟️ Réservations

### `POST /api/events/{id}/book`

**Réserver des places pour un événement**

**Headers** : `Authorization: Bearer {token}`
**Body JSON** :

```json
{
  "nb_places": 2
}
```

---

### `GET /api/user/reservations`

**Lister les réservations de l’utilisateur connecté**

**Headers** : `Authorization: Bearer {token}`
**Réponse** :

```json
[
  {
    "id": 1,
    "event": { "title": "Concert de Jazz", ... },
    "nb_places": 3
  },
  ...
]
```

---

### `DELETE /api/user/reservations/{id}`

**Annuler une réservation**

**Headers** : `Authorization: Bearer {token}`
**Conditions** : Seul le propriétaire peut annuler la reservation

---

### `GET /api/events/{id}/reservations`

**Lister les réservations d’un événement (admin uniquement)**

**Headers** : `Authorization: Bearer {token}`
**Réponse** :

```json
[
  {
    "user": {
      "username": "johndoe"
    },
    "nb_places": 2
  },
  ...
]
```

---

## ⚠️ Codes d’erreur courants

* `401 Unauthorized` : Token manquant ou invalide
* `403 Forbidden` : Accès refusé (ex : non-admin)
* `404 Not Found` : Ressource inexistante
* `422 Unprocessable Entity` : Erreur de validation

---

## 🛡️ Sécurité

Toutes les routes protégées sont sécurisées avec Laravel Sanctum. Les utilisateurs doivent envoyer leur token avec l’en-tête suivant :

```
Authorization: Bearer {token}
```

---

## 📧 Auteur

**Kamon A. M. Prosper-Adrien SOURABIE**
📧 [mandelasourabie@gmail.com](mailto:mandelasourabie@gmail.com)

---
