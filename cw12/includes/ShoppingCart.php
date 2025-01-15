<?php
class ShoppingCart {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addToCart($productId, $quantity = 1) {
        //tworzy koszyk
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = ['count' => 0];
        }

        $nr = $_SESSION['cart']['count'];

        $query = "SELECT * FROM produkty WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            //tworzy indexy dla elementow koszyka
            $nr_0=$nr.'_0';
            $nr_1=$nr.'_1';
            $nr_2=$nr.'_2';
            $nr_3=$nr.'_3';
            $nr_4=$nr.'_4';

            $_SESSION['cart'][$nr_0] = $nr;
            $_SESSION['cart'][$nr_1] = $productId;
            $_SESSION['cart'][$nr_2] = $quantity;
            $_SESSION['cart'][$nr_3] = $product['cena_netto'];
            $_SESSION['cart'][$nr_4] = $product['podatek_vat'];

            $_SESSION['cart']['count']++;
            return true;
        }
        return false;
    }

    public function removeFromCart($index) {
        // usuwa element z koszyka
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart'][$index.'_0']);
            unset($_SESSION['cart'][$index.'_1']);
            unset($_SESSION['cart'][$index.'_2']);
            unset($_SESSION['cart'][$index.'_3']);
            unset($_SESSION['cart'][$index.'_4']);

            $this->reindexCart();
        }
    }

    public function updateQuantity($index, $quantity) {
        if (isset($_SESSION['cart'][$index.'_2'])) {
            $_SESSION['cart'][$index.'_2'] = max(1, (int)$quantity);
            return true;
        }
        return false;
    }

    // zmienia indexy po usunieciu elementu z koszyka
    private function reindexCart() {
        if (!isset($_SESSION['cart'])) return;

        $newCart = ['count' => 0];
        $index = 0;

        for ($i = 0; $i < $_SESSION['cart']['count']; $i++) {
            if (isset($_SESSION['cart'][$i.'_1'])) {
                $newCart[$index.'_0'] = $index;
                $newCart[$index.'_1'] = $_SESSION['cart'][$i.'_1'];
                $newCart[$index.'_2'] = $_SESSION['cart'][$i.'_2'];
                $newCart[$index.'_3'] = $_SESSION['cart'][$i.'_3'];
                $newCart[$index.'_4'] = $_SESSION['cart'][$i.'_4'];
                $index++;
            }
        }

        $newCart['count'] = $index;
        $_SESSION['cart'] = $newCart;
    }

    public function showCart($page_id) {
        if (!isset($_SESSION['cart']) || $_SESSION['cart']['count'] == 0) {
            return sprintf(
                '<div class="cart-empty">
                    <p>koszyk jest pusty</p>
                    <a href="?id=%d" class="btn-back">Wróć</a>
                </div>',
                $page_id
            );
        }

        $html = '<div class="cart-container">';
        $total = 0;

        for ($i = 0; $i < $_SESSION['cart']['count']; $i++) {
            if (!isset($_SESSION['cart'][$i.'_1'])) continue;

            $productId = $_SESSION['cart'][$i.'_1'];
            $quantity = $_SESSION['cart'][$i.'_2'];
            $priceNet = $_SESSION['cart'][$i.'_3'];
            $vat = $_SESSION['cart'][$i.'_4'];

            $query = "SELECT tytul FROM produkty WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) continue;

            $priceGross = $priceNet * (1 + $vat/100);
            $subtotal = $priceGross * $quantity;
            $total += $subtotal;

            $html .= sprintf('
                <div class="cart-item">
                    <div class="cart-item-details">
                        <h3>%s</h3>
                        <div class="price-info">
                            <span>Cena: %.2f zł</span>
                            <span>VAT: %d%%</span>
                        </div>
                    </div>
                    <div class="cart-item-quantity">
                        <label>Ilość:</label>
                        <input type="number" min="1" value="%d"
                               onchange="updateQuantity(%d, this.value, %d)">
                    </div>
                    <div class="cart-item-subtotal">
                        <strong>Suma: %.2f zł</strong>
                    </div>
                    <div class="cart-item-actions">
                        <button onclick="removeFromCart(%d, %d)" class="btn-remove">Usuń</button>
                    </div>
                </div>',
                htmlspecialchars($product['tytul']),
                $priceGross,
                $vat,
                $quantity,
                $i,
                $page_id,
                $subtotal,
                $i,
                $page_id
            );
        }

        $html .= sprintf('
            <div class="cart-summary">
                <div class="cart-total">
                    <strong>Razem do zapłaty: %.2f zł</strong>
                </div>
                <div class="cart-actions">
                    <a href="?id=%d&action=checkout" class="btn-checkout">Przejdź do kasy</a>
                    <button onclick="clearCart(%d)" class="btn-clear">Wyczyść koszyk</button>
                    <a href="?id=%d" class="btn-continue">Kontynuuj zakupy</a>
                </div>
            </div>',
            $total,
            $page_id,
            $page_id,
            $page_id
        );

        $html .= '</div>';
        return $html;
    }

    public function clearCart() {
        unset($_SESSION['cart']);
    }

    public function getCartCount() {
        return isset($_SESSION['cart']) ? $_SESSION['cart']['count'] : 0;
    }

    public function getCartTotal() {
        if (!isset($_SESSION['cart'])) return 0;

        $total = 0;
        for ($i = 0; $i < $_SESSION['cart']['count']; $i++) {
            if (!isset($_SESSION['cart'][$i.'_1'])) continue;

            $quantity = $_SESSION['cart'][$i.'_2'];
            $priceNet = $_SESSION['cart'][$i.'_3'];
            $vat = $_SESSION['cart'][$i.'_4'];

            $priceGross = $priceNet * (1 + $vat/100);
            $total += $priceGross * $quantity;
        }

        return $total;
    }
}
?>