    <hgroup>
        <h1>Search results</h1>
        <h2>Regular bulbs</h2>
    </hgroup>
    
    <p>These are the results of your search for non energy saving bulbs. You searched for "<?=$search?>" in <?if($field=='all_fields'):?>all fields<?else:?>the field "<?=$field?>"<?endif?>.</p>
    
    <?php if($records->paged->total_rows > 0): ?>
    <p>
        <?=$records->paged->total_rows?> results returned<?php if($records->paged->total_pages > 1): ?>, split into <?=$records->paged->total_pages?> pages of <?=$records->paged->page_size?> bulbs each<?php endif ?>.
    </p>
    
    <table id="bulbs_list">
      <tr id="row_heading">
        <th class="col_name">Name</th>
        <th class="col_wattage">Wattage</th>
        <th class="col_voltage">Voltage</th>
        <th colspan="2">&nbsp;</th>
      </tr>
      <?php foreach($records as $record): ?>
      <tr>
        <td class="col_name"><?=$record->name?></td>
        <td class="col_wattage"><?=$record->wattage?></td>
        <td class="col_voltage"><?=$record->voltage?></td>
        <td class="col_view"><a href="/bulbs/information/non_energy_saving/<?=$record->id?>">view</a></td>
        <td class="col_add_to_basket"><a href="/bulbs/find_replacements/<?=$record->id?>">find replacements</a></td>
      </tr>
      <?php endforeach ?>
    </table>
    <?php else: ?>
    <p>Sorry your search returned <strong>no results</strong></p>
    <?php endif ?>
    
