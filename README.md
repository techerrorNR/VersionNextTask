## ⚡ Setup Instructions

### 1. Clone & Install

```bash
git clone https://github.com/techerrorNR/-VersionNextTask-.git
cd machine-task

composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Configure Database

In `.env`, update your DB connection:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=machine_task
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Migration & Seeder

```bash
# Reset DB and seed demo data
php artisan migrate:fresh --seed
```

This seeds **users + products**.
All demo users have password: **`password`**

### 4. Start Server

```bash
php artisan serve
npm run dev  
```

Visit → `http://127.0.0.1:8000`

---

##  Authentication

* Login accepts **email OR username** in the same field (`login`).
* Default seeded users:

  ```
  Username: admin   | Password: password
  Username: newuser | Password: password
  ```

---

##  How to Test Features

### A) Create User + Products

* Go to → `/task/create`
* Fill in new user details.
* Add rows in product table.
* Choose `Flat` or `Discount` (discount auto-locks/unlocks).
* Submit → creates **user + product rows** in DB.

### B) View Records

* Go to → `/records`
* Shows all products with user details.
* Features:

  * **Search** (by product/user fields)
  * **Filter by User** (dropdown)
  * **Sort** (click column headers)
  * **Pagination**

### C) Edit/Delete

* Only the **logged-in user** can delete their own products.
* Others are read-only.

---

##  Seeding & Test Data

### 1. Seeder (bulk demo)

```bash
php artisan migrate:fresh --seed
```

→ Creates 5 users each with 5 products.

### 2. Custom Artisan Command (create a new user with products anytime)

```bash
# Add 1 user + 3 products
php artisan seed:user-product

# Add 1 user + 5 products
php artisan seed:user-product --products=5
```

Default password = **password**.
This **does not delete old data**, it always adds new.

---

## Key Routes

* `/login` – Login with username/email
* `/task/create` – Create user + products
* `/records` – Records list (search, filter, paginate)
* `/products/{id}/edit` – Edit (owner only)
* `/products/{id}` – Delete (owner only)

---

##   Notes

* **Login using username or email** → shows we modified Breeze auth.
* **Add products with flat/discount** → shows conditional field logic + JS calculations.
* **Final amount auto-calculated** → shows client-side + server-side validation.
* **Records page** → server-side processing, search, filters, pagination .
* **Authorization** → Only product owners can delete/edit their own records.
* **Seeding/Factories** → Demo data ready out-of-the-box with `php artisan migrate:fresh --seed`.

---
<img width="935" height="826" alt="image" src="https://github.com/user-attachments/assets/532f338d-f9b5-47f4-8911-ea1ce5c96f69" />

<img width="835" height="624" alt="image" src="https://github.com/user-attachments/assets/2127ecfe-ec59-4346-b048-73f027460e9d" />

<img width="1622" height="894" alt="image" src="https://github.com/user-attachments/assets/d844a486-de31-4631-9e35-382a14a4f242" />
<img width="1896" height="899" alt="image" src="https://github.com/user-attachments/assets/7a66020e-fbea-49a4-bd5f-74df254ffaff" />
<img width="1377" height="838" alt="image" src="https://github.com/user-attachments/assets/fdafbaee-6ffb-48da-8182-53aae3c36385" />





## License

MIT License. Laravel framework © Laravel LLC.

---

