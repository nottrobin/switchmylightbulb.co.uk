
        <?php if(isset($records->paged) && $records->paged->total_pages > 1): ?>
        <nav id="page_controls">
          <ul id="previous_pages">
          <?php if($records->paged->has_previous): ?>
            <li><a href="<?=$pageable_uri?>/1">first page</a></li>
            <?php if($records->paged->previous_page != 1): ?>
            <li><a href="<?=$pageable_uri?>/<?=$records->paged->previous_page?>">previous page</a></li>
            <?php endif ?>
          <?php endif ?>
          </ul>
          
          <ul id="next_pages">
          <?php if($records->paged->has_next): ?>
            <?php if($records->paged->next_page != $records->paged->total_pages): ?>
            <li><a href="<?=$pageable_uri?>/<?=$records->paged->next_page?>">next page</a></li>
            <?php endif ?>
            <li><a href="<?=$pageable_uri?>/<?=($records->paged->total_pages)?>">last page</a></li>
          <?php endif ?>
          </ul>
        </nav>
        <?php endif // end if($records->total_pages > 1) ?>
        
