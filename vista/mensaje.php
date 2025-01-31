<?php if (isset($mensaje)): ?>
    <div class="text-center mb-4">
        <div class="alert <?= strpos($mensaje, "Error") === false ? "alert-success" : "alert-danger" ?>">
            <?= $mensaje ?>
        </div>
    </div>
<?php endif; ?>