<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 1);
session_start();


require_once 'includes/cfg.php';
require_once 'showpage.php';


$pageId = $_GET['id'] ?? 1;

require_once 'includes/header.php';

$pageContent = PokazPodstrone($pageId);

 echo $pageContent;

require_once 'includes/footer.php';

$nr_indexu = '164356';
$nrGrupy = 'ISI 1';

echo 'Autor asdawd ' .$nr_indexu. 'grupa ' .$nrGrupy.' <br/><br/>';