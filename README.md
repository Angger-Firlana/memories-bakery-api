# 🍞 Kenangan Bakery API Documentation

RESTful API untuk sistem manajemen **Kenangan Bakery**.  
API ini mencakup autentikasi, manajemen cabang, unit bahan, bahan baku, pengguna (admin, manager, employee, courier, customer), serta **riwayat bahan baku (ingredient history)**.

---

## ⚙️ Base URL
```
http://127.0.0.1:8000/
```

Semua endpoint diawali dengan `/api/`.

---

# 🔑 Auth (/api/auth)

## Login (/api/auth/login)
### Request
```json
{
  "login": "anggerja",
  "password": "angger12"
}
```
### Response
```json
{
  "success": true,
  "message": "Berhasil Login",
  "user": {
    "id": 6,
    "username": "anggerja",
    "email": "anggera@gmail.com",
    "email_verified_at": null,
    "role_id": 1,
    "created_at": "2025-11-02T08:10:41.000000Z",
    "updated_at": "2025-11-02T08:10:41.000000Z",
    "role": {
      "id": 1,
      "role_name": "admin",
      "created_at": null,
      "updated_at": null
    }
  },
  "token": "7|NNU82L2kilMAF5OYCzeIF8Q4ZNuQO7cOeovxOCZRd91a3f42"
}
```

## Register (/api/auth/register)
### Request
```json
{
  "username": "anggerjaa",
  "email": "angger1222@gmail.com",
  "password": "angger12"
}
```
### Response
```json
{
  "success": true,
  "message": "Registrasi customer berhasil!",
  "data": {
    "user": {
      "username": "anggerjaa",
      "email": "angger1222@gmail.com",
      "role_id": 3,
      "updated_at": "2025-11-07T04:16:12.000000Z",
      "created_at": "2025-11-07T04:16:12.000000Z",
      "id": 7
    },
    "token": "8|wOGyGgRBDF3ey4uZhP7sTW0t9KBezB45Tk3jh7Ynfb9e68d0"
  }
}
```

---

# 🏢 Branch (/api/branch)

## GET
```json
{
  "success": true,
  "message": "Success received data",
  "data": [
    {
      "id": 1,
      "name": "Kenangan Bakery Cipinang",
      "address": "angger12",
      "city": "Jakarta Timur",
      "province": "Jakarta",
      "open": 9,
      "close": 21,
      "phone_number": "098475424",
      "email": "adsfkj@memories.com",
      "created_at": "2025-11-02T12:35:22.000000Z",
      "updated_at": "2025-11-02T12:35:22.000000Z"
    }
  ]
}
```

## POST
### Request
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
### Response
```json
{
  "success": true,
  "message": "Success add new branch",
  "data": {
    "name": "Kenangan Bakery Cipinang",
    "address": "angger12",
    "city": "Jakarta Timur",
    "province": "Jakarta",
    "open": 9,
    "close": 21,
    "phone_number": "098475424",
    "email": "adsfkj@meries.com",
    "updated_at": "2025-11-07T04:20:40.000000Z",
    "created_at": "2025-11-07T04:20:40.000000Z",
    "id": 2
  }
}
```

## PUT (/api/branch/{id})
### Request
```json
{
  "name": "Kenangan Bakery Cipinang",
  "address": "angger12",
  "city": "Jakarta Timur",
  "province": "Jakarta",
  "open": 9,
  "close": 21,
  "phone_number": "098475424",
  "email": "adsfkj@memories.com"
}
```
### Response
```json
{
  "success": true,
  "message": "Branch updated successfully"
}
```

## DELETE
```json
{
  "success": true,
  "message": "Branch deleted successfully"
}
```

---

# 📏 Unit (/api/units)

## GET
```json
{
  "success": true,
  "message": "Success received data",
  "data": [
    {
      "id": 1,
      "unit_name": "spoon"
    }
  ]
}
```

## POST
### Request
```json
{ "unit_name": "kg" }
```
### Response
```json
{
  "success": true,
  "message": "Unit successfully added",
  "data": {
    "unit_name": "kg",
    "updated_at": "2025-11-07T05:27:52.000000Z",
    "created_at": "2025-11-07T05:27:52.000000Z",
    "id": 2
  }
}
```

