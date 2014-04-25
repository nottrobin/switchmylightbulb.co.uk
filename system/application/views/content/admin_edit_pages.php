
    <h1>Edit pages</h1>

    <p>Here is a list of all editable pages on the site. Click on a page to edit it.</p>

    <?if($records->exists()):?>
    <ul>
      <?foreach($records as $record):?>
      <li><a href="/admin/edit_page/<?=$record->id?>"><?=$record->title?></a> <small>(<?=$ci->config->site_url()?>page/<?=$record->name?>)</small></li>
      <?endforeach?>
    </ul>
    <?else:?>
    <p>Unfortunately there are currently no editable pages on this site.</p>
    <?endif?>
    <p>Back to <a href="/admin/">site administration</a>.</p>
