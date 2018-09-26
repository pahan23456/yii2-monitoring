<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title></title>
    <style type="text/css">
        .header a:link {
            color: #ff6e6e;
            font-size: 19px;
            text-decoration: none;
        }

        .header a:hover {
            color: rgba(107, 149, 13, 0.81);
            font-size: 19px;
            text-decoration: none;
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#F2F2F2;">
<center>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
        <tr>
            <td align="center" valign="top">
                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
                    <tr>
                        <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                                <tr>
                                    <td align="center" valign="top" bgcolor="#6200EE">
                                        <p class="header" style="color: #ffffff; font-size: 26px;">Мониторинг сайта <a style="color: #ff6e6e; font-size: 19px; text-decoration: none;" href="http://<?= $_SERVER['SERVER_NAME'] ?>"><?= $_SERVER['SERVER_NAME'] ?></a> </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" style="background:#fff;">
                                            <tr>
                                                <td>Команда</td>
                                                <td><?= $detail->command->command ?></td>
                                            </tr>
                                            <tr style="background:#e0e0e0;">
                                                <td>Статус</td>
                                                <td style="color: #ffffff; background: #ff0000"><?= $detail->status ?></td>
                                            </tr>
                                            <tr>
                                                <td>Причина</td>
                                                <td><?= $detail->message ?></td>
                                            </tr>
                                            <tr style="background:#e0e0e0;">
                                                <td>Время события</td>
                                                <td><?= $detail->creationDate ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <table width="600" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td><h2>Подробности</h2></td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul>
                                            <?php if (!empty($detail->data)): ?>
                                            <li><?= $detail->data ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <p style="color:#909090; font-size: 12px;">Вы получили данное уведомление, так как указаны в списке рассылке уведомлений по команде "<?= $detail->command->description ?>".
                                Настроить уведомления вы можете в <a href="http://content2.retail.ru">Админ-панели</a>
                            </p>
                            <p>Мониторинг сайта <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/"><?= $_SERVER['SERVER_NAME'] ?></a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>
</body>
</html>


<!--<p>-->
<!--    Здравствуйте, --><?//= $user->initials ?><!--! Вам было прислано данное уведомление, так как Вы являеетесь ответственным-->
<!--    за выполнение команды <b>--><?//= $detail->command->command ?><!-- - "--><?//= $detail->command->description ?><!--"</b>.-->
<!--    <br>-->
<!--    Во время выполнения команды - <b>--><?//= $detail->command->description ?><!--</b>, возникла ошибка: <b>--><?//= $detail->message ?><!--</b>. <br><br>-->
<!--    <b>Подробная информация:</b><br>-->
<!--    <b>Выполнеяемая команда</b>: --><?//= $detail->command->command ?><!-- <br>-->
<!--    <b>Описание команды</b>: --><?//= $detail->command->description ?><!-- <br>-->
<!--    <b>Статус события</b>: --><?//= $detail->status ?><!-- <br>-->
<!--    <b>Сообщение события</b>: --><?//= $detail->message ?><!-- <br>-->
<!--    <b>Идентификатор события</b>: --><?//= $detail->eventId ?><!-- <br>-->
<!--    <b>Время события</b>: --><?//= $detail->creationDate ?><!-- <br>-->
<!---->
<!--    --><?php //if (!empty($detail->data)): ?>
<!--        <b>Дополнительная информация</b>: --><?//= $detail->data ?><!-- <br>-->
<!--    --><?php //endif; ?>
<!---->
<!--    <br><br>-->
<!--    Если данное уведомление прислано Вам по ошибке, просьба удалите его!-->
<!--</p>-->
<!---->
<!---->
