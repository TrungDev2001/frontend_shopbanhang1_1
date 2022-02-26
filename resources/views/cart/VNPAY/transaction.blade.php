<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>VNPAY</title>
    <link rel="shortcut icon" href="/merchantv2/favicon.ico" />
</head>
<body style="font-size: 0.9rem;">
    <div class="container">
        <div class="clearfix" style="padding-bottom: 1rem;">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="/tryitnow/">VNPAY</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                {{-- <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        
                            <li class="nav-item">
                                <a class="nav-link " href="/tryitnow/">Danh sách </a> </li>
                            <li class="nav-item">  <a class="nav-link active" href="/tryitnow/Home/CreateOrder">Tạo mới <span class="sr-only">(current)</span></a></li>

                    </ul>
                </div> --}}
            </nav>
        </div>
        
    <h3>Thanh toán đơn h&#224;ng</h3>
    <div class="table-responsive">
    <form action="{{ route('processVNPAY') }}" id="frmCreateOrder" method="post">
        @csrf
        <div class="form-group">
            <label for="language">Loại hàng hóa </label>
            <select name="ordertype" id="ordertype" class="form-control">
                <option value="topup">Nạp tiền điện thoại</option>
                <option value="billpayment" selected>Thanh toán hóa đơn</option>
                <option value="fashion">Thời trang</option>
            </select>
        </div>        
        <div class="form-group">
            <label for="Amount">Số tiền</label>
            <input class="form-control" data-val="true" data-val-number="The field Amount must be a number." data-val-required="The Amount field is required." id="Amount" name="Amount" type="text" value="{{ number_format($priceEnd, 0, ',', '.') }}đ" disabled/>
            <input type="hidden" name="pricePayment" value="{{ $priceEnd }}">
        </div>
        <div class="form-group">
            <label for="OrderDescription">Nội dung thanh toán</label>
            <textarea class="form-control" cols="20" id="OrderDescription" name="OrderDescription" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label for="bankcode">Ngân hàng</label>
            <select name="bankcode" id="bankcode" class="form-control">
                <option value="">Không chọn </option>    
                <option value="MBAPP">Ung dung MobileBanking</option>			
                <option value="VNPAYQR">VNPAYQR</option>
                <option value="VNBANK">LOCAL BANK</option>
                <option value="IB">INTERNET BANKING</option>
                <option value="ATM">ATM CARD</option>
                <option value="INTCARD">INTERNATIONAL CARD</option>
                <option value="VISA">VISA</option>
                <option value="MASTERCARD"> MASTERCARD</option>
                <option value="JCB">JCB</option>
                <option value="UPI">UPI</option>
                <option value="VIB">VIB</option>
                <option value="VIETCAPITALBANK">VIETCAPITALBANK</option>
                <option value="SCB">Ngan hang SCB</option>
                <option value="NCB">Ngan hang NCB</option>
                <option value="SACOMBANK">Ngan hang SacomBank  </option>
                <option value="EXIMBANK">Ngan hang EximBank </option>
                <option value="MSBANK">Ngan hang MSBANK </option>
                <option value="NAMABANK">Ngan hang NamABank </option>
                <option value="VNMART"> Vi dien tu VnMart</option>
                <option value="VIETINBANK">Ngan hang Vietinbank  </option>
                <option value="VIETCOMBANK">Ngan hang VCB </option>
                <option value="HDBANK">Ngan hang HDBank</option>
                <option value="DONGABANK">Ngan hang Dong A</option>
                <option value="TPBANK">Ngân hàng TPBank </option>
                <option value="OJB">Ngân hàng OceanBank</option>
                <option value="BIDV">Ngân hàng BIDV </option>
                <option value="TECHCOMBANK">Ngân hàng Techcombank </option>
                <option value="VPBANK">Ngan hang VPBank </option>
                <option value="AGRIBANK">Ngan hang Agribank </option>
                <option value="MBBANK">Ngan hang MBBank </option>
                <option value="ACB">Ngan hang ACB </option>
                <option value="OCB">Ngan hang OCB </option>
                <option value="IVB">Ngan hang IVB </option>
                <option value="SHB">Ngan hang SHB </option>
            </select>
        </div>
            <div class="form-group">
                <label for="language">Ngôn ngữ</label>
                <select name="language" id="language" class="form-control">
                    <option value="vn">Tiếng Việt</option>
                    <option value="en">English</option>
                </select>
            </div>
            {{-- <button type="submit" class="btn btn-default" id="btnPopup">Thanh toán Popup</button> --}}
        <button type="submit" class="btn btn-success" name="redirect">Thanh toán</button>
    </form>
    </div>
    <p>
        &nbsp;
    </p>
    </div> <!-- /container -->
</body>

</html>