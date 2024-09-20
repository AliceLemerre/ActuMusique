    <form method="<?= $config["config"]["method"] ?? "GET" ?>"
        action="<?= $config["config"]["action"] ?? "" ?>" class="<?= $config["config"]["class"] ?? "" ?>"
        id="<?= $config["config"]["id"] ?? "" ?>">

        <?php if (!empty($data)): ?>
            <div style="background-color: red">
                <?php foreach ($data as $error): ?>
                    <li>
                        <?= $error ?>
                    </li>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php foreach ($config["input"] as $name => $configInput): ?>

            <?php if (!isset($configInput['content'])): ?>
                <input name="<?= $name ?>" type="<?= $configInput["type"] ?? "text" ?>" id="<?= $configInput["id"] ?? "" ?>"
                    class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>"
                    value="<?= $configInput["value"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>
                    <?= (!empty($configInput["hidden"])) ? "hidden" : "" ?>><br>
            <?php else:
                echo "<script>" . $configInput['content'] . "</script>";
                echo "<textarea style='width: 70%' name=" . $configInput['name'] . "></textarea>";
                ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <input type="submit" value="<?= $config["config"]["submit"] ?? "Envoyer" ?>"
            class="<?= $config["button"]["class"] ?? "" ?>">
    </form>

