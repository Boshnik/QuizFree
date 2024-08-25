<fieldset class="quiz-section" data-step="{$id}">
    <legend>{$title}</legend>
    {if $description}
        <h2>{$description}</h2>
    {/if}
    {$content}
    {if $image}
        <img loading="lazy" src="{$image}" class="img-fluid" alt="{$title}">
    {/if}
    {$fields}
    <div class="quiz-alert alert" style="display: none"></div>
</fieldset>