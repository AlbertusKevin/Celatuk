<h4><?= Message::email404(); ?></h4>
<body>
<h2>Input your registered email</h2>
<form action = "<?=URL?>/user/send_email" method = 'post'>
    <div class="container">
        <label for="email">Email   :</label>
        <input type="email" id = 'email' name = 'email'>
        <button type = "submit">Send</button>
    </div>
</form>