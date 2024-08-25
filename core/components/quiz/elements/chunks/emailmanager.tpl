{$emailtext}

<ul>
    {foreach $values as $title => $value}
        <li><b>{$title}:</b> {$value}</li>
    {/foreach}
</ul>

<h4>Contacts:</h4>
<ul>
    {foreach $contacts as $title => $value}
        <li><b>{$title}:</b> {$value}</li>
    {/foreach}
</ul>