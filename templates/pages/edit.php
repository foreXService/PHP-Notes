<?php $note = $params['note'] ?? null?>
<div>
    <h3>Edycja notatki</h3>
    <div> 
        <?php if ($note) : ?>
            <form class="note-form" action="/kurs_php/?action=edit" method="post">
            <input type="hidden" name="id" value="<?= $note['id']?>">
                <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" value="<?= $note['title']?>"/>
                </li>
                <li>
                    <label>Treść</label>
                    <textarea name="description" id="field5" class="field-long field-textarea"><?= $note['description']?></textarea>
                </li>
                <li>
                    <input type="submit" value="Edytuj" />
                </li>
                </ul>
            </form>
        <?php else : ?>
            <div class="error">Brak notatki do wyświetlenia !!! </div>
        <?php endif; ?>
        <a href="/kurs_php/">
            <button>Powrót do listy</button> 
        </a>
    </div>
</div>