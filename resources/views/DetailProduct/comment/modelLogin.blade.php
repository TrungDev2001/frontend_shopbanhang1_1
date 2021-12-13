<!-- Modal -->
<div class="modal fade" id="LoginAndComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle" style="text-align-last: center;">Đăng nhập</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<form id="formDataLoginComment">
			<div class="form-group">
				<label for="exampleInputEmail1">Tài khoản</label>
				<input type="email" class="form-control" name="taikhoan" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tài khoản">
				<small id="emailHelp" class="form-text text-muted text-danger errorTk"></small>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Mật khẩu</label>
				<input type="password" class="form-control" name="matkhau" id="exampleInputPassword1" placeholder="Mật khẩu">
                <small id="emailHelp" class="form-text text-muted text-danger errorMk"></small>
			</div>
			{{-- <div class="form-check">
				<input type="checkbox" class="form-check-input" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Check me out</label>
			</div> --}}
			<button type="button" class="btn btn-primary btnLoginComment">Đăng nhập</button>
		</form>
	</div>
	{{-- <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" style="margin-top: 0px;">Save changes</button>
	</div> --}}
	</div>
</div>
</div>