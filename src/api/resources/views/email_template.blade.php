<p>Olá, <?php print $data['user']; ?></p>
<br>
<p>Houve um pedido de alteração da sua senha!</p>
<br>
<p>Se você não fez essa solicitação, ignore este e-mail.</p>
<br>
<p>Caso contrário, clique neste link para alterar sua senha: <?php echo $data['token'] ?></p>