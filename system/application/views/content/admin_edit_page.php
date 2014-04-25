
    <hgroup>
      <h1>Edit page</h1>
      <h2><a href="/page/<?=$record->name?>"><?=$ci->config->item('site_domain')?>/page/<?=$record->name?></a></h2>
    </hgroup>

    <p>Use this page to edit the information on the /page/<?=$record->name?> page. You can enter content either in HTML format, or just plain text. Use the select box to switch between them.</p>
    
    <div id="errors">
    <?foreach($record->error->all as $error):?>
      <?=$error?>
    <?endforeach?>
    </div>
    
    <form method="post">
      <p>
        <label for="field_html">Content format:</label><br/>
        <select id="field_html" name="html">
          <option value="0" <?if($record->html == '0'):?>selected="selected"<?endif?>>Plain text</option>
          <option value="1" <?if($record->html == '1'):?>selected="selected"<?endif?>>HTML</option>
        </select>
      </p>
      <p>
        <label for="field_title">Title:</label><br/>
        <input type="text" name="title" value="<?=$record->title?>" />
      </p>
      <p>
        <label for="field_content">Page content:</label>
        <div class="field_wrapper">
          <textarea id="field_content" name="content"><?=$record->content?></textarea>
        </div>
      </p>
      <button>Save page</button>
    </form>
    
    <p>Back to <a href="/admin/edit_pages">list of all editable pages</a>.</p>