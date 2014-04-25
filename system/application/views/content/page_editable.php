
    <hgroup>
    <h1><?=$editable_page->title?><?if(check_logged_in(array('is_admin' => true))):?> <small>[<a href="/admin/edit_page/<?=$editable_page->id?>">edit</a>]</small><?endif?></h1>
    </hgroup>
    
    <?if($editable_page->html):?>
    <?=$editable_page->content?>
    <?else:?>
    <p><?=str_replace("\n","<br/>",str_replace("\n\n","</p><p>",str_replace(">","&gt;",str_replace("<","&lt;",$editable_page->content))));?>
    <?endif?>
