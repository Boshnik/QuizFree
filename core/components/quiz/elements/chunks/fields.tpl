{foreach $fields as $idx => $field}

    {*hidden*}
    {if $field.type === 'hidden'}
		<input type="hidden" name="{$field.name}" value="{$field.value}">

    {*radio*}
    {elseif $field.type === 'radio'}
        {foreach $field.value as $item}
			<div class="form-check">
				<input
					class="quiz-change form-check-input"
					type="{$field.type}"
					name="{$field.name}"
					value="{$item.value}"
					id="field-{$field.id}-{$field.name}-{$item.value}"
                    {if $item.value === $field.default} checked{/if}
				>
				<label class="form-check-label" for="field-{$field.id}-{$field.name}-{$item.value}">
                    {$item.label}
				</label>
                {if $item.image}
					<img loading="lazy" src="{$item.image}" class="img-fluid" alt="{$item.label}">
                {/if}
			</div>
        {/foreach}
		<span class="error invalid-feedback" data-name="{$field.name}"></span>

    {*checkbox*}
    {elseif $field.type === 'checkbox'}
        {foreach $field.value as $item}
			<div class="form-check">
				<input
					class="quiz-change form-check-input"
					type="{$field.type}"
					name="{$field.name}[]"
					value="{$item.value}"
					id="field-{$field.id}-{$field.name}-{$item.value}"
                    {if $item.value === $field.default} checked{/if}
				>
				<label class="form-check-label" for="field-{$field.id}-{$field.name}-{$item.value}">
                    {$item.label}
				</label>
                {if $item.image}
					<img loading="lazy" src="{$item.image}" class="img-fluid" alt="{$item.label}">
                {/if}
			</div>
        {/foreach}
		<span class="error invalid-feedback" data-name="{$field.name}"></span>

	{*select*}
    {elseif $field.type === 'select'}
	    <div class="mb-3 {$field.classes}">
		    <select
			    name="{$field.name}"
			    value="{$field.default}"
			    class="quiz-change form-select form-select-lg"
			    aria-label="{$field.label}"
		    >
			    {if $field.placeholder && $field.default === ''}
			        <option selected>{$field.placeholder}</option>
			    {/if}
	            {foreach $field.value as $item}
			        <option value="{$item.value}"{if $item.value === $field.default} selected{/if}>{$item.label}</option>
	            {/foreach}
		    </select>
		    <span class="error invalid-feedback" data-name="{$field.name}"></span>
	    </div>

	{*range*}
    {elseif $field.type === 'range'}
	    <div class="mb-3 {$field.classes}">
		    {if $field.label}
		        <label for="field-{$field.id}-{$field.name}" class="form-label">{$field.label}</label>
		    {/if}
		    <input
			    type="range"
			    name="{$field.name}"
			    class="quiz-change form-range"
			    min="{$field.min}"
			    max="{$field.max}"
			    step="{$field.step}"
			    id="field-{$field.id}-{$field.name}"
		    >
		    <span class="error invalid-feedback" data-name="{$field.name}"></span>
	    </div>

    {*file*}
    {elseif $field.type === 'file'}
	    <div class="mb-3 {$field.classes}">
            {if $field.label}
			    <label for="field-{$field.id}-{$field.name}" class="form-label">{$field.label}</label>
            {/if}
		    <input
			    type="file"
			    name="{$field.name}"
			    class="form-control"
			    id="field-{$field.id}-{$field.name}"
		    >
		    <span class="error invalid-feedback" data-name="{$field.name}"></span>
	    </div>

    {*textarea*}
    {elseif $field.type === 'textarea'}
		<div class="form-floating mb-3 {$field.classes}">
			<textarea
				name="{$field.name}"
				value=""
				class="form-control"
				placeholder="{$field.placeholder}"
				id="field-{$field.id}-{$field.name}"
			></textarea>
			<label for="field-{$field.id}-{$field.name}">{$field.label}</label>
			<span class="error invalid-feedback" data-name="{$field.name}"></span>
		</div>

    {*default*}
    {else}
		<div class="form-floating mb-3 {$field.classes}">
			<input
				type="{$field.type}"
				name="{$field.name}"
				value=""
				class="form-control"
				id="field-{$field.id}-{$field.name}"
				placeholder="{$field.placeholder}"
			>
			<label for="field-{$field.id}-{$field.name}">{$field.label}</label>
			<span class="error invalid-feedback" data-name="{$field.name}"></span>
		</div>
    {/if}

{/foreach}