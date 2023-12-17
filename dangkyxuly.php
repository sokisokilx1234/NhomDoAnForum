<?php
	$servername = "localhost";
	$username = "root";
	$password = "vertrigo";
	$dbname = "mohinh_login";	
	
	
	$connect = new mysqli($servername, $username, $password, $dbname);	

	//Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
	if ($connect->connect_error) {
		    die("Không kết nối :" . $conn->connect_error);
		    exit();
	}		
?>
<?php
	function ThongBaoLoi($thongbao = "")
	{
		echo "<h3>Lỗi</h3><p class='ThongBaoLoi'>$thongbao</p>";
	}
	
	function ThongBao($thongbao = "")
	{
		echo "<h3>Hoàn thành</h3><p class='ThongBao'>$thongbao</p>";
	}
?>
<?php
	// Lấy thông tin từ FORM
	$HoVaTen = $_POST['HoVaTen'];
	$TenDangNhap = $_POST['TenDangNhap'];
	$MatKhau = $_POST['MatKhau'];
	$XacNhanMatKhau = $_POST['XacNhanMatKhau'];
	
	// Kiểm tra
	if(trim($HoVaTen) == "")
		ThongBaoLoi("Họ và tên không được bỏ trống!");
	elseif(trim($TenDangNhap) == "")
		ThongBaoLoi("Tên đăng nhập không được bỏ trống!");
	elseif(trim($MatKhau) == "")
		ThongBaoLoi("Mật khẩu không được bỏ trống!");
	elseif($MatKhau != $XacNhanMatKhau)
		ThongBaoLoi("Xác nhận mật khẩu không đúng!");
	else
	{
		// Kiểm tra người dùng đã tồn tại chưa
		$sql_kiemtra = "SELECT * FROM nguoidung WHERE TenDangNhap = '$TenDangNhap'";
		
		$danhsach = $connect->query($sql_kiemtra);
		
		if($danhsach)
		{
			// Mã hóa mật khẩu
			$MatKhau = md5($MatKhau);
			
			$sql_them = "INSERT INTO `nguoidung`(`TenNguoiDung`, `TenDangNhap`, `MatKhau`, `QuyenHan`, `Khoa`)
					VALUES ('$HoVaTen', '$TenDangNhap', '$MatKhau', 2, 0)";
			$themnd = $connect->query($sql_them);
			
			if($themnd)
				ThongBao("Đăng ký thành công!");
			else
				ThongBaoLoi(mysql_error());
		}
		else
		{
			ThongBaoLoi("Người dùng với tên đăng nhập đã được sử dụng!");
		}
	}
?>