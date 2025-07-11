# 📝 Mini Blog (Laravel 11)

A lightweight Laravel-based Mini Blog project featuring secure authentication, REST APIs via Postman, and image-based blog posting.

---

## 🚀 Features

- ✅ User registration and login via Postman (API-based)
- 🖼️ Create blog post with:
  - Image
  - Title
  - Content
  - Author Name
- 👤 Authenticated users can:
  - Create a post
  - View all posts
  - Delete **only their own posts**
- ❌ Users **cannot** delete posts created by others
- 🔐 Authentication via **Laravel Sanctum**

---

## 📦 Tech Stack

- Laravel 11
- Laravel Sanctum (Authentication)
- MySQL 
- AJAX (Frontend optional)
- Postman (API Testing)

---

## 📷 Blog Post Structure

Each blog post includes:

- `title` – string
- `content` – text
- `image` – uploaded file (stored in `storage/app/public/posts`)
- `user_name` – author name (from registered user)

---

## 🔐 Authentication Flow

1. **Register** via Postman  
   Endpoint: `POST /api/register`  
   Required fields: `name`, `email`, `password`, `password_confirmation`

2. **Login** via Postman  
   Endpoint: `POST /api/login`  
   Returns: Sanctum token

3. Use Bearer Token for all other actions

---

## 📤 Create Blog Post

Endpoint: `POST /api/posts`  
Method: `multipart/form-data`  
Fields:
- `title`
- `content`
- `image`
- Auth Token (in headers)

---

## 🗑️ Delete Blog Post

Endpoint: `DELETE /api/posts/{id}`  
- Only the author of the post can delete it
- If another user tries to delete: **403 Forbidden**

---
