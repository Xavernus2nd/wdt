<!--Menyambung laman utama dengan header, nav, articlehome, footer-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Halaman Utama</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav>
        <?php include 'navbelumlogin.php'; ?>
    </nav>
    <header>
        <?php include 'header.php'; ?>
    </header>
            <section>
                <article>
                    <?php include 'articlehome.php'; ?>
                </article>
            </section>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>