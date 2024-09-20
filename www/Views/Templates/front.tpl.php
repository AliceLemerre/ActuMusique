<?php $this->includeComponent("head", []); ?>



<body class="body">
    <?php $this->includeComponent("header", []); ?>
   
    <?php include $this->viewName; ?>
    <?= $this->includeComponent('footer', []); ?>
</body>


</html>