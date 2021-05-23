<?php 

include "../php/checklogin.php";
$loggedin = checkLogin();

?>

<?php if ($loggedin): ?>
    <article class="adminpanel">
			<h1>Ты залогинен</h1>
    </article>
<?php else: ?>
    <article class="adminpanel">
        <h1>Ты не залогинен</h1>
    </article>
<?php endif; ?>