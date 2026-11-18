# HUIT Schedule Hub (Quản lý và phân lịch giảng dạy đa cơ sở thông minh)

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](LICENSE)
[![CI](https://img.shields.io/badge/CI-GitHub%20Actions-brightgreen?style=flat-square&logo=githubactions&logoColor=white)](.github/workflows/php-syntax-check.yml)

> **HUIT Schedule Hub** là giải pháp phần mềm quản lý và phân lịch giảng dạy đa cơ sở thông minh dành riêng cho trường **Đại học Công Thương TP. Hồ Chí Minh (HUIT)**. Ứng dụng giúp phòng Đào tạo tối ưu hóa việc phân ca, giảm thiểu tối đa khoảng cách và thời gian di chuyển của giảng viên giữa các cơ sở, ngăn chặn tình trạng trùng phòng học / trùng lịch dạy, đồng thời cung cấp cổng tra cứu thời khóa biểu cá nhân tiện lợi cho giảng viên.

---

## 📌 Tính năng nổi bật

### 1. 🧠 Thuật toán gợi ý giảng viên phù hợp (Smart Recommendation)
- Tự động phân tích tên học phần/môn học và khớp với **chuyên môn chính** của giảng viên.
- Quét lịch dạy để loại bỏ các giảng viên đã bận ca học đó (**Hard Conflict**).
- **Tối ưu hóa di chuyển đa cơ sở:**
  - ⭐ **Khuyên dùng (Tối ưu cùng cơ sở):** Ưu tiên giảng viên đã có tiết dạy tại cùng cơ sở trong ngày, giúp tiết kiệm tối đa thời gian đi lại.
  - 🟢 **Khả dụng:** Giảng viên trống lịch cả ngày, sẵn sàng nhận lớp.
  - 🚗 **Lưu ý di chuyển:** Cảnh báo khi giảng viên có ca khác buổi tại cơ sở khác.
  - ⚠️ **Nguy hiểm:** Cảnh báo đỏ nếu xếp 2 ca liền kề trong cùng buổi ở 2 cơ sở cách xa nhau.

### 2. ⚡ Kiểm tra xung đột thời gian thực (Real-time Conflict Checker)
- Kiểm tra trùng phòng học tại cùng cơ sở và ca học.
- Kiểm tra trùng lịch giảng viên trên phạm vi toàn trường.
- Hiển thị phản hồi trực tiếp ngay trên giao diện tạo lịch bằng AJAX trước khi người dùng bấm Lưu.

### 3. 👨‍🏫 Cổng thông tin Giảng viên (Teacher Portal)
- Cổng tra cứu riêng biệt đăng nhập bằng email giảng viên.
- Chế độ xem ma trận Thời khóa biểu theo Tuần hoặc danh sách Timeline.
- Nắm bắt chính xác **Cơ sở trường học**, **Địa chỉ cụ thể** và **Phòng học**.
- Cảnh báo trực quan nếu trong ngày có lịch dạy tại nhiều cơ sở khác nhau.

### 4. 📊 Dashboard quản trị & Bộ lọc ma trận TKB
- Ma trận thời khóa biểu tuần từ Thứ 2 đến Chủ nhật x 5 Ca học tiêu chuẩn HUIT.
- Lọc nhanh theo từng Cơ sở hoặc từng Giảng viên.
- Biểu đồ phân bổ tỷ lệ khối lượng tiết dạy theo các cơ sở.
- CRUD đầy đủ cho Cơ sở, Giảng viên và Lịch giảng dạy.

---

## 🏗️ Cấu trúc thư mục dự án (PSR-4 MVC Architecture)

```
huit-schedule/
├── .github/
│   └── workflows/
│       └── php-syntax-check.yml    # CI/CD tự động kiểm tra cú pháp PHP (php -l)
├── config/
│   └── database.php                # Cấu hình CSDL
├── public/
│   ├── .htaccess                   # Rewrite Apache
│   └── index.php                   # Front Controller
├── src/
│   ├── Controllers/                # Controllers xử lý nghiệp vụ
│   │   ├── ApiController.php       # API gợi ý & kiểm tra xung đột AJAX
│   │   ├── AuthController.php      # Xác thực Admin & Giảng viên
│   │   ├── BranchController.php    # CRUD Cơ sở đào tạo
│   │   ├── DashboardController.php # Trang tổng quan & Ma trận TKB
│   │   ├── ScheduleController.php  # CRUD Lịch dạy
│   │   ├── TeacherController.php   # CRUD Giảng viên
│   │   └── TeacherPortalController.php # Cổng tra cứu giảng viên
│   ├── Core/                       # Hạt nhân ứng dụng
│   │   ├── Auth.php                # Session & Phân quyền Role
│   │   ├── Controller.php          # Base Controller
│   │   ├── Database.php            # Singleton PDO
│   │   ├── Model.php               # Base Model
│   │   └── Router.php              # RESTful HTTP Router
│   ├── Models/                     # Data Access Models
│   │   ├── Admin.php
│   │   ├── Branch.php
│   │   ├── Schedule.php
│   │   └── Teacher.php
│   └── Services/
│       └── ScheduleOptimizerService.php # Thuật toán thông minh tối ưu di chuyển
├── views/                          # Giao diện người dùng
│   ├── auth/                       # Đăng nhập Admin & Giảng viên
│   ├── branches/                   # View quản lý cơ sở
│   ├── dashboard/                  # View tổng quan ma trận TKB
│   ├── layouts/                    # Layout chính, Auth, Portal
│   ├── portal/                     # View thời khóa biểu giảng viên
│   ├── schedules/                  # View tạo/sửa/danh sách lịch dạy
│   └── teachers/                   # View quản lý giảng viên
├── .env.example                    # Cấu hình môi trường mẫu
├── .gitignore                      # Loại trừ vendor/, .env
├── composer.json                   # Quản lý dependencies (Dotenv, Faker)
├── database.sql                    # File CSDL MySQL & Dữ liệu mẫu
├── LICENSE                         # Giấy phép MIT
├── README.md                       # Tài liệu hướng dẫn sử dụng
└── seed.php                        # Script tự động sinh dữ liệu mẫu Faker
```

---

## 🚀 Hướng dẫn cài đặt & Chạy dự án

### 1. Yêu cầu môi trường
- **PHP:** Phiên bản 8.1 trở lên (Đã bật PDO MySQL extension).
- **MySQL / MariaDB:** Phiên bản 8.0 trở lên.
- **Composer:** Phiên bản 2.x.
- **Môi trường khuyến nghị:** Laragon trên Windows (chạy Virtual Host tự động).

### 2. Cài đặt các bước

#### Bước 1: Di chuyển vào thư mục dự án
Đặt thư mục `huit-schedule` trong thư mục `laragon\www\`:
```bash
cd C:\laragon\www\huit-schedule
```

#### Bước 2: Cài đặt thư viện phụ thuộc qua Composer
Cài đặt thư viện `vlucas/phpdotenv` và `fakerphp/faker`:
```bash
composer install
```

#### Bước 3: Cấu hình biến môi trường `.env`
Sao chép file `.env.example` thành `.env`:
```bash
cp .env.example .env
```
Mở file `.env` và kiểm tra thông số kết nối Database:
```env
APP_NAME="HUIT Schedule Hub"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://huit-schedule.test

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=huit_db
DB_USER=root
DB_PASS=
```

#### Bước 4: Tạo CSDL & Import dữ liệu mẫu
Bạn có 2 cách:

- **Cách 1 (Khuyên dùng - Chạy Script Seeder tự động bằng Faker):**
  ```bash
  php seed.php
  # hoặc dùng lệnh composer script:
  composer seed
  ```
  *Lệnh này sẽ tự động làm mới CSDL, khởi tạo 4 cơ sở đào tạo thực tế của HUIT, 12 giảng viên và 18 ca lịch dạy mẫu tối ưu.*

- **Cách 2 (Import file SQL thủ công qua HeidiSQL / phpMyAdmin):**
  Mở HeidiSQL kết nối tới MySQL, tạo database `huit_db` và chạy file [database.sql](database.sql).

#### Bước 5: Cấu hình Virtual Host & Chạy ứng dụng
- Với **Laragon**: Bật Laragon, Laragon sẽ tự động nhận diện Virtual Host `http://huit-schedule.test`.
- Hoặc chạy nhanh bằng PHP Built-in Server:
  ```bash
  php -S localhost:8000 -t public
  ```
  Sau đó mở trình duyệt truy cập: `http://localhost:8000`

---

## 🔑 Tài khoản đăng nhập kiểm thử (Demo Accounts)

### 1. Cổng Quản trị Phòng Đào Tạo (Admin)
- **Đường dẫn:** `http://huit-schedule.test/login`
- **Tên đăng nhập:** `admin` (hoặc `admin@huit.edu.vn`)
- **Mật khẩu:** `admin123`

### 2. Cổng Thông tin Giảng Viên (Teacher Portal)
- **Đường dẫn:** `http://huit-schedule.test/teacher-login`
- **Mật khẩu chung cho tất cả giảng viên:** `123456`
- **Danh sách email giảng viên mẫu:**
  - `nguyenvana@huit.edu.vn` (TS. Nguyễn Văn An - Chuyên môn: Công nghệ phần mềm)
  - `tranthib@huit.edu.vn` (ThS. Trần Thị Bích - Chuyên môn: Công nghệ thực phẩm)
  - `lehoangc@huit.edu.vn` (PGS.TS. Lê Hoàng Cường - Chuyên môn: Mạng máy tính & ATTT)
  - `phammed@huit.edu.vn` (ThS. Phạm Minh Dũng - Chuyên môn: Quản trị kinh doanh)
  - `vuthuhuong@huit.edu.vn` (TS. Vũ Thu Hương - Chuyên môn: Khoa học dữ liệu)

---

## 🤖 Tự động hóa CI/CD (GitHub Actions)

Dự án đã được tích hợp sẵn quy trình CI/CD qua GitHub Actions tại `.github/workflows/php-syntax-check.yml`:
- Tự động chạy mỗi khi có lệnh `git push` hoặc `pull_request` lên nhánh `main`/`master`.
- Thiết lập môi trường PHP 8.3 trên Ubuntu runner.
- Kiểm tra tính hợp lệ của file `composer.json`.
- Chạy kiểm tra cú pháp PHP toàn diện (`php -l`) trên toàn bộ cây mã nguồn dự án để đảm bảo không có bất kỳ lỗi biên dịch hay lỗi cú pháp nào trước khi triển khai.

---

## 📜 Giấy phép bản quyền (License)

Dự án được phân phối dưới giấy phép mã nguồn mở **MIT License**. Chi tiết xem tại file [LICENSE](LICENSE).
