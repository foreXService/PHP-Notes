<div class="list">
  <section>
    
    <?php if (!empty($params['before'])) : ?>
        <div class="message">
            <?php
                switch ($params['before']) {
                  case 'created':
                      echo 'Notatka została utworzona';
                      break;
                  case 'edited':
                      echo 'Notatka została edytowana';
                      break;
                  case 'deleted':
                    echo 'Notatka została usunięta';
                    break;
                }
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($params['error'])) : ?>
        <div class="error">
            <?php
                switch ($params['error']) {
                  case 'noteNotFound':
                      echo 'Notatka nie istnieje';
                      break;
                  case 'missingNoteId':
                    echo 'Niepoprawny identyfikator notatki';
                    break;      

                  
                }
            ?>
        </div>
    <?php endif; ?>

    <?php
      $sort = $params['sort'] ?? [];
      $page = $params['page'] ?? [];
      $by = $sort['by'] ?? 'title';
      $order = $sort['order'] ?? 'desc';
      $size = $page['size'] ?? 10;
      $current = $page['number'] ?? 1;
      $pages = $page['pages'] ?? 1;
      $phrase = $params['phrase'] ?? null;
    ?>

    <div>
                <form class="settings-form" action="/kurs_php/" method="get">
                <div>
                  <div>Wyszukaj : </div>
                  <input type="text" name="phrase" id="phrase" value=<?=$phrase?>>
                </div>
                <div>
                  <div>Sortuj po : </div>
                  <label >Tytule</label>
                  <input type="radio" name="sortby" value="title" <?= $by==='title'?'checked':'' ?>>
                  <label >Dacie</label>
                  <input type="radio" name="sortby" value="created" <?= $by==='created'?'checked':'' ?>>
                </div>
                  
                  <div>
                    <div>Kierunek sortowania :</div>
                    <label >Rosnąco</label>
                    <input type="radio" name="sortorder" value="asc" <?= $order==='asc'?'checked':'' ?>>
                    <label >Malejąco</label>
                    <input type="radio" name="sortorder" value="desc" <?= $order==='desc'?'checked':'' ?>>
                  </div>
                  
                  <div>
                    <div>Ilość wpisów na stronie :</div>
                    <label >
                    <input type="radio" name="pagesize" value="1" <?= $size==='1'?'checked':'' ?>> 1</label>
                    <label >
                    <input type="radio" name="pagesize" value="5" <?= $size==='5'?'checked':'' ?>>5</label>
                    <label >
                    <input type="radio" name="pagesize" value="10" <?= $size==='10'?'checked':'' ?>>10</label>
                    <label >
                    <input type="radio" name="pagesize" value="25" <?= $size==='25'?'checked':'' ?>>25</label>
                  </div>
                
                <input type="submit" value="Wyślij">
                </form>
    </div>

    
    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>Id</th>
            <th>Tytuł</th>
            <th>Data</th>
            <th>Opcje</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <?php foreach ($params['notes'] ?? [] as $note) :?>
            <tr>
                <td><?= $note['id']; ?></td>
                <td><?= $note['title']; ?></td>
                <td><?= $note['created']; ?></td>
                <td>
                    <a href="/kurs_php/?action=show&id=<?= $note['id'] ?>">
                        <button>Pokaż</button> 
                    </a>
                    <a href="/kurs_php/?action=edit&id=<?= $note['id'] ?>">
                        <button>Edytuj</button> 
                    </a>
                    <a href="/kurs_php/?action=delete&id=<?= $note['id'] ?>">
                        <button>Usuń</button> 
                    </a>
                </td>
            </tr>
            


          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    
    <ul class="pagination">
            <?php $paginationUrl = "&phrase=$phrase&pagesize=$size&sortby=$by&sortorder=$order"; ?>
            <?php if ($current !== '1') : ?>
              <li>
                <a href="/kurs_php/?pagenumber=<?=($current -1)?><?= $paginationUrl?>">
                  <button><<</button>
                </a>
              </li>
            <?php endif; ?>
            
            <?php for ($i=1;$i <= $pages;$i++): ?>
              <li>
                <a href="/kurs_php/?pagenumber=<?=$i?><?=$paginationUrl?>">
                  <button><?=$i?></button>
                </a>
              </li>
            <?php endfor; ?>

            <?php if ($current < $pages) : ?>
              <li>
                <a href="/kurs_php/?pagenumber=<?=($current + 1)?><?= $paginationUrl?>">
                  <button>>></button>
                </a>
              </li>
            <?php endif; ?>
    </ul>
  </section>
</div>