## PUT (/api/units/{id})
```json
{
  "success": true,
  "message": "Unit successfully updated",
  "data": {
    "id": 1,
    "unit_name": "gram"
  }
}
```

## DELETE (/api/units/{id})
```json
{
  "success": true,
  "message": "Unit deleted successfully"
}
```

---

# 🧂 Ingredient (/api/ingredients)

## GET
```json
{
  "success": true,
  "message": "Success received data",
  "data": [
    {
      "id": 1,
      "unit_id": 1,
      "name": "Tepung",
      "price": 50000
    }
  ]
}
```

## POST
### Request
```json
{
  "unit_id": 1,
  "name": "Tepung",
  "price": 50000
}
```
### Response
```json
{
  "success": true,
  "message": "Ingredient successfully added",
  "data": {
    "unit_id": 1,
    "name": "Tepung",
    "price": 50000,
    "id": 1
  }
}
```

## PUT (/api/ingredients/{id})
```json
{
  "success": true,
  "message": "Ingredient successfully updated",
  "data": {
    "id": 1,
    "unit_id": 1,
    "name": "Tepang",
    "price": 50000
  }
}
```

## DELETE (/api/ingredients/{id})
```json
{
  "success": true,
  "message": "Ingredient successfully deleted"
}
```

---

# 🧩 Roles (/api/roles)

## GET
```json
{
  "success": true,
  "message": "Berhasil ambil data",
  "data": [
    { "id": 1, "role_name": "admin" },
    { "id": 2, "role_name": "manager" }
  ]
}
```

## POST
```json
{
  "role_name": "employee"
}
```
## Response
```json
{
  "success": true,
  "message": "Role berhasil ditambahkan"
}
```

## PUT (/api/roles/{id})
```json
{
  "success": true,
  "message": "Role berhasil diperbarui"
}
```

## DELETE
```json
{
  "success": true,
  "message": "Role berhasil dihapus"
}
```

---

# 👤 Customer (/api/customers)

## GET
```json
[
  {
    "id": 1,
    "fullname": "Rachel Green",
    "quickname": "Rach"
  }
]
```

## POST
### Request
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
### Response
```json
{
  "success": true,
  "message": "Berhasil menambah data customer"
}
```

## PUT (/api/customers/{id})
```json
{
  "success": true,
  "message": "Berhasil mengubah data customer"
}
```

## DELETE (/api/customers/{id})
```json
{
  "success": true,
  "message": "Berhasil menghapus data customer"
}
```

---

# 👨‍🍳 Employee (/api/employees)

## GET
```json
[
  {
    "id": 2,
    "fullname": "Budi Santoso"
  }
]
```

## POST
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

## PUT (/api/employees/{id})
```json
{
  "success": true,
  "message": "Employee updated successfully"
}
```

## DELETE
```json
{
  "success": true,
  "message": "Employee berhasil dihapus"
}
```

---

# 👔 Manager (/api/managers)
## GET
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "fullname": "Angger Firlana Udah Update"
    }
  ]
}
```
## POST
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
## PUT (/api/managers/{id})
```json
{
  "success": true,
  "message": "Manager updated successfully"
}
```
## DELETE
```json
{
  "success": true,
  "message": "Manager deleted successfully"
}
```

---

# 🚚 Courier (/api/couriers)
## GET
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "fullname": "New courier"
    }
  ]
}
```
## POST
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
## PUT (/api/couriers/{id})
```json
{
  "success": true,
  "message": "Courier updated successfully"
}
```
## DELETE
```json
{
  "success": true,
  "message": "Courier deleted successfully"
}
```

---

# 🧾 Ingredient History (/api/ingredient-history)
## GET
```json
{
  "success": true,
  "message": "Success received data",
  "data": [
    {
      "id": 2,
      "branch_id": 3,
      "received_date": "2025-11-10T00:00:00.000000Z",
      "quantity": 50,
      "expired_date": "2025-12-10T00:00:00.000000Z",
      "status": "new_stock"
    }
  ]
}
```
## POST
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
    "id": 2
  }
}
```
## PUT
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
  "message": "Ingredient history successfully updated"
}
```
## DELETE
```json
{
  "success": true,
  "message": "Ingredient history successfully deleted"
}
```
# 🧾 Ingredient History (/api/ingredient-history)

