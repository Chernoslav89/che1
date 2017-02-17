<?php include "header.php"?>

<main class="container-fluid">
			<div class="row content">
				<?php include "sidebar.php"?>
				<?php include "breadcrumbs.php"?>
                <div class="col-xs-10">
                      <ul class="userInfo">
                        <li><img src="img/avatar-user.png" alt="Ваш аватар" title="Ваш аватар"></li>
                        <li class="infoString"><span>Ваше им0'я: </span>Василь Василька Васильович <a class="iconReg glyphicon glyphicon-pencil"></a></li>
                        <li class="infoString"><span>e-mail: </span>lalala@gmail.com <a class="iconReg glyphicon glyphicon-pencil"></a></li>
                        <li class="infoString"><span>Телефон: </span>+ 380 11-22-33-999 <a class="iconReg glyphicon glyphicon-pencil"></a></li>
                        <li class="infoString"><span>Адреса доставки: </span>м. Хмельницький <a class="iconReg glyphicon glyphicon-pencil"></a></li>
                      </ul>
                    </div>
            </div>
				</section>
		</main>

	</div>


	<div class="bgOpacity"></div>
  <script src="js/jquery.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
      $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
      });
  </script>
<?php include "footer.php";?>
