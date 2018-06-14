</div><!--#wrap-->
<footer id="footer">
	<div class="container">PShop購物車</div>
</footer>
    <!-- Resource jQuery -->
	<script src="js/main.js"></script> 
	<?=($pagename == 'payment') ? "<script src=\"js/payment.js\"></script>":"" ?>
	<script src="js/moment.min.js"></script>
	<?=($pagename == 'coupon') ? "<script type=\"text/javascript\" src=\"//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js\"></script>":"" ?>
	
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>