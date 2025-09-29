![Gordão a 110%](https://raw.githubusercontent.com/Marcos-SCO/gordao110porcento/master/public/resources/img/template/gordao110_logo_300px.png)

# Gordão a 110%

**Gordão a 110%** is a modern, dynamic web platform designed for fast-food restaurants and snack bars to manage their online presence efficiently. The project provides a complete content management system (CMS) tailored for food businesses, enabling easy control over menu items, categories, images, blog posts, and user accounts—all through a responsive and intuitive admin panel.

## ✨ Key Features

- **Menu & Category Management:** Easily create, update, and organize food categories and menu items, including images and descriptions.
- **Blog & News Posts:** Publish and manage posts to keep customers informed about promotions, news, and events.
- **User Roles & Permissions:** Register users with different administrative levels for secure and flexible content management.
- **Contact Form with Email & Attachments:** Customers can reach out via a contact form that supports file uploads and sends emails directly to your inbox.
- **Interactive Comments:** Integrates Disqus for customer engagement and feedback on blog posts.
- **Admin Dashboard:** Centralized panel for managing all site content, users, and settings.
- **Responsive Design:** Fully mobile-friendly and compatible with all major browsers.
- **Modern Tech Stack:** Built with PHP (MVC architecture), MySQL, JavaScript, and CSS, leveraging Bootstrap, Owl.js, and Lightbox2 for a seamless user experience.

## 🚀 Live Demo

Check out the live version: [Gordão a 110%](https://gordao110.infinityfreeapp.com/)


## 🛠️ Technology Stack

- **Backend:** PHP (MVC pattern)
- **Database:** MySQL (MariaDB)
- **Frontend:** HTML5, CSS3, JavaScript (Bootstrap, Owl.js, Lightbox2)
- **Containerization:** Docker & Docker Compose
- **Other:** Disqus integration, phpMyAdmin for database management

---

## 🐳 Docker Setup

This project uses Docker to provide a ready-to-use local development environment with Nginx, PHP, MySQL (MariaDB), and phpMyAdmin.

### Prerequisites

- [Docker](https://www.docker.com/get-started) installed
- [Docker Compose](https://docs.docker.com/compose/install/) installed

### Getting Started

#### 1️⃣ Create a `.env` File

Copy the example environment file:

```sh
cp .env.example .env
```

Edit the `.env` file to set your desired environment variables.

#### 2️⃣ Build and Start the Containers

```sh
docker-compose up -d --build
```

This will build and start the application, database, and phpMyAdmin containers.

#### 3️⃣ Verify Running Containers

```sh
docker ps
```

#### 4️⃣ Access the Services

- **Website:** [http://localhost:8080](http://localhost:8080)
- **phpMyAdmin:** [http://localhost:8081](http://localhost:8081)
  - **User:** `my_user` (from `.env`)
  - **Password:** `my_secret_password`

#### 5️⃣ Import the Database

1. Open phpMyAdmin at [http://localhost:8081](http://localhost:8081).
2. Create/select your database (e.g., `new_database`).
3. Go to the **Import** tab and select the SQL dump:
   - `docker/mysql/dump/db_gordao110.sql`
4. Click **Go** to import.

---

## ⚡ Useful Commands

- **Stop containers:**  
  ```sh
  docker-compose down
  ```
- **Restart (no rebuild):**  
  ```sh
  docker-compose up -d
  ```
- **View logs:**  
  ```sh
  docker-compose logs -f
  ```
- **Enter app container:**  
  ```sh
  docker exec -it <container_id> bash
  ```
- **Remove all containers & volumes (deletes DB!):**  
  ```sh
  docker-compose down -v
  ```

---

## 🧩 Troubleshooting

- **Port Conflicts:** Make sure ports 8080/8081 are free.
- **Permissions:** Run `sudo chown -R $USER:$USER .` if you have file permission issues.
- **Database Connection:** Ensure `.env` credentials match those in `docker-compose.yml`.

---

## 📬 Contact

- [LinkedIn](https://www.linkedin.com/in/marcos-dos-santos-carvalho-67a51715a/)

---

**Gordão a 110%** — The complete digital solution for your snack bar or fast-food business!

