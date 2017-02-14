<?php include "header.php";?>
<?php include "sidebar.php";?>
<?php include "breadcrumbs.php";?>
<!--HTML START-->
	<!-- Default panel contents -->
<form>
	<div class="col-xs-10">
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading"><h2>Ваша корзина покупок</h2></div>

	<!-- Table -->
	<table class="table table-bordered table-stripped">
		<th>№</th>
		<th>Назва товару</th>
		<th>Фотографія</th>
		<th>Ціна за 1 шт.</th>
		<th>Кількість</th>
		<th>Загальна ціна</th>
		<th>Дія</th>
		<tr>
			<td>1</td>
			<td><p><a href="<?php echo "{id}"?>">A pariatur deleniti eaque, iste.</a></p></td>
			<td> <a href="<?php echo "{id}"?>"><img class="media-object" style="height: 80px;width: 80px;" src="img/futbolka.jpg" alt="wdad"></a></td>
			<td><?php echo"{count}"?> грн.</td>
			<td><?php echo"{count}"?> шт.</td>
			<td><?php echo"{count}"?> грн.</td>
			<td><input type="button" class="btn-danger btn" value="delete"><br><br><input type="button"class="btn-info btn" value="info"></td>
		</tr>
		<tr>
			<td>1</td>
			<td><p><b>A pariatur deleniti eaque, iste.</b></p></td>
			<td><img class="media-object" style="height: 80px;width: 80px;" src="img/futbolka.jpg" alt="wdad"></td>
			<td><?php echo"{count}"?> грн.</td>
			<td><?php echo"{count}"?> шт.</td>
			<td><?php echo"{count}"?> грн.</td>
			<td><input type="button" class="btn-danger btn" value="delete"><br><br><input type="button"class="btn-info btn" value="info"></td>
		</tr>
	</table>
		</div>
		<div style="float: right"><input type="submit" class="btn btn-success"value="Продолжить покупку"></div>
	</div>
	</div>
</form>
	<!--HTML END-->
<?php include "footer.php";?>
