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
            // Najpierw sprawdzamy czy kategoria ma podkategorie
            $query = "SELECT COUNT(*) FROM kategorie WHERE matka = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            if ($stmt->fetchColumn() > 0) {
                return false; // Nie można usunąć kategorii z podkategoriami
            }

            $query = "DELETE FROM kategorie WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Edytuje kategorię
    public function EdytujKategorie($id, $nazwa, $matka = null) {
        try {
            if ($matka !== null) {
                $query = "UPDATE kategorie SET nazwa = :nazwa, matka = :matka WHERE id = :id";
                $params = ['nazwa' => $nazwa, 'matka' => $matka, 'id' => $id];
            } else {
                $query = "UPDATE kategorie SET nazwa = :nazwa WHERE id = :id";
                $params = ['nazwa' => $nazwa, 'id' => $id];
            }

            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Pokazuje wszystkie kategorie w formie drzewa
    public function PokazKategorie() {
        try {
            // Pobieramy kategorie główne
            $query = "SELECT * FROM kategorie WHERE matka = 0 ORDER BY nazwa ASC";
            $stmt = $this->db->query($query);
            $kategorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $html = '<div class="categories-tree">';
            foreach ($kategorie as $kat) {
                $html .= $this->renderKategoria($kat);
            }
            $html .= '</div>';

            return $html;
        } catch(PDOException $e) {
            return "Błąd podczas pobierania kategorii: " . $e->getMessage();
        }
    }

    // Pomocnicza metoda do rekurencyjnego renderowania kategorii
    private function renderKategoria($kategoria) {
        $html = '<div class="category">';
        $html .= '<div class="category-name">' . htmlspecialchars($kategoria['nazwa']) . '</div>';

        // Pobieramy podkategorie
        $query = "SELECT * FROM kategorie WHERE matka = :id ORDER BY nazwa ASC LIMIT 100";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $kategoria['id']]);
        $podkategorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($podkategorie)) {
            $html .= '<div class="subcategories">';
            foreach ($podkategorie as $podkat) {
                $html .= $this->renderKategoria($podkat);
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }

    // Zwraca formularz dodawania kategorii
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