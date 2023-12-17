<?php
	session_start();
	$servername = "localhost";
	$username = "root";
	$password = "vertrigo";
	$dbname = "mohinh_login";	
	
	
	$connect = new mysqli($servername, $username, $password, $dbname);	

	//Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
	if ($connect->connect_error) {
		    die("Không kết nối :" . $connect->connect_error);
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
	$TenDangNhap = $_POST['TenDangNhap'];
	$MatKhau = $_POST['MatKhau'];
	
	// Kiểm tra
	if(trim($TenDangNhap) == "")
		ThongBaoLoi("Tên đăng nhập không được bỏ trống!");
	elseif(trim($MatKhau) == "")
		ThongBaoLoi("Mật khẩu không được bỏ trống!");
	else
	{
		// Mã hóa mật khẩu
		$MatKhau = md5($MatKhau);
		
		// Kiểm tra người dùng có tồn tại không
		$sql_kiemtra = "SELECT * FROM nguoidung WHERE TenDangNhap = '$TenDangNhap' AND MatKhau = '$MatKhau'";	
		
		
		$danhsach = $connect->query($sql_kiemtra);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
			exit();
		}
		
		$dong = $danhsach->fetch_array(MYSQLI_ASSOC);
		if($dong)
		{
			if($dong['Khoa'] == 0)
			{
				if($dong['QuyenHan']==1){
					header("Location: Admin/cartegoryadd.php");
				}
				else
				{
				// Đăng ký SESSION
				$_SESSION['MaND']= $dong['MaNguoiDung'];
				$_SESSION['HoTen'] = $dong['TenNguoiDung'];
				$_SESSION['QuyenHan'] = $dong['QuyenHan'];
				
				// Chuyển hướng về trang index.php
				header("Location: index_logged-in.html");
				}
			}
			else
			{
				ThongBaoLoi("Người dùng đã bị khóa tài khoản!");
			}			
		}
		else
		{
			ThongBaoLoi("Tên đăng nhập hoặc mật khẩu không chính xác!");
		}
	}
	
?>