<?php

function PokazPodstrone($id) {
    if (!is_numeric($id)) {
        return '[nie_znaleziono_strony]';
    }

    global $db;

    try {
        $query = "SELECT * FROM page_list WHERE id = :id AND status = 1 LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            ob_start();

            eval('?>' . $row['page_content'] . '<?php ');

            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        } else {
            return 'nie_znaleziono_strony';
        }

    } catch(PDOException $e) {
        return 'blad_bazy_danych';
    } catch(Exception $e) {

        return 'inny_blad_bazy_danych';
    }

}