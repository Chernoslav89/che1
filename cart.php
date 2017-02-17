<?php include "header.php";?>





<main class="container-fluid">
	<div class="row content">
		<?php include "sidebar.php";?>
			<?php include "breadcrumbs.php";?>
<!--HTML START-->
	<!-- Default panel contents -->

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

		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Посмотреть отчет</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Ваш отчет</h4>
		      </div>
		      <div class="modal-body">
		        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
		        <button type="button" class="btn btn-primary">Сохранить изменения</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- Modal -->
	</div>
	</div>
</div>
</main>

	<!--HTML END-->

<?php include "footer.php";?>
