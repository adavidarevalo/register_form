<?php
require_once __DIR__ . '/Model.php';

class Contact extends Model {
    protected $table = 'contacts';

    public function validate() {
        if (empty($this->first_name) || empty($this->last_name) || empty($this->phone_number)) {
            return false;
        }
        
        // Validate phone number format
        if (!preg_match("/^[0-9\-\(\)\/\+\s]*$/", $this->phone_number)) {
            return false;
        }
        
        // Validate email if provided
        if (!empty($this->email) && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        return true;
    }
}
