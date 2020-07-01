<?php $note = $params['note'] ?? null?>
<div class="show">
    <?php if ($note) : ?>
    <ul>
        <li>Id : <?= $note['id'];?></li>
        <li>Tytuł : <?= $note['title'];?></li>
        <li><?= $note['description'];?></li>
        <li>Zapisano : <?= $note['created'];?></li>
    </ul>
    <a href="/kurs_php/?action=edit&id=<?=$note['id']?>">
       <button>Edytycja</button> 
    </a>
    <?php else : ?>
        <div class="error">Brak notatki do wyświetlenia !!! </div>
    <?php endif; ?>
    <a href="/kurs_php/">
       <button>Powrót do listy</button> 
    </a>
</div>