1. Tạo Project và Bật API:

Truy cập Google Cloud Console.

Tạo một project mới (hoặc chọn project đã có).

Đi đến "APIs & Services" -> "Library".

Tìm kiếm "Cloud Vision API" và nhấp vào.

Nhấp vào nút "Enable".

2. Tạo Service Account và Key:

Đi đến "APIs & Services" -> "Credentials".

Nhấp vào "Create credentials" -> "Service account".

Nhập tên cho service account (ví dụ: ocr-service-account) và nhấp "Create".

Trong phần "Grant this service account access to project", chọn role "Vision API User" (hoặc "Project -> Viewer" nếu bạn muốn cấp quyền rộng hơn, nhưng không khuyến khích).

Nhấp "Continue" và "Done".

Tìm service account bạn vừa tạo, nhấp vào dấu ba chấm và chọn "Manage keys".

Nhấp "Add Key" -> "Create new key".

Chọn "JSON" và nhấp "Create".

File credentials.json sẽ được tải xuống. Lưu file này (bạn sẽ cần upload nó lên hosting sau).

3. Cài đặt thư viện google/cloud-vision qua Composer:

Có 2 cách để cài đặt:

Cách 1: Cài đặt trên máy local rồi upload lên hosting (Khuyên dùng):

Trên máy tính local (đã cài đặt Composer):

Tạo thư mục dự án (ví dụ: gemini-ocr).

Mở terminal/command prompt, di chuyển đến thư mục dự án: cd gemini-ocr

Chạy lệnh: composer require google/cloud-vision

Lệnh này sẽ tạo thư mục vendor chứa thư viện google/cloud-vision và các thư viện phụ thuộc.

Tạo các file index.php, chat.php, ocr.php (như code ở trên) trong thư mục gemini-ocr.

Upload toàn bộ thư mục gemini-ocr (bao gồm cả vendor và credentials.json) lên thư mục public của hosting Cpanel (thường là public_html).

Cách 2: Cài đặt trực tiếp trên hosting Cpanel (nếu hosting hỗ trợ SSH và Composer):

Kết nối SSH vào hosting:

Trong Cpanel, tìm phần "Advanced" -> "SSH Access" (hoặc tương tự).

Bật SSH Access.

Sử dụng phần mềm SSH client (ví dụ: PuTTY trên Windows) để kết nối vào hosting.

Di chuyển đến thư mục public:

Sử dụng lệnh cd public_html (hoặc thư mục chứa code của bạn).

Kiểm tra Composer:

Chạy lệnh composer --version. Nếu Composer chưa được cài đặt, bạn cần liên hệ với nhà cung cấp hosting để nhờ hỗ trợ.

Cài đặt thư viện:

Chạy lệnh: composer require google/cloud-vision

Tạo các file index.php, chat.php, ocr.php (như code ở trên) trong thư mục hiện tại.

Upload file credentials.json lên thư mục này.

4. Cấu hình và Kiểm tra:

Tạo thư mục uploads:

Trong Cpanel, đi đến "File Manager".

Di chuyển đến thư mục chứa code của bạn (ví dụ: public_html/gemini-ocr).

Tạo thư mục uploads và đặt quyền 777 (hoặc 755 tùy cấu hình server).

Thay API Key:

Mở file chat.php bằng File Manager (hoặc qua FTP).

Thay thế API-cua-ban-o-day bằng API Key của bạn.

Kiểm tra:

Truy cập website của bạn qua trình duyệt (ví dụ: yourdomain.com/gemini-ocr).

Thử tải ảnh lên và xem kết quả.

Lưu ý quan trọng:

Bảo mật file credentials.json: Không đặt file này trong thư mục public (ví dụ: public_html). Nên đặt ở thư mục cao hơn, ví dụ: /home/yourusername/ và chỉnh sửa đường dẫn trong file ocr.php cho phù hợp:

putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/yourusername/credentials.json');
Use code with caution.
PHP
Xử lý lỗi: Code mẫu ở trên chưa xử lý lỗi đầy đủ. Bạn cần thêm các đoạn code để bắt lỗi và xử lý các trường hợp ngoại lệ (ví dụ: lỗi kết nối, lỗi API, lỗi upload file, v.v.).

Giới hạn của Vision API: Google Cloud Vision API có giới hạn về số lượng request miễn phí mỗi tháng. Nếu vượt quá, bạn sẽ bị tính phí. Hãy kiểm tra bảng giá và hạn mức sử dụng của API.

Hỗ trợ từ nhà cung cấp hosting: Nếu bạn gặp khó khăn trong việc cài đặt, hãy liên hệ với nhà cung cấp hosting để được hỗ trợ.
