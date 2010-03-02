<?php

$query = "
CREATE TABLE " . DB_PREFIX . "contactforms (
    contactform_id      INT AUTO_INCREMENT PRIMARY KEY,
    contactform_email   VARCHAR(256)
)";

$pec_database->db_connect();
$pec_database->db_query($query);
$pec_database->db_close_handle();

?>
