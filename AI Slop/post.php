<?php
// ==========================================
// 1. ПОДКЛЮЧЕНИЕ К БАЗЕ И ПОИСК НОВОСТИ
// ==========================================
$host = 'localhost';
$dbname = 'news_site'; 
$username = 'root';    
$password = '';        

$article = null;

// Проверяем, передан ли ID новости в адресной строке
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Ищем в базе новость с конкретным ID
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        die("<p style='color:red;'>Ошибка БД: " . $e->getMessage() . "</p>");
    }
}

// Если хакер ввёл несуществующий ID или новость удалена
if (!$article) {
    die("<h1 style='text-align:center; margin-top:50px;'>Упс! Новость не найдена.</h1><p style='text-align:center;'><a href='index.php'>Вернуться на главную</a></p>");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($article['title']) ?></title>
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Шапка */
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
        }

        /* Контентная область */
        .content {
            flex: 1;
            max-width: 800px; /* Сузили для удобного чтения текста */
            margin: 0 auto;
            padding: 40px 20px;
            width: 100%;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #00bcd4;
            text-decoration: none;
            font-weight: bold;
        }

        /* Блок полной новости */
        .full-news-block {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .full-news-block h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #1a1a1a;
            line-height: 1.3;
        }

        .full-news-block img {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 30px;
            background-color: #eee;
        }

        .full-text {
            font-size: 18px;
            line-height: 1.8; /* Хороший интервал между строками */
            color: #444;
            white-space: pre-line; /* Сохраняет абзацы из базы данных */
        }

        /* Подвал */
        footer {
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px 0;
            margin-top: auto;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header-site">
        <a href="index.php" class="header-site-child">Главная</a>
        <a href="index.php?cat=today" class="header-site-child">Сегодня</a>
        <a href="index.php?cat=week" class="header-site-child">За неделю</a>
        <a href="index.php?cat=finance" class="header-site-child">Финансы</a>
    </div>

    <div class="content">
        <a href="index.php" class="back-button">&larr; Назад к списку новостей</a>
        
        <article class="full-news-block">
            <h1><?= htmlspecialchars($article['title']) ?></h1>
            
            <img src="<?= htmlspecialchars($article['image']) ?>" alt="Иллюстрация">
            
            <div class="full-text">
                <?= htmlspecialchars($article['full_text']) ?>
            </div>
        </article>
    </div>

    <footer>
        <p>&copy; <?= date('Y') ?> Мой новостной сайт</p>
    </footer>

</body>
</html>