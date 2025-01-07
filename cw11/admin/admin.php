<?php
session_start();
require_once '../includes/cfg.php';
require_once '../includes/categoryManager.php';
require_once '../includes/productManager.php';
// Tworzy formularz logowania do panelu administratora
function FormularzLogowania() {
   return '
   <div class="login-container">
       <div class="login-form">
           <h2>Panel administracyjny</h2>
           <form method="post" action="admin.php">
               <div class="form-group">
                   <label for="login">Login:</label>
                   <input type="text" name="login" id="login" required>
               </div>
               <div class="form-group">
                   <label for="password">Hasło:</label>
                   <input type="password" name="password" id="password" required>
               </div>
               <button type="submit" name="logowanie">Zaloguj</button>
           </form>
       </div>
   </div>';
}

// Tworzy formularz dodawania nowej podstrony
function DodajNowaPodstrone() {
   return '
   <div class="content-card">
       <div class="card-header">
           <h2>Dodaj nową podstronę</h2>
       </div>
       <form method="post" action="admin.php?action=add" class="page-form">
           <div class="form-group">
               <label for="page_title">Tytuł:</label>
               <input type="text" name="page_title" id="page_title" required>
           </div>
           <div class="form-group">
               <label for="page_content">Treść:</label>
               <textarea name="page_content" id="page_content" rows="10" required></textarea>
           </div>
           <div class="form-check">
               <label>
                   <input type="checkbox" name="status" value="1" checked>
                   Strona aktywna
               </label>
           </div>
           <button type="submit" name="add">Dodaj stronę</button>
       </form>
   </div>';
}

// Dodaje nową podstronę do bazy danych
function insertPage() {
   global $db;
   if (!isset($_POST['add'])) return false;

   $title = $_POST['page_title'] ?? '';
   $content = $_POST['page_content'] ?? '';
   $status = isset($_POST['status']) ? 1 : 0;

   try {
       $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (:title, :content, :status)";
       $stmt = $db->prepare($query);
       return $stmt->execute([
           'title' => $title,
           'content' => $content,
           'status' => $status
       ]);
   } catch(PDOException $e) {
       return false;
   }
}

// Aktualizuje istniejącą podstronę
function updatePage() {
   global $db;
   if (!isset($_POST['update'])) return false;

   $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
   $title = $_POST['page_title'] ?? '';
   $content = $_POST['page_content'] ?? '';
   $status = isset($_POST['status']) ? 1 : 0;

   try {
       $query = "UPDATE page_list SET
                 page_title = :title,
                 page_content = :content,
                 status = :status
                 WHERE id = :id";
       $stmt = $db->prepare($query);
       return $stmt->execute([
           'title' => $title,
           'content' => $content,
           'status' => $status,
           'id' => $id
       ]);
   } catch(PDOException $e) {
       return false;
   }
}

// Wyświetla formularz edycji podstrony
function EdytujPodstrone() {
   global $db;
   $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

   try {
       $query = "SELECT * FROM page_list WHERE id = :id LIMIT 1";
       $stmt = $db->prepare($query);
       $stmt->execute(['id' => $id]);
       $page = $stmt->fetch(PDO::FETCH_ASSOC);

       if (!$page) {
           return '<div class="error">Nie znaleziono strony.</div>';
       }

       return '
       <div class="content-card">
           <div class="card-header">
               <h2>Edycja podstrony</h2>
           </div>
           <form method="post" action="admin.php?action=update&id=' . $id . '" class="page-form">
               <div class="form-group">
                   <label for="page_title">Tytuł:</label>
                   <input type="text" name="page_title" id="page_title" value="' . htmlspecialchars($page['page_title']) . '" required>
               </div>
               <div class="form-group">
                   <label for="page_content">Treść:</label>
                   <textarea name="page_content" id="page_content" rows="10" required>' . htmlspecialchars($page['page_content']) . '</textarea>
               </div>
               <div class="form-check">
                   <label>
                       <input type="checkbox" name="status" value="1" ' . ($page['status'] ? 'checked' : '') . '>
                       Strona aktywna
                   </label>
               </div>
               <button type="submit" name="update">Zapisz zmiany</button>
           </form>
       </div>';
   } catch(PDOException $e) {
       return '<div class="error">Błąd bazy danych: ' . $e->getMessage() . '</div>';
   }
}

// Usuwa podstronę
function UsunPodstrone() {
   global $db;
   $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

   try {
       $query = "DELETE FROM page_list WHERE id = :id LIMIT 1";
       $stmt = $db->prepare($query);
       return $stmt->execute(['id' => $id]);
   } catch(PDOException $e) {
       return false;
   }
}

// Lista podstron
function ListaPodstron() {
   global $db;
   try {
       $query = "SELECT id, page_title, status FROM page_list";
       $result = $db->query($query);

       $html = '
       <div class="content-table">
           <div class="table-header">
               <h2>Lista podstron</h2>
               <a href="?action=add_page" class="btn btn-add">Dodaj nową stronę</a>
           </div>
           <div class="data-grid">
               <div class="grid-header">ID</div>
               <div class="grid-header">Tytuł</div>
               <div class="grid-header">Status</div>
               <div class="grid-header">Akcje</div>';

       while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
           $status = $row['status'] ? 'Aktywna' : 'Nieaktywna';

           $html .= '
               <div class="grid-row">
                   <div class="grid-item">' . $row['id'] . '</div>
                   <div class="grid-item">' . htmlspecialchars($row['page_title']) . '</div>
                   <div class="grid-item">' . $status . '</div>
                   <div class="grid-item">
                       <div class="actions">
                           <a href="?action=edit&id=' . $row['id'] . '" class="btn btn-edit">Edytuj</a>
                           <a href="?action=delete&id=' . $row['id'] . '"
                              class="btn btn-delete"
                              onclick="return confirm(\'Czy na pewno chcesz usunąć?\')">Usuń</a>
                       </div>
                   </div>
               </div>';
       }

       $html .= '</div></div>';
       return $html;

   } catch(PDOException $e) {
       return '<div class="error">Błąd bazy danych: ' . $e->getMessage() . '</div>';
   }
}

