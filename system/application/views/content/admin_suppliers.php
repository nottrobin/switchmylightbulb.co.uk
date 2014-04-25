
        <hgroup>
          <h1>All suppliers</h1>
        </hgroup>
        
        <p>Following is a list of all suppliers. From here you can view or edit any of the suppliers' information.</p>
        
        <table>
          <tr>
            <th>Company name</th>
            <th>Description</th>
            <th></th>
          </tr>
          <?foreach($records as $record):?>
          <tr>
            <td><strong><?=$record->company_name?></strong></td>
            <td><?=$record->description?></td>
            <td><a href="/supplier/information/<?=$record->id?>">view / edit</a></td>
          </tr>
          <?endforeach?>
        </table>
        