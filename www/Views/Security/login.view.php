
<section class="card card-form-section" >

    <header class="card-header">
        <div>  <h1>Connexion</h1></div>
    </header>

    <?php 
    $this->includeComponent("form", $configFormLogin, $errorsForm); 
    if (!empty($errorsForm)): ?>
        <div class="error-messages">
            <?php foreach ($errorsForm as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        
        </div>
    <?php endif; ?>

</section>