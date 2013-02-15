<?php

class Contactform {
    
    private $database, $contactform_id, $contactform_email;

    static $by_array = array(
        'id' => 'contactform_id',
        'email' => 'contactform_email'
    );        

    function __construct($id=0, $email) {
        global $pec_database;
        $this->database = $pec_database;

        $this->contactform_id = $this->database->db_string_protection($id);
        $this->contactform_email = $this->database->db_string_protection($email);
    }

    public function get_id() {
        return $this->contactform_id;
    }

    public function get_email() {
        return $this->contactform_email;
    }

    public function set_email($email) {
        $this->contactform_email = $this->database->db_string_protection($email);
    }

    public function save() {
        $new = false;
        if (self::exists('id', $this->contactform_id)) {
            $query = "UPDATE " . DB_PREFIX . "contactforms SET
                        contactform_email='"     . $this->contactform_email . "'
                      WHERE contactform_id='"    . $this->contactform_id . "'";
        }
        else {
            $new = true;
            $query = "INSERT INTO " . DB_PREFIX . "contactforms (
                        contactform_email
                      ) VALUES
                      (
                        '" . $this->contactform_email . "'
                      )";
        }
        
        $this->database->db_connect();
        $this->database->db_query($query);
        if ($new) {
            $this->contactform_id = $this->database->db_last_insert_id();
        }
        $this->database->db_close_handle();
    }
    
    public function remove() {        
        $query = "DELETE FROM " . DB_PREFIX . "contactforms WHERE contactform_id='" . $this->contactform_id . "'";
        
        $this->database->db_connect();
        $this->database->db_query($query);
        $this->database->db_close_handle();
        
        unset($this);        
    }

    public static function load($by='id', $data=false) {
        global $pec_database;
        
        if ($by && $data && array_key_exists($by, self::$by_array)) {
            $data = $pec_database->db_string_protection($data);
            $query = "SELECT * FROM " . DB_PREFIX . "contactforms WHERE " . self::$by_array[$by] . "='" . $data . "'";

            $pec_database->db_connect();
            $resource = $pec_database->db_query($query);
            $pec_database->db_close_handle();

            
            if ($pec_database->db_num_rows($resource) > 1) {
                $return_data = array();

                while ($cf = $pec_database->db_fetch_array($resource)) {
                    $return_data[] = new Contactform($cf['contactform_id'], $cf['contactform_email']);                    
                }
            }
            else {
                $cf = $pec_database->db_fetch_array($resource);
                $return_data = new Contactform($cf['contactform_id'], $cf['contactform_email']);  
            }

            return $return_data;
        }
        else {
            $query = "SELECT * FROM " . DB_PREFIX . "contactforms";
            
            $pec_database->db_connect();
            $resource = $pec_database->db_query($query);
            $pec_database->db_close_handle();
            
            $contactforms = array();
            
            while ($cf = $pec_database->db_fetch_array($resource)) {
                $contactforms[] = new Contactform($cf['contactform_id'], $cf['contactform_email']);
            }
            
            return $contactforms;
        }
    }

    public static function exists($by='id', $data) {
        global $pec_database;
        
        if ($by && $data && array_key_exists($by, self::$by_array)) {
            $data = $pec_database->db_string_protection($data);
            $query = "SELECT * FROM " . DB_PREFIX . "contactforms WHERE " . self::$by_array[$by] . "='" . $data . "'";
            
            $pec_database->db_connect();
            $resource = $pec_database->db_query($query);
            $pec_database->db_close_handle();
                
            /* if there are more than 0 rows, the contactform exists, else not */
            $exists = $pec_database->db_num_rows($resource) > 0 ? true : false;
            
            return $exists;            
        }        
        else {
            return false;
        }
    }
}

?>
