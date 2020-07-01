<?php $note = $params['note'] ?? null?>
<div>
    <h3>Usunięcie notatki</h3>
    <div> 
        <?php if ($note) : ?>
            <form class="note-form" action="/kurs_php/?action=delete" method="post">
            <input type="hidden" name="id" value="<?= $note['id']?>">
                <ul>
                    <li>Id : <?= $note['id'];?></li>
                    <li>Tytuł : <?= $note['title'];?></li>
                    <li><?= $note['description'];?></li>
                    <li>Zapisano : <?= $note['created'];?></li>
                    <li>
                        <input type="submit" value="Usuń" />
                    </li>
                </ul>
            </form>
        <?php else : ?>
            <div class="error">Brak notatki do wyświetlenia !!! </div>
        <?php endif; ?>
    </div>
    <a href="/kurs_php/">
        <button>Powrót do listy</button> 
    </a>
</div>