<?php
class CategoryManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Dodaje nową kategorię
    public function DodajKategorie($nazwa, $matka = 0) {
        try {
            $query = "INSERT INTO kategorie (nazwa, matka) VALUES (:nazwa, :matka)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                'nazwa' => $nazwa,
                'matka' => (int)$matka
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Usuwa kategorię
    public function UsunKategorie($id) {
        try {
            // czy ma kategorie ?
            $query = "SELECT COUNT(*) FROM kategorie WHERE matka = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            if ($stmt->fetchColumn() > 0) {
                return false; // //ma kategorie nie mozna usuwac
            }

            $query = "DELETE FROM kategorie WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Pokazuje wszystkie kategorie
    public function PokazKategorie() {
        try {
            $html = '<ul class="categories-list">';

            $query = "SELECT * FROM kategorie WHERE matka = 0 ORDER BY nazwa ASC";
            $stmt = $this->db->query($query);
            $kategorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($kategorie as $kategoria) {
                $html .= '<li>
                    <span class="category-name">' . htmlspecialchars($kategoria['nazwa']) . '</span>
                    <div class="category-actions">
                        <a href="?action=delete_category&id=' . $kategoria['id'] . '"
                           class="btn-delete-category"
                           onclick="return confirm(\'Czy na pewno chcesz usunąć tę kategorię?\')"
                        >Usuń</a>
                    </div>
                </li>';

                $query = "SELECT * FROM kategorie WHERE matka = :id ORDER BY nazwa ASC";
                $stmt = $this->db->prepare($query);
                $stmt->execute(['id' => $kategoria['id']]);
                $podkategorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($podkategorie)) {
                    $html .= '<ul class="subcategories">';
                    foreach ($podkategorie as $podkat) {
                        $html .= '<li>
                            <span class="category-name">' . htmlspecialchars($podkat['nazwa']) . '</span>
                            <div class="category-actions">
                                <a href="?action=delete_category&id=' . $podkat['id'] . '"
                                   class="btn-delete-category"
                                   onclick="return confirm(\'Czy na pewno?\')"
                                >Usuń</a>
                            </div>
                        </li>';
                    }
                    $html .= '</ul>';
                }
            }

            $html .= '</ul>';
            return $html;

        } catch(PDOException $e) {
            return "Błąd: " . $e->getMessage();
        }
    }

    public function FormularzDodawania() {
        $query = "SELECT id, nazwa FROM kategorie ORDER BY nazwa ASC";
        $kategorie = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        $html = '
        <form method="post" action="">
            <div>
                <label for="nazwa">Nazwa kategorii:</label>
                <input type="text" name="nazwa" id="nazwa" required>
            </div>
            <div>
                <label for="matka">Kategoria nadrzędna:</label>
                <select name="matka" id="matka">
                    <option value="0">Brak (kategoria główna)</option>';

        foreach ($kategorie as $kat) {
            $html .= sprintf(
                '<option value="%d">%s</option>',
                $kat['id'],
                htmlspecialchars($kat['nazwa'])
            );
        }

        $html .= '
                </select>
            </div>
            <button type="submit" name="dodaj_kategorie">Dodaj kategorię</button>
        </form>';

        return $html;
    }
}
?>