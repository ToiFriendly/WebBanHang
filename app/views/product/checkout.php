<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
   <h1 class="text-center mb-4 fw-bold text-primary">Thanh toán</h1>
   <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger text-center" role="alert">
         <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
         <?php unset($_SESSION['error']); ?>
      </div>
   <?php endif; ?>
   <div class="row justify-content-center">
      <div class="col-md-6">
         <form method="POST" action="/webbanhang/Product/processCheckout">
            <div class="form-group mb-3">
               <label for="name" class="form-label">Họ tên:</label>
               <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
               <label for="phone" class="form-label">Số điện thoại:</label>
               <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="form-group mb-3">
               <label for="address" class="form-label">Địa chỉ:</label>
               <textarea id="address" name="address" class="form-control" required></textarea>
            </div>
            <div class="form-group mb-3">
               <label for="gmail" class="form-label">Email:</label>
               <input type="email" id="gmail" name="gmail" class="form-control">
            </div>
            <div class="form-group mb-3">
               <label for="time" class="form-label">Thời gian giao hàng mong muốn:</label>
               <input type="datetime-local" id="time" name="time" class="form-control">
            </div>
            <div class="form-group mb-3">
               <label for="note" class="form-label">Ghi chú:</label>
               <textarea id="note" name="note" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Thanh toán</button>
         </form>
         <div class="text-center mt-3">
            <a href="/webbanhang/Product/cart" class="btn btn-secondary">Quay lại giỏ hàng</a>
         </div>
      </div>
   </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>