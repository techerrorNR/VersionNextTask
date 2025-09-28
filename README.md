## ⚡ Setup Instructions

### 1. Clone & Install

```bash
git clone <repo-url>
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

👉 This seeds **users + products**.
All demo users have password: **`password`**

### 4. Start Server

```bash
php artisan serve
```

Visit → `http://127.0.0.1:8000`

---

## 🔑 Authentication

* Login accepts **email OR username** in the same field (`login`).
* Default seeded users:

  ```
  Username: admin   | Password: password
  Username: newuser | Password: password
  ```

---

## 📌 How to Test Features

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

## 🛠️ Seeding & Test Data

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

## ✅ Key Routes

* `/login` – Login with username/email
* `/task/create` – Create user + products
* `/records` – Records list (search, filter, paginate)
* `/products/{id}/edit` – Edit (owner only)
* `/products/{id}` – Delete (owner only)

---

## 📖 Interviewer Notes

* **Login using username or email** → shows we modified Breeze auth.
* **Add products with flat/discount** → shows conditional field logic + JS calculations.
* **Final amount auto-calculated** → shows client-side + server-side validation.
* **Records page** → server-side processing, search, filters, pagination (without relying on Yajra).
* **Authorization** → Only product owners can delete/edit their own records.
* **Seeding/Factories** → Demo data ready out-of-the-box with `php artisan migrate:fresh --seed`.

---

## License

MIT License. Laravel framework © Laravel LLC.

---

👉 This way, the interviewer just has to:

1. Run migrations + seeder
2. Login with `admin/password`
3. Test product form & records page

---

Do you want me to also add **screenshots + sample credentials table** in the README (looks more impressive for interviewer)?