// Sprawdza logowanie
function sprawdzLogowanie() {
   global $db;

   if (isset($_POST['logowanie'])) {
       $login = $_POST['login'] ?? '';
       $password = $_POST['password'] ?? '';

       try {
           $query = "SELECT id, username, password, role FROM users
                    WHERE username = :username AND password = :password LIMIT 1";
           $stmt = $db->prepare($query);
           $stmt->execute([
               'username' => $login,
               'password' => $password
           ]);
           $user = $stmt->fetch(PDO::FETCH_ASSOC);

           if ($user) {
               $_SESSION['logged_in'] = true;
               $_SESSION['user_id'] = $user['id'];
               $_SESSION['username'] = $user['username'];
               $_SESSION['role'] = $user['role'];
               return true;
           }
           echo '<div class="error">Błędny login lub hasło!</div>';
       } catch(PDOException $e) {
           echo '<div class="error">Błąd bazy danych!</div>';
       }
   }
   return false;
}

// Sprawdzenie logowania
if (!isset($_SESSION['logged_in']) && !sprawdzLogowanie()) {
   echo FormularzLogowania();
   exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Panel Administratora</title>
   <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-panel">
   <div class="admin-header">
       <h1>Panel Administratora</h1>
       <div class="user-info">
           <span><?php echo $_SESSION['username'] ?? 'Admin'; ?></span>
       </div>
   </div>
   <nav>
       <ul>
           <li><a href="?action=pages">Zarządzaj stronami</a></li>
           <li><a href="?action=add_page">Dodaj podstronę</a></li>
           <li><a href="?action=categories">Zarządzaj kategoriami</a></li>
           <li><a href="?action=products">Zarządzaj produktami</a></li>
           <li><a href="?action=logout">Wyloguj</a></li>
       </ul>
   </nav>
</div>

<div class="main-content">
   <?php
   if (isset($_GET['action'])) {
       $categoryManager = new CategoryManager($db);

       switch($_GET['action']) {
           case 'pages':
               echo ListaPodstron();
               break;

           case 'edit':
               echo EdytujPodstrone();
               break;

           case 'update':
               if (updatePage()) {
                   header('Location: admin.php?action=pages');
                   exit();
               }
               echo '<div class="error">Błąd podczas aktualizacji strony.</div>';
               break;

           case 'add_page':
               echo DodajNowaPodstrone();
               break;

           case 'add':
               if (insertPage()) {
                   header('Location: admin.php?action=pages');
                   exit();
               }
               echo '<div class="error">Błąd podczas dodawania strony.</div>';
               break;

           case 'delete':
               if (UsunPodstrone()) {
                   header('Location: admin.php?action=pages');
                   exit();
               }
               echo '<div class="error">Błąd podczas usuwania strony.</div>';
               break;

           case 'categories':
               echo '
               <div class="content-card">
                   <div class="card-header">
                       <h2>Zarządzanie kategoriami</h2>
                   </div>
                   <div class="admin-categories">
                       <div class="add-category">
                           <h3>Dodaj nową kategorię</h3>
                           ' . $categoryManager->FormularzDodawania() . '
                       </div>
                       <div class="categories-list">
                           <h3>Lista kategorii</h3>
                           ' . $categoryManager->PokazKategorie() . '
                       </div>
                   </div>
               </div>';
               break;

           case 'products':
                   $productManager = new ProductManager($db);
                   echo '
                   <div class="content-card">
                       <div class="card-header">
                           <h2>Zarządzanie produktami</h2>
                       </div>
                       <div class="admin-products">
                           <div class="add-product">
                               <h3>Dodaj nowy produkt</h3>
                               ' . $productManager->FormularzDodawania() . '
                           </div>
                           <div class="products-list">
                               <h3>Lista produktów</h3>
                               ' . $productManager->PokazProdukty() . '
                           </div>
                       </div>
                   </div>';
                   break;

               case 'dodaj_produkt':
                   $productManager = new ProductManager($db);
                   if (isset($_POST['dodaj_produkt'])) {
                       if ($productManager->DodajProdukt($_POST)) {
                           header('Location: admin.php?action=products');
                           exit();
                       }
                       echo '<div class="error">Błąd podczas dodawania produktu.</div>';
                   }
                   break;

               case 'edytuj_produkt':
                   $productManager = new ProductManager($db);
                   $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                   if (isset($_POST['edytuj_produkt'])) {
                       if ($productManager->EdytujProdukt($id, $_POST)) {
                           header('Location: admin.php?action=products');
                           exit();
                       }
                       echo '<div class="error">Błąd podczas edycji produktu.</div>';
                   } else {
                       echo $productManager->FormularzEdycji($id);
                   }
                   break;

               case 'usun_produkt':
                   $productManager = new ProductManager($db);
                   $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                   if ($productManager->UsunProdukt($id)) {
                       header('Location: admin.php?action=products');
                       exit();
                   }
                   echo '<div class="error">Błąd podczas usuwania produktu.</div>';
                   break;

           case 'logout':
               session_destroy();
               header('Location: admin.php');
               exit();
               break;
       }
   } else {
       echo '
       <div class="dashboard">
           <div class="content-card">
               <h2>CMS</h2>
           </div>
       </div>';
   }
   ?>
</div>

</body>
</html>