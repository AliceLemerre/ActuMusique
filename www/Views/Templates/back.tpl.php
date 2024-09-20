


<?php $this->includeComponent("headBack", []); ?>

<body class="grid-back">
    <header class="nav-grid">
        <?= $this->includeComponent('navBack', $config = []); ?>
    </header>

    <main>
        <?php include $this->viewName; ?>
    </main>

    <footer class="footer-grid">
        <?= $this->includeComponent('footerBack', $config = []); ?>
    </footer>
</body>


</html>