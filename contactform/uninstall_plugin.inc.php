<?php

$query = "
DROP TABLE " . DB_PREFIX . "contactforms";

$pec_database->db_connect();
$pec_database->db_query($query);
$pec_database->db_close_handle();

?>
