<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="quickview" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div style="width: 700px;" class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Xem nhanh sản phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @include('DetailProduct.quickview.index')
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" style="margin-top: 0px;"><a href="{{ route('cart.show_cart') }}" style="color: white;">Đi đến giỏ hàng</a></button>
    </div>
    </div>
</div>
</div>