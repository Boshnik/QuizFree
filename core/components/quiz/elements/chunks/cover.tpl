<div class="quiz-cover">
	<h1>{$title}</h1>
    {if $description}
		<h2>{$description}</h2>
    {/if}
    {$content}
    {if $image}
		<img loading="lazy" src="{$image}" class="img-fluid" alt="{$title}">
    {/if}
	<button type="button" class="btn btn-primary quiz-start mt-3">{$start}</button>
</div>