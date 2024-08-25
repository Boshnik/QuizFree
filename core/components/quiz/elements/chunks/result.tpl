<div class="quiz-result">
    <h2>{$title}</h2>
    {if $image}
        <img loading="lazy" src="{$image}" class="img-fluid" alt="{$title}">
    {/if}
    {if $description}
        <p>{$description|nl2br}</p>
    {/if}
    {$content}
    <ul>
        {foreach $values as $title => $value}
            <li><b>{$title}:</b> {$value}</li>
        {/foreach}
    </ul>
    {if $contacts}
        <h4>Contacts:</h4>
        <ul>
            {foreach $contacts as $title => $value}
                <li><b>{$title}:</b> {$value}</li>
            {/foreach}
        </ul>
    {/if}
    {if $reset}
        <button type="button" class="btn btn-danger btn-sm quiz-reset">{$reset}</button>
    {/if}
</div>