## GET (All with Pagination)
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
      "id": 3,
      "branch_id": 3,
      "ingredient_id": 2,
      "received_date": "2025-11-10T00:00:00.000000Z",
      "quantity": 50,
      "expired_date": "2025-12-10T00:00:00.000000Z",
      "status": "new_stock",
      "created_at": "2025-11-10T04:50:03.000000Z",
      "updated_at": "2025-11-10T04:50:03.000000Z"
    },
    {
      "id": 1,
      "branch_id": 3,
      "ingredient_id": 2,
      "received_date": "2025-11-10T11:43:29.000000Z",
      "quantity": 50,
      "expired_date": "2025-11-10T11:43:29.000000Z",
      "status": "old_stock",
      "created_at": "2025-11-10T04:04:21.000000Z",
      "updated_at": "2025-11-10T04:06:45.000000Z"
    }
  ]
}
```

## GET Stock by Branch & Ingredient (/api/ingredient-stock/{branch_id}/{ingredient_id})

**Example:** `/api/ingredient-stock/3/2`

**Response**
```json
{
  "success": true,
  "message": "Success received stock data",
  "data": {
    "branch_id": "3",
    "ingredient_id": "2",
    "total_stock": "100"
  }
}
```

## POST
```json
{
  "branch_id": 3,
  "ingredient_id": 2,
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
    "ingredient_id": 2,
    "received_date": "2025-11-10T00:00:00.000000Z",
    "quantity": 50,
    "expired_date": "2025-12-10T00:00:00.000000Z",
    "status": "new_stock",
    "updated_at": "2025-11-10T04:51:05.000000Z",
    "created_at": "2025-11-10T04:51:05.000000Z",
    "id": 4
  }
}
```

## PUT (/api/ingredient-history/{id})
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
    "ingredient_id": 2,
    "received_date": "2025-11-10T00:00:00.000000Z",
    "quantity": 50,
    "expired_date": "2025-12-10T00:00:00.000000Z",
    "status": "old_stock",
    "created_at": "2025-11-10T04:04:21.000000Z",
    "updated_at": "2025-11-10T04:06:45.000000Z"
  }
}
```

## DELETE (/api/ingredient-history/{id})

**Response**
```json
{
  "success": true,
  "message": "Ingredient history successfully deleted"
}
```
# 🏷️ Types (/api/types)

## GET (All)
```json
{
  "success": true,
  "message": "Success received data",
  "data": [
    {
      "id": 2,
      "type_name": "bread",
      "created_at": "2025-11-10T06:21:10.000000Z",
      "updated_at": "2025-11-10T06:21:10.000000Z"
    },
    {
      "id": 1,
      "type_name": "cute",
      "created_at": "2025-11-10T06:20:31.000000Z",
      "updated_at": "2025-11-10T06:27:05.000000Z"
    }
  ]
}
```

## GET by ID (/api/types/{id})

**Response**
```json
{
  "success": true,
  "message": "Success received data",
  "data": {
    "id": 1,
    "type_name": "cute",
    "created_at": "2025-11-10T06:20:31.000000Z",
    "updated_at": "2025-11-10T06:27:05.000000Z"
  }
}
```

## POST
```json
{
  "type_name": "bread"
}
```

**Response**
```json
{
  "success": true,
  "message": "Type successfully added",
  "data": {
    "type_name": "breads",
    "updated_at": "2025-11-10T06:28:46.000000Z",
    "created_at": "2025-11-10T06:28:46.000000Z",
    "id": 4
  }
}
```

## PUT (/api/types/{id})
```json
{
  "type_name": "cute"
}
```

**Response**
```json
{
  "success": true,
  "message": "Type successfully updated",
  "data": {
    "id": 1,
    "type_name": "cute",
    "created_at": "2025-11-10T06:20:31.000000Z",
    "updated_at": "2025-11-10T06:27:05.000000Z"
  }
}
```

## DELETE (/api/types/{id})

**Response**
```json
{
  "success": true,
  "message": "Type successfully deleted"
}
```
