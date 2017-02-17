<?php include "header.php";?>
<main class="container-fluid">
			<div class="row content">
				<?php include "sidebar.php";?>
				<?php include "breadcrumbs.php";?>
				<div class="row">
					<div class="col-xs-10 product">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">
							<?php echo "НАЗВАНИЕ ПРОДУКТА"?>
						</span>
						<hr>
						<div class="col-sm-12 col-lg-6">
							<img src="img/futbolka.jpg" width="350px"> 	 <!--width="350"-->
						</div>

                    <div class="col-sm-12 col-lg-6">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                      <!-- Indicators -->
                      <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                      </ol>

                      <!-- Wrapper for slides -->
                      <div class="carousel-inner" role="listbox">
                        <div class="item active">
                          <img src="img/futbolka.jpg" width="350px" alt="...">
                          <div class="carousel-caption">
                            ...
                          </div>
                        </div>
                        <div class="item">
                          <img src="img/futbolka.jpg" width="350px" alt="...">
                          <div class="carousel-caption">
                            ...
                          </div>
                        </div>
                            <div class="item">
                          <img src="img/futbolka.jpg" width="350px" alt="...">
                          <div class="carousel-caption">
                            ...
                          </div>
                        </div>
                      </div>


                      <!-- Controls -->
                      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                        </div>

                        <div class="col-xs-10">

                        <div class="caption">
                            <h2 class="price">Price:<label type="">{}</label> grn </h2>
                            <input type="text" value="1">
                            <button class="btn btn-success">Buy</button>
                            <button class="btn btn-success">Add to Cart</button>
                        </div>
                            <label type="">Общая цена:</label><label type="">{}</label>
                        </div>
						<div class="col-xs-12">
							<h2 class="description">Описание:</h2>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit,
								sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
								Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
								Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
								Excepteur sint occaecat cupidatat non proident,
								sunt in culpa qui officia deserunt mollit anim id est laborum.
							</p>
						</div>
                        <hr>
                        <div class="thumbnail col-xs-12">
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Дополнительние параметри
                            </button>
                            <div class="collapse" id="collapseExample">
                              <div class="well">
                                <table class="table">
                                    <label class="table-title">Характеристика</label>
                                    <th>Htlea</th>
                                    <th>Htlea</th>
                                    <th>Htlea</th>
                                    <th>Htlea</th>
                                    <tr>
                                    <td>sdadas  </td>
                                    <td>asdasdas</td>
                                    <td>asdasd  </td>
                                    <td>asdsad  </td>
                                    </tr>
                                </table>
                                <table class="table">
                                    <label class="table-title"><b>Свойства</b></label>
                                    <th>Htlea</th>
                                    <th>Htlea</th>
                                    <th>Htlea</th>
                                    <th>Htlea</th>
                                    <tr>
                                    <td>sdadas  </td>
                                    <td>asdasdas</td>
                                    <td>asdasd  </td>
                                    <td>asdsad  </td>
                                    </tr>
                                </table>
                              </div>
                            </div>
                        </div>
                            <div class="col-sm-12 col-lg-6">
                            <ul class="media-list">
                              <li class="media">
                                <div class="media-left">
                                  <a href="#">
                                    <img class="media-object" width="70px" src="img/futbolka.jpg" alt="...">
                                  </a>
                                </div>
                                <div class="media-body">
                                  <h4 class="media-heading">Богдан Рибчинський</h4>
                                  <p class="description">Гуд</p>
                                </div>
                              </li>
                            </ul>
                            </div>
					</div>
				</div>
			</div>
</main>
<?php include "footer.php";?>
