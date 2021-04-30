<?php

return [
    'plugin' => [
        'name' => 'Hírlevél küldése',
        'description' => 'Egyszerű, de nagyszerű megoldás.',
        'author' => 'Szabó Gergő'
    ],
    'menu' => [
        'newsletter' => 'Hírlevél',
        'mails' => 'Levelek',
        'subscribers' => 'Feliratkozók',
        'import' => 'Importálás',
        'export' => 'Exportálás',
        'logs' => 'Naplózás',
        'settings' => 'Beállítások'
    ],
    'title' => [
        'mails' => 'levél',
        'subscribers' => 'feliratkozó',
        'statistics' => 'Statisztika'
    ],
    'new' => [
        'mails' => 'Új levél',
        'subscribers' => 'Új feliratkozó'
    ],
    'stat' => [
        'mails' => 'Levél|Levél',
        'view' => ' Megtekintés',
        'mail' => 'Elküldve',
        'loss' => 'Veszteség',
        'basic' => 'Alap',
        'emails' => 'Levelek',
        'queued' => 'Folyamatban',
        'send' => 'Elküldve',
        'sent' => 'Elküldve',
        'viewed' => 'Megtekintve',
        'click' => 'Kattintás',
        'clicked' => 'Kattintva',
        'failed' => 'Sikertelen',
        'log' => [
            'events' => 'Események',
            'summary' => 'Összegzés'
        ]
    ],
    'form' => [
        // Általános
        'id' => 'ID',
        'created_at' => 'Létrehozva',
        'updated_at' => 'Módosítva',
        // Bejegyzések
        'title' => 'Cím',
        'content' => 'Tartalom',
        'status' => 'Státusz',
        'status_final' => 'Végleges',
        'status_draft' => 'Piszkozat',
        'status_active' => 'Aktív',
        'status_inactive' => 'Inaktív',
        'status_unsubscribed' => 'Leiratkozott',
        'status_pending' => 'Függőben',
        'yes' => 'Igen',
        'no' => 'Nem',
        'view' => 'megtekintés',
        'last_send_at' => 'Utoljára elküldve',
        'last_send' => 'Levélküldés',
        'length' => 'Hossz',
        'clone_of' => 'Másolat',
        'mail_cloning' => 'Levél másolása :name',
        // Feliratkozók
        'name' => 'Név',
        'email' => 'E-mail',
        'comment' => 'Megjegyzés',
        'mail' => 'levél',
        'registered_at' => 'Regisztráció ideje',
        'confirmed_at' => 'Elfogadás ideje',
        'unsubscribed_at' => 'Leiratkozás ideje',
        'ip_address' => 'IP cím',
        'no_data' => 'Nincs adat',
        // Naplózás
        'mail' => 'Levél',
        'subscriber_name' => 'Feliratkozó neve',
        'subscriber_email' => 'Feliratkozó címe',
        'queued_at' => 'Folyamatban',
        'send_at' => 'Elküldve',
        'viewed_at' => 'Megnézve',
        'clicked_at' => 'Kattintva',
        'logs_count' => 'Levél'
    ],
    'button' => [
        'activate' => 'Közzétesz',
        'deactivate' => 'Rejtés',
        'active' => 'Aktív',
        'inactive' => 'Inaktív',
        'import' => 'Importálás',
        'export' => 'Exportálás',
        'unsubscribe' => 'Leiratkozás',
        'subscribe' => 'Feliratkozás',
        'test' => 'Tesztlevél küldése',
        'send' => 'Hírlevél küldése',
        'send_confirmation' => 'Valóban el akarja küldeni a hírlevelet?',
        'resend' => 'Hírlevél újraküldése',
        'resend_confirmation' => 'Valóban újra akarja küldeni a hírlevelet?',
        'return' => 'Vissza'
    ],
    'flash' => [
        'activate' => 'A levelek sikeresen aktiválva lettek.',
        'deactivate' => 'A levelek sikeresen deaktiválva lettek.',
        'draft' => 'A levelek sikeresen piszkozatok lettek.',
        'subscribe' => 'A felhasználók feliratkozása megtörtént.',
        'unsubscribe' => 'A felhasználók leiratkozása megtörtént.',
        'delete' => 'Valóban törölni akarja?',
        'remove' => 'Az eltávolítás sikeresen megtörtént.',
        'newsletter_test_error' => 'A teszt levél elküldése során hiba történt.',
        'newsletter_send_success' => 'A hírlevél sikeresen el lett küldve.',
        'newsletter_send_error' => 'A hírlevél elküldése során hiba történt. Mielőtt ismét elküldené, nézze meg a naplót, hogy több információt kapjon az aktuális állapotról.',
        'newsletter_resend_success' => 'A hírlevél sikeresen újra lett küldve.',
        'newsletter_resend_error' => 'A hírlevél újraküldése során hiba történt. Mielőtt ismét elküldené, nézze meg a naplót, hogy több információt kapjon az aktuális állapotról.',
        'subscriber_confirmation_token_invalid' => 'Az elfogadó link vagy az azonosító kód helytelen.',
        'subscriber_confirmation_token_expired' => 'Az elfogadás határideje lejárt, kérjük regisztráljon újból.',
        'subscriber_confirmation' => 'Sikeresen elfogadta a feliratkozást. Hamarosan meg fogja kapni hírlevelünket.',
        'subscriber_already_confirmed' => 'A feliratkozása már el lett fogadva.',
        'mail_clone_confirm' => 'Valóban másolni akarja ezt a levelet?'
    ],
    'backend_settings' => [
        'description' => 'A levélküldésre és a statisztikára vonatkozó beállítások.',
        'main_section' => 'Hírlevelek küldésére vonatkozó beállítások',
        'click_tracking' => 'Kattintás követése',
        'click_tracking_comment' => 'Követés engedélyezése, amikor a feliratkozó egy levélben lévő hivatkozásra kattint.',
        'email_view_tracking' => 'Megtekintés követése',
        'email_view_tracking_comment' => 'Követés engedélyezése, amikor a feliratkozó megtekinti a levelet.',
        'email_view_tracking_warning' => [
            'heading' => 'Legyen óvatos ennek a használatával',
            'subheading' => 'Nem elfogadott minden országban!',
            'text' => 'Ha ezt a funkciót használja, akkor győződjön meg róla, hogy nem sérti meg a helyi törvényeket.'
        ],
        'newsletter_double_opt_in' => 'Hírlevél feliratkozás megerősítése',
        'newsletter_double_opt_in_comment' => 'Egy megerősítő levelet fog kapni a feliratkozó, amivel igazolhaja az email címét.',
    ],
    'widget' => [
        'mails' => 'Hírlevél - Gyors statisztika',
        'newposts' => 'Hírlevél - Újak',
        'subscribers' => 'Hírlevél - Feliratkozók',
        'show_total' => 'Összes mutatása',
        'show_active' => 'Aktívak mutatása',
        'show_inactive' => 'Inaktívak mutatása',
        'show_draft' => 'Piszkozatok mutatása',
        'show_piece' => 'Bejegyzések száma',
        'show_rank' => 'Helyezés mutatása',
        'show_date' => 'Dátum mutatása',
        'show_unsub' => 'Leiratkozottak mutatása',
        'show_pending' => 'Függőben lévők mutatása',
        'total' => 'Összes'
    ],
    'component' => [
        'subscribe' => 'Űrlap feliratkozáshoz',
        'unsubscribe' => 'Űrlap leiratkozáshoz'
    ],
    'permission' => [
        'mails' => 'Levelek kezelése',
        'subscribers' => 'Feliratkozók kezelése',
        'statistics' => 'Statisztika megtekintése',
        'import_export' => 'Importálás és exportálás',
        'settings' => 'Beállítások módosítása',
        'logs' => 'Naplózás megtekintése'
    ],
    'messages' => [
        'unsubscribed' => 'Sikeresen leiratkozott a hírlevelünkről.',
        'not_subscribed' => 'Már leiratkozott a hírlevelünkről.',
        'subscribed' => 'Köszönjük, hogy feliratkozott a hírlevelünkre!'
    ]
];
