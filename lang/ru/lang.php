<?php

return [

    //
    // SHOP
    //
    'shop' => [
        'menu_label' => 'Магазин',
        'create_order' => 'заказа',
        'create_import_task' => 'задания импорта',
        'preview_import_task' => 'Просмотр задания импорта',
        'products' => 'Товары',
        'categories' => 'Категории',
        'manufacturers' => 'Производители',
        'bindings' => 'Связи',
        'warehouses' => 'Склады',
        'reserves' => 'Резервы',
        'orders' => 'Заказы',
        'import_tasks' => 'Задачи импорта'
    ],

    //
    // IMPORT TASKS
    //
    'import_task' => [
        'title_preview' => 'Просмотр задания импорта',
        'id' => 'ID события',
        'status' => 'Статус выполнения',
        'progress' => 'Прогресс',
        'file' => 'Файл импорта',
        'template' => 'Шаблон импорта',
        'template_empty' => '-- Выберите шаблон --',
        'status_done' => 'Выполнено',
        'status_failed' => 'Прервано',
        'status_waiting' => 'В очереди',
        'status_in_progress' => 'Выполняется',
        'created' => 'Создано',
        'updated' => 'Обновлено',

        'error_count' => 'Ошибок',
        'skipped_count' => 'Пропущенно',
        'warning_count' => 'Предупреждений',

        'done_at' => 'Дата выполнения',
        'created_at' => 'Дата создания',
        'return_link' => 'Вернуться к списку заданий',
        'error_row' => 'Номер строки',
        'error_message' => 'Сообщение',
    ],

    'import_tasks' => [
        'list_title' => 'Управление задачами импорта',
        'new_task' => 'Создать новое задание',
        'form_create_header' => 'Создать новое задание импорта',
        'form_button_create' => 'Создать задание',
        'form_button_cancel' => 'Отменить',
        'create_success' => 'Задание импорта успешно создано',
    ],

    //
    // Products
    //
    'products' => [
        'list_title' => 'Управление товарами',
        'new_product' => 'Создать новый товар',
        'scoreboard_enabled_count' => 'Отображаются',
        'scoreboard_disabled_count' => 'Товаров отключено',
        'scoreboard_deleted_count' => 'Товаров удалено',
        'filter_category' => 'Категория',
        'filter_manufacturer' => 'Производитель',
        'filter_is_active' => 'Активность',
    ],

    //
    // Orders
    //
    'orders' => [
        'list_title' => 'Управление заказами',
        'new_order' => 'Создать новый заказ',
        'filter_status' => 'Статус',
        'filter_manager' => 'Менеджер',
        'filter_date' => 'Дата заказа',
        'hint_draft_title' => 'Счёт помечен, как черновик!',
        'hint_draft_sub_title' => 'Заказчик будет получать уведомления только после активации счёта.',
        'hint_draft_link_text' => 'Активировать счёт',
        'activated_success' => 'Счёт успешно активирован!',
    ],

    'order' => [
        'id' => '',
        'customer' => 'Заказчик',
        'customer_prompt' => 'Нажмите на кнопку %s для поиска заказчика',
        'comment' => 'Комментарий',
    ],
















    // Plugin
    'plugin' => [
        'name' => 'Djetson Shop',
        'description' => 'Платформа для торговли',
        'label' => 'Магазин'
    ],

    // Permissions
    'permissions' => [
        'access_product' => 'Управление товарами',
        'access_categories' => 'Управление категориями',
        'access_manufacturers' => 'Управление производителями',
        'access_orders' => 'Управление заказами',
        'access_currencies' => 'Управление валютами',
        'access_shipping_methods' => 'Управление методами доставки',
        'access_payment_methods' => 'Управление методами оплаты',
        'access_binding' => 'Управление связями',
        'access_binding_type' => 'Управление типами связи',
    ],

    // Btn
    'btn' => [
        'create' => 'Создать',
        'reorder' => 'Изменить порядок',
        'property_groups' => 'Группы свойств',
        'return_to_properties' => 'Вернуться к свойствам',
    ],

    // Scoreboard
    'scoreboard' => [
        'enabled_count' => 'Включено',
        'disabled_count' => 'Отключено',
        'deleted_count' => 'Удалено',
    ],

    // Filter
    'filter' => [
        'category' => 'Категория',
        'manufacturers' => 'Производитель',
    ],











    // Form
    'form' => [
        'name' => 'Название',
        'slug'  => 'Параметр URL',
        'code' => 'Уникальный код',
        'type' => 'Тип',
        'sku' => 'SKU код',
        'ean_13' => 'EAN13 код',
        'isbn' => 'ISBN код',
        'symbol' => 'Символ',
        'symbol_position' => 'Позиция символа',
        'symbol_position_before' => 'Перед стоимостью',
        'symbol_position_after' => 'После стоимости',
        'symbol_space' => 'Пробел между символом и ценой',
        'provider' => 'Поставщик',
        'provider_empty' => '--- Выберите поставщика ---',
        'free_shipping_limit' => 'Лимит бесплатной доставки',
        'mail_template' => 'Шаблон письма',
        'mail_template_empty' => '--- Выберите шаблон ---',
        'mail_template_section' => 'Настройка уведомления на E-mail',
        'description' => 'Описание',
        'meta_title' => 'Мета Title',
        'meta_keywords' => 'Мета Keywords',
        'meta_description' => 'Мета Description',
        'manufacturer' => 'Производитель',
        'package_width' => 'Ширина упаковки',
        'package_height' => 'Высота упаковки',
        'package_depth' => 'Глубина упаковки',
        'package_weight' => 'Вес упаковки',
        'category' => 'Категория',
        'categories' => 'Категории',
        'color' => 'Цвет',
        'bindings' => 'Связи',
        'binding_type' => 'Тип связи',
        'value' => 'Значение',
        'group' => 'Группа',
        'properties' => 'Свойства',
        'property_value' => 'Значение свойства',
        'see_in_categories' => 'Отображать в категориях',
        'quantity' => 'Количество',
        'sum' => 'Сумма',
        'warehouse' => 'Склад',
        'firstname' => 'Фамилия',
        'lastname' => 'Имя',
        'address' => 'Адрес',
        'city' => 'Город',
        'billing_address' => 'Адрес оплаты',
        'shipping_address' => 'Адрес доставки',
        'sub_total' => 'Стоимость',
        'invoice' => 'Номер счёта',
        'status' => 'Статус',
        'cost' => 'Стоимость',
        'price' => 'Цена',
        'product' => 'Товар',
        'price_original' => 'Текущая цена',
        'currency_default' => 'Основная валюта магазина',
        'comment' => 'Комментарий',
        'payment_total' => 'Стоимость оплаты',
        'shipping_total' => 'Стоимость доставки',
        'shipping' => 'Доставка',
        'payment' => 'Оплата',
        'shipped' => 'Отправлен',
        'paid' => 'Оплачен',

        'email' => 'Email',
        'phone' => 'Телефон',
        'country' => 'Страна',
        'state' => 'Область',
        'zip' => 'Индекс',
        'track' => 'Код отслеживания посылки',

        'customer' => 'Заказчик',
        'customer_name' => 'Имя',
        'customer_surname' => 'Фамилия',
        'customer_email' => 'Email',
        'customer_phone' => 'Телефон',



        'total' => 'Всего',
        'subtotal' => 'Сумма заказа',
        'payment_method' => 'Метод оплаты',
        'shipping_method' => 'Метод доставки',

        'is_active' => 'Активность',
        'is_searchable' => 'Индексация',
        'is_available' => 'Доступность',
        'is_available_option_true' => 'Доступен',
        'is_available_option_false' => 'Предзаказ',
        'is_unique_text' => 'Уникальный текст',
        'is_allow_in_order' => 'Разрешить учитывать в заказе',
        'is_allow_free_shipping' => 'Разрешить бесплатную доставку',
        'is_send_email' => 'Отправить уведомление на E-mail?',
        'is_attach_invoice' => 'Прикрепить счёт во вложение?',
        'is_closed' => 'Закрыт',
        'is_paid' => 'Оплачен',
        'is_shipped' => 'Отправлен',
        'is_delivered' => 'Доставлен',

        'created_at' => 'Создан',
        'updated_at' => 'Обновлен',
        'deleted_at' => 'Удален',
        'reserved_at' => 'Резерв',
        'shipped_at' => 'Дата отправки',

        'status_new' => 'Статус новых счетов',
        'status_paid' => 'Статус оплаченных счетов',
        'status_shipped' => 'Статус отправленных счетов',
        'status_delivered' => 'Статус доставленных счетов',
        'status_closed' => 'Статус закрытых счетов',

        'order_allow_shipping_total' => 'Учитывать стоимость доставки',
        'order_allow_payment_total' => 'Учитывать стоимость оплаты',

        'price_format_decimal_count' => 'Количество цифр после знака разделения',
        'price_format_decimal_point' => 'Знак разделения',
        'price_format_thousands_separator' => 'Знак разделения тысяч',
        'price_format_position' => 'Позиция знака валюты',
        'price_format_space' => 'Разделение числа и знака пробелом',

        'dropdown_empty' => '--- Выберите из списка ---',

        'section' => [
            'price_format' => 'Формат отображения стоимости',
            'order_statuses' => 'Статусы счёта'
        ],

        'tab' => [
            'statuses' => 'Статусы',
            'settings' => 'Настройки',
            'general' => 'Основное',
            'seo' => 'SEO',
            'log' => 'Лог',
            'sizes' => 'Размеры',
            'categories' => 'Категории',
            'featured' => 'Связанные товары',
            'images' => 'Изображения',
            'currency' => 'Валюты',
            'products' => 'Товары',
            'properties' => 'Свойства',
            'bindings' => 'Связи',
            'shipping_address' => 'Адрес доставки',
            'billing_address' => 'Адрес оплаты',
            'warehouses' => 'Хранение',
            'orders' => 'Заказы',
            'customer' => 'Заказчик',
            'shipping' => 'Доставка',
            'payment' => 'Оплата',
        ]
    ],

    // List
    'list' => [
        'name' => 'Название',
        'slug'  => 'URL',
        'code' => 'Код',
        'sku' => 'SKU',
        'ean_13' => 'EAN13',
        'isbn' => 'ISBN',
        'symbol' => 'Символ',
        'currency_position' => 'Позиция символа',
        'preview' => 'Предпросмотр',
        'provider' => 'Поставщик',
        'value' => 'Значение',
        'sum' => 'Сумма',
        'warehouse' => 'Склад',
        'event' => 'Событие',


        'group' => 'Группа',
        'type' => 'Тип',
        'category' => 'Категория',
        'categories' => 'Категории',
        'binding_type' => 'Тип связи',
        'status' => 'Статус',
        'payment_cost' => 'Стоиомсть оплаты',
        'shipping_cost' => 'Стоимость доставки',
        'manager' => 'Менеджер',
        'author' => 'Aвтор',
        'customer' => 'Заказчик',

        'quantity' => 'Количество',
        'available' => 'Доступно',
        'preorder' => 'Предзаказ',

        'subtotal' => 'Стоимость',
        'total' => 'Всего',

        'cost' => 'Стоимость',
        'price' => 'Цена',
        'price_current' => 'Текущая цена',

        'price_original' => 'Текущая цена',
        'properties_count' => 'Количество свойств',

        'is_active' => 'Активен',
        'is_searchable' => 'Поиск',
        'is_available' => 'Доступен',
        'is_available_option_true' => 'Доступен',
        'is_available_option_false' => 'Предзаказ',
        'is_unique_text' => 'Текст',
        'is_allow_in_order' => 'Учитывать',
        'is_allow_free_shipping' => 'Бесплатная доставка',
        'is_send_email' => 'Отправить Email',
        'is_attach_invoice' => 'Отправить счёт',
        'is_reserved' => 'Зарезервирован',


        'created_at' => 'Создано',
        'updated_at' => 'Обновлено',
        'deleted_at' => 'Удалено',
        'reserved_to' => 'Резерв до',
        'finished_at' => 'Выполнен'
    ],

    // Errors
    'errors' => [
        'failed_get_default_currency' => 'Не удалось получить валюту по умолчанию!',
        'failed_price_format_position' => 'Настройки позиции знака валюты заданы не верно',
    ],

    // Bindings
    'bindings' => [
        'label' => 'Связи',
        'create' => 'Создание связи',
        'update' => 'Обновление связи',
        'preview' => 'Просмотр связи',
    ],

    // Bindings
    'binding_types' => [
        'label' => 'Типы связи товара',
        'description' => 'Управление типами связи товара',
        'create' => 'Создание типа связи',
        'update' => 'Обновление типа связи',
        'preview' => 'Просмотр типа связи',
    ],

    // Categories
    'categories' => [
        'label' => 'Категории',
        'create' => 'Создание категории',
        'update' => 'Обновление категории',
        'preview' => 'Просмотр категории',
    ],

    // Currencies
    'currencies' => [
        'label' => 'Валюты',
        'description' => 'Управление валютами магазина',
        'create' => 'Создание валюты',
        'update' => 'Обновление валюты',
        'preview' => 'Просмотр валюты',
        'errors' => [
            'delete_default' => 'Вы не можете удалить основную валюту!'
        ]
    ],

    // Import
    'imports' => [
        'id' => 'ID события',
        'status_done' => 'Выполнен',
        'status_failed' => 'Прерван',
        'status_waiting' => 'В очереди',
        'status_in_progress' => 'Выполняется',
    ],

    // Import Template
    'import_templates' => [
        'label' => 'Шаблоны импорта',
        'description' => 'Управление шаблонами импорта',
    ],

    'featured' => [
        'label' => 'Связанные товары',
    ],

    // Manufacturers
    'manufacturers' => [
        'label' => 'Производители',
        'create' => 'Создание производителя',
        'update' => 'Обновление производителя',
        'preview' => 'Просмотр производителя',
    ],

//    // Orders
//    'orders' => [
//        'label' => 'Заказы',
//
//        'filter_date' => 'Дата',
//        'filter_status' => 'Статус',
//        'filter_manager' => 'Менеджер',
//
//        'activated_success' => 'Счёт успешно активирован!',
//
//        'hint_draft_title' => 'Счёт помечен, как черновик!',
//        'hint_draft_sub_title' => 'Заказчик будет получать уведомления только после активации счёта.',
//        'hint_draft_link_text' => 'Активировать счёт',
//
//
//
//        'errors' => [
//            'empty_order' => 'Вы ещё не добавили товары в счёт'
//        ]
//    ],


    // Order items
    'order_items' => [
        'label' => 'Позиции счёта',
        'errors' => [
            'warehouse_update' => 'Не удалось списать товар :product со склада :warehouse в количестве :quantity шт.'
        ]
    ],

    // Order logs
    'order_logs' => [
        'label' => 'Истории счёта',
        'list' => [
            'name' => 'Имя заказчика - :val',
            'surname' => 'Фамилия заказчика - :val',
            'email' => 'Email - :val',
            'phone' => 'Телефон - :val',
            'comment' => 'Комментарий - :val',
            'payment_method' => 'Выбранный метод оплаты - :val',
            'shipping_method' => 'Выбранный метод доставки - :val',
            'payment_total' => 'Стоимость оплаты - :val',
            'shipping_total' => 'Стоимость доставки - :val',
            'sub_total' => 'Сумма заказа - :val',
            'total' => 'Итого - :val',
        ],
        'messages' => [
            'create' => 'Счёт создан',
            'update' => 'Счёт изменён',
            'delete' => 'Счёт удалён',
            'status_update' => 'Статус изменён'
        ],
    ],

    // Order statuses
    'order_statuses' => [
        'label' => 'Статусы счёта',
        'description' => 'Управление статусами счёта',
        'create' => 'Создание статуса счёта',
        'update' => 'Обновление статуса счёта',
        'preview' => 'Просмотр статуса счёта',
    ],

    // Payments
    'payments' => [
        'statuses' => [
            'cancelled' => 'Отменён',
            'paid' => 'Оплачен',
            'failed' => 'Ошибка'
        ],
    ],

    // Payment methods
    'payment_methods' => [
        'label' => 'Методы оплаты',
        'description' => 'Управление методами оплаты',
        'create' => 'Создание метода оплаты',
        'update' => 'Обновление метода оплаты',
        'preview' => 'Просмотр метода оплаты',
        'errors' => [
            'provider_not_found' => 'Не удалось найти провайдер :provider'
        ]
    ],

    // Properties
    'properties' => [
        'label' => 'Свойства товара',
        'description' => 'Управление свойствами товара',
        'create' => 'Создание свойства',
        'update' => 'Обновление свойства',
        'preview' => 'Просмотр свойства',
        'reorder' => 'Сортировка свойст'
    ],

    // Properties
    'property_values' => [
        'label' => 'Значение',
    ],

    // Property Groups
    'property_groups' => [
        'label' => 'Группы свойств',
        'description' => 'Управление группами свойств',
        'create' => 'Создание группы свойства',
        'update' => 'Обновление группы свойства',
        'preview' => 'Просмотр группы свойства',
        'reorder' => 'Сортировка групп свойст'
    ],

    // Settings
    'settings' => [
        'label' => 'Настройки магазина',
        'description' => 'Управление основными настройками',




        'categories' => [
            'shop' => "Shop"
        ]
    ],

    // Shipping methods
    'shipping_methods' => [
        'label' => 'Методы доставки',
        'description' => 'Управление методами доставки',
        'create' => 'Создание метода доставки',
        'update' => 'Обновление метода доставки',
        'preview' => 'Просмотр метода доставки',
    ],

    // Statuses
    'statuses' => [
        'label' => 'Статусы',
        'description' => 'Управление статусами',
        'create' => 'Создание статуса',
        'update' => 'Обновление статуса',
        'preview' => 'Просмотр статуса',
    ],

    // Warehouses
    'warehouses' => [
        'label' => 'Хранение',
        'code' => [
            'available' => 'Доступен к заказу',
            'preorder' => 'Доступен к предзаказу',
        ]
    ],

    // WarehouseLogs
    'warehouse_logs' => [
        'label' => 'Лог склада',
        'events' => [
            'take' => 'Списание товара',
            'put' => 'Возврат товара',
        ],
    ],
];