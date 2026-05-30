<?php
// ==========================================
// 1. ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ И ПОЛУЧЕНИЕ ДАННЫХ
// ==========================================
$host = 'localhost';
$dbname = 'news_site'; // Убедись, что в phpMyAdmin база называется именно так!
$username = 'root';    
$password = '';        

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Получаем категорию из ссылки (если кликнули по кнопкам в шапке)
    $category = isset($_GET['cat']) ? $_GET['cat'] : '';

    if ($category === 'today' || $category === 'week' || $category === 'finance') {
        $stmt = $pdo->prepare("SELECT id, title, short_text, image FROM articles WHERE category = ? ORDER BY id DESC");
        $stmt->execute([$category]);
    } else {
        // Если ничего не выбрано, показываем ВСЕ новости
        $stmt = $pdo->query("SELECT id, title, short_text, image FROM articles ORDER BY id DESC");
    }
    
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Если база данных не настроена, этот текст подсветит проблему
    $db_error = "Ошибка подключения к БД: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Новости спорта и финансов</title>
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #3b3b3b;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Твоя шапка сайта */
        .header-site {
            background-color: #1a1a1a;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
        }

        .header-site-child {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .header-site-child:hover {
            color: #00bcd4;
        }

        img.header-site-child {
            height: 40px;
            width: auto;
            filter: invert(100%)
        }

        /* Контентная часть */
        .content {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* Ссылка-обертка над карточкой */
        .news-link-wrapper {
            text-decoration: none;
            color: inherit;
            display: block;
            width: calc(33.333% - 17px); /* Ровно 3 блока в ряд */
            min-width: 290px;
        }

        /* Твой блок новости */
        .block-news {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        }

        .block-news:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-color: #00bcd4;
        }

        .block-news img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 15px;
            background-color: #eee; /* Серый фон, если картинка не загрузится */
        }

        .block-news h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #1a1a1a;
            line-height: 1.3;
        }

        .block-news p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            flex-grow: 1; /* Растягивает текст, выравнивая кнопку внизу */
        }

        .read-btn {
            display: inline-block;
            margin-top: 15px;
            color: #00bcd4;
            font-weight: bold;
            font-size: 14px;
        }

        /* Твой подвал сайта */
        footer {
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px 0;
            margin-top: auto;
        }

        .footer-site {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        .footer-site p {
            margin-right: 10px;
        }

        .footer-site img {
            height: 24px;
            width: 24px;
            cursor: pointer;
        }

        /* Ошибки и уведомления */
        .error-msg {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ffcdd2;
        }
        .icon {
          filter: invert(100%);
        }
    </style>
</head>
<body>

    <div class="header-site">
        <a href="index.php">
            <img src="icon.svg" alt="Логотип" class="header-site-child">
        </a>
        <a href="index.php?cat=today" class="header-site-child">Сегодня</a>
        <a href="index.php?cat=week" class="header-site-child">За неделю</a>
        <a href="index.php?cat=finance" class="header-site-child">Финансы</a>
    </div>

    <div class="content">
        
        <?php if (isset($db_error)): ?>
            <div class="error-msg"><?= $db_error ?></div>
        <?php endif; ?>
        
        <?php if (!empty($news)): ?>
            <?php foreach ($news as $item): ?>
                
                <a href="post.php?id=<?= $item['id'] ?>" class="news-link-wrapper">
                    <section class="block-news">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="Иллюстрация">
                        <h2><?= htmlspecialchars($item['title']) ?></h2>
                        <p><?= htmlspecialchars($item['short_text']) ?></p>
                        <span class="read-btn">Читать полностью &rarr;</span>
                    </section>
                </a>

            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%; color: #888;">
                Новости не найдены. Добавьте записи в таблицу `articles` через phpMyAdmin!
            </p>
        <?php endif; ?>

    </div>

    <footer>
        <div class="footer-site">
            <p>Мы в социальных сетях:</p>
            <img src="vk.svg" alt="VK" class="icon">
            <img src="tg.svg" alt="TG" class="icon">
            <img src="yt.svg" alt="YT" class="icon">
        </div>
    </footer>

</body>
</html>