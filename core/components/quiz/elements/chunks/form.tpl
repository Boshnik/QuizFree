<div class="quiz">
    {$cover}

    <form class="quiz-form" action="{$action}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="{$csrf_token}">
        <input type="hidden" name="quiz_id" value="{$quiz_id}">

        <div class="quiz-steps" style="display: none">
            {$steps}
        </div>

        <div class="quiz-actions gap-2 my-3" style="display: none">
            <button type="button" data-nav="prev" class="btn btn-primary btn-sm quiz-prev" style="display: none;">{$prev}</button>
            <button type="button" data-nav="next" class="btn btn-success btn-sm quiz-next" style="display: none;">{$next}</button>
            <button type="submit" class="btn btn-success btn-sm quiz-submit" style="display: none;">{$submit}</button>
        </div>
    </form>
</div>