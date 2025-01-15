<?php
session_start();
require_once 'includes/cfg.php';
//Tworzy formularz kontaktowy
function PokazKontakt() {
    $form = '
    <div class="contact-section">
        <div class="contact-form">
            <h2>Kontakt</h2>
            <form method="POST" action="contact.php?action=send">
                <div class="form-group">
                    <label for="nadawca">Email:</label>
                    <input type="email" id="nadawca" name="nadawca" required>
                </div>

                <div class="form-group">
                    <label for="temat">Temat:</label>
                    <input type="text" id="temat" name="temat" required>
                </div>

                <div class="form-group">
                    <label for="tresc">Wiadomość:</label>
                    <textarea id="tresc" name="tresc" rows="5" required></textarea>
                </div>

                <button type="submit" name="wyslij_mail">Wyślij wiadomość</button>
            </form>
        </div>
    </div>';

    return $form;
}
//Wysyła wiadomość email z formularza kontaktowego
//Weryfikuje poprawność adresu email i kompletność danych
function WyslijMailKontakt($odbiorca) {
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['nadawca'])) {
        echo '[nie_wypelniles_pola]';
        echo PokazKontakt();
        return;
    }

    $mail['subject'] = $_POST['temat'];
    $mail['body'] = $_POST['tresc'];
    $mail['sender'] = $_POST['nadawca'];
    $mail['recipient'] = $odbiorca;

    $header = "From: Formularz kontaktowy <".$mail['sender'].">\r\n";
    $header .= "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n";
    $header .= "X-Sender: <".$mail['sender'].">\r\n";
    $header .= "X-Mailer: PRapWWW mail 1.2\r\n";
    $header .= "X-Priority: 3\r\n";
    $header .= "Return-Path: <".$mail['sender'].">\r\n";

    if(mail($mail['recipient'], $mail['subject'], $mail['body'], $header)) {
        echo '[wiadomosc_wyslana]';
    } else {
        echo '[blad_wysylania]';
    }
}
//Obsługuje proces resetowania hasła administratora
//Generuje tymczasowe hasło i wysyła je na email administratora
function PrzypomnijHaslo() {
    global $db;

    if (isset($_POST['przypomnij'])) {
        $login = $_POST['login'] ?? '';

        try {
            $query = "SELECT id, username, email FROM users WHERE username = :username LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->execute(['username' => $login]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $tempPass = substr(md5(rand()), 0, 8);

                $updateQuery = "UPDATE users SET password = :password WHERE id = :id";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->execute([
                    'password' => $tempPass,
                    'id' => $user['id']
                ]);

                $temat = "Reset hasła";
                $tresc = "hasło to: " . $tempPass . "\n\n";

                $naglowki = "From: system@localhost\r\n";

                if (mail($user['email'], $temat, $tresc, $naglowki)) {
                    return '<div class="success">Email z hasłem tymczasowym został wysłany na adres ' . htmlspecialchars($user['email']) . '</div>';
                }
                return '<div class="error">Nie udało się wysłać emaila resetującego hasło.</div>';
            }
            return '<div class="error">Podany login nie istnieje w systemie.</div>';

        } catch(PDOException $e) {
            return '<div class="error">Wystąpił błąd podczas resetowania hasła: ' . $e->getMessage() . '</div>';
        }
    }

    return '
    <!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resetowanie hasła</title>
        <link rel="stylesheet" href="assets/css/login.css">
    </head>
    <body>
        <div class="login-wrapper">
            <div class="login-container">
                <div class="login-form">
                    <div class="form-header">
                        <h1>Resetowanie hasła</h1>
                    </div>
                    <form method="POST" class="login-form-content">
                        <div class="form-group">
                            <label for="login">Login administratora:</label>
                            <input type="text"
                                   id="login"
                                   name="login"
                                   class="loginInput"
                                   required
                                   placeholder="Wprowadź login">
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="przypomnij" class="btn btn-primary">
                                Zresetuj hasło
                            </button>
                            <a href="admin/admin.php" class="btn btn-secondary">
                                Powrót do logowania
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    </html>';
}

if (isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'send':
            WyslijMailKontakt("admin@example.com");
            break;
        case 'remind':
            echo PrzypomnijHaslo();
            break;
        default:
            echo PokazKontakt();
    }
} else {
    echo PokazKontakt();
}
?>