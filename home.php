<link rel="stylesheet" href="home.css">
<section>
    <div class="container mt-4 overflow-auto">
        <?php 
        require_once 'session.php';
        if ($_SESSION['loginSuccess']) {
            include('calendar/index.html');
        }

        ?>
    </div>
</section>