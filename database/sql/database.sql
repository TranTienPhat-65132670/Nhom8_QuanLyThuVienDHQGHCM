-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2026 at 04:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qltv_dhqghcm`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `book_name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `language` varchar(30) DEFAULT NULL,
  `page_count` int(11) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `available_quantity` int(11) NOT NULL DEFAULT 0,
  `location` varchar(100) DEFAULT NULL,
  `book_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `category_id`, `book_name`, `author`, `isbn`, `language`, `page_count`, `total_quantity`, `available_quantity`, `location`, `book_image`, `description`, `status`, `slug`, `created_at`, `deleted_at`) VALUES
(15, 22, 'Kinh Tế Học Vĩ Mô MacroEconomics', 'N. Gregory Mankiw', '8394-8247-9384-3', 'Tiếng Việt', 704, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1793982135_kinhtehocvimoMACROECONOMIC.jpg', 'Giáo trình \"Kinh Tế Học Vĩ Mô\" (Ấn bản thứ 11) của Giáo sư N. Gregory Mankiw là một trong những cuốn sách học thuật kinh điển, uy tín và được sử dụng phổ biến nhất tại các trường đại học trên toàn thế giới. Cuốn sách cung cấp hệ thống kiến thức toàn diện, cân bằng và cập nhật nhất về cách thức vận hành của một nền kinh tế tổng thể.', 1, 'kinh-te-hoc-vi-mo-macroeconomics', '2026-11-06 09:22:15', NULL),
(16, 25, 'Thiết kế hệ thống SoC trên FPGA', 'TS.Trần Thị Điểm', '8340-3453-4245-3', 'Tiếng Việt', 300, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1793982434_thietkehethongSOCtrenFGPA.jpg', 'Cuốn sách \"Thiết kế hệ thống SoC trên FPGA\" do TS. Trần Thị Điểm làm chủ biên (cùng các đồng tác giả TS. Phạm Hoài Luân và TS. Nguyễn Văn Tình) thuộc thể loại giáo trình kỹ thuật - công nghệ thông tin. Sách cung cấp kiến thức toàn diện từ nền tảng đến nâng cao về quy trình thiết kế hệ thống nhúng trên chip (SoC) và mạch lập trình FPGA, bao gồm kiến trúc vi xử lý, hệ thống giao tiếp chuẩn và phương pháp tối ưu hóa phần cứng cho các ứng dụng công nghệ hiện đại.', 1, 'thiet-ke-he-thong-soc-tren-fpga', '2026-11-06 09:26:58', NULL),
(17, 25, 'Cấu Trúc Rời Rạc', 'Nguyễn Thanh Long', '978-632-608-554-9', 'Tiếng Việt', 279, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1793982655_cautrucroirac.jpg', 'Cuốn sách \"Giáo trình Cấu trúc rời rạc\" do Nguyễn Thanh Long làm chủ biên cung cấp hệ thống kiến thức toán học rời rạc nền tảng dành cho sinh viên bậc đại học ngành Công nghệ Thông tin. Nội dung bao gồm các chủ đề cốt lõi như đại số mệnh đề, tập hợp, quan hệ, lý thuyết đồ thị và cây, giúp người học phát triển tư duy logic và xây dựng nền tảng giải thuật bền vững cho việc thiết kế, tối ưu phần mềm.', 1, 'cau-truc-roi-rac', '2026-11-06 09:30:55', NULL),
(18, 19, 'Trí Tuệ Nhân Tạo', 'Lê Hoài Bắc', '3455-3525-4235-4', 'Tiếng Việt', 232, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1793982743_trituenhantao.jpg', 'Cuốn sách \"Cơ sở Trí tuệ Nhân tạo\" do Lê Hoài Bắc và Tô Hoài Việt biên soạn là tài liệu giảng dạy nền tảng dành cho sinh viên ngành Công nghệ Thông tin và Khoa học Máy tính. Sách tập trung giới thiệu các khái niệm cốt lõi của Trí tuệ nhân tạo (AI), bao gồm các chiến lược tìm kiếm (tìm kiếm mù, tìm kiếm heuristic), biểu diễn tri thức, hệ logic (mệnh đề, bậc nhất), suy diễn không chắc chắn, cùng các mô hình học máy cơ bản và mạng nơ-ron nhân tạo. Đây là cuốn cẩm anh giúp người học xây dựng tư duy thuật toán thông minh và ứng dụng giải quyết các bài toán thực tế.', 1, 'tri-tue-nhan-tao', '2026-11-06 09:32:23', NULL),
(19, 19, 'Artificial Intelligence: A Modern Approach (Second Edition)', 'Stuart Russell, Peter Norvig', '978-0137903955', 'Tiếng Anh', 1112, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1793982847_artificialintelligence.jpg', '\"Artificial Intelligence: A Modern Approach\" (Ấn bản thứ 2) của Stuart Russell và Peter Norvig được coi là cuốn \"thánh kinh\" toàn diện nhất trong lĩnh vực trí tuệ nhân tạo. Sách tiếp cận AI dựa trên khái niệm tác thể thông minh (intelligent agent), bao quát từ giải thuật tìm kiếm, logic suy luận, tri thức đến học máy, mạng nơ-ron, xử lý ngôn ngữ tự nhiên và thị giác máy tính.', 1, 'artificial-intelligence-a-modern-approach-second-edition', '2026-11-06 09:34:07', NULL),
(20, 19, 'Clean Code', 'Robert C. Martin', '978-0132350884', 'Tiếng Anh', 464, 100, 100, 'Ký túc xá Khu B Đại học Quốc gia TP.HCM', 'book/1794065937_cleancode.webp', 'Clean Code\" của Robert C. Martin là cuốn cẩm nang kinh điển hướng dẫn lập trình viên nghệ thuật viết mã nguồn sạch, dễ đọc, dễ bảo trì và mở rộng. Sách cung cấp các nguyên tắc thực tiễn từ cách đặt tên biến, tối ưu hàm, xử lý lỗi đến tái cấu trúc mã (refactoring) và viết unit test, giúp biến code phức tạp thành sản phẩm phần mềm chất lượng cao.', 1, 'clean-code', '2026-11-07 08:38:57', NULL),
(21, 25, 'Giáo trình C++ & Lập trình hướng đối tượng', 'GS. Phạm Văn Ất', '978-604-950-843-1', 'Tiếng Việt', 396, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1794066024_laptrinhhuongdoituong.jpg', 'Giáo trình C++ & Lập trình hướng đối tượng\" của GS. Phạm Văn Ất và Lê Trường Thông là tài liệu học tập kinh điển dành cho sinh viên ngành Công nghệ Thông tin. Sách trình bày bài bản từ cú pháp C++ cơ bản đến các trụ cột của lập trình hướng đối tượng (OOP) như lớp, đối tượng, đóng gói, kế thừa, đa hình và nạp chồng toán tử, giúp người học xây dựng nền tảng tư duy lập trình vững chắc', 1, 'giao-trinh-c-lap-trinh-huong-doi-tuong', '2026-11-07 08:40:24', NULL),
(22, 19, 'Head First Design Patterns: Building Extensible & Maintainable Object-Oriented Software (Second Edition)', 'Eric Freeman, Elisabeth Robson', '978-1492078003', 'Tiếng Anh', 672, 100, 100, 'Ký túc xá Khu B Đại học Quốc gia TP.HCM', 'book/1794066124_headfirstdesignpatterns.jpg', 'Head First Design Patterns\" (Ấn bản thứ 2) của Eric Freeman và Elisabeth Robson là cuốn sách kinh điển sử dụng phương pháp tiếp cận trực quan, sinh động (A Brain-Friendly Guide) để hướng dẫn lập trình viên cách áp dụng các mẫu thiết kế hướng đối tượng (Design Patterns). Sách giúp người đọc hiểu sâu sắc về nguyên lý thiết kế phần mềm linh hoạt, dễ bảo trì và mở rộng thông qua các ví dụ thực tế và bài tập trực quan.', 1, 'head-first-design-patterns-building-extensible-maintainable-object-oriented-software-second-edition', '2026-11-07 08:42:04', NULL),
(23, 24, 'Muôn Kiếp Nhân Sinh', 'Nguyên Phong (John Vu)', '978-604-305-156-5', 'Tiếng Việt', 400, 100, 100, 'Ký túc xá Khu B Đại học Quốc gia TP.HCM', 'book/1794066207_muonkiepnhansinh.jpg', 'Muôn Kiếp Nhân Sinh\" của tác giả Nguyên Phong là tập hợp những câu chuyện kỳ diệu về tiền kiếp và luật nhân quả qua góc nhìn của Thomas Ashley-Farrand – một doanh nhân thành đạt ở New York và những trải nghiệm sâu sắc của ông về chuỗi kiếp sống qua nhiều nền văn minh lớn như Atlantis, Ai Cập cổ đại và Hoa Kỳ. Cuốn sách truyền tải thông điệp sâu sắc về quy luật vũ trụ, nhân quả và sự thức tỉnh tâm linh, giúp người đọc thấu hiểu ý nghĩa cuộc sống để hướng thiện và sống tử tế hơn', 1, 'muon-kiep-nhan-sinh', '2026-11-07 08:43:27', NULL),
(24, 24, 'Bài học diệu kỳ từ chiếc xe rác', 'David J. Pollay', '978-604-58-0382-0', 'Tiếng Việt', 200, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1794066287_baihocdieukytuchiecxerac.png', 'Bài Học Diệu Kỳ Từ Chiếc Xe Rác\" của tác giả David J. Pollay là cuốn sách truyền cảm hứng giúp chúng ta học cách kiểm soát cảm xúc trước những năng lượng tiêu cực từ người khác. Sách ví những người mang tâm trạng bực dọc, hay trút giận lên người xung quanh giống như những \"chiếc xe rác\", đồng thời hướng dẫn bạn cách không để họ đổ rác lên cuộc đời mình, qua đó xây dựng lối sống tích cực, vị tha và bình yên hơn', 1, 'bai-hoc-dieu-ky-tu-chiec-xe-rac', '2026-11-07 08:44:47', NULL),
(25, 23, 'Deep Work: Rules for Focused Success in A Distracted World', 'Cal Newport', '978-1455586699', 'Tiếng Anh', 304, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1794066364_deepwork.jpg', 'Deep Work\" của Cal Newport là cuốn sách thiết yếu giúp bạn lấy lại khả năng tập trung cao độ trong một thế giới đầy rẫy sự xao nhãng và mạng xã hội. Sách định nghĩa khái niệm \"làm việc sâu\" (deep work) – khả năng tập trung không mệt mỏi vào một nhiệm vụ đòi hỏi trí tuệ cao, đồng thời cung cấp các quy tắc thực tế giúp loại bỏ \"làm việc nông\" (shallow work), từ đó tối ưu hóa năng suất và đạt được thành công vượt trội trong công việc lẫn cuộc sống', 1, 'deep-work-rules-for-focused-success-in-a-distracted-world', '2026-11-07 08:46:04', NULL),
(26, 22, 'Một Đời Quản Trị', 'GS. Phan Văn Trường', '978-604-1-15589-9', 'Tiếng Việt', 380, 100, 100, 'Ký túc xá Khu B Đại học Quốc gia TP.HCM', 'book/1794066440_motdoiquantri.jpg', 'Một Đời Quản Trị\" của Giáo sư Phan Văn Trường đúc kết những kinh nghiệm thực chiến phong phú và triết lý quản trị sâu sắc suốt hàng chục năm làm việc tại các tập đoàn đa quốc gia và cơ quan chính phủ quốc tế. Cuốn sách không chỉ mang đến các bài học kinh doanh sắc bén về nghệ thuật điều hành, tư duy chiến lược và quản lý con người, mà còn truyền cảm hứng sống tử tế, tinh thần phụng sự và thái độ tích cực trong công việc cũng như cuộc sống', 1, 'mot-doi-quan-tri', '2026-11-07 08:47:20', NULL),
(27, 22, 'Blue Ocean Strategy', 'W. Chan Kim, Renée Mauborgne', '978-604-929-232-3', 'Tiếng Anh', 350, 100, 100, 'Thư viện Trung tâm DHQG-HCM', 'book/1794066514_chienluocdaiduong.jpg', 'Chiến Lược Đại Dương Xanh\" của W. Chan Kim và Renée Mauborgne là tác phẩm kinh điển về chiến lược kinh doanh, thay đổi hoàn toàn tư duy cạnh tranh truyền thống. Cuốn sách lập luận rằng thành công bền vững không đến từ việc chém giết lẫn nhau trong các thị trường đã bão hòa (\"đại dương đỏ\"), mà đến từ việc tạo ra những không gian thị trường hoàn toàn mới, chưa được khai phá (\"đại dương xanh\") bằng cách kết hợp đồng thời sự đổi mới giá trị và tối ưu hóa chi phí', 1, 'blue-ocean-strategy', '2026-11-07 08:48:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_reservation`
--

