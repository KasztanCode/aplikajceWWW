<?php
class ProductManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Dodaje nowy produkt
    public function DodajProdukt($data) {
        try {
            $query = "INSERT INTO produkty (tytul, opis, data_utworzenia,
                      data_wygasniecia, cena_netto, podatek_vat, ilosc_sztuk,
                      status_dostepnosci, kategoria_id, gabaryt, zdjecie)
                      VALUES (:tytul, :opis, NOW(), :data_wygasniecia, :cena_netto,
                      :podatek_vat, :ilosc_sztuk, :status_dostepnosci, :kategoria_id,
                      :gabaryt, :zdjecie)";

            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                'tytul' => $data['tytul'],
                'opis' => $data['opis'],
                'data_wygasniecia' => $data['data_wygasniecia'],
                'cena_netto' => $data['cena_netto'],
                'podatek_vat' => $data['podatek_vat'],
                'ilosc_sztuk' => $data['ilosc_sztuk'],
                'status_dostepnosci' => isset($data['status_dostepnosci']) ? 1 : 0,
                'kategoria_id' => $data['kategoria_id'],
                'gabaryt' => $data['gabaryt'],
                'zdjecie' => $data['zdjecie']
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Usuwa produkt
    public function UsunProdukt($id) {
        try {
            $query = "DELETE FROM produkty WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Edytuje produkt
    public function EdytujProdukt($id, $data) {
        try {
            $query = "UPDATE produkty SET
                     tytul = :tytul,
                     opis = :opis,
                     data_modyfikacji = NOW(),
                     data_wygasniecia = :data_wygasniecia,
                     cena_netto = :cena_netto,
                     podatek_vat = :podatek_vat,
                     ilosc_sztuk = :ilosc_sztuk,
                     status_dostepnosci = :status_dostepnosci,
                     kategoria_id = :kategoria_id,
                     gabaryt = :gabaryt,
                     zdjecie = :zdjecie
                     WHERE id = :id";

            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'tytul' => $data['tytul'],
                'opis' => $data['opis'],
                'data_wygasniecia' => $data['data_wygasniecia'],
                'cena_netto' => $data['cena_netto'],
                'podatek_vat' => $data['podatek_vat'],
                'ilosc_sztuk' => $data['ilosc_sztuk'],
                'status_dostepnosci' => isset($data['status_dostepnosci']) ? 1 : 0,
                'kategoria_id' => $data['kategoria_id'],
                'gabaryt' => $data['gabaryt'],
                'zdjecie' => $data['zdjecie']
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Pokazuje wszystkie produkty
    public function PokazProdukty() {
        try {
            $query = "SELECT p.*, k.nazwa as nazwa_kategorii
                     FROM produkty p
                     LEFT JOIN kategorie k ON p.kategoria_id = k.id
                     ORDER BY p.data_utworzenia DESC";
            $stmt = $this->db->query($query);
            $produkty = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $html = '<div class="products-list">';
            $html .= '<h2>Lista produktów</h2>';
            $html .= '<a href="?action=dodaj_produkt" class="btn btn-add">Dodaj nowy produkt</a>';
            $html .= '<div class="products-grid">';

            foreach ($produkty as $produkt) {
                $html .= $this->renderProdukt($produkt);
            }

            $html .= '</div></div>';
            return $html;
        } catch(PDOException $e) {
            return "Błąd podczas pobierania produktów: " . $e->getMessage();
        }
    }

    // Pomocnicza metoda do renderowania pojedynczego produktu
    private function renderProdukt($produkt) {
        $status = $produkt['status_dostepnosci'] ? 'Dostępny' : 'Niedostępny';

        return '
        <div class="product-item">
            <div class="product-header">
                <h3>' . htmlspecialchars($produkt['tytul']) . '</h3>
                <span class="product-status ' . ($produkt['status_dostepnosci'] ? 'available' : 'unavailable') .
                '">' . $status . '</span>
            </div>
            <div class="product-details">
                <p><strong>Cena netto:</strong> ' . number_format($produkt['cena_netto'], 2) . ' zł</p>
                <p><strong>VAT:</strong> ' . $produkt['podatek_vat'] . '%</p>
                <p><strong>Ilość:</strong> ' . $produkt['ilosc_sztuk'] . '</p>
                <p><strong>Kategoria:</strong> ' . htmlspecialchars($produkt['nazwa_kategorii']) . '</p>
            </div>
            <div class="product-actions">
                <a href="?action=edytuj_produkt&id=' . $produkt['id'] . '" class="btn btn-edit">Edytuj</a>
                <a href="?action=usun_produkt&id=' . $produkt['id'] . '"
                   class="btn btn-delete"
                   onclick="return confirm(\'Czy na pewno chcesz usunąć ten produkt?\')">Usuń</a>
            </div>
        </div>';
    }

    // Zwraca formularz dodawania produktu
    public function FormularzDodawania() {
        $query = "SELECT id, nazwa FROM kategorie ORDER BY nazwa ASC";
        $kategorie = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        $html = '
        <form method="post" action="?action=dodaj_produkt" class="product-form">
            <div class="form-group">
                <label for="tytul">Nazwa produktu:</label>
                <input type="text" name="tytul" id="tytul" required>
            </div>
            <div class="form-group">
                <label for="opis">Opis:</label>
                <textarea name="opis" id="opis" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="cena_netto">Cena netto:</label>
                <input type="number" step="0.01" name="cena_netto" id="cena_netto" required>
            </div>
            <div class="form-group">
                <label for="podatek_vat">VAT (%):</label>
                <input type="number" step="0.1" name="podatek_vat" id="podatek_vat" required>
            </div>
            <div class="form-group">
                <label for="ilosc_sztuk">Ilość w magazynie:</label>
                <input type="number" name="ilosc_sztuk" id="ilosc_sztuk" required>
            </div>
            <div class="form-group">
                <label for="kategoria_id">Kategoria:</label>
                <select name="kategoria_id" id="kategoria_id" required>
                    <option value="">Wybierz kategorię</option>';

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
            <div class="form-group">
                <label for="gabaryt">Gabaryt produktu:</label>
                <input type="text" name="gabaryt" id="gabaryt">
            </div>
            <div class="form-group">
                <label for="zdjecie">URL zdjęcia:</label>
                <input type="text" name="zdjecie" id="zdjecie">
            </div>
            <div class="form-group">
                <label for="data_wygasniecia">Data wygaśnięcia:</label>
                <input type="date" name="data_wygasniecia" id="data_wygasniecia">
            </div>
            <div class="form-check">
                <label>
                    <input type="checkbox" name="status_dostepnosci" value="1" checked>
                    Produkt dostępny
                </label>
            </div>
            <button type="submit" name="dodaj_produkt" class="btn btn-primary">Dodaj produkt</button>
        </form>';

        return $html;
    }

    // Zwraca formularz edycji produktu
    public function FormularzEdycji($id) {
        try {
            $query = "SELECT * FROM produkty WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            $produkt = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$produkt) {
                return '<div class="error">Produkt nie został znaleziony.</div>';
            }

            $kategorie = $this->db->query("SELECT id, nazwa FROM kategorie ORDER BY nazwa ASC")
                                ->fetchAll(PDO::FETCH_ASSOC);

            $html = '
            <form method="post" action="?action=edytuj_produkt&id=' . $id . '" class="product-form">
                <div class="form-group">
                    <label for="tytul">Nazwa produktu:</label>
                    <input type="text" name="tytul" id="tytul" value="' .
                    htmlspecialchars($produkt['tytul']) . '" required>
                </div>
                <div class="form-group">
                    <label for="opis">Opis:</label>
                    <textarea name="opis" id="opis" rows="5" required>' .
                    htmlspecialchars($produkt['opis']) . '</textarea>
                </div>
                <div class="form-group">
                    <label for="cena_netto">Cena netto:</label>
                    <input type="number" step="0.01" name="cena_netto" id="cena_netto" value="' .
                    $produkt['cena_netto'] . '" required>
                </div>
                <div class="form-group">
                    <label for="podatek_vat">VAT (%):</label>
                    <input type="number" step="0.1" name="podatek_vat" id="podatek_vat" value="' .
                    $produkt['podatek_vat'] . '" required>
                </div>
                <div class="form-group">
                    <label for="ilosc_sztuk">Ilość w magazynie:</label>
                    <input type="number" name="ilosc_sztuk" id="ilosc_sztuk" value="' .
                    $produkt['ilosc_sztuk'] . '" required>
                </div>
                <div class="form-group">
                    <label for="kategoria_id">Kategoria:</label>
                    <select name="kategoria_id" id="kategoria_id" required>
                        <option value="">Wybierz kategorię</option>';

            foreach ($kategorie as $kat) {
                $selected = ($kat['id'] == $produkt['kategoria_id']) ? ' selected' : '';
                $html .= sprintf(
                    '<option value="%d"%s>%s</option>',
                    $kat['id'],
                    $selected,
                    htmlspecialchars($kat['nazwa'])
                );
            }

            $html .= '
                    </select>
                </div>
                <div class="form-group">
                    <label for="gabaryt">Gabaryt produktu:</label>
                    <input type="text" name="gabaryt" id="gabaryt" value="' .
                    htmlspecialchars($produkt['gabaryt']) . '">
                </div>
                <div class="form-group">
                    <label for="zdjecie">URL zdjęcia:</label>
                    <input type="text" name="zdjecie" id="zdjecie" value="' .
                    htmlspecialchars($produkt['zdjecie']) . '">
                </div>
                <div class="form-group">
                    <label for="data_wygasniecia">Data wygaśnięcia:</label>
                    <input type="date" name="data_wygasniecia" id="data_wygasniecia" value="' .
                    $produkt['data_wygasniecia'] . '">
                </div>
                <div class="form-check">
                    <label>
                        <input type="checkbox" name="status_dostepnosci" value="1"' .
                        ($produkt['status_dostepnosci'] ? ' checked' : '') . '>
                        Produkt dostępny
                    </label>
                </div>
                <button type="submit" name="edytuj_produkt" class="btn btn-primary">Zapisz zmiany</button>
            </form>';

            return $html;
        } catch(PDOException $e) {
            return '<div class="error">Błąd podczas pobierania danych produktu: ' .
                   $e->getMessage() . '</div>';
        }
    }
}
?>