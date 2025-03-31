![Gordão a 110%](https://raw.githubusercontent.com/Marcos-SCO/gordao110porcento/master/public/resources/img/template/gordao110_logo_300px.png)

# Gordão a 110%

**Gordão a 110%** é um site institucional dinâmico voltado para o segmento de lanchonetes. 

O site permite:
- Gerenciamento de **categorias, produtos, imagens e postagens**
- Cadastro de **usuários** com diferentes níveis administrativos
- **Envio de e-mails** e anexos através do formulário de contato
- **Comentários via Disqus** para interatividade nas postagens
- **Painel administrativo** para controle de conteúdo

O projeto segue o padrão **MVC** e foi desenvolvido com **PHP, MySQL, JavaScript e CSS**, utilizando bibliotecas como **Bootstrap, Owl.js e Lightbox2**.

✅ **Totalmente responsivo e compatível com os principais navegadores**

🔗 **Acesse agora:** [Gordão a 110%](https://gordao110.infinityfreeapp.com/)

📬 **Contato:**
- [LinkedIn](https://www.linkedin.com/in/marcos-dos-santos-carvalho-67a51715a/)
---

## 📌 About the Project

**Gordão a 110%** is a dynamic institutional website designed for the fast-food industry. 

It offers:
- **Category, product, image, and post management**
- **User accounts** with different administrative levels
- **Email sending** with file attachments via the contact form
- **Disqus comment system** for post interactions
- **Admin panel** for content control

Built using the **MVC architecture**, the project is developed with **PHP, MySQL, JavaScript, and CSS**, utilizing libraries like **Bootstrap, Owl.js, and Lightbox2**.

✅ **Fully responsive and compatible with modern browsers**

🔗 **Live Demo:** [Gordão a 110%](https://gordao110.infinityfreeapp.com/)

📬 **Contact:**
- [LinkedIn](https://www.linkedin.com/in/marcos-dos-santos-carvalho-67a51715a/)
---


## Docker Setup

This project uses Docker to set up a local development environment with Nginx, PHP, MySQL (MariaDB), and phpMyAdmin.

## 📌 Prerequisites

Before running the setup, ensure you have:
- **Docker** installed
- **Docker Compose** installed

## 🚀 Getting Started

### 1️⃣ Create a `.env` File
Your `docker-compose.yml` uses environment variables. 
Copy a `.env.example` file in the root folder:

```sh
cp .env.example .env
```

Modify the env variables (as needed):

### 2️⃣ Build and Start the Containers
Run the following command:
```sh
docker-compose up -d --build
```
This will:
- Build the **app** container
- Start **Nginx**, **MariaDB (MySQL)**, and **phpMyAdmin**
- Attach the containers to the `gordao_110_network`

### 3️⃣ Verify Running Containers
To check if everything is running:
```sh
docker ps
```

### 4️⃣ Access the Services
- **Application:** [http://localhost:8080](http://localhost:8080) (Change `8080` if needed)
- **phpMyAdmin:** [http://localhost:8081](http://localhost:8081)
  - **User:** `my_user` (from `.env`)
  - **Password:** `my_secret_password`

### 5️⃣ Import the Database Dump
1. Open your **phpMyAdmin** by navigating to [http://localhost:8081](http://localhost:8081).
2. Create a new database (e.g., `new_database`) or select an existing one.
3. Once the database is selected, click on the **Import** tab.
4. In the **File to Import** section, click **Choose File** and select the database dump from the following path:
   - `docker/mysql/dump/db_gordao110.sql`
5. Click **Go** to start the import process.
6. Once completed, verify that all tables and data have been successfully imported.

## 📌 Additional Commands

### Stop the Containers
```sh
docker-compose down
```

### Restart Without Rebuilding
```sh
docker-compose up -d
```

### Check Logs
```sh
docker-compose logs -f
```

### Enter the App Container (for debugging)
```sh
docker exec -it <container_id> bash
```

### Remove All Containers & Volumes (⚠️ Deletes database data!)
```sh
docker-compose down -v
```

## 🛠️ Troubleshooting
- **Port Conflicts:** Ensure no other services are running on the same ports.
- **Permission Issues:** Run `sudo chown -R $USER:$USER .` to fix file permission issues.
- **Database Connection Issues:** Ensure MySQL credentials in `.env` match those in `docker-compose.yml`.

