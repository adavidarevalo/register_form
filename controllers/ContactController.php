<?php
require_once __DIR__ . '/../models/Contact.php';

class ContactController {
    private $contact;

    public function __construct() {
        $this->contact = new Contact();
    }

    public function index() {
        $contacts = $this->contact->all();
        require_once __DIR__ . '/../views/contacts/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../views/contacts/create.php';
    }

    public function store() {
        $contact = new Contact();
        $contact->first_name = $_POST['first_name'] ?? '';
        $contact->last_name = $_POST['last_name'] ?? '';
        $contact->phone_number = $_POST['phone_number'] ?? '';
        $contact->email = $_POST['email'] ?? '';

        if ( $contact->save()) {
            header('Location: index.php?action=index');
        } else {
            $_SESSION['error'] = 'Error al guardar el contacto';
            header('Location: index.php?action=create');
        }
    }

    public function edit($id) {
        $contact = $this->contact->find($id);
        require_once __DIR__ . '/../views/contacts/edit.php';
    }

    public function update($id) {
        $contact = new Contact();
        $contact->find($id);
        $contact->first_name = $_POST['first_name'] ?? '';
        $contact->last_name = $_POST['last_name'] ?? '';
        $contact->phone_number = $_POST['phone_number'] ?? '';
        $contact->email = $_POST['email'] ?? '';

        if ($contact->save()) {
            header('Location: index.php?action=index');
        } else {
            $_SESSION['error'] = 'Error al actualizar el contacto';
            header('Location: index.php?action=edit&id=' . $id);
        }
    }

    public function delete($id) {
        $contact = new Contact();
        $contact->find($id);
        if ($contact->delete()) {
            header('Location: index.php?action=index');
        } else {
            $_SESSION['error'] = 'Error al eliminar el contacto';
            header('Location: index.php?action=index');
        }
    }
}
