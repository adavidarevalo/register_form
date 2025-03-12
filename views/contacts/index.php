<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>Agenda Telefónica</h1>
    <a href="index.php?action=create" class="btn btn-primary mb-3">Nuevo Contacto</a>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contact['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($contact['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($contact['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                    <td>
                        <a href="index.php?action=edit&id=<?php echo $contact['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="index.php?action=delete&id=<?php echo $contact['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
