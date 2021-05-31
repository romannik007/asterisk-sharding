<?php

return array(
	### Подключение к базе данных
	'db' => array(
		# Тип базы, который поддерживается PDO. Например: mysql, pgsql
		'type' => 'mysql',
		# Хост
		'host' => 'mysql',
		# Порт
		'port' => '3306',
		# Пользователь
		'user' => 'cdr',
		# Имя базы
		'name' => 'AsteriskCDRViewerMod',
		# Пароль
		'pass' => '**password**',
		# Название таблицы
		'table' => 'cdr',
		# Доп. опции подключения
		'options' => array(
			//PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		),
	),
	
	### Системное
	'system' => array(
		## Название столбца в БД, в котором хранится название записи звонка
		'column_name' => 'filename',
		
		## Путь к папке для временных файлов
		'tmp_dir' => '/tmp',		
		
		## Путь к папке, где находятся записи Asterisk. БЕЗ слеша на конце
		'monitor_dir' => '/var/calls',		
		
		### Формат хранения файлов записей Asterisk
		## Если 1, то файлы записей должны распределяться скриптом по папкам в соответствии с датой "/var/calls/2015/2015-01/2015-01-01".
		# Записи за сегодня находятся в "/var/calls", записи за прошедшие даты в папках в соответствии с датой "/var/calls/2015/2015-01/2015-01-01"

		## Если 2, то файлы записей должны распределяться скриптом по папкам в соответствии с датой "/var/calls/2015/12/01".
		# Записи за сегодня находятся в "/var/calls", записи за прошедшие даты в папках в соответствии с датой "/var/calls/2015/12/01"

		## Если 3, то файлы записей должны распределяться по папкам Asterisk-ом в соответствии с датой "/var/calls/2015/2015-01/2015-01-01".
		# Записи за все даты находятся в папках в соответствии с датой "/var/calls/2015/2015-01/2015-01-01"

		## Если 4, то файлы записей должны распределяться по папкам Asterisk-ом в соответствии с датой "/var/calls/2015/12/01".
		# Записи за все даты находятся в папках в соответствии с датой "/var/calls/2015/12/01"
		
		## Если др. значение, то все записи хранятся в одной папке "/var/calls"
		'storage_format' => 2,
		
		## Размер файла в Килобайтах, больше которого считается, что файл существует
		'fsize_exists' => 10,
		
		## Формат аудио, в котором записываются записи звонков
		# Плеер не воспроизводит WAV в Enternet Explorer. В последних версиях Firefox и Chrome все работает
		# Например: mp3, wav		
		'audio_format' => 'mp3',
		
		## Отложенная конвертация записей звонков. Полезно для снижения нагрузки на сервер
		# В этом режиме Asterisk должен записывать записи звонков в WAV, затем каждый день в 00.01 часов файлы из WAV должны быть конвертированы в MP3 с помощью скрипта (см. в папке docs + Readme.txt)
		# Файлы за сегодняшний день хранятся в WAV, за прошедшие дни в MP3. В "audio_format" должно быть задано: mp3. В базу в поле 'filename' будет записано имя файла с расширением wav (имя_файла.wav)
		# Если 0 - выключить, 1 - включить
		'audio_defconv' => 1,
		
		## Если записи звонков / факсов через некоторое время архивируются, раскомментировать строку ниже и указать формат архива (zip gz rar bz2 и т.д.)
		# Имя архива должно быть "имя_файла.mp3.zip". Т.е. к имени файла из базы должно быть добавлено расширение архива, например: zip
		//'archive_format' => 'zip',
		
		## Разделитель в CSV файле отчета
		# Обычно используется запятая ",". Но по умолчанию в Microsoft Office для русского языка установлен разделитель точка с запятой ";"
		'csv_delim' => ';',
		
		## Имена пользователей, которым разрешен доступ к сайту. Работает, только если настроена Basic-Auth аутентификация (htpasswd файл) на веб-сервере
		# Добавлять имена пользователей в виде массива. Например: 'admins' => array( 'admin1', 'admin2', 'admin3' );
		# Если массив пустой, то разрешено всем. Т.е. если задано: 'admins' => array( );
		'admins' => array(

		),
		
		## Используемые плагины
		# Если плагин не нужен, закомментировать соответствующую строку
		# Название плагина => имя файла
		'plugins' => array(
			//'Расход средств' => 'my_callrates',
		),
	),

	### Тарифы на звонки
	'callrate' => array(
		## Включение / Отключение функционала подсчета тарифов. Если отключено, то будет работать немного быстрее при большом количестве записей в выводе
		# Если 0 - выключить, 1 - включить
		'enabled' => 0,
		
		## Нетарифицируемый интервал в секундах
		'free_interval' => 3,
		
		## Путь к CSV файлу с тарифами
		# Задается для расчета тарифов при поиске в базе и плагина
		'csv_file' =>  'inc/plugins/my_callrates.csv',
		
		## Название валюты, которая используется при тарификации
		# Например: Будет показано не "1.29", а "1.29 название_валюты"
		'currency' =>  '',
	),
	
	### Отображение
	'display' => array(
		'lookup' => array(
			## URL сервиса информации о номере
			# Где "%n" будет заменено на номер телефона
			'url' => 'https://zvonok.octo.net/number.aspx/' . '%n',
			
			## Минимальная длина номера, для которого будет подставлен URL с инфо о номере
			'num_length' => 7,
		),
		
		'main' => array(
			## Количество записей для показа на странице по умолчанию
			'result_limit' => 100,
			## Количество показанных записей, после которых снова будет показана шапка (Дата, Статус...)
			'header_step' => 20,
			
			### Если 0 - выключить, 1 - включить
			## Показ без дублирующихся записей в Asterisk 13 и выше
			'duphide' => 0,
			
			## Показ кнопки - Воспроизведение записи звонка
			'rec_play' => 0,			
			
			## Показ кнопки - Удаление записи звонка
			'rec_delete' => 0,
			
			## Возможность редактировать поле "Комментарий" (userfield)
			'userfield_edit' => 1,
			
			## Показ контекстного пункта меню - Удаление строки из базы
			'entry_delete' => 0,
			
			## Показать Вх. / Исх. канал полностью
			# В колонках Вх. / Исх. канал, Например, вместо "SIP" будет показано "SIP/123"
			'full_channel' => 1,
			
			## Показать при наведении на "Вх. / Исх. канал", канал полностью с его ID
			# При наведении на колонки Вх. / Исх. канал, во всплывающей подсказке, Например, вместо "SIP" или "SIP/100" будет показано "SIP/123-00000025"
			'full_channel_tooltip' => 1,			
		),
		
		### Включение / Отключение показа фильтров поиска
		# Если 0 - всегда скрывать, 1 - всегда показывать, 2 - показать при нажатии на кнопку "Дополнительные фильтры"	
		'search' => array(
			## Кто звонил
			'src' => 1,
			## Куда звонили
			'dst' => 1,
			## Статус звонка
			'disposition' => 1,
			## Длительность
			'duration' => 2,
			## Входящий канал
			'channel' => 2,
			## Имя звонящего
			'clid' => 1,
			## DID (Внешний номер)
			'did' => 2,
			## Исходящий канал
			'dstchannel' => 2,
			## Код аккаунта
			'accountcode' => 1,
			## Комментарий (userfield)
			'userfield' => 2,
			## Приложение
			'lastapp' => 2,
			## Параллельные звонки
			'chart_cc' => 2,
			## ASR и ACD (Коэффициент отвеченных вызовов / Средняя продолжительность вызова)
			'asr_report' => 1,
			## CSV файл
			'csv' => 2,
			## График звонков
			'chart' => 2,
			## Расход минут
			'minutes_report' => 1,
		),
		
		### Включение / Отключение показа некоторых колонок
			# Если 0 - скрыть, 1 - показать
			'column' => array(
			## DID
			'did' => 1,
			## Длительность ожидания ответа
			'durwait' => 1,				
			## Длительность обработки звонка
			'billsec' => 1,		
			## Длительность полная (ожидание ответа + обработка звонка)
			'duration' => 1,
			## CallerID
			'clid' => 1,
			## Аккаунт
			'accountcode' => 1,
			## Тариф
			'callrates' => 1,
			## Направление звонка
			'callrates_dst' => 1,
			## Входящий канал
			'channel' => 1,
			## Исходящий канал
			'dstchannel' => 1,
			## Приложение
			'lastapp' => 1,
			## Файл
			'file' => 0,			
			## Комментарий (userfield)
			'userfield' => 1,			
		),
	),

	### Параметры сайта
	'site' => array(
		'main' => array(
			## Meta - Title
			'title' => 'Детализация звонков',
			
			## Meta - Description
			'desc' => 'Детализация звонков',
			
			## Meta - Robots
			'robots' => 'noindex, nofollow',
			
			## Текст в шапке
			'head' => 'Детализация звонков',
			
			## Путь к изображению с вашим логотипом, которое будет показано в шапке вместо текста
			# Если нужно оставить текст, то закомментировать строку ниже или задать значение ''			
			//'logo_path' => 'img/example_logo.png',
			
			## Путь к основному разделу сайта
			# Чтобы стрелка (рядом с текстом или логотипом в шапке) не показывалась, закомментировать строку ниже или задать значение ''
			'main_section' => '../',
			## Минимальная ширина шаблона сайта
			# Минимальная ширина сжатия по горизонтали. Например: 900px
			'min_width' => '1024px',
	    
			## Максимальная ширина шаблона сайта
			# Максимальная ширина растяжения по горизонтали. Например: 100%, 1200px
			'max_width' => '1400px',
		),
		
		'js' => array(
			## Автовоспроизведение записи звонка. Если 0 - выключить, 1 - включить
			'player_autoplay' => 1,
			
			## Показ даты записи звонка над плеером. Если 0 - скрыть, 1 - показать
			'player_title' => 1,
			
			## Символ, который будет добавлен в Meta - Title страницы во время воспроизведения записи звонка
			'player_symbol' => '&#9835;&#9835;&#9835;',
			
			## Показ стрелок для быстрой навигации справа. Если 0 - скрыть, 1 - показать
			'scroll_show' => 1,
		),		
	),
	
    ### CDN
    # Пути к некоторым CSS и JS файлам. Можно указать URL и загружать, например, jQuery с Google CDN
    'cdn' => array(
	'css' => array(
	## Tooltips
	'tooltips' => 'img/simptip.min.css',
	## jQuery contextMenu
	'jquery_contextmenu' => 'img/jquery-contextmenu/jquery.contextMenu.min.css',
	),
	
	'js' => array(
	## Плеер
	'player' => 'img/player.js',
	## Скин для плеера
	'player_skin' => 'img/player_skin.js',
	## jQuery
	'jquery' => 'img/jquery.min.js',
	## jQuery query object
	'jquery_object' => 'img/jquery.query-object.min.js',
	## Clipboard JS
	'clipboard_js' => 'img/clipboard.min.js',
	## jQuery contextMenu
	'jquery_contextmenu' => 'img/jquery-contextmenu/jquery.contextMenu.min.js',
	## jQuery UI position
	'jquery_ui_position' => 'img/jquery-contextmenu/jquery.ui.position.min.js',
	## Moment JS
	'moment_js' => 'img/moment.js/moment.min.js',
	## Moment JS - Locale RU
	'moment_js_locale' => 'img/moment.js/ru.js',			
	),		
    ), 
	

);