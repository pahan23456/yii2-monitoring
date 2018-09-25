<p>
    Здравствуйте, <?= $user->initials ?>! Вам было прислано данное уведомление, так как Вы являеетесь ответственным
    за выполнение команды <b><?= $detail->command->command ?> - "<?= $detail->command->description ?>"</b>.
    <br>
    Во время выполнения команды - <b><?= $detail->command->description ?></b>, возникла ошибка: <b><?= $detail->message ?></b>. <br><br>
    <b>Подробная информация:</b><br>
    <b>Выполнеяемая команда</b>: <?= $detail->command->command ?> <br>
    <b>Описание команды</b>: <?= $detail->command->description ?> <br>
    <b>Статус события</b>: <?= $detail->status ?> <br>
    <b>Сообщение события</b>: <?= $detail->message ?> <br>
    <b>Идентификатор события</b>: <?= $detail->eventId ?> <br>
    <b>Время события</b>: <?= $detail->creationDate ?> <br>

    <?php if (!empty($detail->data)): ?>
        <b>Дополнительная информация</b>: <?= $detail->data ?> <br>
    <?php endif; ?>

    <br><br>
    Если данное уведомление прислано Вам по ошибке, просьба удалите его!
</p>


