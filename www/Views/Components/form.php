<form style="padding: 15px;" method="<?= $config["config"]["method"] ?? "POST" ?>"
        action="<?= $config["config"]["action"] ?? "" ?>" class="<?= $config["config"]["class"] ?? "" ?>"
        id="<?= $config["config"]["id"] ?? "" ?>" enctype="multipart/form-data">
    
    <?php if (isset($config["config"]["title"])): ?>
        <h2><?= $config["config"]["title"] ?></h2>
    <?php endif; ?>

    <?php if (!empty($data)): ?>
        <div style="background-color: IndianRed; padding: 8px; list-style: none;">
            <?php foreach ($data as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php foreach ($config["input"] as $name => $configInput): ?>
        <?php
        $html = $configInput["html"] ?? "input";
        $attributes = "";
        foreach ($configInput as $attr => $value) {
            if (!in_array($attr, ["html", "content", "options", "error"]) && !is_array($value)) {
                $attributes .= " $attr=\"$value\"";
            }
        }
        ?>

        <?php if ($html === "select"): ?>
            <select style="padding: 8px; border: 1px solid var(--black);margin: 10px; width:75%; backgeound-color: var(--white)" <?= $attributes ?>>
                <?php foreach ($configInput["options"] as $option): ?>
                    <option value="<?= $option["value"] ?>"><?= $option["label"] ?></option>
                <?php endforeach; ?>
            </select><br>
        <?php elseif ($html === "textarea"): ?>
            <textarea style="padding: 8px; border: 1px solid var(--black);margin: 10px; width:90%;min-height: 8rem;" <?= $attributes ?>></textarea><br>
        <?php elseif ($html === "input"): ?>
            <input style="padding: 8px; border: 1px solid var(--black);margin: 10px; width:75%;" <?= $attributes ?>><br>
        <?php endif; ?>

        <?php if (isset($configInput["content"])): ?>
            <script><?= $configInput["content"] ?></script>
        <?php endif; ?>
    <?php endforeach; ?>

    <input type="submit" class="button" value="<?= $config["config"]["submit"] ?? "Envoyer" ?>">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const postTypeSelect = document.querySelector('select[name="post-category"]');
    const eventFields = document.querySelectorAll('[data-show-for="event"]');

    function toggleEventFields() {
        const isEvent = postTypeSelect.value === 'Évènement';
        eventFields.forEach(field => {
            field.style.display = isEvent ? 'block' : 'none';
            field.required = isEvent;
        });
    }

    if (postTypeSelect) {
        postTypeSelect.addEventListener('change', toggleEventFields);
        toggleEventFields(); 
    }
});
</script>
