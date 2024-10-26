# Xử lý Video

Đoạn mã này xử lý việc tải lên video từ người dùng và lưu thông tin vào cơ sở dữ liệu.

## Các bước thực hiện:

1. **Kiểm tra sự tồn tại của file video**

   - Nếu có file video được tải lên (`$_FILES['fileVideo']['name']`), thực hiện các bước tiếp theo.

2. **Khởi tạo biến và thiết lập thư mục lưu trữ**

   - Thiết lập thư mục để lưu trữ video: `uploads/videos/`.
   - Khởi tạo một mảng `$response` để lưu thông tin phản hồi.

3. **Lặp qua từng video được tải lên**

   - Kiểm tra nếu không có lỗi xảy ra trong quá trình tải lên.
   - Tạo đường dẫn tệp video.

4. **Kiểm tra định dạng file video**

   - Kiểm tra định dạng file (chỉ cho phép các định dạng: MP4, AVI, MOV, MPEG).
   - Nếu định dạng không hợp lệ, thêm thông báo lỗi vào mảng `$response`.

5. **Di chuyển file video đến thư mục lưu trữ**

   - Nếu không có lỗi và video được di chuyển thành công, tiếp tục xử lý video.

6. **Khởi tạo đối tượng FFmpeg**

   - Khởi tạo FFmpeg và FFprobe với đường dẫn đến các tệp nhị phân của chúng.
   - Mở video bằng FFmpeg.

7. **Lấy thông tin video**

   - Lấy độ dài video (duration).
   - Lấy độ phân giải (resolution).
   - Lấy bitrate.

8. **Tạo Thumbnail cho video**

   - Lưu thumbnail vào thư mục `uploads/thumbnails/`.

9. **Lưu thông tin video vào cơ sở dữ liệu**

   - Kiểm tra xem người dùng đã đăng nhập hay chưa.
   - Sử dụng câu lệnh SQL để lưu thông tin video vào bảng `videos`.

10. **Phản hồi kết quả**
    - Thêm thông tin phản hồi vào mảng `$response` và trả về kết quả dưới dạng JSON.

## Kết quả

- Nếu video được tải lên thành công, trả về mã trạng thái 200 cùng thông báo thành công.
- Nếu có lỗi, trả về mã trạng thái 500 cùng thông báo lỗi cụ thể.
- Nếu không có file video nào được tải lên, trả về mã trạng thái 400 cùng thông báo lỗi.

## Lưu ý

- Đảm bảo rằng bạn đã khởi động session trước khi lấy thông tin `user_id`.
- Kiểm tra và xử lý lỗi để đảm bảo ứng dụng hoạt động mượt mà.