CREATE TABLE `book_reservation` (
  `reservation_id` int(11) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `borrow_id` int(11) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `borrow_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime NOT NULL,
  `return_date` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `borrow_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`borrow_id`, `user_id`, `approved_by`, `borrow_datetime`, `due_date`, `return_date`, `status`, `borrow_note`, `created_at`, `updated_at`) VALUES
(18, 'ff9a6e0b-a45e-4df4-bfec-5126d82e64fb', 'bef76426-139d-4462-a14d-fefb530c6888', '2026-11-06 16:40:10', '2026-11-17 00:00:00', '2026-11-06 16:42:49', 'returned', 'Cho em mượn sách ạ!', '2026-11-06 09:40:10', '2026-11-06 09:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_details`
--

CREATE TABLE `borrow_details` (
  `borrow_details_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `borrow_details`
--

INSERT INTO `borrow_details` (`borrow_details_id`, `borrow_id`, `book_id`, `quantity`) VALUES
(18, 18, 18, 3),
(19, 18, 19, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `deleted_at`) VALUES
(19, 'Công nghệ thông tin & Lập trình', NULL),
(20, 'Khoa học kỹ thuật & Toán học', NULL),
(22, 'Kinh tế - Quản trị kinh doanh', NULL),
(23, 'Văn học nghệ thuật & Tiểu thuyết', NULL),
(24, 'Kỹ năng sống & Phát triển bản thân', NULL),
(25, 'Giáo Trình Học Tập Chung', NULL),
(26, 'Ngoại ngữ & Từ điển', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `favorite_id` int(11) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`favorite_id`, `user_id`, `book_id`) VALUES
(21, 'ff9a6e0b-a45e-4df4-bfec-5126d82e64fb', 18),
(20, 'ff9a6e0b-a45e-4df4-bfec-5126d82e64fb', 19);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000002_create_jobs_table', 1),
(2, '0001_01_01_000000_create_users_table', 2),
(3, '0001_01_01_000001_create_cache_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `title`, `body`, `status`, `slug`, `created_at`, `updated_at`) VALUES
(11, 'bef76426-139d-4462-a14d-fefb530c6888', 'Thông báo điều chỉnh giờ mở cửa phục vụ mùa thi', 'Nhằm tạo điều kiện cho sinh viên ôn tập cho kỳ thi sắp tới, Thư viện Trung tâm mở rộng thời gian phục vụ từ 07:30 đến 21:00 các ngày trong tuần (từ thứ 2 đến thứ 7', 1, 'thong-bao-dieu-chinh-gio-mo-cua-phuc-vu-mua-thi-gw5pp0hq', '2026-11-06 09:41:21', '2026-11-07 08:51:44'),
(12, 'bef76426-139d-4462-a14d-fefb530c6888', 'Lịch nghỉ phục vụ các ngày Lễ và nghỉ Tết', 'Thư viện sẽ tạm ngưng các hoạt động phục vụ trực tiếp tại chỗ trong thời gian nghỉ Lễ. Mọi giao dịch gia hạn sách quá hạn trong khoảng thời gian này sẽ tự động được dời sang ngày làm việc tiếp theo', 1, 'lich-nghi-phuc-vu-cac-ngay-le-va-nghi-tet-et8fdnm2', '2026-11-07 08:52:07', '2026-11-07 08:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(36) NOT NULL,
  `student_code` varchar(10) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'member',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `student_code`, `hashed_password`, `student_name`, `email`, `phone`, `role`, `status`, `created_at`, `deleted_at`) VALUES
('01a1b027-06fe-7288-989f-01c1a0901808', '23456789', '$2y$12$MEysL0bfkp9atO0GxAAhueSZdCS24Hqy1INB5MC1XAxpghvivxexa', 'Trương Gia Khang', 'truonggiakhang@gmail.com', NULL, 'member', 1, '2026-11-06 02:18:30', NULL),
('01a1b185-6ed6-7081-adc9-b28b01471c2f', '92834920', '$2y$12$wNyACuMjlkMsJc9Z9sOyyecWJWHLlFeD2LJpXEA3zXmswUt0NKaYu', 'Nguyễn Hữu An', 'nguyenhuuanky@gmail.com', NULL, 'member', 1, '2026-11-06 08:41:14', NULL),
('bef76426-139d-4462-a14d-fefb530c6888', '12345678', '$2y$12$JIGRL0UeOSCNcyCx.YnGMe99GRM/rPnsgqZFCg6llIijAGzfhcAfe', 'Trần Tiến Phát', 'subnautica1234567@gmail.com', '0373821040', 'admin', 1, '2026-10-17 13:56:10', NULL),
('ff9a6e0b-a45e-4df4-bfec-5126d82e64fb', '87654321', '$2y$10$paQhm6hO6cSjIWLRcc1cS.vKghfU8hVv803dKuaUFrVRJJDaJU18e', 'Trần Minh Trí', 'trancuong1979nt@gmail.com', '0935013041', 'member', 1, '2026-10-21 12:02:16', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `uq_slug` (`slug`),
  ADD UNIQUE KEY `uq_isbn` (`isbn`),
  ADD KEY `book_category` (`category_id`);

--
-- Indexes for table `book_reservation`
--
ALTER TABLE `book_reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `reservation_book` (`book_id`),
  ADD KEY `reservation_user` (`user_id`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `borrow_approved` (`approved_by`),
  ADD KEY `borrow_user` (`user_id`);

--
-- Indexes for table `borrow_details`
--
ALTER TABLE `borrow_details`
  ADD PRIMARY KEY (`borrow_details_id`),
  ADD UNIQUE KEY `uq_borrow_id_book_id` (`borrow_id`,`book_id`),
  ADD KEY `borrow_book` (`book_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `uq_user_id_book_id` (`user_id`,`book_id`),
  ADD KEY `favorite_book` (`book_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `uq_slug` (`slug`) USING BTREE,
  ADD KEY `user_post` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uq_student_code` (`student_code`),
  ADD UNIQUE KEY `uq_email` (`email`),
  ADD UNIQUE KEY `uq_phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `book_reservation`
--
ALTER TABLE `book_reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `borrow_details`
--
ALTER TABLE `borrow_details`
  MODIFY `borrow_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `book_reservation`
--
ALTER TABLE `book_reservation`
  ADD CONSTRAINT `reservation_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_approved` FOREIGN KEY (`approved_by`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `borrow_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `borrow_details`
--
ALTER TABLE `borrow_details`
  ADD CONSTRAINT `borrow_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `borrow_id` FOREIGN KEY (`borrow_id`) REFERENCES `borrow` (`borrow_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `user_post` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
