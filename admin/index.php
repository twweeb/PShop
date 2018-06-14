<?php include('header.php');
	include('../class/category.php');
	include('../class/chart.php');
	$product = new commodity();
	$cat = new Cat();
	$order = new Order();
?><div id="pshop" class="container">
	<div class="row">

            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-usd f-s-40 color-primary"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?=$product->this_month_total_revenue(); ?></h2>
                                    <p class="m-b-0">本月營業額</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-shopping-cart f-s-40 color-success"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?=$product->this_month_total_sold(); ?></h2>
                                    <p class="m-b-0">本月銷售數量</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-archive f-s-40 color-warning"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?=$cat->CountCat();?></h2>
                                    <p class="m-b-0">總商品類別</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?=$user->get_total_user_count(); ?></h2>
                                    <p class="m-b-0">使用者人數</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row bg-white m-l-0 m-r-0 box-shadow ">

                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">每月營業額</h4>
                                <?php 
                                	date_default_timezone_set("Asia/Taipei");
                                	$chart = new FusionCharts("line",date("Ym"),"100%","300","MonthlyRevenue","json",$order->MonthlyRevenueJson());
                                	$chart->render();
                                ?>
                                <div id="MonthlyRevenue"></div>
                                <!--<div id="extra-area-chart"></div>-->
                            </div>
                        </div>
                    </div>
                    <!-- column -->

                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body browser">
                                <h4 class="card-title">銷售量前5名</h4>
                                <?php 
                                	$charts = new FusionCharts("column2d",date("Ymd"),"100%","350","Popular","json",$order->CommodityRankJson());
                                	$charts->render();
                                ?>
                                <div id="Popular"></div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>
                <div class="row">
						<div class="col-lg-4">
							<div class="card">
								<div class="card-title">
									<h4>最新評價</h4>
								</div>
								<div class="recent-comment">
									<div class="media">
										<div class="media-left">
											<a href="#"><img alt="..." src="images/avatar/1.jpg" class="media-object"></a>
										</div>
										<div class="media-body">
											<h4 class="media-heading">xxx</h4>
											<p>優質推薦的好賣家 </p>
											<p class="comment-date">October 21, 2018</p>
										</div>
									</div>
									<div class="media">
										<div class="media-left">
											<a href="#"><img alt="..." src="images/avatar/1.jpg" class="media-object"></a>
										</div>
										<div class="media-body">
											<h4 class="media-heading">Amazing</h4>
											<p>出貨速度快</p>
											<p class="comment-date">October 21, 2018</p>
										</div>
									</div>

									<div class="media">
										<div class="media-left">
											<a href="#"><img alt="..." src="images/avatar/1.jpg" class="media-object"></a>
										</div>
										<div class="media-body">
											<h4 class="media-heading">Miracle</h4>
											<p>優良的商品品質</p>
											<p class="comment-date">October 21, 2018</p>
										</div>
									</div>

									<div class="media no-border">
										<div class="media-left">
											<a href="#"><img alt="..." src="images/avatar/1.jpg" class="media-object"></a>
										</div>
										<div class="media-body">
											<h4 class="media-heading">Mr. Michael</h4>
											<p>超讚的商品品質 </p>
											<div class="comment-date">October 21, 2018</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /# card -->
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-title">
                                <h4>最新訂單</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>買家</th>
                                                <th>商品名稱</th>
                                                <th>數量</th>
                                                <th>狀態</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>xxx</td>
                                                <td><span>iBook</span></td>
                                                <td><span>456</span></td>
                                                <td><span class="badge badge-success">待出貨</span></td>
                                            </tr>
                                            <tr>
                                                <td>xxx</td>
                                                <td><span>iPhone</span></td>
                                                <td><span>456</span></td>
                                                <td><span class="badge badge-success">待出貨</span></td>
                                            </tr>
                                            <tr>
                                                <td>xxx</td>
                                                <td><span>Tshirt</span></td>
                                                <td><span>456</span></td>
                                                <td><span class="badge badge-warning">待付款</span></td>
                                            </tr>
                                            <tr>
                                                <td>xxx</td>
                                                <td><span>iBook</span></td>
                                                <td><span>456</span></td>
                                                <td><span class="badge badge-success">待出貨</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
	</div>
</div>
<?php include('footer.php'); ?>