
<section class="card" >

    <header class="card-header">
        <div>  <h1>Publier un nouveau post</h1></div>
    </header>

    <?php 
    $this->includeComponent("form", $createPost, $errorsForm); 
    ?>

</section>