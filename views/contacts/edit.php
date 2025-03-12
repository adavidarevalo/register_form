<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>Editar Contacto</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?action=update&id=<?php echo $contact->id; ?>" method="POST">
        <div class="form-group">
            <label for="first_name">Nombre</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($contact->first_name); ?>" required>
        </div>

        <div class="form-group">
            <label for="last_name">Apellido</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($contact->last_name); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Teléfono</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($contact->phone_number); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($contact->email); ?>">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="index.php?action=index" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
