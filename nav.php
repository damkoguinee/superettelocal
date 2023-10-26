

	<?php $productnav = $DB->query('SELECT * FROM logo ORDER BY (name)');
	foreach ($productnav as $logo):?>

		<div class="navl"><a href="index.php?logo=<?= $logo->name; ?>"><?= $logo->name; ?></a></div>
	<?php endforeach ?>
