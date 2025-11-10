# 🍞 Kenangan Bakery API Documentation

RESTful API untuk sistem manajemen **Kenangan Bakery**.  
API ini mencakup autentikasi, manajemen cabang, unit bahan, bahan baku, pengguna (admin, manager, employee, courier, customer), serta **riwayat bahan baku (ingredient history)**.

---

## ⚙️ Base URL
```
http://yourdomain.com/api
```
Semua endpoint diawali dengan `/api/`.

---

## 🔑 Auth
### Login
**POST** `/auth/login`
```json
{
  "login": "anggerja",
  "password": "angger12"
}
```
**Response**
```json
{
  "success": true,
  "message": "Berhasil Login",
  "user": {
    "id": 6,
    "username": "anggerja",
    "email": "anggera@gmail.com",
    "role_id": 1,
    "role": {
      "id": 1,
      "role_name": "admin"
    }
  },
  "token": "7|NNU82L2kilMAF5OYCzeIF8Q4ZNuQO7cOeovxOCZRd91a3f42"
}
```

### Register
**POST** `/auth/register`
```json
{
  "username": "anggerjaa",
  "email": "angger1222@gmail.com",
  "password": "angger12"
}
```
**Response**
```json
{
  "success": true,
  "message": "Registrasi customer berhasil!",
  "data": {
    "user": {
      "username": "anggerjaa",
      "email": "angger1222@gmail.com",
      "role_id": 3,
      "id": 7
    },
    "token": "8|wOGyGgRBDF3ey4uZhP7sTW0t9KBezB45Tk3jh7Ynfb9e68d0"
  }
}
```

---

## 🏢 Branch
### GET
`GET /branch`
### POST
```json
{
  "name": "Kenangan Bakery Cipinang",
  "address": "angger12",
  "city": "Jakarta Timur",
  "province": "Jakarta",
  "open": 9,
  "close": 21,
  "phone_number": "098475424",
  "email": "adsfkj@meries.com"
}
```
### PUT
`PUT /branch/{id}`
### DELETE
`DELETE /branch/{id}`

---

## 📏 Unit
### GET
`GET /units`
### POST
```json
{ "unit_name": "kg" }
```
### PUT
`PUT /units/{id}`
```json
{ "unit_name": "gram" }
```
### DELETE
`DELETE /units/{id}`

---

## 🧂 Ingredient
### GET
`GET /ingredients`
### POST
```json
{
  "unit_id": 1,
  "name": "Tepung",
  "price": 50000
}
```
### PUT
`PUT /ingredients/{id}`
```json
{
  "unit_id": 1,
  "name": "Tepung Terigu",
  "price": 50000
}
```
### DELETE
`DELETE /ingredients/{id}`

---

## 🧩 Roles
### GET
`GET /roles`
### POST
```json
{ "role_name": "employee" }
```
### PUT
`PUT /roles/{id}`
```json
{ "role_name": "manager" }
```
### DELETE
`DELETE /roles/{id}`

---

## 👤 Customer
### GET
`GET /customers`
### POST
```json
{
  "username": "rachel123",
  "email": "rachel@example.com",
  "password": "secret123",
  "fullname": "Rachel Green",
  "quickname": "Rach",
  "address": "Jl. Melati No. 45, Bandung",
  "phone_number": "081234567890"
}
```
### PUT
`PUT /customers/{id}`
### DELETE
`DELETE /customers/{id}`

---

## 👨‍🍳 Employee
### GET
`GET /employees`
### POST
```json
{
  "username": "budi23",
  "email": "budi@examle.com",
  "password": "rahasia123",
  "branch_id": 3,
  "fullname": "Budi Santoso",
  "address": "Jl. Mawar No. 45, Jakarta Selatan",
  "phone_number": "081234567890"
}
```
### PUT
`PUT /employees/{id}`
### DELETE
`DELETE /employees/{id}`

---

## 👔 Manager
### GET
`GET /managers`
### POST
```json
{
  "branch_id": 3,
  "fullname": "Angger Firlana Updated",
  "address": "Jl. Mawar No. 99, Bekasi",
  "phone_number": "08987654321",
  "username": "angger_updated",
  "email": "angger_updated@example.com",
  "password": "newpass123",
  "password_confirmation": "newpass123"
}
```
### PUT
`PUT /managers/{id}`
### DELETE
`DELETE /managers/{id}`

---

## 🚚 Courier
### GET
`GET /couriers`
### POST
```json
{
  "branch_id": 3,
  "fullname": "New courier",
  "address": "Jl. Mawar No. 99, Bekasi",
  "phone_number": "08987654321",
  "username": "courier",
  "email": "courieradded@example.com",
  "password": "newpass123",
  "password_confirmation": "newpass123"
}
```
### PUT
`PUT /couriers/{id}`
### DELETE
`DELETE /couriers/{id}`

---

## 🧾 Ingredient History
### GET
`GET /ingredient-history`
**Response**
```json
{
  "success": true,
  "message": "Success received data",
  "current_page": 1,
  "per_page": 10,
  "total": 2,
  "last_page": 1,
  "data": [
    {
      "id": 2,
      "branch_id": 3,
      "received_date": "2025-11-10T00:00:00.000000Z",
      "quantity": 50,
      "expired_date": "2025-12-10T00:00:00.000000Z",
      "status": "new_stock",
      "created_at": "2025-11-10T04:04:44.000000Z",
      "updated_at": "2025-11-10T04:04:44.000000Z"
    }
  ]
}
```
### POST
`POST /ingredient-history`
```json
{
  "branch_id": 3,
  "received_date": "2025-11-10",
  "quantity": 50,
  "expired_date": "2025-12-10",
  "status": "new_stock"
}
```
**Response**
```json
{
  "success": true,
  "message": "Ingredient history successfully added",
  "data": {
    "branch_id": 3,
    "received_date": "2025-11-10T00:00:00.000000Z",
    "quantity": 50,
    "expired_date": "2025-12-10T00:00:00.000000Z",
    "status": "new_stock",
    "updated_at": "2025-11-10T04:04:44.000000Z",
    "created_at": "2025-11-10T04:04:44.000000Z",
    "id": 2
  }
}
```
### PUT
`PUT /ingredient-history/{id}`
```json
{
  "branch_id": 3,
  "received_date": "2025-11-10",
  "quantity": 50,
  "expired_date": "2025-12-10",
  "status": "old_stock"
}
```
**Response**
```json
{
  "success": true,
  "message": "Ingredient history successfully updated",
  "data": {
    "id": 1,
    "branch_id": 3,
    "received_date": "2025-11-10T00:00:00.000000Z",
    "quantity": 50,
    "expired_date": "2025-12-10T00:00:00.000000Z",
    "status": "old_stock",
    "created_at": "2025-11-10T04:04:21.000000Z",
    "updated_at": "2025-11-10T04:06:45.000000Z"
  }
}
```
### DELETE
`DELETE /ingredient-history/{id}`
**Response**
```json
{
  "success": true,
  "message": "Ingredient history successfully deleted"
}
```
