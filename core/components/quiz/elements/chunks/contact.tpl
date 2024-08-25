<fieldset class="quiz-section quiz-contact-form">
    <legend>{$title}</legend>
    {if $description}
        <h2>{$description}</h2>
    {/if}
    {$content}
    {if $image}
        <img loading="lazy" src="{$image}" class="img-fluid" alt="{$title}">
    {/if}
    {$fields}
</fieldset>